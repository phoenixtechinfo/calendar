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
import { Globals } from '../../shared/globals';

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
  maxDate = new Date(2050, 0, 1);
  fileData: File = null;
  previewUrl:any = null;
  fileUploadProgress: string = null;
  uploadedFilePath: string = null;
  image_error:boolean = false;
  categories_data:any;
  selected_categories:any;
  selected_categories_data:Array<Object> = [];
  color_id:number;

  constructor(private formBuilder: FormBuilder, private dialogRef: MatDialogRef<EditEventComponent>, private router: Router, @Inject(MAT_DIALOG_DATA) data, private adapter : DateAdapter<any>, private atp: AmazingTimePickerService, private dialog: MatDialog,  private event_service:EventService, private datePipe: DatePipe, private globals: Globals) {
  	console.log(data.data);
    this.getCategories();
    this.event_data = data.data;
    this.selected_categories = data.categories;
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
      color:['', Validators.compose([Validators.required])],
      category: ['', Validators.compose([Validators.required])],
      color_id:[''],
    });
    this.editEventForm.controls.title.setValue(this.event_data.title);
  	this.editEventForm.controls.description.setValue(this.event_data.description);
  	this.editEventForm.controls.start_date.setValue(new Date(this.event_data.start_datetime.split(' ')[0]));
  	this.editEventForm.controls.end_date.setValue(new Date(this.event_data.end_datetime.split(' ')[0]));
  	this.editEventForm.controls.start_time.setValue(moment(this.event_data.start_datetime).format("HH:mm"));
  	this.editEventForm.controls.end_time.setValue(moment(this.event_data.end_datetime).format("HH:mm"));
  	this.editEventForm.controls.contact_no.setValue(this.event_data.contact_no);
  	this.editEventForm.controls.color.setValue(this.event_data.color.name);
    this.editEventForm.controls.color_id.setValue(this.event_data.color.id);
    if(this.event_data.image != null) {
      this.previewUrl = this.globals.imgUrl + this.event_data.image;
    }
    this.minDate = new Date(this.event_data.start_datetime.split(' ')[0]);
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
          let string = data.split("-");
          this.color_id = string[1];
          this.editEventForm.controls.color.setValue(string[0]);
          this.editEventForm.controls.color_id.setValue(string[1]);
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
      payload.append('category', this.editEventForm.controls.category.value.toString());
      payload.append('interested_flag', '0');
      payload.append('image', this.fileData);
      payload.append('color_id', this.editEventForm.controls.color_id.value);
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

  //function to get all the categories
  getCategories() {
    this.event_service.getAllCategories()
      .subscribe(res => {
        console.log('res', res);
        this.categories_data = res['data'];
        this.selected_categories.forEach(item => {
          this.selected_categories_data.push(item.id);
        });
        console.log(this.selected_categories_data);
        this.editEventForm.controls.category.setValue(this.selected_categories_data);
      }, err => {
        console.log('error', err);
      });
  }

  //function to change the end date selection
  endDateChange(event) {
      this.minDate = new Date(event.value);
      this.editEventForm.controls['end_date'].setValue('');
  }

}
