<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Tymon\JWTAuth\Facades\JWTAuth;


class CrimeController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware('auth:api');
    }

    public function criminalList(){
        $criminals = DB::select('SELECT crm.ID, crm.Name, crm.Short_Name, crm.Accused_FName, crm.Cast, crm.Gender, crm.Address1, crm.Police_Station, crm.Status FROM tbl_criminal AS crm ');
        if($criminals){
            foreach ($criminals as $key => $criminal){
                $crime = DB::select('SELECT cri.ID, cri.CaseNo, cri.PS, cri.Place, cri.Place_Type, cri.MO_Type, mo.Modus AS MO_Type_name FROM `tbl_crime` AS cri LEFT JOIN crime_criminal AS cri_crm ON cri.ID = cri_crm.Crime LEFT JOIN tbl_modus AS mo ON mo.ID = cri.MO_Type WHERE cri_crm.Criminal = ?',[$criminal->ID]);
                $criminals[$key]->crime = $crime;
            }
            return response()->json(['status' => 200, 'type' => TRUE, 'criminal' => $criminals, 'message' => 'Criminal Record']);
        }else{
            return response()->json(['status' => 200, 'type' => FALSE,  'message' => 'Criminal Record Not Found.']);

        }
    }

    public function criminal(Request $request){
        //search with criminal Name
        $type = $request->post('search_type');
        $value = $request->post('search_value');
        if($type == 'criminal_name'){
            $criminals = DB::select('SELECT crm.ID, crm.Name, crm.Short_Name, crm.Accused_FName, crm.Cast, crm.Gender, crm.Address1, crm.Police_Station, crm.Status FROM tbl_criminal AS crm WHERE crm.Name LIKE ?', [$value.'%']);
            if($criminals){
                foreach ($criminals as $key => $criminal){
                    $crime = DB::select('SELECT cri.ID, cri.CaseNo, cri.PS, cri.Place, cri.Place_Type, cri.MO_Type, mo.Modus AS MO_Type_name FROM `tbl_crime` AS cri LEFT JOIN crime_criminal AS cri_crm ON cri.ID = cri_crm.Crime LEFT JOIN tbl_modus AS mo ON mo.ID = cri.MO_Type WHERE cri_crm.Criminal = ?',[$criminal->ID]);
                    $criminals[$key]->crime = $crime;
                }
                return response()->json(['status' => 200, 'type' => TRUE, 'criminal' => $criminals, 'message' => 'Criminal Record']);
            }else{
                return response()->json(['status' => 200, 'type' => FALSE,  'message' => 'Criminal Record Not Found.']);

            }
        }

        //search with Police Station
        if($type == 'police_station'){
            $criminals = DB::select('SELECT crm.ID, crm.Name, crm.Short_Name, crm.Accused_FName, crm.Cast, crm.Gender, crm.Address1, crm.Police_Station, crm.Status FROM tbl_criminal AS crm WHERE crm.Police_Station LIKE ?', [$value.'%']);
            if($criminals){
                foreach ($criminals as $key => $criminal){
                    $crime = DB::select('SELECT cri.ID, cri.CaseNo, cri.PS, cri.Place, cri.Place_Type, cri.MO_Type, mo.Modus AS MO_Type_name FROM `tbl_crime` AS cri LEFT JOIN crime_criminal AS cri_crm ON cri.ID = cri_crm.Crime LEFT JOIN tbl_modus AS mo ON mo.ID = cri.MO_Type WHERE cri_crm.Criminal = ?',[$criminal->ID]);
                    $criminals[$key]->crime = $crime;
                }
                return response()->json(['status' => 200, 'type' => TRUE, 'criminal' => $criminals, 'message' => 'Criminal Record']);
            }else{
                return response()->json(['status' => 200, 'type' => FALSE,  'message' => 'Criminal Record Not Found.']);

            }
        }

        //search with MO Type
        if($type == 'mo_type'){
            $crimes = DB::select('SELECT cri.ID, cri.CaseNo, cri.PS, cri.Place, cri.Place_Type, cri.MO_Type, mo.Modus AS MO_Type_name FROM `tbl_crime` AS cri LEFT JOIN tbl_modus AS mo on mo.ID = cri.MO_Type WHERE mo.Modus LIKE ?',[$value.'%']);
            if($crimes){
                foreach ($crimes AS $key => $crime){
                    $criminal = DB::select('SELECT crm.ID, crm.Name, crm.Short_Name, crm.Accused_FName, crm.Cast, crm.Gender, crm.Address1, crm.Police_Station, crm.Status FROM tbl_criminal AS crm LEFT JOIN crime_criminal AS cri_crm ON crm.ID = cri_crm.Criminal WHERE cri_crm.Crime = ?', [$crime->ID]);
                    $crimes[$key]->criminal = $criminal;
                }
                return response()->json(['status' => 200, 'type' => TRUE, 'crime' => $crimes, 'message' => 'Crime Record']);
            }else{
                return response()->json(['status' => 200, 'type' => FALSE,  'message' => 'Crime Record Not Found.']);
            }
        }

        //search with Crime PS
        if($type == 'crime'){
            $crimes = DB::select('SELECT cri.ID, cri.CaseNo, cri.PS, cri.Place, cri.Place_Type, cri.MO_Type, mo.Modus AS MO_Type_name FROM `tbl_crime` AS cri LEFT JOIN tbl_modus AS mo on mo.ID = cri.MO_Type WHERE cri.PS LIKE ?',[$value.'%']);
            if($crimes){
                foreach ($crimes AS $key => $crime){
                    $criminal = DB::select('SELECT crm.ID, crm.Name, crm.Short_Name, crm.Accused_FName, crm.Cast, crm.Gender, crm.Address1, crm.Police_Station, crm.Status FROM tbl_criminal AS crm LEFT JOIN crime_criminal AS cri_crm ON crm.ID = cri_crm.Criminal WHERE cri_crm.Crime = ?', [$crime->ID]);
                    $crimes[$key]->criminal = $criminal;
                }
                return response()->json(['status' => 200, 'type' => TRUE, 'crime' => $crimes, 'message' => 'Crime Record']);
            }else{
                return response()->json(['status' => 200, 'type' => FALSE,  'message' => 'Crime Record Not Found.']);
            }
        }



        //$criminal = DB::select('SELECT crm.ID, crm.Name, crm.Short_Name, crm.Accused_FName, crm.Cast, crm.Gender, crm.Address1, crm.Police_Station, crm.Status, cri.CaseNo, cri.PS, cri.Place, cri.Place_Type, cri.MO_Type FROM tbl_criminal AS crm LEFT JOIN crime_criminal AS crm_crime ON crm.ID = crm_crime.Criminal LEFT JOIN tbl_crime AS cri ON crm_crime.Crime = cri.ID WHERE crm.Name = ?', [$name]);

    }

    public function station_and_mo_type(Request $request){
        $value = $request->post('police_station');
        $mo_type = $request->post('mo_type');

        $crimes = DB::select('SELECT cri.ID, cri.CaseNo, cri.PS, cri.Place, cri.Place_Type, cri.MO_Type, mo.Modus AS MO_Type_name FROM `tbl_crime` AS cri LEFT JOIN tbl_modus AS mo on mo.ID = cri.MO_Type WHERE cri.PS = ? AND mo.Modus = ?',[$value, $mo_type]);
        if($crimes){
            foreach ($crimes AS $key => $crime){
                $criminal = DB::select('SELECT crm.ID, crm.Name, crm.Short_Name, crm.Accused_FName, crm.Cast, crm.Gender, crm.Address1, crm.Police_Station, crm.Status FROM tbl_criminal AS crm LEFT JOIN crime_criminal AS cri_crm ON crm.ID = cri_crm.Criminal WHERE cri_crm.Crime = ?', [$crime->ID]);
                $crimes[$key]->criminal = $criminal;
            }
            return response()->json(['status' => 200, 'type' => TRUE, 'crime' => $crimes, 'message' => 'Crime Record']);
        }else{
            return response()->json(['status' => 200, 'type' => FALSE,  'message' => 'Crime Record Not Found.']);
        }

    }
}
