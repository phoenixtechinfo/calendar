import { Injectable } from '@angular/core';
import { Resolve, ActivatedRouteSnapshot, RouterStateSnapshot } from '@angular/router';
import { UserService } from '../services/user.service';
import { Observable } from 'rxjs';
import { Globals } from './globals';

@Injectable()

export class UserResolver implements Resolve<any> {
    constructor(private user_service: UserService, private globals: Globals){}
    users: any = [];
    result;
    async resolve(route: ActivatedRouteSnapshot, state: RouterStateSnapshot){
        if(localStorage.getItem('uid')) {
            if(this.globals.users_data == '' || this.globals.users_data == null || this.globals.users_data == undefined) {
                const user = await this.user_service.getUserDetails(localStorage.getItem('uid')).toPromise();
                if(user.error  != 'Unauthorized') {
                    this.result = user;
                    this.globals.users_data = this.result.data;
                    this.user_service.isUserLoggedIn.next(true);
                    return user;
                } else {
                    this.globals.users_data = '';
                    this.user_service.isUserLoggedIn.next(false);
                    return null;
                }
                
            } else {
              console.log('res in reolver', 'null');
                  return ;
            }
        }
        return '';
    }
}
