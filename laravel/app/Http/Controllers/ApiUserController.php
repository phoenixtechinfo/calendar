<?php

namespace App\Http\Controllers;

use App\Mail\Commonmail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use URL;

class ApiUserController extends Controller
{

    public function Register(Request $r)
    { 
        try {
            DB::beginTransaction();
            $authDB = DB::table('auth')->where('id', '1')->value('auth');
            if (Hash::check($r->header('Auth'), $authDB)) {
                $email = DB::table('users')->where('email', $r->email)->value('id');
                if ($email) {
                    return $this->respondJson(false, trans('message.email-validation'));
                } else {
                    $rand_no = rand(1000, 9999);
                    $token = uniqid(base64_encode(str_random(60)));
                    $data = [
                        'name' => $r->name,
                        'password' => Hash::make($r->password),
                        'otp' => $rand_no,
                        'remember_token' => $token,
                        'email' => $r->email,
                        'verified_at' => 'email',
                        'gender' => $r->gender,
                        'dob' => $r->dob,
                        'updated_at' => date('Y-m-d H:i:s'),
                    ]; 
                    $user = DB::table('users')->insertgetid($data); //print_r($user);die;
                    if ($user) {
                        if ($r->device_token && $r->device_type) {
                            $device = DB::table('device_token')->where('device_token', $r->device_token)->value('user_id');
                            if ($device) {
                                $device_token = DB::table('device_token')->where('device_token', $r->device_token)->update(['user_id' => $user, 'updated_at' => date('Y-m-d H:i:s')]);
                            } else {
                                DB::table('device_token')->insertGetId(['device_token' => $r->device_token, 'device_type' => $r->device_type, 'user_id' => $user, 'updated_at' => date('Y-m-d H:i:s')]);
                            }
                        }
                        $msg = str_replace(["[name]", "[otp]"], [$r->name, $rand_no], config('notification.new_user'));
                        Mail::to($r->email)->send(new Commonmail($msg, 'Welcome to SHEERS'));
                        DB::commit();
                        return $this->respondJson(true, trans('message.registration_success'), array('user_id' => $user, 'access_token' => $token));
                    } else {
                        return $this->respondJson(false, trans('message.registration_error'));
                    }
                }
            } else {
                return $this->respondJson(false, 'Authentication Failed');
            }
        } catch (Exception $ex) {
            $ex->getMessage();
            DB::rollback();
        }
    }

    public function login(Request $r)
    { 
        try {
            DB::beginTransaction();
            $authDB = DB::table('auth')->where('id', '1')->value('auth');
            if (Hash::check($r->header('Auth'), $authDB)) {
                $user = DB::table('users')->where(['email' => $r->email, 'role' => 1])->first();
                if ($user) { 
                    if ($user->status == 0) { 
                        return $this->respondJson(true, trans('message.login_status_error'), array('user_id' => $user->id, 'status' => $user->status, 'access_token' => $user->remember_token));
                    } else if (Hash::check($r->password, $user->password)) {
                        if ($r->device_token && $r->device_type) {
                            $device = DB::table('device_token')->where('device_token', $r->device_token)->value('user_id');
                            if ($device) {
                                $device_token = DB::table('device_token')->where('device_token', $r->device_token)->update(['user_id' => $user->id, 'updated_at' => date('Y-m-d H:i:s')]);
                            } else {
                                DB::table('device_token')->insertGetId(['device_token' => $r->device_token, 'device_type' => $r->device_type, 'user_id' => $user->id, 'updated_at' => date('Y-m-d H:i:s')]);
                            }
                        }
                        DB::commit();
                    return $this->respondJson(true, trans('message.login_success'), array('user_id' => $user->id,
                                'name'  => $user->name,
                                'email'  => $user->email,
                                'verified_at' => $user->verified_at,
                                'status' => $user->status,
                                'gender' => $user->gender,
                                'dob' => date('d-M-Y', strtotime($user->dob)),
                                'profile_status' => $user->profile_status,
                                'profile_pic' => ($user->profile_pic ? $user->profile_pic : url('assets/images/user/user.jpeg')),
                                'access_token' => $user->remember_token,
                                'location' => $user->location,
                                'lat' => $user->lat,
                                'lng' => $user->lng,
                                'notification' => $user->notification,
                                'availability' => $user->availability
                        ));
                    } else {
                        return $this->respondJson(false, trans('message.password_error'));
                    }
                } else {
                    return $this->respondJson(false, trans('message.login_error'));
                }
            } else {
                return $this->respondJson(false, 'Authentication Failed');
            }
        } catch (Exception $ex) {
            echo $ex->getMessage();
            DB::rollback();
        }
    }
    
