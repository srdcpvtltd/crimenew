<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PsController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware('auth:web');
    }

    public function index(){
        $records = DB::table('tbl_psname')->get();
        return view('PS.index', compact('records'));
    }

    public function create(Request $request){
        if($request->isMethod('POST')){
            $newRecord = DB::table('tbl_psname')->insertGetId([
                'PSName' => $request->PSName,
            ]);

            return redirect()->route('ps.index')->with('success','Police Station Added Successfully');
        }
    }

    public function edit(Request $request){
        if($request->isMethod('POST')){
            $updateRecord = DB::table('tbl_psname')
                ->where('ID', $request->id)
                ->update(['PSName' => $request->name]);

            return redirect()->route('ps.index')->with('success', 'Police Station Name Updated Successfully');
        }
    }

    public function destroy(Request $request){
        $del = DB::table('tbl_psname')->where('ID', $request->id)->delete();

        return response()->json(['status' => 200, 'type' => TRUE, 'message' => 'Record Deleted Successfully']);
    }
}
