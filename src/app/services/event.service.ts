import { Injectable } from '@angular/core';
import { HttpClient, HttpHeaders, HttpErrorResponse } from '@angular/common/http';
import { Observable, of, throwError } from 'rxjs';
import { catchError, tap, map } from 'rxjs/operators';
import { BehaviorSubject } from 'rxjs';

const apiUrl = "http://127.0.0.1:8000/api/";
const imageUrl = "http://127.0.0.1:8000/storage";

var httpOptions = {
  headers: new HttpHeaders({'Access-Control-Allow-Origin':'*'})
};

@Injectable({
  providedIn: 'root'
})
export class EventService {

  constructor(private http:HttpClient) { }

  //Api for create event
  createEvent (data): Observable<any> {
    return this.http.post<any>(`${apiUrl}create-event`, data, httpOptions).pipe(
      tap(_ => console.log('Event created successfully')),
      catchError(this.handleError<any>('createEvent'))
    );
  }

  //Api for getting all the events
  getAllEvents(): Observable<any> {
	return this.http.get(`${apiUrl}get-all-events`, httpOptions).pipe(
      tap(_ => {
        console.log('Fetched all the events successfully');
      }),
      catchError(this.handleError('getAllEvents'))
    );
  }

  //Function to get event details
  getEventDetails(data): Observable<any> {
  	return this.http.get(`${apiUrl}get-event-details`, { params: data}).pipe(
      tap(_ => {
        console.log('Fetched the events details successfully');
      }),
      catchError(this.handleError('getEventDetails'))
    );
  }

   //Api for edit event
  editEvent (data): Observable<any> {
    return this.http.post<any>(`${apiUrl}edit-event`, data, httpOptions).pipe(
      tap(_ => console.log('Event edited successfully')),
      catchError(this.handleError<any>('editEvent'))
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
