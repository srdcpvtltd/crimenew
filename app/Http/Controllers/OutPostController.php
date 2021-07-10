<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OutPostController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware('auth:web');
    }

    public function index(){
        $records = DB::table('tbl_outpost')->join('tbl_psname','tbl_outpost.PSID','=','tbl_psname.ID')
            ->select('tbl_outpost.*','tbl_psname.PSName')->get();
        $policeStations = DB::table('tbl_psname')->get();
        return view('outpost.index', compact('records', 'policeStations'));
    }

    public function create(Request $request){
        if($request->isMethod('POST')){
            $newRecord = DB::table('tbl_outpost')->insertGetId([
                'PSID' => $request->PSID,
                'outpost_name' => $request->outpost_name,
            ]);

            return redirect()->route('outpost.index')->with('success','Outpost Added Successfully');
        }
    }

    public function edit(Request $request){
        if($request->isMethod('POST')){
            $updateRecord = DB::table('tbl_outpost')
                ->where('ID', $request->id)
                ->update([
                    'PSID' => $request->PSIDEdit,
                    'outpost_name' => $request->name
                ]);

            return redirect()->route('outpost.index')->with('success', 'OutPost Updated Successfully');
        }
    }

    public function destroy(Request $request){
        $del = DB::table('tbl_outpost')->where('ID', $request->id)->delete();

        return response()->json(['status' => 200, 'type' => TRUE, 'message' => 'Record Deleted Successfully']);
    }
}
