import { NgModule } from '@angular/core';
import { CommonModule } from '@angular/common';
import { Routes, RouterModule } from '@angular/router';
import { HomeComponent } from './home/home.component';
import { ScheduleComponent } from './schedule/schedule.component';

const routes: Routes = [
{
    path: '',
    component: HomeComponent,
    data: { title: 'Home page' }
  },
    {
        path: 'schedule',
        component: ScheduleComponent,
        data: { title: 'Schedule' }
    },
 ];

@NgModule({
  declarations: [],
  imports: [RouterModule.forRoot(routes)],
  exports: [RouterModule]		
})
export class AppRoutingModule { }
