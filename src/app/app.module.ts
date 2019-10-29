import { BrowserModule } from '@angular/platform-browser';
import { NgModule } from '@angular/core';
import { FullCalendarModule } from '@fullcalendar/angular';
import { ReactiveFormsModule, FormControl, FormsModule } from '@angular/forms';
import { AppComponent } from './app.component';
import { EventComponent } from './event/event.component';
import { CommonModule } from '@angular/common';
import {
  MatButtonModule, MatCardModule, MatDialogModule, MatInputModule, MatSelectModule,
  MatToolbarModule, MatMenuModule,MatIconModule, MatProgressSpinnerModule, MatRadioModule, MatDatepickerModule, MatNativeDateModule
} from '@angular/material';
import { BrowserAnimationsModule } from '@angular/platform-browser/animations';
import { AppRoutingModule } from './app-routing.module';
import { HomeComponent } from './home/home.component';
import { AmazingTimePickerModule } from 'amazing-time-picker';
import { ColorDialogueComponent } from './shared/color-dialogue/color-dialogue.component'; 


@NgModule({
  declarations: [
    AppComponent,
    EventComponent,
    HomeComponent,
    ColorDialogueComponent
  ],
  imports: [
    CommonModule,
    BrowserModule,
    MatDialogModule,
    MatInputModule,
    MatRadioModule,
    MatToolbarModule,
    FullCalendarModule,
    BrowserAnimationsModule,
    AppRoutingModule, // import the FullCalendar module! will make the FullCalendar component available
    ReactiveFormsModule,
    MatDatepickerModule,
    AmazingTimePickerModule,
    MatNativeDateModule,
    FormsModule,
    MatButtonModule

  ],
  providers: [],
  bootstrap: [AppComponent],
  entryComponents: [EventComponent, ColorDialogueComponent ]
})
export class AppModule { }
