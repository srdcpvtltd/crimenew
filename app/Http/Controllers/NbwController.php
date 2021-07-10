<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class NbwController extends Controller
{
    //

    public function __construct()
    {
        $this->middleware('auth:web');
    }

    public function index(){
        $criminals = DB::table('tbl_criminal')->select('ID', 'Name', 'Short_Name')->get();
        $policeStations = DB::table('tbl_psname')->get();
        $nbws = DB::table('tbl_nbw')->get();
        return view('nbw.index', compact('criminals', 'nbws','policeStations'));
    }

    public function create(Request $request){
        if($request->isMethod('POST')){
            $nbw = DB::table('tbl_nbw')->insertGetId([
                'criminal_id' => $request->criminal_id,
                'Name' => $request->Name,
                'Short_Name' => $request->Short_Name,
                'Accused_FName' => $request->Accused_FName,
                'Address' => $request->Address,
                'PS' => $request->PS,
                'Warrant_No' => $request->Warrant_No,
                'date_of_issue' => $request->date_of_issue,
                'issuing_court' => $request->issuing_court,
                'Date_of_hearing' => $request->Date_of_hearing,
                'U_s' => $request->U_s,
            ]);

            return redirect()->route('nbw.index')->with('success','NBW Added Successfully');
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
