import { Component, OnInit } from '@angular/core';
import { ErrorStateMatcher } from '@angular/material/core';
import { UserService } from '../services/user.service';
import { Globals } from '../shared/globals';
import { Router,ActivatedRoute, NavigationStart, NavigationEnd, RoutesRecognized } from '@angular/router';
import {FormBuilder, FormGroup, Validators, FormControl, FormGroupDirective, NgForm, AbstractControl} from "@angular/forms";

/** Error when invalid control is dirty, touched, or submitted. */
export class MyErrorStateMatcher implements ErrorStateMatcher {
  isErrorState(control: FormControl | null, form: FormGroupDirective | NgForm | null): boolean {
    const isSubmitted = form && form.submitted;
    return !!(control && control.invalid && (control.dirty || control.touched || isSubmitted));
  }
}

@Component({
  selector: 'app-register',
  templateUrl: './register.component.html',
  styleUrls: ['./register.component.scss']
})
export class RegisterComponent implements OnInit {

	createUserForm: FormGroup;
	submitted:boolean;
	result:any;
	errros:any;
	baseUrl:string;
	constructor(private globals: Globals, private user_service: UserService, private router: Router, private formBuilder: FormBuilder, private route: ActivatedRoute) {
		this.baseUrl = this.globals.baseUrl;
	}

	ngOnInit() {
		this.createUserForm = this.formBuilder.group({
		    firstname: ['', Validators.compose([Validators.required])],
		    lastname: ['', Validators.compose([Validators.required])],
		    email: ['', Validators.compose([Validators.required, Validators.email]), this.isEmailUnique.bind(this)],
		    password: ['', Validators.compose([Validators.required, Validators.pattern('(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*[$@$!%*?&])[A-Za-z\d$@$!%*?&].{8,}')])],
	    });
	}

	//Function to get the form control value
	get f()
  	{
		return this.createUserForm.controls;
  	}

  	//Function to save the user details
	addUser(form) {
	    console.log(form);
	    this.submitted = true;
	      if (this.createUserForm.invalid) {
	        console.log("error");
	          return;
	      }
	      const payload = {
	        firstname: this.createUserForm.controls.firstname.value,
	        lastname: this.createUserForm.controls.lastname.value,
	        email: this.createUserForm.controls.email.value,
	        password: this.createUserForm.controls.password.value
	      };
	    this.user_service.registerUser(payload)
	        .subscribe(res => {
	            this.result = res;
	            if(this.result.code == 200) {
	            	localStorage.setItem('uid', this.result.token);
	                this.globals.users_data = this.result.data;
	                this.user_service.isUserLoggedIn.next(true);
	              	this.router.navigate(['/']);
	            } else {
	              this.errros = this.result.message;
	            }
	          }, (err) => {
	            console.log('error', err);
	          }); 
	}
   
	  //Function to check the email is already registered or not
	  isEmailUnique(control: FormControl) {
	    let result;
	    const q = new Promise((resolve, reject) => {
	      this.user_service.isEmailRegisterd(control.value, null).subscribe((res) => {
	        result =  res;
	        if(result == 1){
	          resolve({ 'isEmailUnique': true });
	        } else {
	          resolve();
	        }
	      }, () => { resolve({ 'isEmailUnique': true }); console.log('test'); });
	    });
	    return q;
	  }
	  matcher = new MyErrorStateMatcher();

}
