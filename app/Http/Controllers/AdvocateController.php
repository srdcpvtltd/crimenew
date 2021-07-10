<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdvocateController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware('auth:web');
    }

    public function index(Request $request){
        $advocates = DB::table('tbl_advocate')->get();

        return view('advocate.index', compact('advocates'));
    }

    public function create(Request $request){
        if($request->isMethod('GET')){

        }
        if($request->isMethod('POST')){
            $advocate = DB::table('tbl_advocate')->insertGetId([
                'AdvName' => $request->aName,
                'AdvF_Name' => $request->aFatherName,
                'Address' => $request->address,
                'MobileNo' => $request->mobile,
            ]);

            return redirect()->route('advocate.index');
        }

    }

    public function edit(Request $request){
        if($request->isMethod('POST')){
            $updateRecord = DB::table('tbl_advocate')
                ->where('ID', $request->id)
                ->update([
                    'AdvName' => $request->name,
                    'AdvF_Name' => $request->fatherName,
                    'Address' => $request->eAddress,
                    'MobileNo' => $request->eMobileNo
                ]);

            return redirect()->route('advocate.index')->with('success', 'Advocate Record Updated Successfully');
        }
    }

    public function destroy(Request $request){
        $del = DB::table('tbl_advocate')->where('ID', $request->id)->delete();

        return response()->json(['status' => 200, 'type' => TRUE, 'message' => 'Record Deleted Successfully']);
    }
}
