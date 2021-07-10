<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BailerController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware('auth:web');
    }

    public function index(Request $request){
        $bailers = DB::table('tbl_bailer')->get();

        return view('bailer.index', compact('bailers'));
    }

    public function create(Request $request){
        if($request->isMethod('GET')){

        }
        if($request->isMethod('POST')){
            $bailer = DB::table('tbl_bailer')->insertGetId([
                'B_Name' => $request->bName,
                'B_F_Name' => $request->bFatherName,
                'Address' => $request->address,
                'MobileNo' => $request->mobile,
            ]);

            return redirect()->route('bailer.index');
        }

    }

    public function edit(Request $request){
        if($request->isMethod('POST')){
            $updateRecord = DB::table('tbl_bailer')
                ->where('ID', $request->id)
                ->update([
                    'B_Name' => $request->name,
                    'B_F_Name' => $request->fatherName,
                    'Address' => $request->eAddress,
                    'MobileNo' => $request->eMobileNo
                ]);

            return redirect()->route('bailer.index')->with('success', 'Bailer Record Updated Successfully');
        }
    }

    public function destroy(Request $request){
        $del = DB::table('tbl_bailer')->where('ID', $request->id)->delete();

        return response()->json(['status' => 200, 'type' => TRUE, 'message' => 'Record Deleted Successfully']);
    }
}
