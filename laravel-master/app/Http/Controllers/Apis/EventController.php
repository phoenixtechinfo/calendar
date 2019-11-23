<?php

namespace App\Http\Controllers\Apis;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\models\events;
use App\models\Categories;
use Storage;
use Validator;
use Carbon\Carbon;
use File;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\UploadedFile;

class EventController extends Controller
{

    //public function to create the event
    public function createEvent(Request $request) {
    	$event = new events();
    	$event->title = $request->get('title');
    	$event->description = $request->get('description');
    	$event->start_datetime = new Carbon($request->get('start_datetime'));
        $event->start_datetime = $event->start_datetime->format('Y-m-d H:i:s');
    	$event->end_datetime = new Carbon($request->get('end_datetime'));
        $event->end_datetime = $event->end_datetime->format('Y-m-d H:i:s');
    	$event->contact_no = $request->get('contact_no');
    	$event->color_id = 1;
    	$event->created_by = 1;
    	$event->modified_by = 1;
    	if ($request->has('image') && $request->file('image') != '' && $request->file('image') != null) {
            // Get image file
            $image = $request->file('image');
            // Make a image name based on user name and current timestamp
            $name = Str::slug($request->get('title'), '-') . '_' . time();
            $folder = '/uploads/event_images/';
            // Make a file path where image will be stored [ folder path + file name + file extension]
            $filePath = $folder . $name . '.' . $image->getClientOriginalExtension();
            // Upload image
            $this->uploadOne($image, $folder, 'public', $name);
            // Set user profile image path in database to filePath
            $event->image = $filePath;
        }
    	$event->save();
        $category = Categories::find(array_map('intval', explode(',', $request->category)));
        $event->categories()->attach($category);
        $response['code'] = 200;
        $response['message'] = 'Successfully added';
        return response()->json($response);
    }

    //public function to get the eventdata
    public function getEvents(Request $request) {
        $user = \Auth::guard('api')->user();
        $events = events::with(['user', 'color'])->get();
        $event_data = array();
        foreach($events as $event) {
            if($event->created_by == 15 || ($event->user->role == 1 || $event->user->role == 2)) {
                $event_data[] = $event;
            }
        }
        $response['code'] = 200;
        $response['message'] = 'Successfully fetched events';
        $response['data'] = $event_data;
        return response()->json($response);
    }

    //Function to get the specific event details
    public function getEventDetails(Request $request) {
        $id = $request->get('id');
        $event = events::find($id);
        $categories = $event->categories;
        if($event->image != '' && $event->image != null) {
            if(!file_exists(public_path() .'/storage/'.$event->image)) {
                $event->image = '/uploads/event_images/no-image.png';
            }
        } else {
           $event->image = '/uploads/event_images/no-image.png'; 
        }
        $response['code'] = 200;
        $response['message'] = 'Successfully fetched event\'s data';
        $response['data'] = $event;
        $response['categories'] = $categories;
        return response()->json($response);
    }

    //public function to create the event
    public function editEvent(Request $request) {
        $event = events::find($request->get('id'));
        $event->title = $request->get('title');
        $event->description = $request->get('description');
        $event->start_datetime = new Carbon($request->get('start_datetime'));
        $event->start_datetime = $event->start_datetime->format('Y-m-d H:i:s');
        $event->end_datetime = new Carbon($request->get('end_datetime'));
        $event->end_datetime = $event->end_datetime->format('Y-m-d H:i:s');
        $event->contact_no = $request->get('contact_no');
        $event->color_id = 1;
        $event->created_by = 1;
        $event->modified_by = 1;
        if ($request->has('image') && $request->file('image') != '' && $request->file('image') != null) {
             if($event->image != '' && $event->image != null){
                $file_name = explode('/', $event->image)[3];
                Storage::delete('public/uploads/event_images/' . $file_name);
            }
            // Get image file
            $image = $request->file('image');
            // Make a image name based on user name and current timestamp
            $name = Str::slug($request->get('title'), '-') . '_' . time();
            $folder = '/uploads/event_images/';
            // Make a file path where image will be stored [ folder path + file name + file extension]
            $filePath = $folder . $name . '.' . $image->getClientOriginalExtension();
            // Upload image
            $this->uploadOne($image, $folder, 'public', $name);
            // Set user profile image path in database to filePath
            $event->image = $filePath;
        }
        $event->save();
        $category = Categories::find(array_map('intval', explode(',', $request->category)));
        $event->categories()->sync($category);
        $response['code'] = 200;
        $response['message'] = 'Successfully edited';
        return response()->json($response);
    }

     // function to upload the file at specific location
    public function uploadOne(UploadedFile $uploadedFile, $folder = null, $disk = 'public', $filename = null)
    {
        $name = !is_null($filename) ? $filename : str_random(25);

        $file = $uploadedFile->storeAs($folder, $name . '.' . $uploadedFile->getClientOriginalExtension(), $disk);

        return $file;
    }
}
