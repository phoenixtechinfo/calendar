<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\models\events;
use Storage;
use Validator;
use Carbon\Carbon;
use File;
use Auth;
use Helper;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Schema;



class EventController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        // DB::enableQueryLog(); 
        $columns=Schema::getColumnListing('events');
        $orderBy = ($request->input('sortBy') && in_array($request->input('sortBy'), $columns))?$request->input('sortBy'):'id';
        $orderOrder = ($request->input('sortOrder') && ($request->input('sortOrder') == 'asc' || $request->input('sortOrder') == 'desc'))?$request->input('sortOrder'):'asc';
        $limit = env('PAGINATION_PER_PAGE_RECORDS') ? env('PAGINATION_PER_PAGE_RECORDS') : 5;
        $search = ($request->input('search') && $request->input('search') != '')?$request->input('search'):'';
        $events = events::where(function($query) use ($search){
            if($search) {
                $searchColumn = ['title', 'description', 'color', 'contact_no'];
                foreach ($searchColumn as $singleSearchColumn) {
                    $query->orWhere($singleSearchColumn, "LIKE", '%' . $search . '%');
                }
            }
        });
        if(Auth::user()->role == 2) {
            $events = $events->whereHas('user', function($query)  {
                $query->where('role', '!=', 1);
            });
        }
        $events = $events->orderBy($orderBy, $orderOrder)->paginate($limit);
        // dd(DB::getQueryLog());
        return view('events/index', compact('events'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('events/add_event');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $rules = [
            'title' => 'required',
            'description' => 'required',
            'contact_number' => 'required|numeric',
            'color' => 'required',
            'datetime' => 'required',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg'
        ];
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            // dd($validator->messages());
            return redirect()->back()->withErrors($validator)->withInput();
        }
        $events = new events();
        $events->title = $request->title;
        $events->description = $request->description;
        $events->contact_no = $request->contact_number;
        $events->start_datetime = new Carbon($request->get('start_date'));
        $events->start_datetime = $events->start_datetime->format('Y-m-d H:i:s');
        $events->end_datetime = new Carbon($request->get('end_date'));
        $events->end_datetime = $events->end_datetime->format('Y-m-d H:i:s');
        $events->color = $request->color;
        $events->interested_flag = isset($request->interested) ? 1 : 0;
        $events->created_by = Auth::user()->id;
        $events->modified_by = Auth::user()->id;
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
           $events->image = $filePath;
        }
        $events->save();
        $request->session()->flash('alert-success', 'Event created successfully');
        return redirect()->to('events');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $event = events::with('user')->find($id);
        return view('events/show_event', compact('event'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $events = events::find($id);
        return view('events/edit_event', compact('events'));
        
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
    
        $rules = [
            'title' => 'required',
            'description' => 'required',
            'contact_number' => 'required|numeric',
            'color' => 'required',
            'datetime' => 'required',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg'
        ];
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            // dd($validator->messages());
            return redirect()->back()->withErrors($validator)->withInput();
        }
        $events = events::find($id);
        // dd($events->image);
        $events->title = $request->title;
        $events->description = $request->description;
        $events->contact_no = $request->contact_number;
        if(!empty($request->get('start_date'))) {
            $events->start_datetime = new Carbon($request->get('start_date'));
            $events->start_datetime = $events->start_datetime->format('Y-m-d H:i:s');
        }
        if(!empty($request->get('end_date'))) {
            $events->end_datetime = new Carbon($request->get('end_date'));
            $events->end_datetime = $events->end_datetime->format('Y-m-d H:i:s');
        }
        $events->color = $request->color;
        $events->interested_flag = isset($request->interested) ? 1 : 0;
        $events->modified_by = Auth::user()->id;
        if ($request->has('image') && $request->file('image') != '' && $request->file('image') != null) {
            if (!empty($events->image)) {
                $file_name = explode('/', $events->image)[3];
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
           $events->image = $filePath;
        }
        $events->save();
        $request->session()->flash('alert-success', 'Event edited successfully');
        return redirect()->to('events');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        $event = events::find($id);
        $event->delete();

        $request->session()->flash('alert-success', 'Event deleted successfully');
        return redirect()->to('events');
    }

    // function to upload the file at specific location
    public function uploadOne(UploadedFile $uploadedFile, $folder = null, $disk = 'public', $filename = null)
    {
        $name = !is_null($filename) ? $filename : str_random(25);

        $file = $uploadedFile->storeAs($folder, $name . '.' . $uploadedFile->getClientOriginalExtension(), $disk);

        return $file;
    }

}
