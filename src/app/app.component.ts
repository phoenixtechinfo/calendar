import {ChangeDetectionStrategy, Component, ViewChild, ChangeDetectorRef} from '@angular/core';
import {FullCalendarComponent} from '@fullcalendar/angular';
import {EventInput} from '@fullcalendar/core';
import dayGridPlugin from '@fullcalendar/daygrid';
import timeGrigPlugin from '@fullcalendar/timegrid';
import interactionPlugin from '@fullcalendar/interaction'; // for dateClick
import {MatDialog, MatDialogConfig, MatMenuModule} from "@angular/material";
import { AuthGuard } from './shared/guards/auth.guard';
import { EventComponent } from './event/event.component';
import { UserService } from './services/user.service';
import { Globals } from './shared/globals';
import { Router,ActivatedRoute, NavigationStart, NavigationEnd, RoutesRecognized } from '@angular/router';
import * as moment from 'moment';
import {MAT_MOMENT_DATE_ADAPTER_OPTIONS, MomentDateAdapter} from '@angular/material-moment-adapter';
import {DateAdapter, MAT_DATE_FORMATS, MAT_DATE_LOCALE} from '@angular/material/core';
import {FormControl} from '@angular/forms';
import {EventService} from './services/event.service';
import { UserProfileComponent } from './user-profile/user-profile.component';

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

    result:any;
    selectedDateFormControl:any;
   viewType:any;
   isUserLoggedIn:boolean; 
  constructor(private dialog: MatDialog, private user_service: UserService, private globals: Globals, private router: Router, private event_service: EventService, private changeDetection: ChangeDetectorRef) {
        this.selectedDateFormControl = new FormControl(moment());
        this.event_service.currentDate.subscribe(data => this.selectedDateFormControl = new FormControl(data.date));
        this.event_service.viewType.subscribe(type => this.viewType = type);
        this.user_service.isUserLoggedIn.subscribe( value => {
          this.isUserLoggedIn = value;
        });
   }
	  ngOnInit() {
	  	if(localStorage.getItem('uid')) {
		    const user = this.user_service.getUserDetails(localStorage.getItem('uid')).toPromise();
		    	this.result = user;
		    	console.log(this.result.error);
		    	if(this.result.error != 'Unauthorized') {
				    console.log(this.result);
				    this.globals.users_data = this.result.data;
                    this.globals.categories = this.result.categories;
				    this.globals.isUserLoggedInLoggedIn = true;
				    this.user_service.isUserLoggedIn.next(true);
			    } else {
			    	this.user_service.isUserLoggedIn.next(false);
			    	this.router.navigate(['']);
		  		}
	      }
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

    logout() {
        localStorage.removeItem('uid');
        this.globals.users_data = {};
        this.globals.isUserLoggedInLoggedIn = false;
        this.user_service.isUserLoggedIn.next(false);
        this.router.navigate(['login']);
  }

    editProfile(arg) {

        const dialogConfig = new MatDialogConfig();

        dialogConfig.disableClose = true;
        dialogConfig.autoFocus = true;

        dialogConfig.data = {
                type:arg
        };

        // this.dialog.open(UserdialogueComponent, dialogConfig);
        
        const dialogRef = this.dialog.open(UserProfileComponent, dialogConfig);

        dialogRef.afterClosed().subscribe(
                data => {
                    if(data == 200) {
                        console.log('vivek');
                    }
                }
        );    

    }

}
