@extends('layouts.app')

@push('css')
   <style>
       .display-custom{
           display: none;
       }
   </style>
    @endpush
@section('content')

    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Add/Edit Case</div>

                    <div class="card-body">
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif

                        <form action="{{route('edit.case',['id',$case->ID])}}" id="add-case-form" method="POST" enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" name="id" id="id" value="{{$case->ID}}">
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label for="policeStation">Police Station</label>
                                    <select class="form-control" id="policeStation" name="policeStation">
                                        @if(isset($policeStations))
                                            @foreach($policeStations AS $policeStation)
                                                <option data-id="{{$policeStation->ID}}" value="{{$policeStation->PSName}}" {{($policeStation->PSName == $case->PS) ? 'selected' : ''}}>{{$policeStation->PSName}}</option>
                                            @endforeach
                                        @endif
                                    </select>
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="Outpost">OutPost</label>
                                    <select class="form-control" id="Outpost" name="Outpost">
                                        <option value="">Select Outpost</option>
                                    </select>
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="CaseNo">Case No</label>
                                    <input type="number" class="form-control" id="caseNo" name="caseNo" value="{{isset($case->CaseNo) ? $case->CaseNo : ""}}">
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="year">Year</label>
                                    <input type="number" class="form-control" id="year" name="year" value="{{isset($case->Year) ? $case->Year : ""}}">
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="place">Place of Occurance</label>
                                    <input type="text" class="form-control" id="place" name="place" value="{{isset($case->Place) ? $case->Place : ""}}">
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="place_type">Place Type</label>
                                    <select class="form-control" id="place_type" name="place_type">
                                        <option value="">Select Place Type</option>
                                        @if(!empty($placeTypes[0]))
                                            @foreach($placeTypes AS $placeType)
                                                <option value="{{$placeType->place_type}}" {{($placeType->place_type == $case->Place_Type) ? 'selected' : ''}}>{{$placeType->place_type}}</option>
                                                @endforeach
                                            @endif
                                      </select>
                                </div>

                                <div class="form-group col-md-12">
                                    <label for="area">Area Name</label>
                                    <input type="text" class="form-control" id="area" name="area" value="{{isset($case->Area) ? $case->Area : ""}}">
                                </div>

                                <div class="form-group col-md-6">
                                    <label for="date">Date of Occurance</label>
                                    <input type="date" class="form-control" id="date" name="date" value="{{isset($case->Date) ? date('Y-m-d', strtotime($case->Date)) : ""}}">
                                </div>

                                <div class="form-group col-md-6">
                                    <label for="time">Time of Occurance</label>
                                    <input type="time" class="form-control" id="time" name="time" value="{{isset($case->Time) ? date('H:i', strtotime($case->Time)) : ""}}">
                                </div>


                                <div class="form-group col-md-6">
                                    <label for="dateReporting">Date of Reporting</label>
                                    <input type="date" class="form-control" id="dateReporting" name="dateReporting" value="{{isset($case->DateReporting) ? date('Y-m-d', strtotime($case->DateReporting)) : ""}}">
                                </div>

                                <div class="form-group col-md-6">
                                    <label for="timeReporting">Time of Reporting</label>
                                    <input type="time" class="form-control" id="timeReporting" name="timeReporting" value="{{isset($case->TimeReporting) ? date('H:i', strtotime($case->TimeReporting)) : ""}}">
                                </div>

                                <div class="form-group col-md-6">
                                    <label for="is_cctv_footage">CCTV Footage Available</label>
                                    <select class="form-control" id="is_cctv_footage" name="is_cctv_footage">
                                        <option value="1" {{($case->is_cctv_footage == 1) ? 'selected' : ''}}>Yes</option>
                                        <option value="0" {{($case->is_cctv_footage == 0) ? 'selected' : ''}}>No</option>
                                    </select>
                                </div>

                                <div class="form-group col-md-6 display-custom" id="cctv-display">
                                    @php
                                    $cctv = DB::table('tbl_cctv')->where('case_id','=', $case->ID)->get();
                                    @endphp
                                    <video width="100%" height="240" controls>
                                        @if(!empty($cctv[0]))
                                            @foreach($cctv as $ctv)
                                                <source src="{{url('/').'/public/case/cctv/footage/'.$ctv->cctv_footage}}" type="video/mp4">

                                            @endforeach
                                            @endif
                                        Your browser does not support the video tag.
                                    </video>

                                    <label for="c">Upload CCTV Footage</label>
                                    <input type="file" class="form-control" id="cctv_footage" name="cctv_footage" accept=".mp4">
                                </div>

                                <div class="form-group col-md-6">
                                    <label for="Entry_point">Accused Entry Point</label>
                                    <input type="text" class="form-control" id="Entry_point" name="Entry_point" value="{{isset($case->Entry_point) ? $case->Entry_point : ""}}">
                                </div>

                                <div class="form-group col-md-6">
                                    <label for="Exit_point">Accused Exit Point</label>
                                    <input type="text" class="form-control" id="Exit_point" name="Exit_point" value="{{isset($case->Exit_point) ? $case->Exit_point : ""}}">
                                </div>

                                <div class="form-group col-md-6">
                                    <label for="No_of_Accused">No of Accused</label>
                                    <input type="number" class="form-control" id="No_of_Accused" name="No_of_Accused" value="{{isset($case->No_of_Accused) ? $case->No_of_Accused : ""}}">
                                </div>

                                <div class="form-group col-md-6">
                                    <label for="Accused_Physical_Appearance">Accused Physical Appearance</label>
                                    <input type="text" class="form-control" id="Accused_Physical_Appearance" name="Accused_Physical_Appearance" value="{{isset($case->Accused_Physical_Appearance) ? $case->Accused_Physical_Appearance : ""}}">
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="other_details_accused">Any Other Details About Accused</label>
                                    <input type="text" class="form-control" id="other_details_accused" name="other_details_accused" value="{{isset($case->other_details_accused) ? $case->other_details_accused : ""}}">
                                </div>

                                <div class="form-group col-md-6">
                                    <label for="vehicle_used_by_accused">Vehicle used by accused</label>
                                    <input type="text" class="form-control" id="vehicle_used_by_accused" name="vehicle_used_by_accused" value="{{isset($case->vehicle_used_by_accused) ? $case->vehicle_used_by_accused : ""}}">
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="weaponEquipment">Weapon/Equipment Used</label>
                                    <input type="text" class="form-control" id="weaponEquipment" name="weaponEquipment" value="{{isset($case->Weapon_Equipment) ? $case->Weapon_Equipment : ""}}">
                                </div>

                                <div class="form-group col-md-6">
                                    <p class="text-center">Weapon Image</p>
                                    <img src="{{url('/').'/public/case/images/weapon/'.$case->Picture_Weapon}}" width="100%" height="250px">
                                    <label for="Picture_Weapon">Upload Weapon Image if available</label>
                                    <input type="file" class="form-control" id="Picture_Weapon" name="Picture_Weapon">
                                </div>

                            </div>
                            <br>
                            <div class="form-row border border-dark">
                                <div class="form-group col-md-6">
                                    <label for="latitude">Latitude</label>
                                    <input type="text" class="form-control" id="latitude" name="latitude" placeholder="" value="{{isset($case->Latitude) ? $case->Latitude : ''}}">
                                </div>

                                <div class="form-group col-md-6">
                                    <label for="longitude">Longitude</label>
                                    <input type="text" class="form-control" id="longitude" name="longitude" placeholder="" value="{{isset($case->Longitude) ? $case->Longitude : ''}}">
                                </div>

                                <div class="col-md-12">
                                    <div id="map"></div>

                                </div>

                            </div>
                            <br>
                            <div class="form-row border border-dark">
                                <div class="form-group col-md-2 pt-2">
                                    <button type="button" class="btn btn-primary" id="add-witness-btn" data-toggle="modal" data-target="#witness-model">Add Witness</button>
                                </div>
                               {{-- <div class="form-group col-md-2 pt-2">
                                    <button type="button" class="btn btn-primary" id="refresh-witness-btn">Refresh</button>
                                </div>
                               --}}
                                @php
                                    $witnesses = DB::table('tbl_witness')->where('case_id','=',$case->ID)->get();
                                @endphp

                                @if(isset($witnesses[0]))
                                    <table width="100%">
                                        <thead>
                                        <tr>
                                            <th>Witness Name</th>
                                            <th>Witness Father Name</th>
                                            <th>Address</th>
                                            <th>Mobile No</th>
                                            <th>Action</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($witnesses AS $witness)
                                            <tr>
                                                <td>{{$witness->witness_name}}</td>
                                                <td>{{$witness->witness_fname}}</td>
                                                <td>{{$witness->address}}</td>
                                                <td>{{$witness->mobile_no}}</td>
                                                <td><a href="javascript:void(0);" data-witnessid="{{$witness->ID}}" class="btn btn-primary btn-sm mb-2 remove-witness-btn">Remove</a> </td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>

                                @endif
                            </div>

                            <br>
                            <div class="form-row border border-dark">
                                <div class="form-group col-md-6">
                                    <label for="complainantName">Complainant Name</label>
                                    <input type="text" class="form-control" id="complainantName" name="complainantName" value="{{isset($case->Complainant_Name) ? $case->Complainant_Name : ""}}">
                                </div>

                                <div class="form-group col-md-6">
                                    <label for="fatherHusbandsName">Complainant Father/Husband's Name</label>
                                    <input type="text" class="form-control" id="fatherHusbandsName" name="fatherHusbandsName" value="{{isset($case->Father_HusbandsName) ? $case->Father_HusbandsName : ""}}">
                                </div>

                                <div class="form-group col-md-6">
                                    <label for="address1">Address 1</label>
                                    <input type="text" class="form-control" id="address1" name="address1" value="{{isset($case->Address1) ? $case->Address1 : ""}}">
                                </div>

                                <div class="form-group col-md-6">
                                    <label for="address2">Address 2</label>
                                    <input type="text" class="form-control" id="address2" name="address2" value="{{isset($case->Address2) ? $case->Address2 : ""}}">
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="address1">Address 3</label>
                                    <input type="text" class="form-control" id="address1" name="address3" value="{{isset($case->Address3) ? $case->Address3 : ""}}">
                                </div>

                                <div class="form-group col-md-6">
                                    <label for="mobileNo">Mobile No</label>
                                    <input type="text" class="form-control" id="mobileNo" name="mobileNo" value="{{isset($case->MobileNo) ? $case->MobileNo : ""}}">
                                </div>

                                <div class="form-group col-md-6">
                                    <label for="age">Age/Year of Birth</label>
                                    <input type="text" class="form-control" id="age" name="age" value="{{isset($case->Age) ? $case->Age : ""}}">
                                </div>

                                <div class="form-group col-md-6">
                                    <label for="sex">Sex</label>
                                    <select class="form-control" id="sex" name="sex">
                                        <option value="">Select Gender</option>
                                        <option value="Male" {{($case->Sex == 'Male') ? 'selected': ''}}>Male</option>
                                        <option value="Female" {{($case->Sex == 'Female') ? 'selected': ''}}>Female</option>
                                        <option value="Other" {{($case->Sex == 'Other') ? 'selected': ''}}>Other</option>
                                    </select>
                                </div>

                                <div class="form-group col-md-6">
                                    <label for="occupation">Occupation</label>
                                    <input type="text" class="form-control" id="occupation" name="occupation" value="{{isset($case->Occupation) ? $case->Occupation : ""}}">
                                </div>

                                <div class="form-group col-md-6">
                                    <label for="remarks">Remarks</label>
                                    <input type="text" class="form-control" id="remarks" name="remarks" value="{{isset($case->Remarks) ? $case->Remarks : ""}}">
                                </div>

                            </div>
                            <br>
                            <div class="form-row border border-dark">
                                <div class="col-md-12">
                                    <div class="custom-control custom-checkbox">
                                        <input type="checkbox" class="custom-control-input" id="Property_Offence" name="Property_Offence" value="1" {{($case->Property_Offence == 1)? 'checked' : ''}}>
                                        <label class="custom-control-label" for="Property_Offence">Property Offence</label>
                                    </div>
                                </div>
                                <div class="category-offence col-md-12 d-none">
                                    <div class="form-row">
                                        <div class="col-md-12">
                                            @if(isset($categories))
                                                <strong>Select Category</strong>
                                                <br>
                                                @foreach($categories as $category)
                                                    <div class="custom-control custom-checkbox custom-control-inline col-md-3 ml-2">
                                                        <input type="checkbox" class="custom-control-input" id="{{'cat-'.$category->ID}}" name="propCategories[]" {{in_array($category->ID,$crimeCate) ? 'checked' : ''}} value="{{$category->ID}}">
                                                        <label class="custom-control-label" for="{{'cat-'.$category->ID}}">{{$category->Category}}</label>
                                                    </div>
                                                @endforeach
                                            @endif

                                        </div>
                                        <br>
                                        <div class="form-group col-md-12">
                                            <label for="propertyStolen" class="mt-2"><strong>Property Stolen</strong></label>
                                            <input type="text" class="form-control" id="propertyStolen" name="propertyStolen" value="{{isset($case->Property_Stolen) ? $case->Property_Stolen : ""}}">
                                        </div>

                                        <div class="form-group col-md-6">
                                            <label for="propertyValue" class="mt-2">Property Value</label>
                                            <input type="text" class="form-control" id="propertyValue" name="propertyValue" value="{{isset($case->Property_Value) ? $case->Property_Value : ""}}">
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label for="propertyRemakrs" class="mt-2">Property Remarks</label>
                                            <input type="text" class="form-control" id="propertyRemakrs" name="propertyRemakrs" value="{{isset($case->Property_Remakrs) ? $case->Property_Remakrs : ""}}">
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label for="moType" class="mt-2">MO Type</label>

                                            <select class="form-control" id="moType" name="moType">
                                                <option value="">Select Type</option>
                                                @foreach($moTypes AS $moType)
                                                    <option value="{{$moType->ID}}" {{($moType->ID == $case->MO_Type) ? 'selected' : ''}}>{{$moType->Modus}}</option>
                                                    @endforeach
                                               </select>

                                        </div>

                                        <div class="form-group col-md-6">
                                            <label for="moRemarks" class="mt-2">MO Remarks</label>
                                            <input type="text" class="form-control" id="moRemarks" name="moRemarks" value="{{isset($case->MO_Remarks) ? $case->MO_Remarks : ""}}">
                                        </div>
                                        <div class="form-group col-md-12">
                                            {{--assoicate vehicle--}}
                                            <div class="form-row border border-dark vehicle-show d-none">
                                                @if(isset($vehicleInfo[0]))
                                                    <table width="100%" class="text-center">
                                                        <thead>
                                                        <tr>
                                                            <th>Vehicle No</th>
                                                            <th>Owner Name</th>
                                                            <th>Chesis No</th>
                                                            <th>Engine No</th>
                                                            <th>Vehicle Type</th>
                                                            <th>Vehicle Model</th>
                                                            <th>Insurance Upto</th>
                                                            <th>Registraion Upto</th>
                                                            <th>Action</th>
                                                        </tr>
                                                        </thead>
                                                        <tbody>
                                                            <tr>
                                                                <td>{{$vehicleInfo[0]->vehicle_no}}</td>
                                                                <td>{{$vehicleInfo[0]->owners_name}}</td>
                                                                <td>{{$vehicleInfo[0]->chesis_no}}</td>
                                                                <td>{{$vehicleInfo[0]->engine_no}}</td>
                                                                <td>{{$vehicleInfo[0]->vehicle_type}}</td>
                                                                <td>{{$vehicleInfo[0]->vehicle_model}}</td>
                                                                <td>{{$vehicleInfo[0]->insurance_upto}}</td>
                                                                <td>{{$vehicleInfo[0]->registration_upto}}</td>
                                                                <td> <button type="button" class="btn btn-sm btn-primary m-2" id="add-associate-btn" data-toggle="modal" data-target="#vehicleInforModal">Edit Info</button></td>
                                                            </tr>
                                                        </tbody>
                                                    </table>

                                                @else
                                                    <div class="form-group col-md-2 pt-2">
                                                        <button type="button" class="btn btn-primary" id="add-associate-btn" data-toggle="modal" data-target="#vehicleInforModal">Add Vehicles</button>
                                                    </div>
                                                    <div class="form-group col-md-2 pt-2">
                                                        <button type="button" class="btn btn-primary" id="refresh-associate-btn">Refresh</button>
                                                    </div>

                                                @endif
                                                {{-- @php
                                                     $associates = DB::table('criminal_criminal AS cc')->join('tbl_criminal AS c','cc.Criminal2','=','c.ID')->where('cc.Criminal1','=',$accused->ID)->select('cc.JoinID','c.ID AS AssociateID','c.Name','c.Short_Name','c.Accused_FName')->get();
                                                 @endphp

                                                 @if(isset($associates[0]))
                                                     <table width="100%">
                                                         <thead>
                                                         <tr>
                                                             <th>Accused ID</th>
                                                             <th>Associate Name</th>
                                                             <th>Associate Father Name</th>
                                                             <th>Action</th>
                                                         </tr>
                                                         </thead>
                                                         <tbody>
                                                         @foreach($associates AS $associate)
                                                             <tr>
                                                                 <td>{{$associate->AssociateID}}</td>
                                                                 <td>{{$associate->Name .' @ '.$associate->Short_Name}}</td>
                                                                 <td>{{$associate->Accused_FName}}</td>
                                                                 <td><a href="javascript:void(0);" data-associateid="{{$associate->JoinID}}" class="btn btn-primary btn-sm mb-2 remove-associate-btn">Remove</a> </td>
                                                             </tr>
                                                         @endforeach
                                                         </tbody>
                                                     </table>

                                                 @endif--}}
                                            </div>
                                            <br>

                                        </div>


                                    </div>
                                </div>
                                <br>

                                <div class="form-group col-md-6">
                                    <label for="section">Sections</label>
                                    <input type="text" class="form-control" id="section" name="section" value="{{isset($case->Sections) ? $case->Sections : ""}}">
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="io">IO</label>
                                    <input type="text" class="form-control" id="io" name="io" value="{{isset($case->IO) ? $case->IO : ""}}">
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="modeTranspassing">Mode of Trespassing</label>
                                    <input type="text" class="form-control" id="modeTranspassing" name="modeTranspassing" value="{{isset($case->Mode_Transpassing) ? $case->Mode_Transpassing : ""}}">
                                </div>

                                <div class="form-group col-md-6">
                                    <label for="status">Case Status</label>
                                    <select class="form-control" id="status" name="status">
                                        <option value="">Select Status</option>
                                        <option value="PI" {{($case->Status == 'PI') ? 'selected': ''}}>PI</option>
                                        <option value="CS" {{($case->Status == 'CS') ? 'selected': ''}}>CS</option>
                                        <option value="CS PI" {{($case->Status == 'CS PI') ? 'selected': ''}}>CS PI</option>
                                        <option value="FRT(N C)" {{($case->Status == 'FRT(N C)') ? 'selected': ''}}>FRT(N C)</option>
                                        <option value="FR False" {{($case->Status == 'FR False') ? 'selected': ''}}>FR False</option>
                                        <option value="FRT" {{($case->Status == 'FRT') ? 'selected': ''}}>FRT</option>
                                        <option value="MF" {{($case->Status == 'MF') ? 'selected': ''}}>MF</option>
                                        <option value="MOL" {{($case->Status == 'MOL') ? 'selected': ''}}>MOL</option>
                                        <option value="FR(R)" {{($case->Status == 'FR(R)') ? 'selected': ''}}>FR(R)</option>
                                        <option value="FR(I.E)" {{($case->Status == 'FR(I.E)') ? 'selected': ''}}>FR(I.E)</option>
                                        <option value="NOT CS" {{($case->Status == 'NOT CS') ? 'selected': ''}}>NOT CS</option>
                                    </select>
                                </div>

                                <div class="form-group col-md-6">
                                    <label for="statusNo">Case Status No</label>
                                    <input type="text" class="form-control" id="statusNo" name="statusNo" value="{{isset($case->Status_No) ? $case->Status_No : ""}}">
                                </div>

                                <div class="form-group col-md-6">
                                    <label for="detection_status">Detection Status</label>
                                    <select class="form-control" id="detection_status" name="detection_status">
                                        <option value="detected" {{($case->detection_status == 'detected') ? 'selected' : ''}}>Detected</option>
                                        <option value="undetected" {{($case->detection_status == 'undetected') ? 'selected' : ''}}>Undetected</option>
                                    </select>
                                </div>

                            </div>
                            <br>

                            {{--associate accused--}}
                            <div class="form-row border border-dark display-custom" id="add-accused-section">
                                <div class="form-group col-md-2 pt-2">
                                    <button type="button" class="btn btn-primary" id="add-associate-btn" data-toggle="modal" data-target="#accused-associate-model">Add Accused</button>
                                </div>
                                <div class="form-group col-md-2 pt-2">
                                    <button type="button" class="btn btn-primary" id="refresh-associate-btn1">Refresh</button>
                                </div>
                                @php
                                    $associates = DB::table('crime_criminal AS cc')->join('tbl_criminal AS c','cc.Criminal','=','c.ID')
                                    ->leftJoin('tbl_crime_criminal_status AS ccs', function ($join){
                                    $join->on("ccs.Criminal", '=', 'cc.Criminal');
                                    $join->on('ccs.Crime', '=', 'cc.Crime');
                                    })
                                    ->where('cc.Crime','=',$case->ID)->select('cc.JoinID','c.ID AS AssociateID','c.Name','c.Short_Name','c.Accused_FName','ccs.ID AS ccs_id','ccs.Status AS ccs_status')->get();
                                @endphp

                                @if(isset($associates[0]))
                                    <table width="100%">
                                        <thead>
                                        <tr>
                                            <th>Accused ID</th>
                                            <th>Associate Name</th>
                                            <th>Associate Father Name</th>
                                            <th>Status</th>
                                            <th>Action</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($associates AS $associate)
                                            <tr>
                                                <td>{{$associate->AssociateID}}</td>
                                                <td>{{$associate->Name .' @ '.$associate->Short_Name}}</td>
                                                <td>{{$associate->Accused_FName}}</td>
                                                <td class="m-1">
                                                    <select class="form-control case_accused_status" id="case_accused_status" name="case_accused_status">
                                                        <option value="">Select Status</option>
                                                        @if($status[0])
                                                            @foreach($status AS $stats)
                                                                <option value="{{$stats->status_name}}" {{($stats->status_name == $associate->ccs_status) ? 'selected' : ''}} data-crimeid="{{$case->ID}}" data-criminalid="{{$associate->AssociateID}}">{{$stats->status_name}}</option>
                                                                @endforeach
                                                            @endif
                                                        </select>
                                                </td>
                                                <td><a href="javascript:void(0);" data-associateid="{{$associate->JoinID}}" class="btn btn-primary btn-sm mb-2 remove-associate-btn">Remove</a> </td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>

                                @endif
                            </div>
                            <br>
                            {{--associate victim--}}
                            <div class="form-row border border-dark">
                                <div class="form-group col-md-2 pt-2">
                                    <button type="button" class="btn btn-primary" id="add-victim-btn" data-toggle="modal" data-target="#victim-model">Add Victim</button>
                                </div>
                                <div class="form-group col-md-2 pt-2">
                                    <button type="button" class="btn btn-primary" id="refresh-victim-btn">Refresh</button>
                                </div>
                                 @php
                                     $victims = DB::table('tbl_victim')->where('CaseID','=',$case->ID)->get();
                                 @endphp

                                 @if(isset($victims[0]))
                                     <table width="100%">
                                         <thead>
                                         <tr>
                                             <th>Victim ID</th>
                                             <th>Victim Name</th>
                                             <th>Victim Father Name</th>
                                             <th>Victim Age</th>
                                             <th>Gender</th>
                                             <th>Mobile No</th>
                                             <th>Address1</th>
                                             <th>Action</th>
                                         </tr>
                                         </thead>
                                         <tbody>
                                         @foreach($victims AS $victim)
                                             <tr>
                                                 <td>{{$victim->ID}}</td>
                                                 <td>{{$victim->VictimName}}</td>
                                                 <td>{{$victim->VictimFName}}</td>
                                                 <td>{{$victim->Age}}</td>
                                                 <td>{{$victim->Gender}}</td>
                                                 <td>{{$victim->MobileNo}}</td>
                                                 <td>{{$victim->Address1}}</td>
                                                 <td><a href="javascript:void(0);" data-victimid="{{$victim->ID}}" class="btn btn-primary btn-sm mb-2 remove-victim-btn">Remove</a> </td>
                                             </tr>
                                         @endforeach
                                         </tbody>
                                     </table>

                                 @endif
                            </div>
                            <br>
                            <div class="form-row border border-dark">
                                <div class="form-group col-md-4 pt-2">
                                    <button type="button" class="btn btn-primary" id="add-recovery-btn" data-toggle="modal" data-target="#recovery-model">Add Recovery Detail</button>
                                </div>
                                @php
                                    $recoveries = DB::table('tbl_recovery')->where('case_id','=',$case->ID)->get();
                                @endphp

                                @if(isset($recoveries[0]))
                                    <table width="100%">
                                        <thead>
                                        <tr>
                                            <th>Date of Recovery</th>
                                            <th>Item</th>
                                            <th>Quantity</th>
                                            <th>Remarks</th>
                                            <th>Status</th>
                                            <th>Action</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($recoveries AS $recovery)
                                            <tr>
                                                <td>{{$recovery->date_of_recovery}}</td>
                                                <td>{{$recovery->item}}</td>
                                                <td>{{$recovery->quantity}}</td>
                                                <td>{{$recovery->remarks}}</td>
                                                <td>{{$recovery->status}}</td>
                                                <td><a href="javascript:void(0);" data-recoveryid="{{$recovery->id}}" class="btn btn-primary btn-sm mb-2 remove-recovery-btn">Remove</a> </td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>

                                @endif
                            </div>

                            <br>
                            <div class="form-row">
                                <div class="form-group col-md-3">
                                    <p class="text-center">Image 1</p>
                                    <img src="{{url('/').'/public/case/images/'.$case->Picture_Place}}" width="100%" height="250px">
                                </div>
                                <div class="form-group col-md-3">
                                    <p class="text-center">Image 2</p>
                                    <img src="{{url('/').'/public/case/images/'.$case->Picture_Place1}}" width="100%" height="250px">
                                </div>
                                <div class="form-group col-md-3">
                                    <p class="text-center">Image 3</p>
                                    <img src="{{url('/').'/public/case/images/'.$case->Picture_Place2}}" width="100%" height="250px">
                                </div>
                                <div class="form-group col-md-3">
                                    <p class="text-center">Image 4</p>
                                    <img src="{{url('/').'/public/case/images/'.$case->Picture_Place3}}" width="100%" height="250px">
                                </div>
                                <div class="form-group col-md-3">
                                    <input type="file" class="form-control" id="placePicture" name="placePicture">
                                </div>
                                <div class="form-group col-md-3">
                                    <input type="file" class="form-control" id="placePicture1" name="placePicture1">
                                </div>
                                <div class="form-group col-md-3">
                                    <input type="file" class="form-control" id="placePicture2" name="placePicture2">
                                </div>
                                <div class="form-group col-md-3">
                                    <input type="file" class="form-control" id="placePicture3" name="placePicture3">
                                </div>

                            </div>
                            <br>
                            <button type="submit" class="btn btn-primary display-custom" id="show-save-btn">Save All</button>

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <div class="modal fade" id="bailed-model" tabindex="-1" role="dialog" aria-labelledby="bailedInforModalTitle" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="bailedInforModalTitle">Bailed Information</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="javascript:void(0);" id="add-bailed-info-form" method="POST" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="criminal_crime_status_id" id="criminal_crime_status_id" value="">
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="date_of_bail">Date Of Bail</label>
                                <input type="date" class="form-control" id="date_of_bail" name="date_of_bail" value="">
                            </div>
                            <div class="form-group col-md-6">
                                <label for="bail_condition">Bail Condition</label>
                                <input type="text" class="form-control" id="bail_condition" name="bail_condition" value="">
                            </div>
                            <div class="form-group col-md-6">
                                <label for="case_ref_no">Case Ref No.</label>
                                <input type="text" class="form-control" id="case_ref_no" name="case_ref_no" value="">
                            </div>

                            <div class="form-group col-md-6">
                                <label for="court">Court</label>
                                <input type="text" class="form-control" id="court" name="court" value="">
                            </div>
                            @php
                            $bailers = DB::table('tbl_bailer')->get();
                            $advocates = DB::table('tbl_advocate')->get();
                            @endphp
                            <div class="form-group col-md-6">
                                <label for="bailer">Bailer</label>
                                <select class="form-control" id="bailer" name="bailer">
                                    <option value="">Select Bailer</option>
                                    @if($bailers[0])
                                        @foreach($bailers AS $bailer)
                                            <option value="{{$bailer->B_Name}}">{{$bailer->B_Name}}</option>
                                            @endforeach
                                        @endif
                                  </select>

                            </div>

                            <div class="form-group col-md-6">
                                <label for="advocate">Advocate</label>
                                <select class="form-control" id="advocate" name="advocate">
                                    <option value="">Select Bailer</option>
                                    @if($advocates[0])
                                        @foreach($advocates AS $advocate)
                                            <option value="{{$advocate->AdvName}}">{{$advocate->AdvName}}</option>
                                        @endforeach
                                    @endif
                                </select>

                            </div>

                            <div class="form-group col-md-6">
                                <label for="security_amount">Secuirty Amount</label>
                                <input type="text" class="form-control" id="security_amount" name="security_amount" value="">
                            </div>
                            <div class="form-group col-md-6">
                                <label for="land_patta_detail">Land Patta Detail (Khata No) </label>
                                <input type="text" class="form-control" id="land_patta_detail" name="land_patta_detail" value="">
                            </div>


                        </div>


                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" id="bailed-add-btn">Save</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>

                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="recovery-model" tabindex="-1" role="dialog" aria-labelledby="recoveryInforModalTitle" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="recoveryInforModalTitle">Recovery Detail</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="javascript:void(0);" id="add-recovery-info-form" method="POST" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="case_id" id="case_id" value="{{$case->ID}}">
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="date_of_recovery">Date Of Recovery</label>
                                <input type="date" class="form-control" id="date_of_recovery" name="date_of_recovery" value="">
                            </div>
                            <div class="form-group col-md-6">
                                <label for="item">Item</label>
                                <input type="text" class="form-control" id="item" name="item" value="">
                            </div>
                            <div class="form-group col-md-6">
                                <label for="quantity">Quantity</label>
                                <input type="text" class="form-control" id="quantity" name="quantity" value="">
                            </div>

                            <div class="form-group col-md-6">
                                <label for="remarks">Remarks</label>
                                <input type="text" class="form-control" id="remarks" name="remarks" value="">
                            </div>

                            <div class="form-group col-md-6">
                                <label for="status">Status</label>
                                <select class="form-control" id="status" name="status">
                                    <option value="Handed over to Owner">Handed over to Owner</option>
                                    <option value="Police Custody">Police Custody</option>
                                </select>

                            </div>

                        </div>


                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" id="recovery-add-btn">Save</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>

                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="victim-model" tabindex="-1" role="dialog" aria-labelledby="assoicate-victim" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="victimInforModalTitle">Victim Info</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="javascript:void(0);" id="add-victim-info-form" method="POST" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="CaseID" id="CaseID" value="{{$case->ID}}">
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="VictimName">Victim Name</label>
                                <input type="text" class="form-control" id="VictimName" name="VictimName" value="">
                            </div>
                            <div class="form-group col-md-6">
                                <label for="VictimFName">Victim Father Name</label>
                                <input type="text" class="form-control" id="VictimFName" name="VictimFName" value="">
                            </div>
                            <div class="form-group col-md-6">
                                <label for="Age">Age</label>
                                <input type="text" class="form-control" id="Age" name="Age" value="">
                            </div>

                            <div class="form-group col-md-6">
                                <label for="Gender">Gender</label>
                                <select class="form-control" name="Gender" id="Gender">
                                    <option value="Male">Male</option>
                                    <option value="Female">Female</option>
                                    <option value="Other">Other</option>
                                </select>
                            </div>

                            <div class="form-group col-md-6">
                                <label for="MobileNo">Mobile No</label>
                                <input type="text" class="form-control" id="MobileNo" name="MobileNo" value="">
                            </div>

                            <div class="form-group col-md-6">
                                <label for="Address1">Address 1</label>
                                <input type="text" class="form-control" id="Address1" name="Address1" value="">
                            </div>
                            <div class="form-group col-md-6">
                                <label for="Address2">Address 2</label>
                                <input type="text" class="form-control" id="Address2" name="Address2" value="">
                            </div>
                            <div class="form-group col-md-6">
                                <label for="Address3">Address 3</label>
                                <input type="text" class="form-control" id="Address3" name="Address3" value="">
                            </div>


                            <div class="form-group col-md-6">
                                <label for="Remarks">Remark</label>
                                <input type="text" class="form-control" id="Remarks" name="Remarks" value="">
                            </div>
                            <div class="form-group col-md-6">
                                <label for="Status">Status</label>
                                <input type="text" class="form-control" id="Status" name="Status" value="">
                            </div>
                            <div class="form-group col-md-6">
                                <label for="Picture">Picture</label>
                                <input type="file" class="form-control" id="Picture" name="Picture" value="">
                            </div>

                        </div>


                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" id="victim-add-btn">Save</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>

                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="witness-model" tabindex="-1" role="dialog" aria-labelledby="witnessInforModalTitle" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="witnessInforModalTitle">Witness Info</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="javascript:void(0);" id="add-witness-info-form" method="POST" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="caseId" id="caseId" value="{{$case->ID}}">
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="witness_name">Witness Name</label>
                                <input type="text" class="form-control" id="witness_name" name="witness_name" value="">
                            </div>
                            <div class="form-group col-md-6">
                                <label for="witness_fname">Witness Father Name</label>
                                <input type="text" class="form-control" id="witness_fname" name="witness_fname" value="">
                            </div>
                            <div class="form-group col-md-6">
                                <label for="address">Address</label>
                                <input type="text" class="form-control" id="address" name="address" value="">
                            </div>

                            <div class="form-group col-md-6">
                                <label for="mobile_no">Mobile No</label>
                                <input type="text" class="form-control" id="mobile_no" name="mobile_no" value="">
                            </div>

                        </div>


                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" id="witness-add-btn">Save</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>

                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="vehicleInforModal" tabindex="-1" role="dialog" aria-labelledby="vehicleInforModalTitle" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="vehicleInforModalTitle">Vehicle Info</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="javascript:void(0);" id="add-vehicle-info-form" method="POST" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="caseId" id="caseId" value="{{$case->ID}}">
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="vehicleNo">Vehicle Reg. No</label>
                                <input type="text" class="form-control" id="vehicleNo" name="vehicleNo" value="{{isset($vehicleInfo[0]->vehicle_no) ? $vehicleInfo[0]->vehicle_no : ''}}">
                            </div>
                            <div class="form-group col-md-6">
                                <label for="ownerName">Ower/Complainant Name</label>
                                <input type="text" class="form-control" id="ownerName" name="ownerName" value="{{isset($vehicleInfo[0]->owners_name) ? $vehicleInfo[0]->owners_name : ''}}">
                            </div>
                            <div class="form-group col-md-6">
                                <label for="city">City</label>
                                <input type="text" class="form-control" id="city" name="city" value="{{isset($vehicleInfo[0]->city) ? $vehicleInfo[0]->city : ''}}">
                            </div>
                            <div class="form-group col-md-6">
                                <label for="vpoliceStation">Police Station</label>
                                <select class="form-control" id="vpoliceStation" name="vpoliceStation">
                                    @if(isset($policeStations))
                                        @foreach($policeStations AS $policeStation)
                                            <option value="{{$policeStation->PSName}}" {{isset($vehicleInfo[0]->police_station) ? (($policeStation->PSName == $vehicleInfo[0]->police_station) ? 'selected' : '') : ''}}>{{$policeStation->PSName}}</option>
                                        @endforeach
                                    @endif
                                </select>
                            </div>

                            <div class="form-group col-md-6">
                                <label for="firDate">FIR Date</label>
                                <input type="date" class="form-control" id="firDate" name="firDate" value="{{isset($vehicleInfo[0]->affair_date) ? $vehicleInfo[0]->affair_date : ''}}">
                            </div>
                            <div class="form-group col-md-6">
                                <label for="firNo">FIR No.</label>
                                <input type="text" class="form-control" id="firNo" name="firNo" value="{{isset($vehicleInfo[0]->affair_no) ? $vehicleInfo[0]->affair_no : ''}}">
                            </div>

                            <div class="form-group col-md-6">
                                <label for="vRegDate">Date of Registration Vehicle</label>
                                <input type="date" class="form-control" id="vRegDate" name="vRegDate" value="{{isset($vehicleInfo[0]->register_date) ? $vehicleInfo[0]->register_date : ''}}">
                            </div>
                            <div class="form-group col-md-6">
                                <label for="chasisNo">Chasis Number.</label>
                                <input type="text" class="form-control" id="chasisNo" name="chasisNo" value="{{isset($vehicleInfo[0]->chesis_no) ? $vehicleInfo[0]->chesis_no : ''}}">
                            </div>

                            <div class="form-group col-md-6">
                                <label for="engNo">Engine Number</label>
                                <input type="text" class="form-control" id="engNo" name="engNo" value="{{isset($vehicleInfo[0]->engine_no) ? $vehicleInfo[0]->engine_no : ''}}">
                            </div>
                            <div class="form-group col-md-6">
                                <label for="vType">Vehicle Type</label>
                                <input type="text" class="form-control" id="vType" name="vType" value="{{isset($vehicleInfo[0]->vehicle_type) ? $vehicleInfo[0]->vehicle_type : ''}}">
                            </div>

                            <div class="form-group col-md-6">
                                <label for="vBrand">Vehicle Brand</label>
                                <input type="text" class="form-control" id="vBrand" name="vBrand" value="{{isset($vehicleInfo[0]->vehicle_class) ? $vehicleInfo[0]->vehicle_class : ''}}">
                            </div>

                            <div class="form-group col-md-6">
                                <label for="vModel">Vehicle Model</label>
                                <input type="text" class="form-control" id="vModel" name="vModel" value="{{isset($vehicleInfo[0]->vehicle_model) ? $vehicleInfo[0]->vehicle_model : ''}}">
                            </div>
                            <div class="form-group col-md-6">
                                <label for="fuleType">Fule Type</label>
                                <input type="text" class="form-control" id="fuleType" name="fuleType" value="{{isset($vehicleInfo[0]->fuel_type) ? $vehicleInfo[0]->fuel_type : ''}}">
                            </div>

                            <div class="form-group col-md-6">
                                <label for="incuranceUpto">Insurance Upto</label>
                                <input type="date" class="form-control" id="incuranceUpto" name="incuranceUpto" value="{{isset($vehicleInfo[0]->insurance_upto) ? $vehicleInfo[0]->insurance_upto : ''}}">
                            </div>
                            <div class="form-group col-md-6">
                                <label for="registrationUpto">Registration Upto</label>
                                <input type="date" class="form-control" id="registrationUpto" name="registrationUpto" value="{{isset($vehicleInfo[0]->registration_upto) ? $vehicleInfo[0]->registration_upto : ''}}">
                            </div>


                        </div>


                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" id="vehicle-add-btn">Save</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>

                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="accused-associate-model" tabindex="-1" role="dialog" aria-labelledby="accusedModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="accusedModalCenterTitle">Assoicate Accused</h5>
                    <a href="{{route('validate.accused')}}" target="_blank" class="btn btn-primary btn-sm ml-5 mr-5">Add New</a>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <table width="100%" id="accused-relation-tbl-list">
                        <thead>
                        <tr>
                            <th>Accused ID</th>
                            <th>Name</th>
                            <th>Accused Father's Name</th>
                            <th>Add To List</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($accusedlists AS $accused)
                            <tr>
                                <td>{{$accused->ID}}</td>
                                <td>{{$accused->Name}}</td>
                                <td>{{$accused->Accused_FName}}</td>
                                <td><a href="javascript:void(0);" class="btn btn-primary btn-sm accused-relation" data-id="{{$accused->ID}}">Add</a> </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>

                </div>
            </div>
        </div>
    </div>

