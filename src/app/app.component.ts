import {ChangeDetectionStrategy, Component, ViewChild, ChangeDetectorRef} from '@angular/core';
import {FullCalendarComponent} from '@fullcalendar/angular';
import {EventInput} from '@fullcalendar/core';
import dayGridPlugin from '@fullcalendar/daygrid';
import timeGrigPlugin from '@fullcalendar/timegrid';
import interactionPlugin from '@fullcalendar/interaction'; // for dateClick
import {MatDialog, MatDialogConfig} from '@angular/material';
import {EventComponent} from './event/event.component';
import * as moment from 'moment';
import {MAT_MOMENT_DATE_ADAPTER_OPTIONS, MomentDateAdapter} from '@angular/material-moment-adapter';
import {DateAdapter, MAT_DATE_FORMATS, MAT_DATE_LOCALE} from '@angular/material/core';
import {FormControl} from '@angular/forms';
import {EventService} from './services/event.service';

export const MY_FORMATS = {
    parse: {
        dateInput: 'MM/YYYY',
    },
    display: {
        dateInput: 'MMM YYYY',
        monthYearLabel: 'MMM YYYY',
        dateA11yLabel: 'LL',
        monthYearA11yLabel: 'MMMM YYYY',
    },
};

@Component({
    selector: 'app-root',
    templateUrl: './app.component.html',
    styleUrls: ['./app.component.scss'],
    changeDetection: ChangeDetectionStrategy.OnPush,
    providers: [
        {
            provide: DateAdapter,
            useClass: MomentDateAdapter,
            deps: [MAT_DATE_LOCALE, MAT_MOMENT_DATE_ADAPTER_OPTIONS]
        },
        {provide: MAT_DATE_FORMATS, useValue: MY_FORMATS},
    ],
})
export class AppComponent {

    selectedDateFormControl:any;
    viewType:any;
    constructor(private dialog: MatDialog, private event_service: EventService, private changeDetection: ChangeDetectorRef) {
        this.selectedDateFormControl = new FormControl(moment());
        this.event_service.currentDate.subscribe(data => this.selectedDateFormControl = new FormControl(data.date));
        this.event_service.viewType.subscribe(type => this.viewType = type);
    }

    dateChange(){
        this.event_service.changeCurrentDate(this.selectedDateFormControl.value, 1);
    }

    setViewType(type){
        this.event_service.changeViewType(type);
    }

    currentDateSelect(){
        this.event_service.changeCurrentDate(moment(), 1);
    }

}