    public function login_fb(Request $r)
    { 
        try {
            $authDB = DB::table('auth')->where('id', '1')->value('auth');
            if (Hash::check($r->header('Auth'), $authDB)) {
                $user = DB::table('users')->where('fb_login', $r->fb_login)->first();
                if ($user) { 
                    if ($r->device_token && $r->device_type) {
                        $device = DB::table('device_token')->where('device_token', $r->device_token)->value('user_id');
                        if ($device) {
                                $device_token = DB::table('device_token')->where('device_token', $r->device_token)->update(['user_id' => $user->id, 'updated_at' => date('Y-m-d H:i:s')]);
                        } else {
                                DB::table('device_token')->insertGetId(['device_token' => $r->device_token, 'device_type' => $r->device_type, 'user_id' => $user->id, 'updated_at' => date('Y-m-d H:i:s')]);
                        }
                    }
                    return $this->respondJson(true, trans('message.fb_login_success'), array('user_id' => $user->id,
                            'name'  => $user->name,
                            'email' => $user->email,
                            'verified_at' => $user->verified_at,
                            'status' => $user->status,
                            'gender' => $user->gender,
                            'dob' => date('d-M-Y', strtotime($user->dob)),
                            'profile_status' => $user->profile_status,
                            'profile_pic' => ($user->profile_pic ? $user->profile_pic : url('assets/images/user/user.jpeg')),
                            'access_token' => $user->remember_token,
                            'location' => $user->location,
                            'lat' => $user->lat,
                            'lng' => $user->lng,
                            'notification' => $user->notification,
                            'availability' => $user->availability
                        ));
                }else{
                    $userEmail=DB::table('users')->where(['email'=>$r->email])->first();
                    if($userEmail){
                        if($userEmail->login_with == 'Fb'){
                            $user = DB::table('users')->where('id', $userEmail->id)->update(['fb_login' => $r->fb_login,'updated_at' => date('Y-m-d H:i:s')]);
                            if ($r->device_token && $r->device_type) {
                                $device = DB::table('device_token')->where('device_token', $r->device_token)->value('user_id');
                                if ($device) {
                                        $device_token = DB::table('device_token')->where('device_token', $r->device_token)->update(['user_id' => $userEmail->id, 'updated_at' => date('Y-m-d H:i:s')]);
                                } else {
                                        DB::table('device_token')->insertGetId(['device_token' => $r->device_token, 'device_type' => $r->device_type, 'user_id' => $userEmail->id, 'updated_at' => date('Y-m-d H:i:s')]);
                                }
                            }
                            return $this->respondJson(true, trans('message.fb_login_success'), array(
                                    'name'  => $userEmail->name,
                                    'email'  => $userEmail->email,
                                    'verified_at' => $userEmail->verified_at,
                                    'status' => $userEmail->status,
                                    'gender' => $userEmail->gender,
                                    'dob' => date('d-M-Y', strtotime($userEmail->dob)),
                                    'profile_status' => $userEmail->profile_status,
                                    'profile_pic' => ($userEmail->profile_pic ? $userEmail->profile_pic : url('assets/images/user/user.jpeg')),
                                    'access_token' => $userEmail->remember_token,
                                    'location' => $userEmail->location,
                                    'lat' => $userEmail->lat,
                                    'lng' => $userEmail->lng,
                                    'notification' => $userEmail->notification,
                                    'availability' => $userEmail->availability
                            ));
                        }else{
                                return $this->respondJson(true, trans('message.fb_validation_error'));
                        }
                    }else{
                        $newuser = DB::table('users')->insertGetId(['name' => $r->name,'email' => $r->email, 'fb_login' => $r->fb_login,'login_with' => 'Fb' ,'profile_pic' => $r->profile_pic,'status' => 1,'updated_at' => date('Y-m-d H:i:s'), 'remember_token' => uniqid(base64_encode(str_random(60)))]);
                        if($newuser){
                            $user = DB::table('users')->where('id',$newuser)->first();
                            return $this->respondJson(true, trans('message.fb_login_success'), array(
                                    'name'  => $user->name,
                                    'email' => $user->email,
                                    'verified_at' => $user->verified_at,
                                    'status' => $user->status,
                                    'gender' => $user->gender,
                                    'dob' => date('d-M-Y', strtotime($user->dob)),
                                    'profile_status' => $user->profile_status,
                                    'profile_pic' => ($user->profile_pic ? $user->profile_pic : url('assets/images/user/user.jpeg')),
                                    'access_token' => $user->remember_token,
                                    'location' => $user->location,
                                    'lat' => $user->lat,
                                    'lng' => $user->lng,
                                    'notification' => $user->notification,
                                    'availability' => $user->availability
                            ));
                        }else{
                            return $this->respondJson(true, trans('message.fb_login_error'));
                        }
                    }
                }
            } else {
                return $this->respondJson(false, 'Authentication Failed');
            }
        } catch (Exception $ex) {
            echo $ex->getMessage();
            DB::rollback();
        }
    }

