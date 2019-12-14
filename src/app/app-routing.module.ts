import { NgModule } from '@angular/core';
import { CommonModule } from '@angular/common';
import { Routes, RouterModule } from '@angular/router';
import { HomeComponent } from './home/home.component';
import { ScheduleComponent } from './schedule/schedule.component';
import { LoginComponent } from './login/login.component';
import { RegisterComponent } from './register/register.component';
import { AuthGuard } from './shared/guards/auth.guard';
import { UserResolver } from './shared/user-resolver';

const routes: Routes = [
    {
        path: 'home',
        component: HomeComponent,
        data: { title: 'Home page' },
        resolve : {
          user: UserResolver
        },
        canActivate: [AuthGuard],
    },
    {
        path: 'login',
        component: LoginComponent,
        data: { title: 'Login page' }
    },
    {
        path: 'register',
        component: RegisterComponent,
        data: { title: 'Registers page' }
    },
    {
        path: '',
        component: ScheduleComponent,
        data: { title: 'Schedule' },
        resolve : {
          user: UserResolver
        },
        canActivate: [AuthGuard],
    },
 ];

@NgModule({
  declarations: [],
  imports: [RouterModule.forRoot(routes)],
  exports: [RouterModule]		
})
export class AppRoutingModule { }
