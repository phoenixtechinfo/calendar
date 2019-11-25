// globals.ts
import { Injectable } from '@angular/core';

@Injectable()
export class Globals {
	api_url:string = 'http://127.0.0.1:8000/api/'; 
  imgUrl:string = 'http://127.0.0.1:8000/storage/';
  users_data:any = '';
  isUserLoggedInLoggedIn:boolean = false;
}