<?php

namespace App\Http\Controllers;

use http\Env\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CaseController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware('auth:web');
    }

    public function validateCase(Request $request){
        if($request->isMethod('GET')){
            $policeStations = DB::table('tbl_psname')->select('tbl_psname.*')->get();
            return view('case.validateCase', compact('policeStations'));
        }
        if($request->isMethod('POST')){
            $policeStation = $request->policeStation;
            $caseNo = $request->caseNo;
            $year = $request->year;

            $validate = DB::table('tbl_crime')->where('CaseNo','=',$caseNo)
                ->where('Year','=', $year)->where('PS','=',$policeStation)->get();

            if(!empty($validate[0])){
                //edit new form
                return response()->json(['status' => 200, 'type' => 'edit', 'message' => 'Add New Case']);
            }else{
                //add new form
                return response()->json(['status' => 200, 'type' => 'add', 'message' => 'Add New Case']);
            }
        }
    }

    public function addCaseForm(Request $request){
        if($request->isMethod('GET')){
            return redirect()->route('validate.case');
        }
        if($request->isMethod('POST')){
            $policeStation = $request->policeStation;
            $caseNo = $request->caseNo;
            $year = $request->year;

            $caseId = DB::table('tbl_crime')->insertGetId([
                'CaseNo' => $caseNo,
                'Year' => $year,
                'PS' => $policeStation
            ]);

            return redirect()->route('edit.case',['id' => $caseId]);


        }
    }
    public function editCaseForm(Request $request){
        if($request->isMethod('GET')){
            return redirect()->route('validate.case');
        }
        if($request->isMethod('POST')){
            $policeStation = $request->policeStation;
            $caseNo = $request->caseNo;
            $year = $request->year;

            $caseID = DB::table('tbl_crime')->where('CaseNo','=',$caseNo)
                ->where('Year','=', $year)->where('PS','=',$policeStation)->get();

            $caseID = $caseID[0];

            return redirect()->route('edit.case',['id' => $caseID->ID]);

        }
    }

    public function editCase(Request $request, $id){
        if($request->isMethod('GET')){
            $case = DB::table('tbl_crime')->where('ID','=', $id)->get();
            $case = $case[0];
            $policeStations = DB::table('tbl_psname')->select('tbl_psname.*')->get();
            $categories = DB::table('tbl_category')->get();
            $moTypes = DB::table('tbl_modus')->get();
            $crimeCategories = DB::table('tbl_propcategory')->where('CaseID','=',$case->ID)->get();
            $crimeCate = [];
            foreach ($crimeCategories AS $crimeCategory){
                $crimeCate[] = $crimeCategory->PropCatID;
            }
            $vehicleInfo = DB::table('tbl_vehicleinfo')->where('id','=', $case->ID)->get();
            $placeTypes = DB::table('tbl_placetype')->get();
            $accusedlists = DB::table('tbl_criminal')->get();
            $status = DB::table('tbl_status')->get();
            return view('case.edit', compact('case','policeStations','categories','crimeCate','moTypes','vehicleInfo','accusedlists','placeTypes','status'));
        }
        if($request->isMethod('POST')){

            $case = DB::table('tbl_crime')
                ->where('ID','=', $request->id)
                ->update([
                    'CaseNo' => $request->caseNo,
                    'PS' => $request->policeStation,
                    'Outpost' => $request->Outpost,
                    'Place' => $request->place,
                    'Place_Type' => $request->place_type,
                    'DateReporting' => $request->dateReporting,
                    'TimeReporting' => $request->timeReporting,
                    'Date' => $request->date,
                    'Time' => $request->time,
                    'Year' => $request->year,
                    'Entry_point' => $request->Entry_point,
                    'Exit_point' => $request->Exit_point,
                    'No_of_Accused' => $request->No_of_Accused,
                    'Accused_Physical_Appearance' => $request->Accused_Physical_Appearance,
                    'other_details_accused' => $request->other_details_accused,
                    'vehicle_used_by_accused' => $request->vehicle_used_by_accused,
                    'is_cctv_footage' => $request->is_cctv_footage,
                    'detection_status' => $request->detection_status,
                    'Longitude' => $request->longitude,
                    'Latitude' => $request->latitude,
                    'Area' => $request->area,
                    'Complainant_Name' => $request->complainantName,
                    'Father_HusbandsName' => $request->fatherHusbandsName,
                    'Address1' => $request->address1,
                    'Address2' => $request->address2,
                    'Address3' => $request->address3,
                    'MobileNo' => $request->mobileNo,
                    'Age' => $request->age,
                    'Sex' => $request->sex,
                    'Occupation' => $request->occupation,
                    'Remarks' => $request->remarks,
                    'Property_Offence' => $request->Property_Offence,
                    'Property_Stolen' => $request->propertyStolen,
                    'Property_Value' => $request->propertyValue,
                    'Property_Remakrs' => $request->propertyRemakrs,
                    'MO_Type' => $request->moType,
                    'MO_Remarks' => $request->moRemarks,
                    'Sections' => $request->section,
                    'IO' => $request->io,
                    'Mode_Transpassing' => $request->modeTranspassing,
                    'Weapon_Equipment' => $request->weaponEquipment,
                    'Status' => $request->status,
                    'Status_No' => $request->statusNo,
                ]);

            if(isset($request->propCategories)){
                DB::table('tbl_propcategory')->where('CaseID','=', $request->id)->delete();

                $propcategories = $request->propCategories;
                foreach($propcategories AS $propcategory){
                    $result = DB::table('tbl_propcategory')->insertGetId([
                        'PropCatID' => $propcategory,
                        'CaseID' => $request->id,
                    ]);
                }
            }

            //images
            if($request->hasFile('placePicture')){
                $placePicture  = time().'.'.$request->placePicture->extension();
                $request->placePicture->move(public_path('case/images'), $placePicture);
                $affected = DB::table('tbl_crime')
                    ->where('ID', '=',$request->id)
                    ->update([
                        'Picture_Place' => $placePicture,
                    ]);
            }
            if($request->hasFile('placePicture1')){
                $placePicture1  = time().'.'.$request->placePicture1->extension();
                $request->placePicture1->move(public_path('case/images'), $placePicture1);
                $affected = DB::table('tbl_crime')
                    ->where('ID', '=',$request->id)
                    ->update([
                        'Picture_Place1' => $placePicture1,
                    ]);
            }
            if($request->hasFile('placePicture2')){
                $placePicture2  = time().'.'.$request->placePicture2->extension();
                $request->placePicture2->move(public_path('case/images'), $placePicture2);
                $affected = DB::table('tbl_crime')
                    ->where('ID', '=',$request->id)
                    ->update([
                        'Picture_Place2' => $placePicture2,
                    ]);
            }
            if($request->hasFile('placePicture3')){
                $placePicture3  = time().'.'.$request->placePicture3->extension();
                $request->placePicture3->move(public_path('case/images'), $placePicture3);
                $affected = DB::table('tbl_crime')
                    ->where('ID', '=',$request->id)
                    ->update([
                        'Picture_Place3' => $placePicture3,
                    ]);
            }

            if($request->hasFile('Picture_Weapon')){
                $Picture_Weapon  = time().'.'.$request->Picture_Weapon->extension();
                $request->Picture_Weapon->move(public_path('case/images/weapon'), $Picture_Weapon);
                $affected = DB::table('tbl_crime')
                    ->where('ID', '=',$request->id)
                    ->update([
                        'Picture_Weapon' => $Picture_Weapon,
                    ]);
            }

            if($request->hasFile('cctv_footage')){
                $cctv_footage  = time().'.'.$request->cctv_footage->extension();
                $request->cctv_footage->move(public_path('case/cctv/footage'), $cctv_footage);
                $affected = DB::table('tbl_cctv')
                    ->insertGetId([
                        'case_id' => $request->id,
                        'cctv_footage' => $cctv_footage
                    ]);
            }



            return redirect()->route('edit.case',['id' => $request->id]);

        }
    }

    public function addVehicleInfo(Request $request){

        DB::table('tbl_vehicleinfo')->where('id','=', $request->caseId)->delete();

        $addVehicleInfo = DB::table('tbl_vehicleinfo')->insertGetId([
            'id' => $request->caseId,
            'vehicle_no' => $request->vehicleNo,
            'owners_name' => $request->ownerName,
            'city' => $request->city,
            'police_station' => $request->vpoliceStation,
            'affair_date' => $request->firDate,
            'affair_no' => $request->firNo,
            'register_date' => $request->vRegDate,
            'chesis_no' => $request->chasisNo,
            'engine_no' => $request->engNo,
            'vehicle_class' => $request->vBrand,
            'vehicle_model' => $request->vModel,
            'fuel_type' => $request->fuleType,
            'insurance_upto' => $request->incuranceUpto,
            'registration_upto' => $request->registrationUpto,
            'vehicle_type' => $request->vType,
        ]);

        if($addVehicleInfo){
            return response()->json(['status' => 200, 'type' => TRUE, 'message' => 'Added vehicle information successfully']);
        }else{
            return response()->json(['status' => 200, 'type' => TRUE, 'message' => 'Something Went Wrong. Please Try Again.']);
        }
    }

    public function associate(Request $request){
        $associate = DB::table('crime_criminal')->insertGetId([
            'Crime' => $request->crime_id,
            'Criminal' => $request->accused_id
        ]);

        if($associate){
            return response()->json(['status' => 200, 'type' => TRUE, 'message' => 'Associated Successfully']);
        }else{
            return response()->json(['status' => 200, 'type' => False, 'message' => 'Something Went Wrong. Please Try Again.']);
        }
    }

    public function removeAssociate(Request $request){
        $associate = DB::table('crime_criminal')->where('JoinID','=', $request->id)->delete();
        return response()->json(['status' => 200, 'type' => TRUE]);
    }

    public function search(Request $request){
        if($request->isMethod('GET')){
            $moduses = DB::table('tbl_modus')->get();
            $categories = DB::table('tbl_category')->get();
            $psnames = DB::table('tbl_psname')->get();

            return view('case.search', compact('moduses','categories','psnames'));
        }
        if($request->isMethod('POST')){
            //tc is table_crime
            //pc is tbl_propcategory
            //tcc is tbl_criminal this is join through crime_criminal table
            $where = '';
            if($request->PS != ''){
                $where .= ' tc.PS = "'.$request->PS.'"';
            }
            if($request->Year != ''){
                if($where != ''){
                    $where .= ' AND ';
                }
                $where .= 'tc.Year = "'.$request->Year.'"';
            }
            if($request->MO_Type != ''){
                if($where != ''){
                    $where .= ' AND ';
                }
                $where .= 'tc.MO_Type = "'.$request->MO_Type.'"';
            }
            if($request->Status != ''){
                if($where != ''){
                    $where .= ' AND ';
                }
                $where .= 'tc.Status = "'.$request->Status.'"';
            }
            if($request->PropCatID != ''){
                if($where != ''){
                    $where .= ' AND ';
                }
                $where .= 'pc.PropCatID = "'.$request->PropCatID.'"';
            }
            if($request->Sections != ''){
                if($where != ''){
                    $where .= ' AND ';
                }
                $where .= 'tc.Sections = "'.$request->Sections.'"';
            }
            if($request->Place != ''){
                if($where != ''){
                    $where .= ' AND ';
                }
                $where .= 'tc.Place = "'.$request->Place.'"';
            }
            if($request->Date_Start != ''){
                if($where != ''){
                    $where .= ' AND ';
                }
                $where .= 'tc.Date >= "'.$request->Date_Start.'"';
            }
            if($request->Date_End != ''){
                if($where != ''){
                    $where .= ' AND ';
                }
                $where .= 'tc.Date <= "'.$request->Date_End.'"';
            }
            if($request->Complainant_Name != ''){
                if($where != ''){
                    $where .= ' AND ';
                }
                $where .= 'tc.Complainant_Name = "'.$request->Complainant_Name.'"';
            }
            if($request->Time_Start != ''){
                if($where != ''){
                    $where .= ' AND ';
                }
                $where .= 'tc.Time >= "'.$request->Time_Start.'"';
            }
            if($request->Time_End != ''){
                if($where != ''){
                    $where .= ' AND ';
                }
                $where .= 'tc.Time <= "'.$request->Time_End.'"';
            }

            if($request->Accused != ''){
                if($where != ''){
                    $where .= ' AND ';
                }
                $where .= 'tcc.Name >= "'.$request->Accused.'"';
            }
            if($request->reporting_date_start != ''){
                if($where != ''){
                    $where .= ' AND ';
                }
                $where .= 'tc.DateReporting >= "'.$request->reporting_date_start.'"';
            }
            if($request->reporting_date_end != ''){
                if($where != ''){
                    $where .= ' AND ';
                }
                $where .= 'tc.DateReporting <= "'.$request->reporting_date_end.'"';
            }
            if($request->CaseNo != ''){
                if($where != ''){
                    $where .= ' AND ';
                }
                $where .= 'tc.CaseNo <= "'.$request->CaseNo.'"';
            }



            $query = 'SELECT tc.ID AS CrimeID, tc.CaseNo, tc.PS, tc.Year, tcc.Name, tcc.Short_Name, tcc.Accused_FName, tcc.aadhar_no, tcc.Address1 FROM tbl_crime AS tc LEFT JOIN tbl_propcategory AS pc ON tc.ID = pc.CaseID LEFT JOIN crime_criminal AS cc ON tc.ID = cc.Crime JOIN tbl_criminal AS tcc ON cc.Criminal = tcc.ID ';
            if($where != ''){
                $query .= 'WHERE '.$where;
            }
            $cases = DB::select($query);
            $moduses = DB::table('tbl_modus')->get();
            $categories = DB::table('tbl_category')->get();
            $psnames = DB::table('tbl_psname')->get();

            return view('case.search', compact('cases','moduses','categories','psnames'));

        }
    }

    public function outpost(Request $request){
        $psid = $request->id;
        $outposts = DB::table('tbl_outpost')->where('PSID','=', $psid)->get();

        return response()->json(['status' => 200, 'type' => TRUE, 'outposts' => $outposts]);
    }

    public function addWitness(Request $request){
        $record = DB::table('tbl_witness')->insertGetId([
            'case_id' => $request->caseId,
            'witness_name' => $request->witness_name,
            'witness_fname' => $request->witness_fname,
            'address' => $request->address,
            'mobile_no' => $request->mobile_no
        ]);

        if($record){
            return response()->json(['status' => 200, 'type' => TRUE, 'message' => 'Witness Added successfully']);
        }else{
            return response()->json(['status' => 200, 'type' => FALSE, 'message' => 'Something Went Wrong. Please Try Again.']);
        }
    }

    public function removeWitness(Request $request){
        $record = DB::table('tbl_witness')->where('ID', '=', $request->id)->delete();
        return response()->json(['status' => 200, 'type' => TRUE, 'message' => 'Record Deleted Successfully']);
    }

    public function CrimeCriminalStatusUpdate(Request $request){
        DB::table('tbl_crime_criminal_status')->updateOrInsert(
            ['Criminal' => $request->Criminal, 'Crime' => $request->Crime],['Status' => $request->Status]
        );
        $record = DB::table('tbl_crime_criminal_status')
            ->where('Criminal' ,'=', $request->Criminal)
            ->where('Crime', '=',$request->Crime)
            ->where('Status' , '=', $request->Status)
            ->get();

        return response()->json(['status' => 200, 'type' => TRUE, 'record' => $record, 'message' => 'Status Updated Successfully']);
    }

    public function addVictim(Request $request){
        $record = DB::table('tbl_victim')->insertGetId([
            'CaseID' => $request->CaseID,
            'VictimName' => $request->VictimName,
            'VictimFName' => $request->VictimFName,
            'Age' => $request->Age,
            'Gender' => $request->Gender,
            'MobileNo' => $request->MobileNo,
            'Address1' => $request->Address1,
            'Address2' => $request->Address2,
            'Address3' => $request->Address3,
            'Remarks' => $request->Remarks,
            'Status' => $request->Status
        ]);

        if($record){
            if($request->hasFile('Picture')){
                $Picture  = time().'.'.$request->Picture->extension();
                $request->Picture->move(public_path('case/victim/images'), $Picture);
                $affected = DB::table('tbl_victim')
                    ->where('ID', '=',$record)
                    ->update([
                        'Picture' => $Picture,
                    ]);
            }

            return response()->json(['status' => 200, 'type' => TRUE, 'message' => 'Victim Added Successfully']);
        }else{
            return response()->json(['status' => 200, 'type' => FALSE, 'message' => 'Something Went Wrong. Please Try Again.']);
        }
    }

    public function removeVictim(Request $request){
        DB::table('tbl_victim')->where('ID', '=', $request->id)->delete();
        return response()->json(['status' => 200, 'type' => TRUE, 'message' => 'Record Deleted Successfully']);
    }

    public function addRecovery(Request $request){

        $record = DB::table('tbl_recovery')->insertGetId([
            'case_id' => $request->case_id,
            'date_of_recovery' => $request->date_of_recovery,
            'item' => $request->item,
            'quantity' => $request->quantity,
            'remarks' => $request->remarks,
            'status' => $request->status,
        ]);

        if($record){
            return response()->json(['status' => 200, 'type' => TRUE, 'message' => 'Record Added Successfully']);
        }else{
            return response()->json(['status' => 200, 'type' => FALSE, 'message' => 'Something Went Wrong. Please Try Again.']);
        }
    }

    public function removeRecovery(Request $request){

        DB::table('tbl_recovery')->where('id', '=', $request->id)->delete();

        return response()->json(['status' => 200, 'type' => TRUE, 'message' => 'Record Deleted Successfully']);
    }

    public function addBailedInformation(Request $request){
        $record = DB::table('tbl_bailed')->insertGetId([
            'criminal_crime_status_id' => $request->criminal_crime_status_id,
            'date_of_bail' => $request->date_of_bail,
            'bail_condition' => $request->bail_condition,
            'case_ref_no' => $request->case_ref_no,
            'court' => $request->court,
            'bailer' => $request->bailer,
            'advocate' => $request->advocate,
            'security_amount' => $request->security_amount,
            'land_patta_detail' => $request->land_patta_detail,
        ]);

        if($record){
            return response()->json(['status' => 200, 'type' => TRUE, 'message' => 'Information Added Successfully']);
        }else{
            return response()->json(['status' => 200, 'type' => FALSE, 'message' => 'Something Went Wrong. Please Try Again.']);
        }
    }
}
