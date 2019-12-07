import { Component, OnInit } from '@angular/core';
import { UserService } from '../services/user.service';
import { Globals } from '../shared/globals';
import {FormBuilder, FormGroup, Validators, FormControl, FormGroupDirective, NgForm, AbstractControl} from "@angular/forms";
import { Router,ActivatedRoute, NavigationStart, NavigationEnd, RoutesRecognized } from '@angular/router';
import {MatCardModule} from '@angular/material/card';

@Component({
  selector: 'app-login',
  templateUrl: './login.component.html',
  styleUrls: ['./login.component.scss']
})
export class LoginComponent implements OnInit {

  loginUserForm: FormGroup;
  result:any;
  errors:any = '';
  submitted:boolean = false;
  returnUrl:string = '';

  constructor(private globals: Globals, private user_service: UserService, private router: Router, private formBuilder: FormBuilder, private route: ActivatedRoute) { }

  ngOnInit() {
  	this.loginUserForm = this.formBuilder.group({
      email: ['', Validators.compose([Validators.required, Validators.email])],
      password: ['', Validators.compose([Validators.required])],
    });
    this.returnUrl = this.route.snapshot.queryParams['returnUrl'] || '/';
  }

  //Function to get the form control value
   get f()
   {
     return this.loginUserForm.controls;
   }

   loginUser(form):void {
    this.submitted = true;
      if (this.loginUserForm.invalid) {
          return;
      }
      const payload = {
        email: this.loginUserForm.controls.email.value,
        password: this.loginUserForm.controls.password.value
      };
    this.user_service.login(payload)
      .subscribe(res=> {
        this.result = res;
        if(this.result.success) {
          // localStorage.setItem('user_details', JSON.stringify(this.result.success.data.id));
          localStorage.setItem('uid', this.result.success.token);
          this.globals.users_data = this.result.success.data;
          this.user_service.isUserLoggedIn.next(true);
          this.globals.isUserLoggedInLoggedIn = true;
          if(localStorage.getItem('uid') && this.globals.isUserLoggedInLoggedIn == true) {
            this.router.navigateByUrl(this.returnUrl);
          } else {
            this.router.navigateByUrl('/');
          }
          
        } else {
          this.errors = this.result.error;
          console.log('error',this.errors.message);  
        }
      }, err => {
        console.log('error',err);
      });
  }

}
