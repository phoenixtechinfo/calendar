<?php

namespace App\Http\Controllers;

use App\Mail\Commonmail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use URL;

class ApiCommonController extends Controller
{
    public function index($id){
        $content = DB::table('content')->where('page_slug', $id)->first();
        $data['title'] = $content->page_title;
        $data['content'] = $content->content;
         return view('layouts.page')->with($data);
    }
    
    public function getUserList(Request $r){
        try{
             $users = DB::table('users')
                    ->select('id','name','updated_at','dob','gender','profile_status','profile_pic','availability','lat','lng','location',
                        DB::raw('(6371 * acos(cos(radians('.$r->lat.')) * cos(radians(lat)) * cos(radians(lng) - radians('.$r->lng.')) + sin(radians('.$r->lat.')) * sin(radians(lat)))) as distance'),
                        DB::raw("(SELECT messages.message_id from messages where (messages.sender_id = '$r->user_id' and messages.receiver_id = users.id) or (messages.sender_id = users.id and messages.receiver_id = '$r->user_id') limit 1) as chat_id"))
                    ->where('id','!=',$r->user_id)
                    ->where(['role' => 1, 'status' => 1])
                    ->Where('lat','!=','')
                    ->Where('lng','!=','')
                    //->having('distance', '<' , config('general_setting.user_search_location'))
                    ->get();                 
            if($users){
                $data['user_list'] = [];
                $user_id = $r->user_id;
                foreach($users as $user){                   
                    $to = new \DateTime();
                    $from = new \DateTime($user->updated_at);
                    $current = new \DateTime();
                    $age = new \DateTime($user->dob); 
                    $age_interval = $current->diff($age);
                    $time_interval = $to->diff($from);                    
                    $data['user_list'][] = [
                        'user_id' => $user->id,
                        'name' => $user->name,
                        'age' => $age_interval->y,
                        'distance' => 'about '.number_format($user->distance,2,'.','').'km away',
                        'active' => ($time_interval->d == 0 ? ($time_interval->h != 0 ? 'Active '.$time_interval->h.' hours ago' : ($time_interval->i != 0 ? 'Active '.$time_interval->i.' minutes ago ' : 'Active now')) : 'Active '.$time_interval->d.' days ago'),
                        'image' => ($user->profile_pic ? $user->profile_pic : url('assets/images/user/user.jpeg')),
                        'profile_status' => $user->profile_status,
                        'dob' => date('d-M-Y',strtotime($user->dob)),
                        'gender' => $user->gender,
                        'availability' => $user->availability,
                        'chat_id' => $user->chat_id ? $user->chat_id : 0,
                        'location' => $user->location,
                        'lat' => $user->lat,
                        'lng' => $user->lng,
                    ];
                }
                return $this->respondJson(true, trans('message.user_list_success'),$data);
            }else{
               return $this->respondJson(false, trans('message.user_list__error')); 
            }
        } catch (Exception $ex) {
            $ex->getMessage();
            DB::rollback();
        }
    }
    
    public function getsetting(Request $r){
        $setting = DB::table('settings')->pluck('value','code_key');
        $data[] = $setting;
        if($setting){
            return $this->respondJson(True, trans('message.settings_success'),$data); 
        }else
            return $this->respondJson(False, trans('message.settings_error')); 
    }
}