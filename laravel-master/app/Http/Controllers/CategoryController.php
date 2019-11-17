<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\models\Categories;
use Storage;
use Validator;
use Carbon\Carbon;
use Auth;
use Helper;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $columns=Schema::getColumnListing('categories');
        $orderBy = ($request->input('sortBy') && in_array($request->input('sortBy'), $columns))?$request->input('sortBy'):'id';
        $orderOrder = ($request->input('sortOrder') && ($request->input('sortOrder') == 'asc' || $request->input('sortOrder') == 'desc'))?$request->input('sortOrder'):'asc';
        $limit = env('PAGINATION_PER_PAGE_RECORDS') ? env('PAGINATION_PER_PAGE_RECORDS') : 5;
        $search = ($request->input('search') && $request->input('search') != '')?$request->input('search'):'';
        $categories = Categories::where(function($query) use ($search){
            if($search) {
                $searchColumn = ['name'];
                foreach ($searchColumn as $singleSearchColumn) {
                    $query->orWhere($singleSearchColumn, "LIKE", '%' . $search . '%');
                }
            }
        });
        $categories = $categories->orderBy($orderBy, $orderOrder)->paginate($limit);
        // dd ($events);
        return view('category/index', compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('category/add_category');
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
        ];
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            // dd($validator->messages());
            return redirect()->back()->withErrors($validator)->withInput();
        }
        $categories = new Categories();
        $categories->name = $request->name;
        $categories->created_by = Auth::user()->id;
        $categories->modified_by = Auth::user()->id;
        $categories->save();
        $request->session()->flash('alert-success', 'Category added successfully');
        return redirect()->to('category');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return redirect()->to('category');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $category = Categories::find($id);
        return view('category/edit_category', compact('category'));
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
        ];
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            // dd($validator->messages());
            return redirect()->back()->withErrors($validator)->withInput();
        }
        $categories = Categories::find($id);
        $categories->name = $request->name;
        $categories->modified_by = Auth::user()->id;
        $categories->save();
        $request->session()->flash('alert-success', 'Category updated successfully');
        return redirect()->to('category');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        $categories = Categories::find($id);
        $categories->delete();

        $request->session()->flash('alert-success', 'Category deleted successfully');
        return redirect()->to('category');
    }
}
