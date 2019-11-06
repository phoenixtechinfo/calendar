import { Component, OnInit, Input, EventEmitter, Output } from '@angular/core';
import {MAT_DIALOG_DATA, MatDialogRef} from "@angular/material";
import { Inject } from '@angular/core'; 
import {ErrorStateMatcher} from '@angular/material/core';
import { Router} from '@angular/router';
import { DateAdapter, MatDatepickerInputEvent } from '@angular/material';
import {FormBuilder, FormGroup, Validators, FormControl, FormGroupDirective, NgForm, AbstractControl} from "@angular/forms";
import { AmazingTimePickerService } from 'amazing-time-picker';
import {MatDialog, MatDialogConfig} from "@angular/material";
import { ColorDialogueComponent } from '../../shared/color-dialogue/color-dialogue.component';
import { EventService } from '../../services/event.service';
import { DatePipe } from '@angular/common';
import * as moment from 'moment';

/** Error when invalid control is dirty, touched, or submitted. */
export class MyErrorStateMatcher implements ErrorStateMatcher {
  isErrorState(control: FormControl | null, form: FormGroupDirective | NgForm | null): boolean {
    const isSubmitted = form && form.submitted;
    return !!(control && control.invalid && (control.dirty || control.touched || isSubmitted));
  }
}


@Component({
  selector: 'app-edit-event',
  templateUrl: './edit-event.component.html',
  styleUrls: ['./edit-event.component.scss']
})
export class EditEventComponent implements OnInit {

  editEventForm: FormGroup;
  event_data:any;
  type:string;
  submitted:boolean= false;
  result:any;
  errros:any;
  user_role:any = 'user';
  payload:any;
  start_date:any;
  minDate = new Date(2000, 0, 1);
  maxDate = new Date(2020, 0, 1);
  fileData: File = null;
  previewUrl:any = null;
  fileUploadProgress: string = null;
  uploadedFilePath: string = null;
  image_error:boolean = false;

  constructor(private formBuilder: FormBuilder, private dialogRef: MatDialogRef<EditEventComponent>, private router: Router, @Inject(MAT_DIALOG_DATA) data, private adapter : DateAdapter<any>, private atp: AmazingTimePickerService, private dialog: MatDialog,  private event_service:EventService, private datePipe: DatePipe) {
  	console.log(data.data);
    this.event_data = data.data;
    
  }

  ngOnInit() {
  	this.editEventForm = this.formBuilder.group({
      title: ['', Validators.compose([Validators.required])],
      description:[''], 
      start_date: ['', Validators.compose([Validators.required])],
      end_date: ['', Validators.compose([Validators.required])],
      start_time: [''],
      end_time: [''],
      event_image: [''],
      contact_no:[''],
      color:[''],
    });
    this.editEventForm.controls.title.setValue(this.event_data.title);
  	this.editEventForm.controls.description.setValue(this.event_data.description);
  	this.editEventForm.controls.start_date.setValue(new Date(this.event_data.start_datetime.split(' ')[0]));
  	this.editEventForm.controls.end_date.setValue(new Date(this.event_data.end_datetime.split(' ')[0]));
  	this.editEventForm.controls.start_time.setValue(moment(this.event_data.start_datetime).format("HH:mm"));
  	this.editEventForm.controls.end_time.setValue(moment(this.event_data.end_datetime).format("HH:mm"));
  	this.editEventForm.controls.contact_no.setValue(this.event_data.contact_no);
  	this.editEventForm.controls.color.setValue(this.event_data.color);
    this.previewUrl = 'http://127.0.0.1:8000/storage/'+ this.event_data.image;
  }

  //Function to get the form control values 
  get f()
  {
    return this.editEventForm.controls;
  }

  fileProgress(fileInput: any) {
    if(fileInput.target.files[0]) {
      this.fileData = <File>fileInput.target.files[0];
      if(this.fileData.type.split('/')[0] != 'image') {
        this.image_error = true;
      } else {
        this.image_error = false;
      }
      this.preview();
    }
  }

  preview() {
    // Show preview 
    var mimeType = this.fileData.type;
    if (mimeType.match(/image\/*/) == null) {
      return;
    }

    var reader = new FileReader();      
    reader.readAsDataURL(this.fileData); 
    console.log(reader);
    reader.onload = (_event) => { 
      this.previewUrl = reader.result; 
    }
  }

  //Function to opem the color dialoge
   chooseColor(arg) {

    const dialogConfig = new MatDialogConfig();

    dialogConfig.disableClose = true;
    dialogConfig.autoFocus = true;

    const color = this.editEventForm.controls.color.value 
    dialogConfig.data = {
        color: color
    };

    // this.dialog.open(UserdialogueComponent, dialogConfig);
    
    const dialogRef = this.dialog.open(ColorDialogueComponent, dialogConfig);

    dialogRef.afterClosed().subscribe(
        data => {
          this.editEventForm.controls.color.setValue(data);
        }
    );    
  }

  //Function to save the event details
  editEvent(form) {
      console.log(form);
      let end_datetime:any;
      let start_datetime:any;
      if(this.editEventForm.controls.start_time.value != '') {
         start_datetime = moment(this.editEventForm.controls.start_date.value).startOf('day').add({h:this.editEventForm.controls.start_time.value.split(':')[0], m:this.editEventForm.controls.start_time.value.split(':')[1]});
      } else {
        start_datetime = moment(this.editEventForm.controls.start_date.value);
      }
      if(this.editEventForm.controls.end_time.value != '') {
        end_datetime = moment(this.editEventForm.controls.end_date.value).startOf('day').add({h:this.editEventForm.controls.end_time.value.split(':')[0], m:this.editEventForm.controls.end_time.value.split(':')[1]});
      } else {
        end_datetime = moment(this.editEventForm.controls.end_date.value);
      }
      let payload = new FormData();
      this.submitted = true;
      if (this.editEventForm.invalid || this.image_error == true) {
        console.log("error");
          return;
      }

      payload.append('id', this.event_data.id);
      payload.append('title', this.editEventForm.controls.title.value);
      payload.append('description', this.editEventForm.controls.description.value);
      payload.append('start_datetime', start_datetime);
      payload.append('end_datetime', end_datetime);
      payload.append('color', this.editEventForm.controls.color.value);
      payload.append('contact_no', this.editEventForm.controls.contact_no.value);
      payload.append('interested_flag', '0');
      payload.append('image', this.fileData);
      // console.log('form success');
       this.event_service.editEvent(payload)
        .subscribe(res => {
            this.result = res;
            if(this.result.code == 200) {
              //this.router.navigate(['']);
              this.dialogRef.close(this.result.code);
            } else {
              this.errros = this.result.message;
            }
          }, (err) => {
            console.log('error', err);
          }); 

   }

  //Function to close the popup
  closePopup(event) {
    event.preventDefault()
	 this.dialogRef.close();
  }    

}
