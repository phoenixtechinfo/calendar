<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\models\Colors;
use Storage;
use Validator;
use Carbon\Carbon;
use Auth;
use Helper;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Http\Request;

class ColorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $columns=Schema::getColumnListing('colors');
        $orderBy = ($request->input('sortBy') && in_array($request->input('sortBy'), $columns))?$request->input('sortBy'):'id';
        $orderOrder = ($request->input('sortOrder') && ($request->input('sortOrder') == 'asc' || $request->input('sortOrder') == 'desc'))?$request->input('sortOrder'):'asc';
        $limit = env('PAGINATION_PER_PAGE_RECORDS') ? env('PAGINATION_PER_PAGE_RECORDS') : 5;
        $search = ($request->input('search') && $request->input('search') != '')?$request->input('search'):'';
        $colors = Colors::where(function($query) use ($search){
            if($search) {
                $searchColumn = ['name', 'hexcode', 'created_for'];
                foreach ($searchColumn as $singleSearchColumn) {
                    $query->orWhere($singleSearchColumn, "LIKE", '%' . $search . '%');
                }
            }
        });
        $colors = $colors->orderBy($orderBy, $orderOrder)->paginate($limit);
        return view('colors/index', compact('colors'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('colors/add_color');
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
            'name' => 'required',
            'hexcode' => 'required',
            'created_for' => 'required',
        ];
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            // dd($validator->messages());
            return redirect()->back()->withErrors($validator)->withInput();
        }
        $color = new colors();
        $color->name = $request->name;
        $color->hexcode = $request->hexcode;
        $color->created_for = $request->created_for;
        $color->created_by = Auth::user()->id;
        $color->modified_by = Auth::user()->id;
        $color->save();
        $request->session()->flash('alert-success', 'Color added successfully');
        return redirect()->to('colors');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $color = Colors::find($id);
        return view('colors/show_color', compact('color'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $color = Colors::find($id);
        return view('colors/edit_color', compact('color'));
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
            'name' => 'required',
            'hexcode' => 'required',
            'created_for' => 'required',
        ];
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            // dd($validator->messages());
            return redirect()->back()->withErrors($validator)->withInput();
        }
        $color = colors::find($id);
        $color->name = $request->name;
        $color->hexcode = $request->hexcode;
        $color->created_for = $request->created_for;
        $color->modified_by = Auth::user()->id;
        $color->save();
        $request->session()->flash('alert-success', 'Color saved successfully');
        return redirect()->to('colors');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        $colors = Colors::find($id);
        $colors->delete();

        $request->session()->flash('alert-success', 'Color deleted successfully');
        return redirect()->to('colors');
    }
}
