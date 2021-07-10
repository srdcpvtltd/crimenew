<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BastiController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:web');
    }

    public function index(){
        $records = DB::table('tbl_basti')->get();
        return view('basti.index', compact('records'));
    }

    public function create(Request $request){
        if($request->isMethod('POST')){
            $newRecord = DB::table('tbl_basti')->insertGetId([
                'basti_name' => $request->basti_name,
            ]);

            return redirect()->route('basti.index')->with('success','Basti Added Successfully');
        }
    }
    public function edit(Request $request){
        if($request->isMethod('POST')){
            $updateRecord = DB::table('tbl_basti')
                ->where('ID', $request->id)
                ->update(['basti_name' => $request->name]);

            return redirect()->route('basti.index')->with('success', 'Basti Updated Successfully');
        }
    }

    public function destroy(Request $request){
        $del = DB::table('tbl_basti')->where('ID', $request->id)->delete();

        return response()->json(['status' => 200, 'type' => TRUE, 'message' => 'Record Deleted Successfully']);
    }
}
