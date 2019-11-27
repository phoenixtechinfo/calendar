import { Component, OnInit, Input, EventEmitter, Output, Inject } from '@angular/core';
import {MAT_DIALOG_DATA, MatDialogRef} from "@angular/material";
import {ErrorStateMatcher} from '@angular/material/core';
import { Router} from '@angular/router';
import { DateAdapter, MatDatepickerInputEvent } from '@angular/material';
import {FormBuilder, FormGroup, Validators, FormControl, FormGroupDirective, NgForm, AbstractControl} from "@angular/forms";
import {MatDialog, MatDialogConfig} from "@angular/material";
import { EventService } from '../services/event.service';
import { UserService } from '../services/user.service';
import { Globals } from '../shared/globals';

/** Error when invalid control is dirty, touched, or submitted. */
export class MyErrorStateMatcher implements ErrorStateMatcher {
  isErrorState(control: FormControl | null, form: FormGroupDirective | NgForm | null): boolean {
    const isSubmitted = form && form.submitted;
    return !!(control && control.invalid && (control.dirty || control.touched || isSubmitted));
  }
}

@Component({
  selector: 'app-user-profile',
  templateUrl: './user-profile.component.html',
  styleUrls: ['./user-profile.component.scss']
})
export class UserProfileComponent implements OnInit {

	userForm: FormGroup;
    submitted:boolean= false;
    result:any;
    errros:any;
    fileData: File = null;
    previewUrl:any = null;
    fileUploadProgress: string = null;
    uploadedFilePath: string = null;
    image_error:boolean = false;
    categories_data:any;
	selected_categories:any;
	selected_categories_data:Array<Object> = [];
	constructor(private formBuilder: FormBuilder, private dialogRef: MatDialogRef<UserProfileComponent>, private router: Router, @Inject(MAT_DIALOG_DATA) data, private adapter : DateAdapter<any>, private dialog: MatDialog, private event_service:EventService, private user_service: UserService, private globals: Globals) {
		this.selected_categories = this.globals.categories;
		this.getCategories();
	}

	ngOnInit() {
		this.userForm = this.formBuilder.group({
		      firstname: ['', Validators.compose([Validators.required])],
		      lastname: ['', Validators.compose([Validators.required])],
		      email: ['', Validators.compose([Validators.required, Validators.email]), this.isEmailUnique.bind(this)],
      		  password: [''],
		      profile_image: [''],
		      contact_no:[''],
		      category: [''],
		    });
		this.userForm.controls.firstname.setValue(this.globals.users_data.firstname);
	  	this.userForm.controls.lastname.setValue(this.globals.users_data.lastname);
	  	this.userForm.controls.email.setValue(this.globals.users_data.email);
	  	this.userForm.controls.contact_no.setValue(this.globals.users_data.mobilenumber);
	  	if(this.globals.users_data.profile_image == null) {
	  		this.previewUrl = this.globals.imgUrl + '/uploads/event_images/no-image.png';	
	  	} else {
	  		this.previewUrl = this.globals.imgUrl + this.globals.users_data.profile_image;
	  	}
	    
	}

	//Function to get the form control values 
  	get f()
  	{
	    return this.userForm.controls;
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
	        this.userForm.controls.category.setValue(this.selected_categories_data);
	      }, err => {
	        console.log('error', err);
	      });
	}

	  //Function to set the password validation conditinally
	  checkPassword(value) {
	    if(value != '' && value != null && value != undefined) {
	      this.userForm.get('password').setValidators([Validators.compose([Validators.required, Validators.pattern('(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*[$@$!%*?&])[A-Za-z\d$@$!%*?&].{8,}')])]);
	    } else {
	      this.userForm.get('password').setErrors({'required': null, 'pattern': null});
	      this.userForm.get('password').reset();
	      this.userForm.get('password').clearValidators();
	    }
	  }

	//Function to check the email is already registered or not
	  isEmailUnique(control: FormControl) {
	    let result;
	    let id = this.globals.users_data.id;
	    console.log('id', id);
	    const q = new Promise((resolve, reject) => {
	      this.user_service.isEmailRegisterd(control.value, id).subscribe((res) => {
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

	   //Function to save the event details
  saveProfile(form) {
      console.log(form);
      let payload = new FormData();
      this.submitted = true;
      if (this.userForm.invalid || this.image_error == true) {
        console.log("error");
          return;
      }

      payload.append('firstname', this.userForm.controls.firstname.value);
      payload.append('lastname', this.userForm.controls.lastname.value);
      payload.append('email', this.userForm.controls.email.value);
      payload.append('contact_no', this.userForm.controls.contact_no.value);
      payload.append('category', this.userForm.controls.category.value.toString());
      payload.append('image', this.fileData);
      if(this.userForm.controls.password.value != '') {
      	payload.append('password', this.userForm.controls.password.value);
      }
      // console.log('form success');
       this.user_service.saveProfile(payload)
        .subscribe(res => {
            this.result = res;
            if(this.result.code == 200) {
              this.dialogRef.close(this.result.code);
              location.reload();
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
	 this.dialogRef.close();
  }    

}
