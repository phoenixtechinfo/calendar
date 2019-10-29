import { Component, OnInit } from '@angular/core';
import {MAT_DIALOG_DATA, MatDialogRef} from "@angular/material";
import { Inject } from '@angular/core'; 

@Component({
  selector: 'app-color-dialogue',
  templateUrl: './color-dialogue.component.html',
  styleUrls: ['./color-dialogue.component.scss']
})
export class ColorDialogueComponent implements OnInit {

  color:any;
  constructor(private dialogRef: MatDialogRef<ColorDialogueComponent>, @Inject(MAT_DIALOG_DATA) data) { 
  	this.color = data.color;
  }

  ngOnInit() {
  }

  //Function to select the color 
  selectColor(event) {
	console.log('event', event.value);
	this.dialogRef.close(event.value);
  }



}
