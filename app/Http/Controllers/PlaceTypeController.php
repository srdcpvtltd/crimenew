<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PlaceTypeController extends Controller
{

    //
    public function __construct()
    {
        $this->middleware('auth:web');
    }

    public function index(){
        $records = DB::table('tbl_placetype')->get();
        return view('placeType.index', compact('records'));
    }

    public function create(Request $request){
        if($request->isMethod('POST')){
            $newRecord = DB::table('tbl_placetype')->insertGetId([
                'place_type' => $request->place_type,
            ]);

            return redirect()->route('placeType.index')->with('success','Place Type Added Successfully');
        }
    }

    public function edit(Request $request){
        if($request->isMethod('POST')){
            $updateRecord = DB::table('tbl_placetype')
                ->where('ID', $request->id)
                ->update(['place_type' => $request->name]);

            return redirect()->route('placeType.index')->with('success', 'Place Type Updated Successfully');
        }
    }

    public function destroy(Request $request){
        $del = DB::table('tbl_placetype')->where('ID', $request->id)->delete();

        return response()->json(['status' => 200, 'type' => TRUE, 'message' => 'Record Deleted Successfully']);
    }
}
