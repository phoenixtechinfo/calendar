import { Component, OnInit, Input, EventEmitter, Output, Inject } from '@angular/core';
import {MAT_DIALOG_DATA, MatDialogRef} from "@angular/material";
import {ErrorStateMatcher} from '@angular/material/core';
import { Router} from '@angular/router';
import { DateAdapter, MatDatepickerInputEvent } from '@angular/material';
import {FormBuilder, FormGroup, Validators, FormControl, FormGroupDirective, NgForm, AbstractControl} from "@angular/forms";
import {MatDialog, MatDialogConfig} from "@angular/material";
import { EventService } from '../../services/event.service';
import { UserService } from '../../services/user.service';
import { Globals } from '../../shared/globals';
import * as moment from 'moment';

/** Error when invalid control is dirty, touched, or submitted. */
export class MyErrorStateMatcher implements ErrorStateMatcher {
  isErrorState(control: FormControl | null, form: FormGroupDirective | NgForm | null): boolean {
    const isSubmitted = form && form.submitted;
    return !!(control && control.invalid && (control.dirty || control.touched || isSubmitted));
  }
}

@Component({
  selector: 'app-interested',
  templateUrl: './interested.component.html',
  styleUrls: ['./interested.component.scss']
})
export class InterestedComponent implements OnInit {

	interestedForm: FormGroup;
    submitted:boolean= false;
    result:any;
    errros:any;
    no_of_people = 1; 
    interested_flag:boolean=false;
    event_id:any;
    date:any;
	constructor(private formBuilder: FormBuilder, private dialogRef: MatDialogRef<InterestedComponent>, private router: Router, @Inject(MAT_DIALOG_DATA) data, private adapter : DateAdapter<any>, private dialog: MatDialog, private event_service:EventService, private user_service: UserService, private globals: Globals) {
		this.no_of_people = 1;
		this.event_id = data;
		// this.getCategories();
	}

	ngOnInit() {
		this.interestedForm = this.formBuilder.group({
		      name: ['', Validators.compose([Validators.required])],
		      email: ['', Validators.compose([Validators.required, Validators.email])],
      		  contact_no: ['', Validators.compose([Validators.required])],
		      city: ['', Validators.compose([Validators.required])],
		      date: ['', Validators.compose([Validators.required])],
		      destination:[''],
		      person:[''],
		      budget:[''],
		      terms: ['', Validators.compose([Validators.required])],
		      event_id:[''],
		    });
	  	this.interestedForm.controls.person.setValue(this.no_of_people);
	  	this.interestedForm.controls.event_id.setValue(this.event_id.data);
	    
	}
	//Function to get the form control values 
  	get f()
  	{
	    return this.interestedForm.controls;
    }

    addPerson(event) {
    	event.preventDefault()
    	this.no_of_people = this.no_of_people + 1;
    	this.interestedForm.controls.person.setValue(this.no_of_people);
    }

    minusPerson(event) {
    	event.preventDefault()
    	if(this.no_of_people >= 2) {
    		this.no_of_people = this.no_of_people - 1;
    	} else {
			this.no_of_people = 1;
    	}
    	this.interestedForm.controls.person.setValue(this.no_of_people);
    }


    saveForm(form) {
      console.log(form);
      let payload = new FormData();
      this.submitted = true;
      if (this.interestedForm.invalid) {
        console.log("error");
          return;
      }
      this.date = moment(this.interestedForm.controls.date.value);
      payload.append('name', this.interestedForm.controls.name.value);
      payload.append('contact_no', this.interestedForm.controls.contact_no.value);
      payload.append('email', this.interestedForm.controls.email.value);
      payload.append('city', this.interestedForm.controls.city.value);
      payload.append('date', this.date);
      payload.append('destination', this.interestedForm.controls.destination.value);
      payload.append('budget', this.interestedForm.controls.budget.value);
      payload.append('terms', this.interestedForm.controls.terms.value);
      payload.append('person', this.interestedForm.controls.person.value);
      payload.append('event_id', this.interestedForm.controls.event_id.value);
      console.log(payload);
      // console.log('form success');
       this.event_service.saveForm(payload)
        .subscribe(res => {
            this.result = res;
            if(this.result.code == 200) {
              this.dialogRef.close(this.result.code);
            } else {
              this.errros = this.result.message;
            }
          }, (err) => {
            console.log('error', err);
          }); 

   }

  //Function to close the popup
  close(event) {
    event.preventDefault()
	 this.dialogRef.close(401);
  }  

}