    public function ForgotPassword(Request $r)
    {
        try {
            DB::beginTransaction();
            $email =DB::table('users')->where(['email'=> $r->email, 'status'=>1])->first(); 
            if ($email) {
                $otp = rand(1111, 9999);
                    $msg = str_replace(["[name]", "[otp]"], [$email->name, $otp], config('notification.forgot_password'));
                    Mail::to($email->email)->send(new Commonmail($msg, 'Otp Verification Password'));
                DB::table('users')->where('id', $email->id)->update(['forgot_password' => $otp, 'updated_at' => date('Y-m-d h:i:s')]);
                DB::commit();
                return $this->respondJson(true, trans('message.forgot_success'), array('user_id' => $email->id, 'email' => $email->email, 'access_token' => $email->remember_token));
            } else {
                return $this->respondJson(false, trans('message.forgot_error'));
            }
        } catch (Exception $ex) {
            echo $ex->getMessage();
            DB::rollback();
        }
    }

    public function CheckOtp(Request $r)
    {
        try {
            DB::beginTransaction();
            $user = DB::table('users')->where(['id' => $r->user_id, 'otp' => $r->otp])->first();
            if ($user) {
                Db::table('users')->where('id', $r->user_id)->update(['otp' => 0, 'status' => 1, 'updated_at' => date('Y-m-d H:i:s')]);
                $data = [
                    'user_id' => $user->id,
                    'name'  => $user->name,
                    'email'  => $user->email,
                    'verified_at' => $user->verified_at,
                    'status' => 1,
                    'gender' => $user->gender,
                    'dob' => date('d-M-Y', strtotime($user->dob)),
                    'profile_status' => $user->profile_status,
                    'profile_pic' => ($user->profile_pic ? $user->profile_pic : url('assets/images/user.png')),
                    'access_token' => $user->remember_token,
                    'location' => $user->location,
                    'lat' => $user->lat,
                    'lng' => $user->lng,
                    'notification' => $user->notification,
                    'availability' => $user->availability
                ];
                DB::commit();
                return $this->respondJson(true, trans('message.checkotp_success'), $data);
            } else {
                return $this->respondJson(false, trans('message.checkotp_error'));
            }
        } catch (Exception $ex) {
            $ex->getMessage();
            DB::rollback();
        }
    }

