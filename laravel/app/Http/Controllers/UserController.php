<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use URL;

class UserController extends Controller
{
    public function index(){
        $data['title'] = 'User Management';
        $data['list'] = 'user/list';
        $data['view'] = 'user/user-view';
//        $data['status'] = 'user/list';
        return view('user_list')->with($data);
    }
    
    public function userlist(Request $request){        
        $columns = array(0 =>'name', 1=> 'created_at' , 2 =>'mobile');
        $query = DB::table('users')->where('role',1);
        $totalData = $query->count();
        $totalFiltered = $totalData; 
        $limit = $request->input('length');
        $start = $request->input('start');
        $order = $columns[$request->input('order.0.column')];
        $dir = $request->input('order.0.dir');
        
        if(empty($request->input('search.value'))){            
            $user = $query->offset($start)
                    ->limit($limit)
                    ->orderBy($order,$dir)
                    ->get();
        }else {
            $search = $request->input('search.value'); 
            $user = $query->where(function($q) use ($search) { 
                        $q->Where('name', 'LIKE',"%{$search}%")
                        ->orWhere('email', 'LIKE',"%{$search}%");
                    })
                    ->offset($start)
                    ->limit($limit)
                    ->orderBy($order,$dir)
                    ->get();
        $totalFiltered = count($user);
        }

        $data = array();
        if(!empty($user))
        {
            foreach ($user as $value)
            {
                $option = "<a href='javascript:void(0)' onClick='view_record(".$value->id.")'><i title='View' class='fa fa-eye text-primary' style='font-size: 20px;'></i></a>";
                $nestedData['name'] = $value->name;
                $nestedData['date'] = date('Y-m-d', strtotime($value->created_at));
                $nestedData['email'] = $value->email;
                $nestedData['options'] = $option;
                $data[] = $nestedData;
            }
        }
          
        $json_data = array(
            "draw"            => intval($request->input('draw')),  
            "recordsTotal"    => intval($totalData),  
            "recordsFiltered" => intval($totalFiltered), 
            "data"            => $data   
        );
            
        echo json_encode($json_data); 
    }
    
    public function UserDetails($id){ 
        $user = DB::table('users')->where('id',$id)->first();
        return view('user_view')->with('user',$user);
    }
}