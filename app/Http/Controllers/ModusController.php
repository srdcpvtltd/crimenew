<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ModusController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware('auth:web');
    }

    public function index(){
        $records = DB::table('tbl_modus')->get();
        return view('modus.index', compact('records'));
    }

    public function create(Request $request){
        if($request->isMethod('POST')){
            $newRecord = DB::table('tbl_modus')->insertGetId([
                'Modus' => $request->Modus,
            ]);

            return redirect()->route('modus.index')->with('success','Modus Added Successfully');
        }
    }

    public function edit(Request $request){
        if($request->isMethod('POST')){
            $updateRecord = DB::table('tbl_modus')
                ->where('ID', $request->id)
                ->update(['Modus' => $request->name]);

            return redirect()->route('modus.index')->with('success', 'Modus Updated Successfully');
        }
    }

    public function destroy(Request $request){
        $del = DB::table('tbl_modus')->where('ID', $request->id)->delete();

        return response()->json(['status' => 200, 'type' => TRUE, 'message' => 'Record Deleted Successfully']);
    }
}