    public function ResendOtp(Request $r)
    { 
        try {
            DB::beginTransaction();
            $user = Db::table('users')->where('id', $r->user_id)->first();
            if ($user->status == 0) {
                $msg = str_replace(["[name]", "[otp]"], [$user->name, $user->otp], config('notification.new_user'));
                Mail::to($user->email)->send(new Commonmail($msg, 'Welcome to SHEERS'));
                DB::commit();
                return $this->respondJson(true, trans('message.resendotp_success'));
            } else {
                $msg = str_replace(["[name]", "[otp]"], [$user->name, $user->forgot_password], config('notification.forgot_password'));
                Mail::to($user->email)->send(new Commonmail($msg, 'Otp Verification Password'));
                DB::commit();
                return $this->respondJson(true, trans('message.resend_forgot_success'));
            }
        } catch (Exception $ex) {
            echo $ex->getMessage();
            DB::rollback();
        }
    }

    public function ResetPassword(Request $r)
    {
        try {
            DB::beginTransaction();
            $checkotp = DB::table('users')->where(['id' => $r->user_id, 'forgot_password' => $r->otp])->first();
            if ($checkotp) {
                $resetpassword = DB::table('users')->where('id', $r->user_id)->update(['password' => Hash::make($r->password), 'updated_at' => date('Y-m-d H:i:s')]);
                if ($resetpassword) {
                    DB::commit();
                    return $this->respondJson(true, trans('message.reset_success'));
                } else {
                    return $this->respondJson(false, trans('message.reset_error'));
                }
            } else {
                return $this->respondJson(false, trans('message.reset_password_error'));
            }
        } catch (Exception $ex) {
            echo $ex->getMessage();
            DB::rollback();
        }
    }
    
    public function getProfile(Request $r)
    {
        try {
            $user = DB::table('users')->where('id', $r->user_id)->first();
            if ($user) {
                $data = array('user_id' => $user->id,
                    'user_id' => $user->id,
                    'name' => $user->name,
                    'email' => $user->email,
                    'verified_at' => $user->verified_at,
                    'status' => 1,
                    'gender' => $user->gender,
                    'dob' => date('d-M-Y', strtotime($user->dob)),
                    'profile_status' => $user->profile_status,
                    'profile_pic' => ($user->profile_pic ? $user->profile_pic : url('assets/images/user.png')),
                    'access_token' => $user->remember_token,
                    'location' => $user->location,
                    'lat' => $user->lat,
                    'lng' => $user->lng,
                    'notification' => $user->notification,
                    'availability' => $user->availability
                );
                return $this->respondJson(true, trans('message.getprofile_success'), $data);
            } else {
                return $this->respondJson(false, trans('message.getprofile_error'));
            }
        } catch (Exception $ex) {
            $ex->GetMessage();
            DB::rollback();
        }
    }
    
