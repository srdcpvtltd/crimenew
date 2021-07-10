<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class StatusController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:web');
    }

    public function index(){
        $records = DB::table('tbl_status')->get();
        return view('status.index', compact('records'));
    }

    public function create(Request $request){
        if($request->isMethod('POST')){
            $newRecord = DB::table('tbl_status')->insertGetId([
                'status_name' => $request->status_name,
            ]);

            return redirect()->route('status.index')->with('success','Status Added Successfully');
        }
    }

    public function edit(Request $request){
        if($request->isMethod('POST')){
            $updateRecord = DB::table('tbl_status')
                ->where('ID', $request->id)
                ->update(['status_name' => $request->name]);

            return redirect()->route('status.index')->with('success', 'Status Updated Successfully');
        }
    }

    public function destroy(Request $request){
        $del = DB::table('tbl_status')->where('ID', $request->id)->delete();

        return response()->json(['status' => 200, 'type' => TRUE, 'message' => 'Record Deleted Successfully']);
    }
}

