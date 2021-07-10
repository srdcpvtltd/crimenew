<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class GangController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware('auth:web');
    }

    public function index(Request $request){
        $gangs = DB::table('tbl_gang')->get();

        return view('gang.index', compact('gangs'));
    }

    public function create(Request $request){
        if($request->isMethod('GET')){

        }
        if($request->isMethod('POST')){
            $advocate = DB::table('tbl_gang')->insertGetId([
                'Name' => $request->name,
                'Created_Since' => $request->createdOn,
            ]);

            return redirect()->route('gang.index');
        }

    }

    public function edit(Request $request){
        if($request->isMethod('POST')){
            $updateRecord = DB::table('tbl_gang')
                ->where('ID', $request->id)
                ->update([
                    'Name' => $request->name
                ]);

            return redirect()->route('gang.index')->with('success', 'Gang Updated Successfully');
        }
    }

    public function destroy(Request $request){
        $del = DB::table('tbl_gang')->where('ID', $request->id)->delete();

        return response()->json(['status' => 200, 'type' => TRUE, 'message' => 'Record Deleted Successfully']);
    }
}
