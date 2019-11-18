<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\models\Banners;
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

class BannerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $columns=Schema::getColumnListing('banners');
        $orderBy = ($request->input('sortBy') && in_array($request->input('sortBy'), $columns))?$request->input('sortBy'):'id';
        $orderOrder = ($request->input('sortOrder') && ($request->input('sortOrder') == 'asc' || $request->input('sortOrder') == 'desc'))?$request->input('sortOrder'):'asc';
        $limit = env('PAGINATION_PER_PAGE_RECORDS') ? env('PAGINATION_PER_PAGE_RECORDS') : 5;
        $search = ($request->input('search') && $request->input('search') != '')?$request->input('search'):'';
        $banners = Banners::where(function($query) use ($search){
            if($search) {
                $searchColumn = ['title', 'description', 'month', 'year'];
                foreach ($searchColumn as $singleSearchColumn) {
                    $query->orWhere($singleSearchColumn, "LIKE", '%' . $search . '%');
                }
            }
        });
        if(Auth::user()->role == 2) {
            $banners = $banners->whereHas('user', function($query)  {
                $query->where('role', '!=', 1);
            });
        }
        $banners = $banners->orderBy($orderBy, $orderOrder)->paginate($limit);
        // dd ($events);
        return view('banners/index', compact('banners'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('banners/add_banner');
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
            'month' => 'required',
            'year' => 'required',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg'
        ];
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            // dd($validator->messages());
            return redirect()->back()->withErrors($validator)->withInput();
        }
        $banner = new Banners();
        $banner->title = $request->title;
        $banner->description = $request->description;
        $banner->month = $request->month;
        $banner->year = $request->year;
        $banner->created_by = Auth::user()->id;
        $banner->modified_by = Auth::user()->id;
        if ($request->has('image') && $request->file('image') != '' && $request->file('image') != null) {
           // Get image file
           $image = $request->file('image');
           // Make a image name based on user name and current timestamp
           $name = Str::slug($request->get('title'), '-') . '_' . time();
           $folder = '/uploads/banner_images/';
           // Make a file path where image will be stored [ folder path + file name + file extension]
           $filePath = $folder . $name . '.' . $image->getClientOriginalExtension();
           // Upload image
           $this->uploadOne($image, $folder, 'public', $name);
           // Set user profile image path in database to filePath
           $banner->image = $filePath;
        }
        $banner->save();
        $request->session()->flash('alert-success', 'Banner created successfully');
        return redirect()->to('banners');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $banner = Banners::with('user')->find($id);
        return view('banners/show_banner', compact('banner'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $banner = Banners::find($id);
        return view('banners/edit_banner', compact('banner'));
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
        $banner = Banners::find($id);
        $rules = [
            'title' => 'required',
            'description' => 'required',
            'month' => 'required',
            'year' => 'required',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg'
        ];
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            // dd($validator->messages());
            return redirect()->back()->withErrors($validator)->withInput();
        }
        $banner->title = $request->title;
        $banner->description = $request->description;
        $banner->month = $request->month;
        $banner->year = $request->year;
        $banner->modified_by = Auth::user()->id;
        if ($request->has('image') && $request->file('image') != '' && $request->file('image') != null) {
            if (!empty($banner->image)) {
                $file_name = explode('/', $banner->image)[3];
                Storage::delete('public/uploads/banner_images/' . $file_name);
            }
            // Get image file
            $image = $request->file('image');
            // Make a image name based on user name and current timestamp
            $name = Str::slug($request->get('title'), '-') . '_' . time();
            $folder = '/uploads/banner_images/';
            // Make a file path where image will be stored [ folder path + file name + file extension]
            $filePath = $folder . $name . '.' . $image->getClientOriginalExtension();
            // Upload image
            $this->uploadOne($image, $folder, 'public', $name);
            // Set user profile image path in database to filePath
            $banner->image = $filePath;
        }
        $banner->save();
        $request->session()->flash('alert-success', 'Banner updated successfully');
        return redirect()->to('banners');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        $banner = Banners::find($id);
        $banner->delete();

        $request->session()->flash('alert-success', 'Banner deleted successfully');
        return redirect()->to('banners');
    }

    // function to upload the file at specific location
    public function uploadOne(UploadedFile $uploadedFile, $folder = null, $disk = 'public', $filename = null)
    {
        $name = !is_null($filename) ? $filename : str_random(25);

        $file = $uploadedFile->storeAs($folder, $name . '.' . $uploadedFile->getClientOriginalExtension(), $disk);

        return $file;
    }
}
