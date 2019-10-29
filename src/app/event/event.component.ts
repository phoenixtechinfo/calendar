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

import * as moment_ from 'moment';

const moment = moment_;

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

  constructor(private formBuilder: FormBuilder, private dialogRef: MatDialogRef<EventComponent>, private router: Router, @Inject(MAT_DIALOG_DATA) data, private adapter : DateAdapter<any>, private atp: AmazingTimePickerService, private dialog: MatDialog) {
  	// console.log(new Date(data.type));
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

  //Function to save the user details
  saveEvent(form) {
    console.log(form);
    this.submitted = true;
      if (this.eventForm.invalid || this.image_error == true) {
        console.log("error");
          return;
      }
      console.log('form success');

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

}
