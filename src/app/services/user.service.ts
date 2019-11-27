import { Injectable } from '@angular/core';
import { BehaviorSubject } from 'rxjs';
import { HttpClient, HttpHeaders, HttpErrorResponse } from '@angular/common/http';
import { Observable, of, throwError } from 'rxjs';
import { catchError, tap, map } from 'rxjs/operators';
import { Globals } from '../shared/globals';

var httpOptions = {
	headers: new HttpHeaders({'Access-Control-Allow-Origin':'*'})
};

@Injectable({
	providedIn: 'root'
})
export class UserService {

	public isUserLoggedIn: BehaviorSubject<boolean> = new BehaviorSubject<boolean>(false);
	api_url:string;
	constructor(private http:HttpClient, private globals: Globals) {
		this.api_url = this.globals.api_url;
	}

	//Api for check the user credentails
	login(user): Observable<any> {
		return this.http.post<any>(this.api_url + 'login', user, httpOptions).pipe(
				tap(data => {
					console.log('api response after login', data);
				})
		);
	}

	//Function to get the user details
	getUserDetails(id):Observable<any> {
		let headers = new HttpHeaders();
		headers = headers.set('Accept', 'application/json');
		headers = headers.set('Authorization', 'Bearer '+id);
		return this.http.get<any>(this.api_url + 'get-user-details', { headers: headers } ).pipe(
				tap(_ => {
						console.log('User details successfully fetched');
				}
			),
			catchError(this.handleError<any>('getUserDetails'))
		);
	}

	//Api for check the eamil id is already registered or not
	  isEmailRegisterd(email: string, id:number ) {
	    return this.http.post<any>(this.api_url + 'check-email', JSON.stringify({'email': email, 'id':id}), {
	      headers: new HttpHeaders({
	        'Content-Type': 'application/json',
	        'Access-Control-Allow-Origin': '*'
	      })
	    }).pipe(
	      tap(_ => console.log('Success')),
	      catchError(this.handleError<any>('check email'))
	    );
	  }

	//Api for edit event
	  saveProfile (data): Observable<any> {
	  	let headers = new HttpHeaders();
		headers = headers.set('Accept', 'application/json');
		headers = headers.set('Authorization', 'Bearer '+ localStorage.getItem('uid'));
	    return this.http.post<any>(this.api_url + 'edit-profile', data, { headers: headers }).pipe(
	      tap(_ => console.log('User edited successfully')),
	      catchError(this.handleError<any>('saveProfile'))
	    );
	  }  

	    //Api for register user
	  registerUser (user): Observable<any> {
	    return this.http.post<any>(this.api_url + 'register-user', user, httpOptions).pipe(
	      tap(_ => console.log('User created successfully')),
	      catchError(this.handleError<any>('registerUser'))
	    );
	  }

	//Function to handle the error
	private handleError<T> (operation = 'operation', result?: T) {
		return (error: any): Observable<T> => {
	 
			// TODO: send the error to remote logging infrastructure
			console.error(error); // log to console instead
	 
			// Let the app keep running by returning an empty result.
			return of(result as T);
		};
	}
}
