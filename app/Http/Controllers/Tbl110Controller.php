<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class Tbl110Controller extends Controller
{
    //
    public function __construct()
    {
        $this->middleware('auth:web');
    }

    public function index(){
        $criminals = DB::table('tbl_criminal')->select('ID', 'Name', 'Short_Name', 'Accused_FName')->get();
        $policeStations = DB::table('tbl_psname')->get();
        $records = DB::table('tbl_110')->get();
        return view('r110.index', compact('criminals', 'records','policeStations'));
    }

    public function create(Request $request){
        if($request->isMethod('POST')){
            $nbw = DB::table('tbl_110')->insertGetId([
                'Criminal' => $request->Criminal,
                'Accused_Name' => $request->Accused_Name,
                'Short_Name' => $request->Short_Name,
                'Accused_FName' => $request->Accused_FName,
                'address' => $request->address,
                'PS' => $request->PS,
                'cmc_no' => $request->cmc_no,
                'non_fir_no' => $request->non_fir_no,
                'date_of_release' => $request->date_of_release,
                'status' => $request->status,
                'remarks' => $request->remarks,
            ]);

            return redirect()->route('r110.index')->with('success','110 Added Successfully');
        }
    }

    public function getById(Request $request)
    {
        $id = $request->id;
        $record = DB::table('tbl_criminal')->where('ID','=', $id)->select('ID', 'Name', 'Short_Name', 'Accused_FName','Address1')->get();
        $record = $record[0];

        return response()->json(['status' => 200, 'type' => TRUE, 'message' => 'Criminal Record', 'data' => $record]);
        
    }
}
