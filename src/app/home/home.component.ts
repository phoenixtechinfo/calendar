import { Component, OnInit, ViewChild } from '@angular/core';
import { FullCalendarComponent } from '@fullcalendar/angular';
import { EventInput } from '@fullcalendar/core';
import dayGridPlugin from '@fullcalendar/daygrid';
import timeGrigPlugin from '@fullcalendar/timegrid';
import interactionPlugin from '@fullcalendar/interaction'; // for dateClick
import {MatDialog, MatDialogConfig} from "@angular/material";
import { EventComponent } from '../event/event.component';
import { EventService } from '../services/event.service';
import { ViewEventComponent } from '../event/view-event/view-event.component';


@Component({
  selector: 'app-home',
  templateUrl: './home.component.html',
  styleUrls: ['./home.component.scss']
})
export class HomeComponent implements OnInit {

  @ViewChild('calendar') calendarComponent: FullCalendarComponent; // the #calendar in the template

  constructor(private dialog: MatDialog, private event_service:EventService) { }

  ngOnInit() {
    this.getAllEvents();
  }

  calendarVisible = true;
  showmodel:boolean;
  date:string = '';
  calendarPlugins = [dayGridPlugin, timeGrigPlugin, interactionPlugin];
  calendarWeekends = true;
  calendarEvents: EventInput[] = [];
  // calendarEvents: EventInput[] = [
  //   { id: '1', title: 'Event Now', start: new Date() },
  //   { id: '2', title: 'Test Event', start: new Date(2019, 9, 13), color: 'black', editable: true,textColor:'red' },
  //   { id: '3', title: 'Test Event', start: new Date(2019, 9, 14), color: 'green', editable: true,textColor:'white' },
  //   { id: '4', title: 'Test Event', start: new Date(2019, 9, 14), color: 'yellow', editable: true,textColor:'white' },
  //   { id: '5', title: 'Test Event', start: new Date(2019, 9, 15), color: 'blue', editable: true,textColor:'white' },
  //   { id: '6', title: 'Test Event', start: new Date(2019, 9, 16), color: 'purple', editable: true,textColor:'white' },
  //   { id: '7', title: 'Test Event', start: new Date(2019, 9, 17), color: 'orange', editable: true,textColor:'white' },
  //   { id: '8', title: 'Test Event', start: new Date(2019, 9, 18), color: 'pink', editable: true,textColor:'white' },
  //   { id: '9', title: 'Test Event', start: new Date(2019, 9, 19), color: 'black', editable: true,textColor:'white' },
  // ];

  toggleVisible() {
    this.calendarVisible = !this.calendarVisible;
  }

  toggleWeekends() {
    this.calendarWeekends = !this.calendarWeekends;
  }

  //Function to get all the events
  getAllEvents() {
    this.event_service.getAllEvents()
      .subscribe(res => {
        console.log('res', res['data']);
        this.calendarEvents = [];
        res['data'].forEach(obj => {
          let data:any = {};
           data.id = obj.id;
           data.title = obj.title;
           data.start = new Date(obj.start_datetime);
           data.end = new Date(obj.end_datetime);
           data.color =this.selectColor(obj.color);
           data.textColor = 'white';
           this.calendarEvents.push(data);
           console.log('calendar', this.calendarEvents);
        })
      }, err => {
        console.log('err', err);
      })
  }

  gotoPast() {
    let calendarApi = this.calendarComponent.getApi();
    calendarApi.gotoDate('2000-01-01'); // call a method on the Calendar object
  }

  createEvent(arg) {

    const dialogConfig = new MatDialogConfig();

    dialogConfig.disableClose = true;
    dialogConfig.autoFocus = true;

    dialogConfig.data = {
        type:arg
    };

    // this.dialog.open(UserdialogueComponent, dialogConfig);
    
    const dialogRef = this.dialog.open(EventComponent, dialogConfig);

    dialogRef.afterClosed().subscribe(
        data => {
          if(data == 200) {
            this.getAllEvents();
          }
        }
    );    

  }
  hide() {
    this.showmodel = false;
  }

  getEventDetails(event) {
    const dialogConfig = new MatDialogConfig();

    dialogConfig.disableClose = true;
    dialogConfig.autoFocus = true;

    dialogConfig.data = {
        id:event.event.id
    };

    // this.dialog.open(UserdialogueComponent, dialogConfig);
    
    const dialogRef = this.dialog.open(ViewEventComponent, dialogConfig);

    dialogRef.afterClosed().subscribe(
        data => {
          if(data == 200) {
            this.getAllEvents();
          }
        }
    );    
  }

  //Function to get the color code
  selectColor(color) {
    switch(color) {
      case "tometo" : 
        return '#ff6347';
        break;
      case "tangerine" : 
        return '#f28500';
        break;
      case "banana" : 
        return '#ffe135';
        break;
      case "basil" : 
        return '#579229';
        break;
      case "sage" : 
        return '#77815c';
        break;
      case "peacock" : 
        return '#33A1C9';
        break;
      case "blueberry" : 
        return '#4f86f7';
        break;
      case "lavander" : 
        return '#b57edc';
        break;
      case "grape" : 
        return '#6f2da8';
        break;
       case "flamingo" : 
        return '#fc8eac';
        break;
       case "graphite" : 
        return '#383428';
        break;
      default : 
        return '#0000FF';
        break;
    }
  }

}
