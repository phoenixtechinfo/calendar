// globals.ts
import { Injectable } from '@angular/core';

@Injectable()
export class Globals {
	api_url:string = 'http://travelwhistlecalendar.com/admin/public/index.php/api/';
  imgUrl:string = 'http://travelwhistlecalendar.com/admin/public/storage/';
  baseUrl:string = 'http://travelwhistlecalendar.com/admin/public/';
  users_data:any = '';
  categories:any = '';
  isUserLoggedInLoggedIn:boolean = false;
}