@extends('layouts.app')
@section('content')
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Add/Edit Accused</div>

                    <div class="card-body">
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif

                        <form action="{{route('accused.edit',['id',$accused->ID])}}" id="add-accused-form" method="POST" enctype="multipart/form-data">

                            @csrf
                            <input type="hidden" name="id" id="id" value="{{$accused->ID}}">
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label for="name">Name</label>
                                    <input type="text" class="form-control" id="name" name="name" placeholder="Name" value="{{isset($accused->Name) ? $accused->Name : ''}}">
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="shortName">Short Name</label>
                                    <input type="text" class="form-control" id="shortName" name="shortName" placeholder="Short Name" value="{{isset($accused->Short_Name) ? $accused->Short_Name : ''}}">
                                </div>
                            </div>
                            <div class="form-row">

                                <div class="form-group col-md-6">
                                    <label for="fatherName">Father Name</label>
                                    <input type="text" class="form-control" id="fatherName" name="fatherName" placeholder="Father Name" value="{{isset($accused->Accused_FName) ? $accused->Accused_FName : ''}}">
                                </div>
                               {{-- <div class="form-group col-md-3">
                                    <label for="cast">Cast</label>
                                    <select id="cast" name="cast" class="form-control">
                                        <option value="">Select Cast</option>
                                        <option value="ST" {{($accused->Cast == 'ST') ? 'selected' : ''}}>ST</option>
                                        <option value="SC" {{($accused->Cast == 'SC') ? 'selected' : ''}}>SC</option>
                                        <option value="SEBC" {{($accused->Cast == 'SEBC') ? 'selected' : ''}}>SEBC</option>
                                        <option value="UR" {{($accused->Cast == 'UR') ? 'selected' : ''}}>UR</option>
                                    </select>
                                </div>
                               --}}
                                <div class="form-group col-md-3">
                                    <label for="gender">Gender</label>
                                    <select id="gender" name="gender" class="form-control">
                                        <option value="">Select Gender</option>
                                        <option value="Male" {{($accused->Gender == 'Male') ? 'selected' : ''}}>Male</option>
                                        <option value="Female" {{($accused->Gender == 'Female') ? 'selected' : ''}}>Female</option>
                                        <option value="Other" {{($accused->Gender == 'Other') ? 'selected' : ''}}>Other</option>
                                    </select>
                                </div>
                                <div class="form-group col-md-3">
                                    <label for="occupation">Occupation</label>
                                    <input type="text" class="form-control" id="occupation" name="occupation" placeholder="Occupation" value="{{$accused->Occupation}}">
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label for="habits">Habits</label>
                                    <input type="text" class="form-control" id="habits" name="habits" placeholder="Habits" value="{{$accused->Habits}}">
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="bankAccount">Bank Account</label>
                                    <input type="text" class="form-control" id="bankAccount" name="bankAccount" placeholder="Bank Account" value="{{$accused->Bank_Account}}">
                                </div>
                            </div>


                            <div class="form-row">

                                <div class="form-group col-md-6">
                                    <label for="mobileNo">Mobile No</label>
                                    <input type="text" class="form-control" id="mobileNo" name="mobileNo" placeholder="Mobile No" value="{{$accused->Mobile}}">
                                </div>

                                <div class="form-group col-md-6">
                                    <label for="aadhar_no">Aadhar No</label>
                                    <input type="text" class="form-control" id="aadhar_no" name="aadhar_no" placeholder="Aadhar No" value="{{$accused->aadhar_no}}">
                                </div>
                            </div>


                            <br>
                            <div class="form-row border border-dark">
                                <div class="form-group col-md-5">
                                    <label for="visitingPlace">Visiting Place</label>
                                    <input type="text" class="form-control" id="visitingPlace" name="visitingPlace" placeholder="Visiting Place" value="">
                                </div>
                                <div class="form-group col-md-5">
                                    <label for="purpose">Purpose</label>
                                    <input type="text" class="form-control" id="purpose" name="purpose" placeholder="Purpose" value="">
                                </div>
                                <div class="form-group col-md-1">
                                    <br>
                                    <button type="button" class="btn btn-primary" style="margin-top: 8px" id="add-place-visiting-btn">Add</button>
                                </div>

                                @php
                                    $visitingPlaces = DB::table('tbl_accused_visit AS ar')->where('ar.AccusedID','=',$accused->ID)->get();
                                @endphp
                                @if(isset($visitingPlaces[0]))

                                    <div class="col-md-12">
                                        <table width="100%">
                                            <thead>
                                            <tr>
                                                <th>Visiting Place</th>
                                                <th>Purpose</th>
                                                <th></th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            @foreach($visitingPlaces AS $visitingPlace)
                                                <tr>
                                                    <td>{{$visitingPlace->Place}}</td>
                                                    <td>{{$visitingPlace->purpose}}</td>
                                                    <td><a href="javascript:void(0);" data-visitingid="{{$visitingPlace->ID}}" class="btn btn-primary btn-sm mb-1 remove-visiting-place-btn">Remove</a> </td>
                                                </tr>
                                            @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                @endif
                            </div>
                            <br>

                            <div class="form-row border border-dark">
                                    <input type="hidden" id="accused_id" name="accused_id" value="{{$accused->ID}}">
                                <div class="form-group col-md-2">
                                    <label for="rName">Name</label>
                                    <input type="text" class="form-control" id="rName" name="rName" placeholder="Relative Name" value="">
                                </div>
                                <div class="form-group col-md-2">
                                    <label for="rFatherName">Father Name</label>
                                    <input type="text" class="form-control" id="rFatherName" name="rFatherName" placeholder="Relative Father Name" value="">
                                </div>
                                <div class="form-group col-md-2">
                                    <label for="rRelation">Relation</label>
                                    <select id="rRelation" name="rRelation" class="form-control">
                                        <option value="">Select Relation</option>
                                        <option value="Father">Father</option>
                                        <option value="Mother">Mother</option>
                                        <option value="Brother">Brother</option>
                                        <option value="Friend">Friend</option>
                                        <option value="Father">Father</option>
                                        <option value="Relative">Relative</option>
                                        <option value="Girlfriend">Girlfriend</option>
                                        <option value="Boyfriend">Boyfriend</option>
                                        <option value="Other">Other</option>
                                    </select>
                                </div>
                                <div class="form-group col-md-3">
                                    <label for="rAddress">Address</label>
                                    <input type="text" class="form-control" id="rAddress" name="rAddress" placeholder="Relative Address" value="">
                                </div>
                                <div class="form-group col-md-2">
                                    <label for="rMobile">Mobile No</label>
                                    <input type="text" class="form-control" id="rMobile" name="rMobile" placeholder="Relative Mobile No" value="">
                                </div>
                                    <div class="form-group col-md-1">
                                        <br>
                                        <button type="button" class="btn btn-primary" style="margin-top: 8px" id="add-relation-btn">Add</button>
                                    </div>
                                @php
                                    $relitives = DB::table('tbl_accused_relations AS ar')->where('ar.AccusedID','=',$accused->ID)->get();
                                @endphp
                                @if(isset($relitives[0]))

                                <div class="col-md-12">
                                    <table width="100%">
                                        <thead>
                                        <tr>
                                            <th>Name</th>
                                            <th>Father Name</th>
                                            <th>Relation</th>
                                            <th>Address</th>
                                            <th>Mobile No</th>
                                            <th></th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($relitives AS $relitive)
                                        <tr>
                                            <td>{{$relitive->Name}}</td>
                                            <td>{{$relitive->FatherName}}</td>
                                            <td>{{$relitive->Relation}}</td>
                                            <td>{{$relitive->Address}}</td>
                                            <td>{{$relitive->MobileNo}}</td>
                                            <td><a href="javascript:void(0);" data-relid="{{$relitive->ID}}" class="btn btn-primary btn-sm mb-1 remove-relitive">Remove</a> </td>
                                        </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                                    @endif
                            </div>

                            <br>

                            <div class="form-row border border-dark">
                                <div class="form-group col-md-6">
                                    <label for="address1">Address 1</label>
                                    <input type="text" class="form-control" id="address1" name="address1" placeholder="Address 1" value="{{$accused->Address1}}">
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="address2">Address 2</label>
                                    <input type="text" class="form-control" id="address2" name="address2" placeholder="Address 2" value="{{$accused->Address2}}">
                                </div>

                                <div class="form-group col-md-6">
                                    <label for="address3">Address 3</label>
                                    <input type="text" class="form-control" id="address3" name="address3" placeholder="Address 3" value="{{$accused->Address3}}">
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="policeStation">Police Station</label>
                                    <select class="form-control" id="policeStation" name="policeStation">
                                        <option value="">Select Police Station</option>
                                        @if(isset($policeStations))
                                            @foreach($policeStations AS $policeStation)
                                                <option value="{{$policeStation->PSName}}" {{($policeStation->PSName == $accused->Police_Station) ? 'selected' : ''}}>{{$policeStation->PSName}}</option>
                                            @endforeach
                                        @endif
                                    </select>
                                </div>


                                <div class="form-group col-md-6">
                                    <label for="state">State</label>
                                    <select id="state" name="state" class="form-control">
                                        <option value="">Select State</option>
                                       </select>
                                </div>

                                <div class="form-group col-md-6">
                                    <label for="basti_id">Select Basti</label>
                                    <select id="basti_id" name="basti_id" class="form-control">
                                        <option value="">Select Basti</option>
                                        @if(isset($bastis[0]))
                                            @foreach($bastis AS $basti)
                                                <option value="{{$basti->ID}}" {{($basti->ID == $accused->basti_id) ? 'selected' : ''}}>{{$basti->basti_name}}</option>
                                                @endforeach
                                            @endif
                                    </select>
                                </div>

                            </div>

                            <br>
                            <div class="form-row border border-dark">
                                <div class="form-group col-md-6">
                                    <label for="latitude">Latitude</label>
                                    <input type="text" class="form-control" id="latitude" name="latitude" placeholder="" value="{{$accused->Latitude}}">
                                </div>

                                <div class="form-group col-md-6">
                                    <label for="longitude">Longitude</label>
                                    <input type="text" class="form-control" id="longitude" name="longitude" placeholder="" value="{{$accused->Logitude}}">
                                </div>

                                <div class="col-md-12">
                                    <div id="map"></div>

                                </div>

                            </div>

                            <br>
                            <div class="form-row border border-dark">
                                <div class="form-group col-md-6">
                                    <label for="pAddress1">Permanent Address 1</label>
                                    <input type="text" class="form-control" id="pAddress1" name="pAddress1" placeholder="Permanent Address 1" value="{{$accused->PAddress1}}">
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="pAddress2">Permanent Address 2</label>
                                    <input type="text" class="form-control" id="pAddress2" name="pAddress2" placeholder="Permanent Address 2" value="{{$accused->PAddress2}}">
                                </div>

                                <div class="form-group col-md-6">
                                    <label for="pAddress3">Permanent Address 3</label>
                                    <input type="text" class="form-control" id="pAddress3" name="pAddress3" placeholder="Permanent Address 3" value="{{$accused->PAddress3}}">
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="pPoliceStation">Police Station</label>
                                    <select class="form-control" id="pPoliceStation" name="pPoliceStation">
                                        <option value="">Select Police Station</option>
                                    @if(isset($policeStations))
                                        @foreach($policeStations AS $policeStation)
                                            <option value="{{$policeStation->PSName}}" {{($policeStation->PSName == $accused->PPolice_Station) ? 'selected' : ''}}>{{$policeStation->PSName}}</option>
                                            @endforeach
                                        @endif
                                    </select>
                                </div>

                                <div class="form-group col-md-6">
                                    <label for="pState">Permanent State</label>
                                    <select id="pState" name="pState" class="form-control">
                                        <option value="">Select State</option>
                                       </select>
                                </div>

                            </div>
                            <br>
                            <div class="form-row border border-dark">
                                <div class="form-group col-md-6">
                                    <label for="build">Build</label>
                                    <select id="build" name="build" class="form-control">
                                        <option value="">Select Build</option>
                                        <option value="Plump" {{($accused->Built == 'Plump') ? 'selected' : ''}}>Plump</option>
                                        <option value="Stocky" {{($accused->Built == 'Stocky') ? 'selected' : ''}}>Stocky</option>
                                        <option value="OverWeight" {{($accused->Built == 'OverWeight') ? 'selected' : ''}}>OverWeight</option>
                                        <option value="Fat" {{($accused->Built == 'Fat') ? 'selected' : ''}}>Fat</option>
                                        <option value="Slim" {{($accused->Built == 'Slim') ? 'selected' : ''}}>Slim</option>
                                        <option value="Trim" {{($accused->Built == 'Trim') ? 'selected' : ''}}>Trim</option>
                                        <option value="Skinny" {{($accused->Built == 'Skinny') ? 'selected' : ''}}>Skinny</option>
                                        <option value="Buff" {{($accused->Built == 'Buff') ? 'selected' : ''}}>Buff</option>
                                        <option value="Well Built" {{($accused->Built == 'Well Built') ? 'selected' : ''}}>Well Built</option>
                                        <option value="Medium" {{($accused->Built == 'Medium') ? 'selected' : ''}}>Medium</option>
                                        <option value="Strong" {{($accused->Built == 'Strong') ? 'selected' : ''}}>Strong</option>
                                    </select>
                                </div>

                                <div class="form-group col-md-6">
                                    <label for="height">Height</label>
                                    <input type="text" class="form-control" id="height" name="height" placeholder="__.____ Inch" value="{{$accused->Height}}">
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="weight">Weight</label>
                                    <input type="text" class="form-control" id="weight" name="weight" placeholder="__.____ Kg" value="{{$accused->Weight}}">
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="skinColor">Skin Color</label>
                                    <select id="skinColor" name="skinColor" class="form-control">
                                        <option value="">Select Skin Color</option>
                                        <option value="Dark"  {{($accused->Skin_Color == 'Dark') ? 'selected' : ''}}>Dark</option>
                                        <option value="Light" {{($accused->Skin_Color == 'Light') ? 'selected' : ''}}>Light</option>
                                        <option value="Fair" {{($accused->Skin_Color == 'Fair') ? 'selected' : ''}}>Fair</option>
                                        <option value="Olive" {{($accused->Skin_Color == 'Olive') ? 'selected' : ''}}>Olive</option>
                                        <option value="Pale" {{($accused->Skin_Color == 'Pale') ? 'selected' : ''}}>Pale</option>
                                        <option value="Tan" {{($accused->Skin_Color == 'Tan') ? 'selected' : ''}}>Tan</option>
                                        <option value="Pimply" {{($accused->Skin_Color == 'Pimply') ? 'selected' : ''}}>Pimply</option>
                                        <option value="Freckles" {{($accused->Skin_Color == 'Freckles') ? 'selected' : ''}}>Freckles</option>
                                        <option value="Spots" {{($accused->Skin_Color == 'Spots') ? 'selected' : ''}}>Spots</option>
                                        <option value="Pimples" {{($accused->Skin_Color == 'Pimples') ? 'selected' : ''}}>Pimples</option>
                                        <option value="Wheat" {{($accused->Skin_Color == 'Wheat') ? 'selected' : ''}}>Wheat</option>
                                    </select>
                                </div>

                                <div class="form-group col-md-4">
                                    <label for="dateOfBirth">Date Of Birth</label>
                                    <input type="date" class="form-control" id="dateOfBirth" name="dateOfBirth" placeholder="Date Of Birth" value="{{$accused->DOB}}">
                                </div>

                                <div class="form-group col-md-4">
                                    <label for="yearOfBirth">Year of Birth</label>
                                    <input type="text" class="form-control" id="yearOfBirth" name="yearOfBirth" placeholder="Year Of Birth" value="{{$accused->YearofBirth}}">
                                </div>

                                <div class="form-group col-md-4">
                                    <label for="age">Age</label>
                                    <input type="text" class="form-control" id="age" name="age" placeholder="Age" value="{{$accused->Age}}">
                                </div>

                            </div>
                            <br>
                            <div class="form-row border border-dark">
                                <div class="form-group col-md-3">
                                    <label for="category">Category</label>
                                    <select id="category" name="category" class="form-control">
                                        <option value="">Select Category</option>
                                        <option value="A+" {{($accused->Category == 'A+') ? 'selected' : ''}}>A+</option>
                                        <option value="A" {{($accused->Category == 'A') ? 'selected' : ''}}>A</option>
                                        <option value="B" {{($accused->Category == 'B') ? 'selected' : ''}}>B</option>
                                        <option value="C" {{($accused->Category == 'C') ? 'selected' : ''}}>C</option>
                                      </select>
                                </div>

                                <div class="form-group col-md-3">
                                    <label for="status">Status</label>
                                    <select id="status" name="status" class="form-control">
                                        <option value="">Select Status</option>
                                        <option value="Jailed" {{($accused->Status == 'Jailed') ? 'selected' : ''}}>Jailed</option>
                                        <option value="Bailed" {{($accused->Status == 'Bailed') ? 'selected' : ''}}>Bailed</option>
                                        <option value="Present" {{($accused->Status == 'Present') ? 'selected' : ''}}>Present</option>
                                        <option value="Absconder" {{($accused->Status == 'Absconder') ? 'selected' : ''}}>Absconder</option>
                                    </select>
                                </div>

                                <div class="form-group col-md-3">
                                    <label for="remark">Remark</label>
                                    <input type="text" class="form-control" id="remark" name="remark" value="{{$accused->Other_Remarks}}">
                                </div>
                                <div class="form-group col-md-3">
                                    <label for="classification">Classification</label>
                                    <select id="classification" name="classification" class="form-control">
                                        <option value="">Select</option>
                                        <option value="Intra District" {{($accused->Classification == 'Intra District') ? 'selected' : ''}}>Intra District</option>
                                        <option value="Inter District" {{($accused->Classification == 'Inter District') ? 'selected' : ''}}>Inter District</option>
                                        <option value="Inter State" {{($accused->Classification == 'Inter State') ? 'selected' : ''}}>Inter State</option>
                                        <option value="Inter National" {{($accused->Classification == 'Inter National') ? 'selected' : ''}}>Inter National</option>
                                        <option value="Unknown" {{($accused->Classification == 'Unknown') ? 'selected' : ''}}>Unknown</option>
                                       </select>
                                </div>

                            </div>
                            <br>
                            <div class="form-row border border-dark">
                                <div class="form-group col-md-2 pt-2">
                                    <button type="button" class="btn btn-primary" id="add-associate-btn" data-toggle="modal" data-target="#exampleModalCenter">Add Associate</button>
                                </div>
                                <div class="form-group col-md-2 pt-2">
                                    <button type="button" class="btn btn-primary" id="refresh-associate-btn">Refresh</button>
                                </div>
                                @php
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

                                @endif
                            </div>
                            <br>
                            <div class="form-row border border-dark">
                                <div class="form-group col-md-3 pt-2">
                                    Gang Name
                                </div>
                                <div class="form-group col-md-5 pt-2">
                                    <select id="gang" name="gang" class="form-control">
                                        <option value="">Select Gang</option>
                                        @if(isset($gangs))
                                            @foreach($gangs AS $gang)
                                                <option value="{{$gang->ID}}">{{$gang->Name}}</option>
                                            @endforeach
                                            @endif
                                    </select>
                                </div>
                                <div class="form-group col-md-3 pt-2">
                                    <a href="{{route('gang.index')}}" target="_blank" class="btn btn-primary" id="add-gang-btn-blank">Add</a>
                                </div>
                                @php
                                $gangs = DB::table('tbl_gang_criminal AS gc')->join('tbl_gang AS g','gc.Gang_ID','=','g.ID')->select('gc.ID','g.Name')->get();
                                @endphp
                                @if(isset($gangs[0]))
                                <div class="col-md-12 offset-1">
                                    <table width="40%">
                                        <thead>
                                        <tr>
                                            <th>Gang</th>
                                            <th>Remove</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($gangs AS $gang)
                                        <tr>
                                            <td>{{$gang->Name}}</td>
                                            <td><a href="javascript:void(0);" data-gangid="{{$gang->ID}}" class="btn btn-primary btn-sm mb-2 remove-gang">Remove</a> </td>
                                        </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                                    @endif

                            </div>
                            <br>
                            <div class="form-row">
                                <div class="form-group col-md-3">
                                    <p class="text-center">Front Picture</p>
                                    <img src="{{url('/').'/public/accused/images/'.$accused->Picture_Front}}" width="100%" height="250px">
                                </div>
                                <div class="form-group col-md-3">
                                    <p class="text-center">Left Side Picture</p>
                                    <img src="{{url('/').'/public/accused/images/'.$accused->Picture_Side_Left}}" width="100%" height="250px">
                                </div>
                                <div class="form-group col-md-3">
                                    <p class="text-center">Right Side Picture</p>
                                    <img src="{{url('/').'/public/accused/images/'.$accused->Picture_Side_Right}}" width="100%" height="250px">
                                </div>
                                <div class="form-group col-md-3">
                                    <p class="text-center">Uniq Identification Mark</p>
                                    <img src="{{url('/').'/public/accused/images/'.$accused->Picture_Uinq}}" width="100%" height="250px">
                                </div>
                                <div class="form-group col-md-3">
                                    <input type="file" class="form-control" id="frontPicture" name="frontPicture">
                                </div>
                                <div class="form-group col-md-3">
                                    <input type="file" class="form-control" id="leftSidePicture" name="leftSidePicture">
                                </div>
                                <div class="form-group col-md-3">
                                    <input type="file" class="form-control" id="rightSidePicture" name="rightSidePicture">
                                </div>
                                <div class="form-group col-md-3">
                                    <input type="file" class="form-control" id="uniqIdentityMark" name="uniqIdentityMark">
                                </div>
                            </div>

                            <button type="submit" class="btn btn-primary" id="accused-add-btn">Update</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle">Assoicate Accused</h5>
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
                        @foreach($associateAccuseds AS $accused)
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
            $('#refresh-associate-btn').on('click',function () {
               window.location.reload();
            });
            $('#accused-relation-tbl-list').DataTable();

            $('.remove-associate-btn').on('click', function (e) {
                e.preventDefault();
                var id = $(this).data('associateid');
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                $.ajax({
                    url: "{{ route('remove.accusedAssociate') }}",
                    method: 'POST',
                    data: {
                        id: id,
                    },
                    success: function(result){
                        console.log(result);
                        $('#add-accused-form').submit();
                        //window.location.reload();
                    },
                    error: function(data) {
                        console.log(data);
                    },

                });

            });

            $('#exampleModalCenter .accused-relation').on('click', function (e) {
                e.preventDefault();
                var associate_id = $(this).data("id");
                var accused_id = $('#id').val();
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                $.ajax({
                    url: "{{ route('accusedAssociate') }}",
                    method: 'POST',
                    data: {
                        accused_id: accused_id,
                        associate_id: associate_id,
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


        });
        $('#accused-validate-btn').on('click',function (e) {
            e.preventDefault();
            let form_data = new FormData($('#validate-accused-form')[0]);
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                url: "{{ route('validate.accused') }}",
                method: 'POST',
                data: form_data,
                processData: false,
                contentType: false,
                success: function(result){
                    console.log(result);
                    if(result.type == "add"){
                        $('#validate-accused-form').attr('action','{{route('add.accused.form')}}');
                        Swal.fire({
                            title: 'This Accused doesn\'t exits.',
                            text: "do you want to make a new entry?",
                            icon: 'warning',
                            showCancelButton: true,
                            confirmButtonColor: '#3085d6',
                            cancelButtonColor: '#d33',
                            confirmButtonText: 'Yes'
                        }).then((result) => {
                            $('#validate-accused-form').submit();
                        })
                    }
                    if(result.type == "edit"){
                        $('#validate-accused-form').attr('action','{{route('edit.accused.form')}}');
                        Swal.fire({
                            title: 'This Accused already exits.',
                            text: "do you want to Update",
                            icon: 'warning',
                            showCancelButton: true,
                            confirmButtonColor: '#3085d6',
                            cancelButtonColor: '#d33',
                            confirmButtonText: 'Yes'
                        }).then((result) => {
                            $('#validate-accused-form').submit();
                        })
                    }
                },
                error: function(data) {
                    console.log(data);
                },

            });
        });

        $('#add-place-visiting-btn').on('click', function (e) {
            e.preventDefault();
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                url: "{{ route('add.visitingPlace') }}",
                method: 'POST',
                data: {
                    accused_id: $('#id').val(),
                    visitingPlace: $('#visitingPlace').val(),
                    purpose: $('#purpose').val()
                },
                success: function(result){
                    console.log(result);
                    $('#add-accused-form').submit();
                    //window.location.reload();
                },
                error: function(data) {
                    console.log(data);
                },

            });

        });


        $('.remove-visiting-place-btn').on('click',function (e) {
            var id = $(this).data('visitingid');
            e.preventDefault();
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                url: "{{ route('remove.visitingPlace') }}",
                method: 'POST',
                data: {
                    id: id,
                },
                success: function(result){
                    console.log(result);
                    $('#add-accused-form').submit();

                    //window.location.reload();
                },
                error: function(data) {
                    console.log(data);
                },

            });

        });

        $('#add-relation-btn').on('click', function (e) {
           e.preventDefault();
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                url: "{{ route('add.accusedRelation') }}",
                method: 'POST',
                data: {
                    rName: $('#rName').val(),
                    rFatherName: $('#rFatherName').val(),
                    rAddress: $('#rAddress').val(),
                    rMobile: $('#rMobile').val(),
                    rRelation: $('#rRelation').val(),
                    accused_id: $('#id').val()
                },
                success: function(result){
                    console.log(result);
                    $('#add-accused-form').submit();

                    //window.location.reload();
                },
                error: function(data) {
                    console.log(data);
                },

            });

        });

        $('.remove-relitive').on('click',function (e) {
            var id = $(this).data('relid');
            e.preventDefault();
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                url: "{{ route('remove.accusedRelation') }}",
                method: 'POST',
                data: {
                    id: id,
                },
                success: function(result){
                    console.log(result);
                    $('#add-accused-form').submit();

                    //window.location.reload();
                },
                error: function(data) {
                    console.log(data);
                },

            });

        });

        $('#add-gang-btn').on('click', function (e) {
            e.preventDefault();
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                url: "{{ route('add.accusedToGang') }}",
                method: 'POST',
                data: {
                    gangId: $('#gang').val(),
                    criminalId: $('#id').val()
                },
                success: function(result){
                    console.log(result);
                    $('#add-accused-form').submit();

                    //window.location.reload();
                },
                error: function(data) {
                    console.log(data);
                },

            });

        });

        $('.remove-gang').on('click', function (e) {
            e.preventDefault();
            id = $(this).data('gangid');
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                url: "{{ route('remove.accusedToGang') }}",
                method: 'POST',
                data: {
                    id: id,
                },
                success: function(result){
                    console.log(result);
                    $('#add-accused-form').submit();

                    //window.location.reload();
                },
                error: function(data) {
                    console.log(data);
                },

            });

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
    </script>
@endpush