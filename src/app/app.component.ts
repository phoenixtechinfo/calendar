import { Component, ViewChild } from '@angular/core';
import { FullCalendarComponent } from '@fullcalendar/angular';
import { EventInput } from '@fullcalendar/core';
import dayGridPlugin from '@fullcalendar/daygrid';
import timeGrigPlugin from '@fullcalendar/timegrid';
import interactionPlugin from '@fullcalendar/interaction'; // for dateClick
import {MatDialog, MatDialogConfig} from "@angular/material";
import { AuthGuard } from './shared/guards/auth.guard';
import { EventComponent } from './event/event.component';
import { UserService } from './services/user.service';
import { Globals } from './shared/globals';
import { Router,ActivatedRoute, NavigationStart, NavigationEnd, RoutesRecognized } from '@angular/router';

@Component({
  selector: 'app-root',
  templateUrl: './app.component.html',
  styleUrls: ['./app.component.scss']
})
export class AppComponent {

  result:any;
  constructor(private dialog: MatDialog, private user_service: UserService, private globals: Globals, private router: Router) { }
	  ngOnInit() {
	  	if(localStorage.getItem('uid')) {
		    const user = this.user_service.getUserDetails(localStorage.getItem('uid')).toPromise();
		    	this.result = user;
		    	console.log(this.result.error);
		    	if(this.result.error != 'Unauthorized') {
				    console.log(this.result);
				    this.globals.users_data = this.result.data
				    this.globals.isUserLoggedInLoggedIn = true;
				    this.user_service.isUserLoggedIn.next(true);
			    } else {
			    	this.user_service.isUserLoggedIn.next(false);
			    	this.router.navigate(['']);
		  		}
	      }
	}
}
