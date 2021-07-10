<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AccusedController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware('auth:web');
    }

    public function validateAccused(Request $request){
        if($request->isMethod('GET')){
            return view('accused.validateAccused');
        }
        if($request->isMethod('POST')){
            $name = $request->name;
            $shortName = $request->shortName;
            $fatherName = $request->fatherName;
            $gender = $request->gender;
          //  $cast = $request->cast;

            $validate = DB::table('tbl_criminal')->where('Name','=',$name)
                ->where('Short_Name','=', $shortName)->where('Accused_FName','=',$fatherName)
                ->where('gender','=',$gender)->get();

            if(!empty($validate[0])){
                //edit new form
                return response()->json(['status' => 200, 'type' => TRUE, 'id' => $validate[0]->ID, 'message' => 'Accused']);
            }else{
                //add new form
                $id = DB::table('tbl_criminal')->insertGetId([
                    'Name' => $name,
                    'Short_Name' => $shortName,
                    'Accused_FName' => $fatherName,
                    //'Cast' => $cast,
                    'Gender' => $gender
                ]);

                return response()->json(['status' => 200, 'type' => TRUE, 'id' => $id, 'message' => 'Accused']);
            }
        }
    }


    public function edit(Request $request, $id){
        if($request->isMethod('GET')){
            $accused = DB::table('tbl_criminal')->where('ID','=', $id)->get();
            $accused = $accused[0];
            $gangs = DB::table('tbl_gang')->get();
            $bastis = DB::table('tbl_basti')->get();
            $policeStations = DB::table('tbl_psname')->get();
            $associateAccuseds = DB::table('tbl_criminal')->where('ID','!=', $id)->select('ID','Name','Short_Name','Accused_FName')->get();
            return view('accused.create', compact('accused','gangs','associateAccuseds','bastis','policeStations'));
        }

        if($request->isMethod('POST')){
            $frontPicture = '';
            $leftSidePicture = '';
            $rightSidePicture = '';
            $uniqIdentity = '';
            $affected = DB::table('tbl_criminal')
                ->where('ID', '=',$request->id)
                ->update([
                    'Name' => $request->name,
                    'Short_Name' => $request->shortName,
                    'Accused_FName' => $request->fatherName,
                    'Gender' => $request->gender,
                    'DOB' => $request->dateOfBirth,
                    'YearofBirth' => $request->yearOfBirth,
                    'Occupation' => $request->occupation,
                    'Bank_Account' => $request->bankAccount,
                    'Habits' => $request->habits,
                    'Address1' => $request->address1,
                    'Address2' => $request->address2,
                    'Address3' => $request->address3,
                    'Police_Station' => $request->policeStation,
                    'State' => $request->state,
                    'PAddress1' => $request->pAddress1,
                    'PAddress2' => $request->pAddress2,
                    'PAddress3' => $request->pAddress3,
                    'PPolice_Station' => $request->pPoliceStation,
                    'PState' => $request->pState,
                    'Mobile' => $request->mobileNo,
                    'Built' => $request->build,
                    'Height' => $request->height,
                    'Weight' => $request->weight,
                    'Skin_Color' => $request->skinColor,
                    'Age' => $request->age,
                    'Logitude' => $request->longitude,
                    'Latitude' => $request->latitude,
                    'Other_Remarks' => $request->remark,
                    'Category' => $request->category,
                    'Classification' => $request->classification,
                    'Status' => $request->status,
                    'basti_id' => $request->basti_id,
                    'aadhar_no' => $request->aadhar_no,
                 ]);
            if($request->hasFile('frontPicture')){
                $frontPicture  = time().'frontPicture.'.$request->frontPicture->extension();
                $request->frontPicture->move(public_path('accused/images'), $frontPicture);
                $affected = DB::table('tbl_criminal')
                    ->where('ID', '=',$request->id)
                    ->update([
                        'Picture_Front' => $frontPicture,
                    ]);
            }
            if($request->hasFile('leftSidePicture')){
                $leftSidePicture  = time().'leftSidePicture.'.$request->leftSidePicture->extension();
                $request->leftSidePicture->move(public_path('accused/images'), $leftSidePicture);
                $affected = DB::table('tbl_criminal')
                    ->where('ID', '=',$request->id)
                    ->update([
                        'Picture_Side_Left' => $leftSidePicture,
                    ]);
            }
            if($request->hasFile('rightSidePicture')){
                $rightSidePicture  = time().'rightSidePicture.'.$request->rightSidePicture->extension();
                $request->rightSidePicture->move(public_path('accused/images'), $rightSidePicture);
                $affected = DB::table('tbl_criminal')
                    ->where('ID', '=',$request->id)
                    ->update([
                        'Picture_Side_Right' => $rightSidePicture,
                    ]);
            }
            if($request->hasFile('uniqIdentityMark')){
                $uniqIdentity  = time().'uniqIdentityMark.'.$request->uniqIdentityMark->extension();
                $request->uniqIdentityMark->move(public_path('accused/images'), $uniqIdentity);
                $affected = DB::table('tbl_criminal')
                    ->where('ID', '=',$request->id)
                    ->update([
                        'Picture_Uinq' => $uniqIdentity,
                    ]);
            }

            return redirect()->back();
        }

    }

    public function associate(Request $request){
        $associate = DB::table('criminal_criminal')->insertGetId([
            'Criminal1' => $request->accused_id,
            'Criminal2' => $request->associate_id
        ]);

        if($associate){
            return response()->json(['status' => 200, 'type' => TRUE, 'message' => 'Associated Successfully']);
        }else{
            return response()->json(['status' => 200, 'type' => False, 'message' => 'Something Went Wrong. Please Try Again.']);
        }
    }

    public function removeAssociate(Request $request){
        $associate = DB::table('criminal_criminal')->where('JoinID','=', $request->id)->delete();
        return response()->json(['status' => 200, 'type' => TRUE]);
    }

    public function addRelation(Request $request){
        $relation = DB::table('tbl_accused_relations')->insertGetId([
            'AccusedID' => $request->accused_id,
            'Relation' => $request->rRelation,
            'Name' => $request->rName,
            'FatherName' => $request->rFatherName,
            'Address' => $request->rAddress,
            'MobileNo' => $request->rMobile,
        ]);

        if($relation){
            return response()->json(['status' => 200, 'type' => TRUE, 'relation' => $relation]);
        }else{
            return response()->json(['status' => 200, 'type' => False]);
        }
    }

    public function removeRelation(Request $request){
        $relation = DB::table('tbl_accused_relations')->where('ID','=', $request->id)->delete();
        return response()->json(['status' => 200, 'type' => TRUE]);

    }

    public function addVisiting(Request $request){
        $visit = DB::table('tbl_accused_visit')->insertGetId([
            'AccusedID' => $request->accused_id,
            'Place' => $request->visitingPlace,
            'purpose' => $request->purpose,
        ]);

        if($visit){
            return response()->json(['status' => 200, 'type' => TRUE, 'relation' => $visit]);
        }else{
            return response()->json(['status' => 200, 'type' => False]);
        }
    }

    public function removeVisiting(Request $request){
        $visit = DB::table('tbl_accused_visit')->where('ID','=', $request->id)->delete();
        return response()->json(['status' => 200, 'type' => TRUE]);

    }

    public function addGang(Request $request){
        $gang = DB::table('tbl_gang_criminal')->insertGetId(([
            'Gang_ID' => $request->gangId,
            'Criminal_ID' => $request->criminalId,
        ]));
        if($gang){
            return response()->json(['status' => 200, 'type' => TRUE, 'gang' => $gang]);
        }else{
            return response()->json(['status' => 200, 'type' => False]);
        }
    }

    public function removeGang(Request $request){
        $gang = DB::table('tbl_gang_criminal')->where('ID','=', $request->id)->delete();
        return response()->json(['status' => 200, 'type' => TRUE]);

    }

    public function addAccusedForm(Request $request){
        if($request->isMethod('GET')){
            return redirect()->route('validate.accused');
        }
        if($request->isMethod('POST')){
            $name = $request->name;
            $shortName = $request->shortName;
            $fatherName = $request->fatherName;
            $gender = $request->gender;
            $cast = $request->cast;

            return view('accused.create',compact('name','fatherName', 'shortName','gender','cast'));
        }
    }
    public function editAccusedForm(Request $request){
        if($request->isMethod('GET')){
            return redirect()->route('validate.accused');
        }
        if($request->isMethod('POST')){
            $name = $request->name;
            $shortName = $request->shortName;
            $fatherName = $request->fatherName;
            $gender = $request->gender;
            $cast = $request->cast;

            $accused = DB::table('tbl_criminal')->where('Name','=',$name)
                ->where('Short_Name','=', $shortName)->where('Accused_FName','=',$fatherName)
                ->where('gender','=',$gender)->where('Cast','=',$cast)->get();

            return view('accused.edit', compact('accused'));
        }
    }
    public function search(Request $request){
        if($request->isMethod('GET')){
            $moduses = DB::table('tbl_modus')->get();
            $categories = DB::table('tbl_category')->get();
            $psnames = DB::table('tbl_psname')->get();
            $gangs = DB::table('tbl_gang')->get();
            return view('accused.search', compact('moduses','categories','psnames', 'gangs'));
        }
        if($request->isMethod('POST')){
            $where = '';
            if($request->Name != ''){
                $where .= ' tc.Name = "'.$request->Name.'"';
            }
            if($request->Accused_FName != ''){
                if($where != ''){
                    $where .= ' AND ';
                }
                $where .= 'tc.Accused_FName = "'.$request->Accused_FName.'"';
            }
            if($request->Status != ''){
                if($where != ''){
                    $where .= ' AND ';
                }
                $where .= 'tc.Status = "'.$request->Status.'"';
            }
            if($request->Built != ''){
                if($where != ''){
                    $where .= ' AND ';
                }
                $where .= 'tc.Built = "'.$request->Built.'"';
            }
            if($request->Height_Min != ''){
                if($where != ''){
                    $where .= ' AND ';
                }
                $where .= 'tc.Height >= "'.$request->Height_Min.'"';
            }
            if($request->Height_Max != ''){
                if($where != ''){
                    $where .= ' AND ';
                }
                $where .= 'tc.Height <= "'.$request->Height_Max.'"';
            }
            if($request->Weight_Min != ''){
                if($where != ''){
                    $where .= ' AND ';
                }
                $where .= 'tc.Weight >= "'.$request->Weight_Min.'"';
            }
            if($request->Weight_Max != ''){
                if($where != ''){
                    $where .= ' AND ';
                }
                $where .= 'tc.Weight <= "'.$request->Weight_Max.'"';
            }
            if($request->Skin_Color != ''){
                if($where != ''){
                    $where .= ' AND ';
                }
                $where .= 'tc.Skin_Color = "'.$request->Skin_Color.'"';
            }
            if($request->MO_Type != ''){
                if($where != ''){
                    $where .= ' AND ';
                }
                $where .= 'tcr.MO_Type = "'.$request->MO_Type.'"';
            }
            if($request->PropCatID != ''){
                if($where != ''){
                    $where .= ' AND ';
                }
                $where .= 'tbl_prop.PropCatID = "'.$request->PropCatID.'"';
            }
            if($request->MobileNo != ''){
                if($where != ''){
                    $where .= ' AND ';
                }
                $where .= 'tc.Mobile = "'.$request->MobileNo.'"';
            }

            if($request->Address1 != ''){
                if($where != ''){
                    $where .= ' AND ';
                }
                $where .= 'tc.Address1 = "'.$request->Address1.'"';
            }

            if($request->PS != ''){
                if($where != ''){
                    $where .= ' AND ';
                }
                $where .= 'tcr.PS = "'.$request->PS.'"';
            }

            if($request->Year != ''){
                if($where != ''){
                    $where .= ' AND ';
                }
                $where .= 'tcr.Year = "'.$request->Year.'"';
            }

             if($request->CaseNo != ''){
                 if($where != ''){
                     $where .= ' AND ';
                 }
                 $where .= 'tcr.CaseNo = "'.$request->CaseNo.'"';
             }

            if($request->Gang_ID != ''){
                if($where != ''){
                    $where .= ' AND ';
                }
                $where .= 'tblgang.Gang_ID = "'.$request->Gang_ID.'"';
            }

            if($request->Associate != ''){
                if($where != ''){
                    $where .= ' AND ';
                }
                $where .= 'crim_crim.Criminal2 = "'.$request->Associate.'"';
            }

            $query = 'SELECT tc.ID AS AccusedID, tc.Name, tc.Short_Name, tc.Accused_FName, tc.Address1, tc.Address2, tc.Address3, tc.Police_Station, tc.State, tc.Status, tcr.ID AS CaseID, tcr.PS, tcr.CaseNo, tcr.Year, tm.Modus FROM tbl_criminal AS tc LEFT JOIN crime_criminal AS cc ON tc.ID = cc.Criminal LEFT JOIN tbl_crime AS tcr ON cc.Crime = tcr.ID LEFT JOIN tbl_modus AS tm ON tcr.MO_TYPE = tm.ID LEFT JOIN tbl_propcategory AS tbl_prop ON tbl_prop.CaseID = tcr.ID LEFT JOIN tbl_gang_criminal AS tblgang ON tc.ID = tblgang.Criminal_ID LEFT JOIN criminal_criminal AS crim_crim ON tc.ID = crim_crim.Criminal1 ';
            if($where != ''){
                $query .= 'WHERE '.$where;
            }
            $accuseds = DB::select($query);
            $moduses = DB::table('tbl_modus')->get();
            $categories = DB::table('tbl_category')->get();
            $psnames = DB::table('tbl_psname')->get();
            $gangs = DB::table('tbl_gang')->get();

            return view('accused.search', compact('moduses','categories','psnames', 'gangs','accuseds'));
            //print_r($accused);
        }
    }
}


