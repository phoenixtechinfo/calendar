import { Component, OnInit, ViewChild } from '@angular/core';
import { FullCalendarComponent } from '@fullcalendar/angular';
import { EventInput } from '@fullcalendar/core';
import dayGridPlugin from '@fullcalendar/daygrid';
import timeGrigPlugin from '@fullcalendar/timegrid';
import interactionPlugin from '@fullcalendar/interaction'; // for dateClick
import {MatDialog, MatDialogConfig} from "@angular/material";
import { EventComponent } from '../event/event.component';


@Component({
  selector: 'app-home',
  templateUrl: './home.component.html',
  styleUrls: ['./home.component.scss']
})
export class HomeComponent implements OnInit {

  @ViewChild('calendar') calendarComponent: FullCalendarComponent; // the #calendar in the template

  constructor(private dialog: MatDialog) { }

  ngOnInit() {
  }

  calendarVisible = true;
  showmodel:boolean;
  date:string = '';
  calendarPlugins = [dayGridPlugin, timeGrigPlugin, interactionPlugin];
  calendarWeekends = true;
  calendarEvents: EventInput[] = [
    { title: 'Event Now', start: new Date() },
    { title: 'Test Event', start: new Date(2019, 9, 13), color: 'black', editable: true,textColor:'red' },
    { title: 'Test Event', start: new Date(2019, 9, 14), color: 'green', editable: true,textColor:'white' },
    { title: 'Test Event', start: new Date(2019, 9, 14), color: 'yellow', editable: true,textColor:'white' },
    { title: 'Test Event', start: new Date(2019, 9, 15), color: 'blue', editable: true,textColor:'white' },
    { title: 'Test Event', start: new Date(2019, 9, 16), color: 'purple', editable: true,textColor:'white' },
    { title: 'Test Event', start: new Date(2019, 9, 17), color: 'orange', editable: true,textColor:'white' },
    { title: 'Test Event', start: new Date(2019, 9, 18), color: 'pink', editable: true,textColor:'white' },
    { title: 'Test Event', start: new Date(2019, 9, 19), color: 'black', editable: true,textColor:'white' },
  ];

  toggleVisible() {
    this.calendarVisible = !this.calendarVisible;
  }

  toggleWeekends() {
    this.calendarWeekends = !this.calendarWeekends;
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
            console.log('success');
          }
        }
    );    

    // this.showmodel = true;
    // console.log('test');
    // if (confirm('Would you like to add an event to ' + arg.dateStr + ' ?')) {
    //   this.calendarEvents = this.calendarEvents.concat({ // add new event data. must create new array
    //     title: 'New Event',
    //     start: arg.date,
    //     allDay: arg.allDay
    //   })
    //   this.date  = arg.date;
    // }
  }
  hide() {
    this.showmodel = false;
  }

}