    public function UpdateProfile(Request $r)
    {
        try {
            if($r->name){
                $data = [
                    'name' => $r->name,
                    'gender' => $r->gender,
                    'dob' => $r->dob,
                    'profile_status' => $r->profile_status,
                    'availability' => $r->availability,
                    'updated_at' => date('Y-m-d H:i:s'),
                ];
            }
            if ($r->image) {
                $file     = $r->file('image');
                $filename = time() . '.' . $file->clientExtension();
                $path     = public_path() . '/assets/images/user/';
                $file->move($path, $filename);
                $data['profile_pic'] = URL::to('') . '/assets/images/user/' . $filename;
            }
            if($r->location){
                $data = [
                    'location' => $r->location,
                    'lat' => $r->lat,
                    'lng' => $r->lng,
                    'updated_at' => date('Y-m-d H:i:s'),
                ];
            }
            if(isset($r->notification)){
                $data = [
                    'notification' => $r->notification,
                    'updated_at' => date('Y-m-d H:i:s'),
                ];
            }
            $user_data = DB::table('users')->where('id', $r->user_id)->update($data);
            if ($user_data) {
                $user = DB::table('users')->where('id', $r->user_id)->first();
                    $data = array('user_id' => $user->id,
                        'name' => $user->name,
                        'email' => $user->email,
                        'verified_at' => $user->verified_at,
                        'status'  => 1,
                        'gender' => $user->gender,
                        'dob' => date('d-M-Y', strtotime($user->dob)),
                        'profile_status' => $user->profile_status,
                        'profile_pic' => ($user->profile_pic ? $user->profile_pic : url('assets/images/user.png')),
                        'access_token' => $user->remember_token,
                        'location' => $user->location,
                        'lat' => $user->lat,
                        'lng' => $user->lng,
                        'notification' => $user->notification,
                        'availability' => $user->availability
                    );
                return $this->respondJson(true, trans('message.profile_update_success'), $data);
            } else {
                return $this->respondJson(false, trans('message.profile_update_error'));
            }
        } catch (Exception $ex) {
            $ex->GetMessage();
            DB::rollback();
        }
    }
    
    public function DeviceToken(Request $r)
    {
        try {
            $tokendata = [
                'user_id'      => $r->user_id,
                'device_type'  => $r->device_type,
                'device_token' => $r->device_token,
                'updated_at'   => date('Y-m-d H:i:s'),
            ];
            $isexit = DB::table('device_token')->where(['device_token' => $r->device_token])->value('id');
            if($isexit){
                $update = DB::table('device_token')->where('id',$isexit)->update($tokendata);
            }else{
                $update = DB::table('device_token')->insert($tokendata);
            }
            if ($update) {
                return $this->respondJson(true, trans('message.insert_device_token_success'));
            } else {
                return $this->respondJson(false, trans('message.insert_device_token_error'));
            }
        } catch (Exception $ex) {
            $ex->GetMessage();
            DB::rollback();
        }
    }
    
    public function supportMail(Request $r){
        try {
            $user = DB::table('users')->where('id', $r->user_id)->first();
            $msg  = str_replace(["[name]", "[message]"], [$user->name, $r->message], config('notification.contact_support'));
            $mail = Mail::to(config('services.support_email'))->send(new Commonmail($msg, 'Support Mail'));
            if($mail){
                return $this->respondJson(false, trans('message.support_mail_error'));
            } else {
                return $this->respondJson(true, trans('message.support_mail_success'));
            }
        } catch (Exception $ex) {
            $ex->GetMessage();
            DB::rollback();
        }
    }
    
    public function logout(Request $r){
        try{
            $device_token = DB::table('device_token')->where(['device_token' => $r->device_token, 'user_id' =>$r->user_id])->delete();
            if($device_token){
              return $this->respondJson(false, trans('message.logout_success'));
            }else{
               return $this->respondJson(false, trans('message.logout_error')); 
            }
        } catch (Exception $ex) {
            $ex->GetMessage();
            DB::rollback();
        }
    }
    
    public function userPasswordChange(Request $r){
        try {
            $user = DB::table('users')->where('id', $r->user_id)->first();
            if (Hash::check($r->old_password, $user->password)) {
                $update_password = DB::table('users')->where('id', $r->user_id)->update(['password' => Hash::make($r->password), 'updated_at' => date('Y-m-d H:i:s')]);
                if ($update_password) {
                    return $this->respondJson(true, trans('message.update_password_success'));
                } else {
                    return $this->respondJson(false, trans('message.update_password_error'));
                }
            } else {
                return $this->respondJson(false, trans('message.old_password_error'));
            }
        } catch (Exception $ex) {
            $ex->GetMessage();
            DB::rollback();
        }
    }
}


