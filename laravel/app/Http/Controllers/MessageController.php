<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use URL;

class MessageController extends Controller
{
    public function sendMessage(Request $r){
        try{
            $chat_id =   DB::table('messages')->where(function ($query) use ($r) {
                        $query->where('sender_id', '=', $r->user_id)
                        ->where('receiver_id', '=', $r->receiver_id);
                        })->orWhere(function ($query) use ($r) {
                            $query->where('sender_id', '=', $r->receiver_id)
                                  ->where('receiver_id', '=',$r->user_id);
                        })->value('message_id');
            if($chat_id){
                return $this->respondJson(true, trans('message.message_success'),array('chat_id' => $chat_id));
            }else{
                $data =[ 
                  'sender_id' => $r->user_id,
                  'receiver_id' => $r->receiver_id,
                  'updated_at' => date('Y-m-d H:i:s')
                ];
                $message = DB::table('messages')->insertGetid($data);
                if($message){
                    return $this->respondJson(true, trans('message.message_success'),array('chat_id' => $message));
                }else{
                    return $this->respondJson(false, trans('message.message_error')); 
                }
            }
        } catch (Exception $ex) {
            $ex->getMessage();
            DB::rollback();
        }
    }
    
    public function getMessageList(Request $r){
        try{
            $current = new \DateTime();
            $message_list = DB::table('messages')
                    ->select('messages.*','sender.name as sender_name','receiver.name as receiver_name','sender.profile_pic as sender_profile_pic','receiver.profile_pic as receiver_profile_pic','sender.dob as sender_dob','receiver.dob as receiver_dob','sender.profile_status as sender_profile_status','receiver.profile_status as receiver_profile_status')
                    ->leftjoin('users as sender','sender.id','=','messages.sender_id')
                    ->leftjoin('users as receiver','receiver.id','=','messages.receiver_id')
                    ->where('sender_id', $r->user_id)->orwhere('receiver_id',$r->user_id)->get();   
            if($message_list){
              $user['user_list'] = [];
              foreach($message_list as $message){
                    $age = $message->sender_id != $r->user_id ? new \DateTime($message->sender_dob) : new \DateTime($message->receiver_dob); 
                    $age_interval = $current->diff($age); 
                    $image = $message->sender_id != $r->user_id ? $message->sender_profile_pic : $message->receiver_profile_pic;
                  $user['user_list'][] = [
                      'user_id' => $message->sender_id != $r->user_id ? $message->sender_id: $message->receiver_id,
                      'user_name' => $message->sender_id != $r->user_id ? $message->sender_name: $message->receiver_name,
                      'user_profile_pic' => $image ? $image : url('assets/images/user/user.jpeg'),
                      'age' => $age_interval->y,
                      'profile_status' => $message->sender_id != $r->user_id ? $message->sender_profile_status: $message->receiver_profile_status,
                      'chat_id' => $message->message_id
                  ];
              }
                return $this->respondJson(true, trans('message.message_list_success'),$user);
            }else{
                return $this->respondJson(false, trans('message.message_list_error'));
            }
        } catch (Exception $ex) {
            $ex->getMessage();
            DB::rollback();
        }
    }
}