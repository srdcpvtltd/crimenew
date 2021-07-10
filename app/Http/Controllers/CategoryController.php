<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CategoryController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware('auth:web');
    }

    public function index(){
        $records = DB::table('tbl_category')->get();
        return view('category.index', compact('records'));
    }

    public function create(Request $request){
        if($request->isMethod('POST')){
            $newRecord = DB::table('tbl_category')->insertGetId([
                'Category' => $request->Category,
            ]);

            return redirect()->route('category.index')->with('success','Category Added Successfully');
        }
    }

    public function edit(Request $request){
        if($request->isMethod('POST')){
            $updateRecord = DB::table('tbl_category')
                ->where('ID', $request->id)
                ->update(['Category' => $request->name]);

            return redirect()->route('category.index')->with('success', 'Category Updated Successfully');
        }
    }

    public function destroy(Request $request){
        $del = DB::table('tbl_category')->where('ID', $request->id)->delete();

        return response()->json(['status' => 200, 'type' => TRUE, 'message' => 'Record Deleted Successfully']);
    }
}
