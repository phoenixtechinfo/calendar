import { Injectable } from '@angular/core';
import { HttpClient, HttpHeaders, HttpErrorResponse } from '@angular/common/http';
import { Observable, of, throwError } from 'rxjs';
import { catchError, tap, map } from 'rxjs/operators';
import { BehaviorSubject } from 'rxjs';
import * as moment from 'moment';

const apiUrl = "http://127.0.0.1:8000/api/";
const imageUrl = "http://127.0.0.1:8000/storage";

let headers = new HttpHeaders();
headers = headers.set('Access-Control-Allow-Origin', '*');
headers = headers.set('Authorization', 'Bearer '+localStorage.getItem('uid'));

@Injectable({
  providedIn: 'root'
})
export class EventService {

    private dateSource = new BehaviorSubject({date: moment(), reload: 0});
    private viewTypeSource = new BehaviorSubject(0);
    currentDate = this.dateSource.asObservable();
    viewType = this.viewTypeSource.asObservable();
  constructor(private http:HttpClient) { }

    changeViewType(type:any) {
        this.viewTypeSource.next(type);
    }
    changeCurrentDate(date:any, dataReload:any) {
        this.dateSource.next({date: date, reload: dataReload});
    }

  //Api for create event
  createEvent (data): Observable<any> {
    return this.http.post<any>(`${apiUrl}create-event`, data, { headers: headers }).pipe(
      tap(_ => console.log('Event created successfully')),
      catchError(this.handleError<any>('createEvent'))
    );
  }

  //Api for getting all the events
    getAllEvents(): Observable<any> {
    	return this.http.get(`${apiUrl}get-all-events`, { headers: headers }).pipe(
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
    return this.http.post<any>(`${apiUrl}edit-event`, data, { headers: headers }).pipe(
      tap(_ => console.log('Event edited successfully')),
      catchError(this.handleError<any>('editEvent'))
    );
  }

  //Api for getting all the colors
  getAllColors() {
  return this.http.get(`${apiUrl}get-all-colors`, { headers: headers }).pipe(
      tap(_ => {
        console.log('Fetched all the colors successfully');
      }),
      catchError(this.handleError('getAllColors'))
    );
  }

  //Api for getting all the categories
  getAllCategories() {
  return this.http.get(`${apiUrl}get-all-categories`, { headers: headers }).pipe(
      tap(_ => {
        console.log('Fetched all the categories successfully');
      }),
      catchError(this.handleError('getAllCategories'))
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
