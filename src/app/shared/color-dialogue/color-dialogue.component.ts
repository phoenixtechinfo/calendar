import { Component, OnInit } from '@angular/core';
import {MAT_DIALOG_DATA, MatDialogRef} from "@angular/material";
import { Inject } from '@angular/core'; 
import { EventService } from '../../services/event.service';

@Component({
  selector: 'app-color-dialogue',
  templateUrl: './color-dialogue.component.html',
  styleUrls: ['./color-dialogue.component.scss']
})
export class ColorDialogueComponent implements OnInit {

  color:any;
  colors_data:any;
  constructor(private dialogRef: MatDialogRef<ColorDialogueComponent>, @Inject(MAT_DIALOG_DATA) data, private event_service: EventService) { 
    this.getAllColors();
  	this.color = data.color;
  }

  ngOnInit() {
  }

  getAllColors() {
    this.event_service.getAllColors()
      .subscribe(res => {
        console.log('res', res);
        this.colors_data = res['data'];
      }, err => {
        console.log('error', err);
      });
  }

  //Function to select the color 
  selectColor(event) {
	console.log('event', event);
	this.dialogRef.close(event);
  }

    redioInitialize(event,color){
      console.log(color);
      event._elementRef.nativeElement.getElementsByClassName('mat-radio-outer-circle')[0].style['border-color'] = color.hexcode;
      event._elementRef.nativeElement.getElementsByClassName('mat-radio-inner-circle')[0].style['background-color'] = color.hexcode;
    }



}
