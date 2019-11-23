import { Injectable } from '@angular/core';
import { CanActivate, ActivatedRouteSnapshot, RouterStateSnapshot, UrlTree } from '@angular/router';
import { Observable } from 'rxjs';
import { UserService } from '../../services/user.service';
import { Router } from "@angular/router";


@Injectable({
  providedIn: 'root'
})
export class AuthGuard implements CanActivate {
  	constructor(private api: UserService, private _router: Router) {
	}
	isUserLoggedIn = false;
  	canActivate(next: ActivatedRouteSnapshot, state: RouterStateSnapshot): Observable<boolean> | Promise<boolean> | boolean {
    	this.api.isUserLoggedIn.subscribe( value => {
          console.log(value);
      		this.isUserLoggedIn = value;      
    	});
    	if(this.isUserLoggedIn) {
    		return true;
    	}
    	// navigate to login page
    	this._router.navigate(['/login'], { queryParams: { returnUrl: state.url }});
    	// you can save redirect url so after authing we can move them back to the page they requested
    	return false;
  	}
}
