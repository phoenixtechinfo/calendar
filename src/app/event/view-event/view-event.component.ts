import { Component, OnInit } from '@angular/core';
import {MAT_DIALOG_DATA, MatDialogRef} from "@angular/material";
import { Inject } from '@angular/core'; 
import {MatDialog, MatDialogConfig} from "@angular/material";
import * as moment from 'moment';
import { Router} from '@angular/router';
import { EventService } from '../../services/event.service';
import { Globals } from '../../shared/globals';
import { EditEventComponent } from '../edit-event/edit-event.component';
import { InterestedComponent } from '../interested/interested.component';

@Component({
  selector: 'app-view-event',
  templateUrl: './view-event.component.html',
  styleUrls: ['./view-event.component.scss']
})
export class ViewEventComponent implements OnInit {

  event_id:number;
  events_data:any;
  categories_data:any;
  selected_categories:Array<Object> = [];
  edit_flag:boolean=false;
  interested_flag:boolean=false; 
  img_url:string;
  constructor(private dialogRef: MatDialogRef<ViewEventComponent>, private router: Router, @Inject(MAT_DIALOG_DATA) data, private dialog: MatDialog,  private event_service:EventService, private globals: Globals) { 
  		this.event_id = data.id;
      this.img_url = this.globals.imgUrl;
  }

  ngOnInit() {
  	this.getEventDetails(this.event_id);
  }

  //Function to get all the event details
  getEventDetails(id) {
	 
  	const payload = {
  		'id' : id,
  	};  
      
  	this.event_service.getEventDetails(payload)
  		.subscribe(res => {
  			console.log('res', res);
  			this.events_data = res['data'];
        this.categories_data = res['categories'];
        if(this.events_data.created_by == this.globals.users_data.id) {
          this.edit_flag = true;
        } else {
          this.interested_flag = true;
        }
        this.categories_data.forEach(item => {
          this.selected_categories.push(' '+item.name);
        });
		
  		}, err => {
  			console.log('error', err);
  		});
		
  }

  //Function to edit the event
  editEvent(event) {
  	const dialogConfig = new MatDialogConfig();

    dialogConfig.disableClose = true;
    dialogConfig.autoFocus = true;

    dialogConfig.data = {
        data: this.events_data,
        categories: this.categories_data
    };

    // this.dialog.open(UserdialogueComponent, dialogConfig);
    
    const dialogRef = this.dialog.open(EditEventComponent, dialogConfig);

    dialogRef.afterClosed().subscribe(
        data => {
          if(data == 200) {
          	this.dialogRef.close(data);
          } else {
          	this.dialogRef.close();
          }
        }
    );    
  }

  //function to show the interested form
  showInterestedForm(id) {
    console.log(id);
    const dialogConfig = new MatDialogConfig();

    dialogConfig.disableClose = true;
    dialogConfig.autoFocus = true;

    dialogConfig.data = {
        data: id,
    };

    // this.dialog.open(UserdialogueComponent, dialogConfig);
    
    const dialogRef = this.dialog.open(InterestedComponent, dialogConfig);

    dialogRef.afterClosed().subscribe(
        data => {
          if(data == 200) {
            this.dialogRef.close(data);
          } else {
            this.dialogRef.close();
          }
        }
    );    
  }

  //Function to close the popup
  close() {
	 
      this.dialogRef.close(401);
  }    

}
