<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use URL;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Input;

class ContentController extends Controller
{
    public function index()
    {  
        $data['title'] = 'Content Managment';
        $data['edit'] = 'content/edit-content';
        $data['update'] = 'content/update-content';
        $data['contents'] = DB::table('content')->get();
        return view('content')->with($data);
    }
    public function getContent($id){        
       $contents = DB::table('content')->where('id',$id)->first();
        return response()->json($contents);
    }
    public function updateContent(Request $r){ 
         $this->data['status'] = TRUE;
        if (empty(Input::get('content'))) {
            $this->data['inputerror'][] = 'content';
            $this->data['error_string'][] = 'Please enter content.';
            $this->data['status'] = FALSE;
        }
        if ($this->data['status'] === FALSE) {
                header('Content-Type: application/json; charset=utf-8');
                echo json_encode($this->data);
                exit;
        }else {
            $content = [
                'content' => $r->content,
                'updated_at' => date('Y-m-d H:i:s')
            ]; 
            $update = DB::table('content')->where('id', $r->id)->update($content);
            if($update){
                $data['status'] = TRUE;
                $data['message'] = 'Content update successfully.';
                return response()->json($data);
            }else{
                $data['status'] = FALSE;
                $data['message'] = 'Something went wrong. Please try again.';
                return response()->json($data);
            }
        }
        return redirect('content/content');
    }    
}
