import { BrowserModule } from '@angular/platform-browser';
import { NgModule } from '@angular/core';
import { FullCalendarModule } from '@fullcalendar/angular';
import { ReactiveFormsModule, FormControl, FormsModule } from '@angular/forms';
import { AppComponent } from './app.component';
import { EventComponent } from './event/event.component';
import { CommonModule, DatePipe } from '@angular/common';
import { HttpClientModule } from '@angular/common/http';
import {
  MatButtonModule, MatCardModule, MatDialogModule, MatInputModule, MatSelectModule,
  MatToolbarModule, MatMenuModule,MatIconModule, MatProgressSpinnerModule, MatRadioModule, MatDatepickerModule, MatNativeDateModule,
} from '@angular/material';
import { BrowserAnimationsModule } from '@angular/platform-browser/animations';
import { AppRoutingModule } from './app-routing.module';
import { HomeComponent } from './home/home.component';
import { ScheduleComponent } from './schedule/schedule.component';
import { AmazingTimePickerModule } from 'amazing-time-picker';
import { ColorDialogueComponent } from './shared/color-dialogue/color-dialogue.component';
import { ViewEventComponent } from './event/view-event/view-event.component';
import { EditEventComponent } from './event/edit-event/edit-event.component';
import { ScrollDispatchModule } from '@angular/cdk/scrolling';
import {MatSidenavModule} from '@angular/material/sidenav';
import {MatListModule} from '@angular/material/list';
import { NgInitDirective } from './directives/ng-init.directive';
import { Globals } from './shared/globals';
import { LoginComponent } from './login/login.component';
import { AuthGuard } from './shared/guards/auth.guard';
import { RegisterComponent } from './register/register.component';
import { UserResolver } from './shared/user-resolver';
import { UserProfileComponent } from './user-profile/user-profile.component';



@NgModule({
  declarations: [
    AppComponent,
    EventComponent,
    HomeComponent,
    ScheduleComponent,
    ColorDialogueComponent,
    ViewEventComponent,
    EditEventComponent,
    NgInitDirective,
    LoginComponent,
    RegisterComponent,
    UserProfileComponent
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
    MatButtonModule,
    HttpClientModule,
    MatSelectModule,
    MatCardModule,
    MatIconModule,
    MatSidenavModule,
    MatListModule,
    ScrollDispatchModule,
    MatProgressSpinnerModule,
      MatMenuModule

  ],
  providers: [DatePipe, Globals, AuthGuard, UserResolver],
  bootstrap: [AppComponent],
  entryComponents: [EventComponent, ColorDialogueComponent, ViewEventComponent, EditEventComponent, UserProfileComponent ]
})
export class AppModule { }