@endsection

@push('js')
<script>
    $(document).ready(function () {
        $('#policeStation').trigger('change');
        setTimeout(function () {
            $('#Outpost').val('{{$case->Outpost}}').change();
        },1000);


        $('.case_accused_status').on('change', function (e) {
            e.preventDefault();

            var Status = $(this).children('option:selected').val();
            var Criminal = $(this).children('option:selected').data('criminalid');
            var Crime = $(this).children('option:selected').data('crimeid');
/*

            alert(Status);
            alert(Criminal);
            alert(Crime);
*/
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                url: "{{ route('ccs.status.update') }}",
                method: 'POST',
                data: {
                    Criminal: Criminal,
                    Crime: Crime,
                    Status: Status,
                },
                success: function(result){
                    console.log(result);
                    //window.location.reload();
                    if(result.type){
                        Swal.fire({
                            title: 'Updated',
                            text: "Status Updated Successfully",
                            icon: 'success'
                        });
                        if(Status == 'bailed'){
                            $('#bailed-model #criminal_crime_status_id').val(result.record[0].ID);
                            $('#bailed-model').modal('toggle');
                        }
                    }else{
                        Swal.fire({
                            title: 'Opps',
                            text: "Something Went Wrong. Try Again.",
                            icon: 'error'
                        });
                    }
                },
                error: function(data) {
                    console.log(data);
                },

            });


        });
        var deducation = $('#detection_status option:selected').val();
        if(deducation == 'detected'){
            $('#show-save-btn').removeClass('display-custom');
            $('#add-accused-section').removeClass('display-custom');
        }else{
            $('#show-save-btn').addClass('display-custom');
            $('#add-accused-section').addClass('display-custom');
        }

        //$('#detection_status').trigger('change');

        $('#is_cctv_footage').trigger('change');
        $('#accused-relation-tbl-list').DataTable();

        $('#bailed-add-btn').on('click', function (e) {
            e.preventDefault();

            e.preventDefault();

            let form_data = new FormData($('#add-bailed-info-form')[0]);
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $.ajax({
                url: "{{ route('add.bailed.info') }}",
                method: 'POST',
                data: form_data,
                processData: false,
                contentType: false,
                success: function(result){
                    console.log(result);
                    //window.location.reload();
                    if(result.type){
                        Swal.fire({
                            title: 'Success',
                            text: "Bailed Information Detail Added Successfully",
                            icon: 'success'
                        });
                        //$('#add-case-form').submit();
                        $('#bailed-model').modal('toggle');

                    }else{
                        Swal.fire({
                            title: 'Opps',
                            text: "Something Went Wrong. Try Again.",
                            icon: 'error'
                        });
                    }
                },
                error: function(data) {
                    console.log(data);
                },

            });


        });

        $('#recovery-add-btn').on('click', function (e) {
            e.preventDefault();

            let form_data = new FormData($('#add-recovery-info-form')[0]);
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $.ajax({
                url: "{{ route('add.recovery') }}",
                method: 'POST',
                data: form_data,
                processData: false,
                contentType: false,
                success: function(result){
                    console.log(result);
                    //window.location.reload();
                    if(result.type){
                        Swal.fire({
                            title: 'Success',
                            text: "Recovery Detail Added Successfully",
                            icon: 'success'
                        });
                        $('#add-case-form').submit();

                    }else{
                        Swal.fire({
                            title: 'Opps',
                            text: "Something Went Wrong. Try Again.",
                            icon: 'error'
                        });
                    }
                },
                error: function(data) {
                    console.log(data);
                },

            });


        });

        $('#victim-add-btn').on('click', function (e) {
            e.preventDefault();
            let form_data = new FormData($('#add-victim-info-form')[0]);

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $.ajax({
                url: "{{ route('add.victim') }}",
                method: 'POST',
                data: form_data,
                processData: false,
                contentType: false,
                success: function(result){
                    console.log(result);
                    //window.location.reload();
                    if(result.type){
                        Swal.fire({
                            title: 'Success',
                            text: "Victim Added Successfully",
                            icon: 'success'
                        });
                        $('#add-case-form').submit();

                    }else{
                        Swal.fire({
                            title: 'Opps',
                            text: "Something Went Wrong. Try Again.",
                            icon: 'error'
                        });
                    }
                },
                error: function(data) {
                    console.log(data);
                },

            });


        });

        $('#witness-add-btn').on('click', function (e) {
            e.preventDefault();

            let form_data = new FormData($('#add-witness-info-form')[0]);
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $.ajax({
                url: "{{ route('add.witness') }}",
                method: 'POST',
                data: form_data,
                processData: false,
                contentType: false,
                success: function(result){
                    console.log(result);
                    //window.location.reload();
                    if(result.type){
                        Swal.fire({
                            title: 'Success',
                            text: "Witnss Added Successfully",
                            icon: 'success'
                        });
                        $('#add-case-form').submit();

                    }else{
                        Swal.fire({
                            title: 'Opps',
                            text: "Something Went Wrong. Try Again.",
                            icon: 'error'
                        });
                    }
                },
                error: function(data) {
                    console.log(data);
                },

            });


        });
        $('#accused-associate-model tbody').on('click','.accused-relation', function (e) {
            e.preventDefault();
            var accused_id = $(this).data("id");
            var crime_id = $('#id').val();
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                url: "{{ route('case.accused.associate') }}",
                method: 'POST',
                data: {
                    accused_id: accused_id,
                    crime_id: crime_id,
                },
                success: function(result){
                    console.log(result);
                    //window.location.reload();
                    if(result.type){
                        Swal.fire({
                            title: 'Success',
                            text: "Accused Associate Successfully",
                            icon: 'success'
                        });
                    }else{
                        Swal.fire({
                            title: 'Opps',
                            text: "Something Went Wrong. Try Again.",
                            icon: 'error'
                        });
                    }
                },
                error: function(data) {
                    console.log(data);
                },

            });

        });

        $('.remove-recovery-btn').on('click', function (e) {
            e.preventDefault();
            var id = $(this).data('recoveryid');

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                url: "{{ route('remove.recovery') }}",
                method: 'POST',
                data: {
                    id: id,
                },
                success: function(result){
                    console.log(result);
                    $('#add-case-form').submit();
                },
                error: function(data) {
                    console.log(data);
                },

            });

        })

        $('.remove-witness-btn').on('click', function (e) {
            e.preventDefault();
            var id = $(this).data('witnessid');

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                url: "{{ route('destroy.witness') }}",
                method: 'POST',
                data: {
                    id: id,
                },
                success: function(result){
                    console.log(result);
                    $('#add-case-form').submit();
                },
                error: function(data) {
                    console.log(data);
                },

            });

        });

        $('.remove-victim-btn').on('click', function (e) {
            e.preventDefault();
            var id = $(this).data('victimid');

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                url: "{{ route('remove.victim') }}",
                method: 'POST',
                data: {
                    id: id,
                },
                success: function(result){
                    console.log(result);
                    $('#add-case-form').submit();
                },
                error: function(data) {
                    console.log(data);
                },

            });

        });

        $('.remove-associate-btn').on('click', function (e) {
            e.preventDefault();
            var id = $(this).data('associateid');
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                url: "{{ route('case.accused.associate.remove') }}",
                method: 'POST',
                data: {
                    id: id,
                },
                success: function(result){
                    console.log(result);
                    window.location.reload();
                },
                error: function(data) {
                    console.log(data);
                },

            });

        });

        $('#moType').trigger('change');

        $('#vehicle-add-btn').on('click', function (e) {
            e.preventDefault();
            let form_data = new FormData($('#add-vehicle-info-form')[0]);
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $.ajax({
                url: "{{ route('add.vehicle.info') }}",
                method: 'POST',
                data: form_data,
                processData: false,
                contentType: false,
                success: function(result){
                    console.log(result);
                    if(result.type){
                        $('#add-case-form').submit();
                    }
                },
                error: function(data) {
                    console.log(data);
                },

            });

        });


        $('#Property_Offence').trigger('change');
    });

    $('#moType').on('change', function () {
       if($(this).val() == 55 || $(this).val() == 56 || $(this).val() == 57){
           $('.vehicle-show').removeClass('d-none');
       }else{
           $('.vehicle-show').addClass('d-none');
       }
    });
    $('#Property_Offence').on('change', function () {
       if($(this).prop('checked') == true){
           $('.category-offence').removeClass('d-none');
       }else{
           $('.category-offence').addClass('d-none');
       }
    });
    // Initialize and add the map
    function initMap() {
        // The location of Uluru
        const uluru = { lat: -25.344, lng: 131.036 };
        // The map, centered at Uluru
        const map = new google.maps.Map(document.getElementById("map"), {
            zoom: 4,
            center: uluru,
        });
        // The marker, positioned at Uluru
        const marker = new google.maps.Marker({
            position: uluru,
            map: map,
        });
    }

    $('#policeStation').on('change', function () {
       var PSID = $('#policeStation option:selected').data('id');
       if(PSID != ''){
           $.ajaxSetup({
               headers: {
                   'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
               }
           });

           $.ajax({
               url: "{{ route('ps.outpost') }}",
               method: 'POST',
               data: {
                   id : PSID,
               },
               success: function(result){
                   console.log(result);
                   $('#Outpost').empty().append('<option value="">Select Outpost</option>');
                   $.each(result.outposts, function (k, v) {
                       $('#Outpost').append('<option value="'+v['outpost_name']+'">'+v['outpost_name']+'</option>');
                   });
               },
               error: function(data) {
                   console.log(data);
               },

           });

       }else{
           $('#Outpost').empty().append('<option value="">Select Outpost</option>')
       }


    });


    $('#detection_status').on('change', function () {
        var deducation = $('#detection_status option:selected').val();
        if(deducation == 'detected'){
            $('#show-save-btn').removeClass('display-custom');
            $('#add-accused-section').removeClass('display-custom');
        }else{
            $('#show-save-btn').addClass('display-custom');
            $('#add-accused-section').addClass('display-custom');
        }
        $('#add-case-form').submit();
    });
    $('#is_cctv_footage').on('change', function () {
        var cctv = $(this).val();
        if(cctv == 1){
            $('#cctv-display').removeClass('display-custom');
        }else{
            $('#cctv-display').addClass('display-custom');
        }
    });

    $('#refresh-associate-btn').on('click', function () {
        $('#add-case-form').submit();
    });
    $('#refresh-associate-btn1').on('click', function () {
        $('#add-case-form').submit();
    });
    $('#refresh-victim-btn').on('click', function () {
        $('#add-case-form').submit();
    });

</script>
@endpush