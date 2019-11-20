import { Component, OnInit, Input, EventEmitter, Output } from '@angular/core';
import {MAT_DIALOG_DATA, MatDialogRef} from "@angular/material";
import { Inject } from '@angular/core'; 
import {ErrorStateMatcher} from '@angular/material/core';
import { Router} from '@angular/router';
import { DateAdapter, MatDatepickerInputEvent } from '@angular/material';
import {FormBuilder, FormGroup, Validators, FormControl, FormGroupDirective, NgForm, AbstractControl} from "@angular/forms";
import { AmazingTimePickerService } from 'amazing-time-picker';
import {MatDialog, MatDialogConfig} from "@angular/material";
import { ColorDialogueComponent } from '../shared/color-dialogue/color-dialogue.component';
import { EventService } from '../services/event.service';
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
  selector: 'app-event',
  templateUrl: './event.component.html',
  styleUrls: ['./event.component.scss']
})
export class EventComponent implements OnInit {

  eventForm: FormGroup;
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
  categories_data:any;
  
  constructor(private formBuilder: FormBuilder, private dialogRef: MatDialogRef<EventComponent>, private router: Router, @Inject(MAT_DIALOG_DATA) data, private adapter : DateAdapter<any>, private atp: AmazingTimePickerService, private dialog: MatDialog,  private event_service:EventService, private datePipe: DatePipe) {
  	// console.log(new Date(data.type));
    this.getCategories();
    this.start_date = data.type;
  }

   open() {
    const amazingTimePicker = this.atp.open();
    amazingTimePicker.afterClose().subscribe(time => {
      console.log('time',time);
    });
  }

  ngOnInit() {
    this.eventForm = this.formBuilder.group({
      title: ['', Validators.compose([Validators.required])],
      description:[''], 
      start_date: ['', Validators.compose([Validators.required])],
      end_date: ['', Validators.compose([Validators.required])],
      start_time: [''],
      end_time: [''],
      event_image: [''],
      contact_no:[''],
      color:[''],
      category: ['', Validators.compose([Validators.required])],

    });
    this.eventForm.controls.start_date.setValue(this.start_date.date);
    this.eventForm.controls.color.setValue('default');

  }

  //Function to set the date 
  setDate(type, event) {
    console.log('type', type);
    console.log('event', event);
  }

  //Function to get the form control values 
  get f()
  {
    return this.eventForm.controls;
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

  //Function to save the event details
  saveEvent(form) {
      console.log(form);
      let end_datetime:any;
      let start_datetime:any;
      if(this.eventForm.controls.start_time.value != '') {
         start_datetime = moment(this.eventForm.controls.start_date.value).add({h:this.eventForm.controls.start_time.value.split(':')[0], m:this.eventForm.controls.start_time.value.split(':')[1]});
      } else {
        start_datetime = moment(this.eventForm.controls.start_date.value);
      }
      if(this.eventForm.controls.end_time.value != '') {
        end_datetime = moment(this.eventForm.controls.end_date.value).add({h:this.eventForm.controls.end_time.value.split(':')[0], m:this.eventForm.controls.end_time.value.split(':')[1]});
      } else {
        end_datetime = moment(this.eventForm.controls.end_date.value);
      }
      console.log('start_time', start_datetime.toDate());
      console.log('end_time', end_datetime.toDate());
      let payload = new FormData();
      this.submitted = true;
      if (this.eventForm.invalid || this.image_error == true) {
        console.log("error");
          return;
      }

      payload.append('title', this.eventForm.controls.title.value);
      payload.append('description', this.eventForm.controls.description.value);
      payload.append('start_datetime', start_datetime);
      payload.append('end_datetime', end_datetime);
      payload.append('color', this.eventForm.controls.color.value);
      payload.append('contact_no', this.eventForm.controls.contact_no.value);
      payload.append('interested_flag', '0');
      payload.append('category', this.eventForm.controls.category.value.toString());
      payload.append('image', this.fileData);
      console.log(payload);
      console.log('form success');
       this.event_service.createEvent(payload)
        .subscribe(res => {
            this.result = res;
            console.log('rest', this.result);
            if(this.result.code == 200) {
              this.dialogRef.close(this.result.code);
            } else {
              this.errros = this.result.message;
            }
          }, (err) => {
            console.log('error', err);
          }); 

   }

   //Function to opem the color dialoge
   chooseColor(arg) {

    const dialogConfig = new MatDialogConfig();

    dialogConfig.disableClose = true;
    dialogConfig.autoFocus = true;

    const color = this.eventForm.controls.color.value 
    dialogConfig.data = {
        color: color
    };

    // this.dialog.open(UserdialogueComponent, dialogConfig);
    
    const dialogRef = this.dialog.open(ColorDialogueComponent, dialogConfig);

    dialogRef.afterClosed().subscribe(
        data => {
          this.eventForm.controls.color.setValue(data);
        }
    );    
  }

  //Function to close the popup
  close() {
      this.dialogRef.close(401);
  }    

  //function to get all the categories
  getCategories() {
    this.event_service.getAllCategories()
      .subscribe(res => {
        console.log('res', res);
        this.categories_data = res['data'];
      }, err => {
        console.log('error', err);
      });
  }

}
