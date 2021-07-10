<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HaziraController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware('auth:web');
    }

    public function index(){
        $criminals = DB::table('tbl_criminal')->select('ID', 'Name', 'Short_Name')->get();
        $policeStations = DB::table('tbl_psname')->get();
        $bailers = DB::table('tbl_bailer')->get();
        $records = DB::table('tbl_hazira')->get();
        return view('hazira.index', compact('criminals', 'records','policeStations', 'bailers'));
    }

    public function create(Request $request){
        if($request->isMethod('POST')){
            $nbw = DB::table('tbl_hazira')->insertGetId([
                'Criminal' => $request->Criminal,
                'Accused_Name' => $request->Accused_Name,
                'Short_Name' => $request->Short_Name,
                'Accused_FName' => $request->Accused_FName,
                'address' => $request->address,
                'Forwarding_ps' => $request->Forwarding_ps,
                'Case_ref' => $request->Case_ref,
                'Sections' => $request->Sections,
                'Bail_Condition' => $request->Bail_Condition,
                'name_of_bailer' => $request->name_of_bailer,
                'ps_for_hazira' => $request->ps_for_hazira,
                'dof' => $request->dof,
                'dor' => $request->dor,
                'hazira_at_ps' => $request->hazira_at_ps
            ]);

            return redirect()->route('hazira.index')->with('success','Hazira Added Successfully');
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
