@extends('layouts.app')
@section('content')
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Search Accused</div>

                    <div class="card-body">
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif

                            <form action="{{route('search.accused')}}" method="POST" id="accused-form" enctype="multipart/form-data">
                                @csrf
                                <div class="row">
                                    <div class="col">
                                        <input type="text" class="form-control" placeholder="Accused Name" id="Name" name="Name" value="">
                                    </div>
                                    <div class="col">
                                        <input type="text" class="form-control" placeholder="Father Name" id="Accused_FName" name="Accused_FName" value="">
                                    </div>
                                    <div class="col">
                                        <select id="Status" class="form-control" name="Status">
                                            <option value="">Select Status</option>
                                            <option value="Bailed">Bailed</option>
                                            <option value="Jailed">Jailed</option>
                                            <option value="Absconder">Absconder</option>
                                        </select>
                                    </div>
                                    <div class="col">
                                        <button type="submit" class="btn btn-primary" >Search</button>
                                    </div>
                                </div>

                                <div class="mt-2 mb2">
                                    <a class="btn btn-primary" data-toggle="collapse" href="#collapseExample" role="button" aria-expanded="false" aria-controls="collapseExample">Advance Search
                                    </a>
                                </div>
                                  <div class="collapse mt-2" id="collapseExample">
                                    <div class="card card-body">

                                        <div class="form-row">
                                            <div class="form-group col-md-2">
                                                <label for="Built">Built</label>
                                                <select id="Built" class="form-control" name="Built">
                                                    <option value="">Select Built</option>
                                                    <option value="Build">Build</option>
                                                    <option value="Plump">Plump</option>
                                                    <option value="Stocky">Stocky</option>
                                                    <option value="Overweight">Overweight</option>
                                                    <option value="Fat">Fat</option>
                                                    <option value="Slim">Slim</option>
                                                    <option value="Trim">Trim</option>
                                                    <option value="Skinny">Skinny</option>
                                                    <option value="Buff">Buff</option>
                                                    <option value="Well Built">Well Built</option>
                                                </select>
                                            </div>
                                            <div class="form-group col-md-1 offset-1">
                                                <label for="Height-Min">Height</label>
                                                <input type="text" class="form-control" id="Height_Min" name="Height_Min" value="" placeholder="Min">
                                            </div>
                                            <span style="margin-top: 35px"> To </span>
                                            <div class="form-group col-md-1">

                                                <input style="margin-top: 30px" type="text" class="form-control" id="Height_Max" name="Height_Max" value="" placeholder="Max">
                                            </div>

                                            <div class="form-group col-md-1 offset-1">
                                                <label for="Height-Min">Weight</label>
                                                <input type="text" class="form-control" id="Weight_Min" name="Weight_Min" value="" placeholder="Min">
                                            </div>
                                            <span style="margin-top: 35px"> To </span>
                                            <div class="form-group col-md-1">

                                                <input style="margin-top: 30px" type="text" class="form-control" id="Weight_Max" name="Weight_Max" value="" placeholder="Max">
                                            </div>

                                            <div class="form-group col-md-2 offset-1">
                                                <label for="Skin_Color">Skin Color</label>
                                                <select id="Skin_Color" class="form-control" name="Skin_Color">
                                                    <option value="">Select Skin Color</option>
                                                    <option value="Dark">Dark</option>
                                                    <option value="Light">Light</option>
                                                    <option value="Fair">Fair</option>
                                                    <option value="Olive">Olive</option>
                                                    <option value="Pale">Pale</option>
                                                    <option value="Tan">Tan</option>
                                                    <option value="Pimply">Pimply</option>
                                                    <option value="Freckles">Freckles</option>
                                                    <option value="Spots">Spots</option>
                                                    <option value="Pimples">Pimples</option>
                                                    <option value="Wheat">Wheat</option>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="form-row">
                                            <div class="form-group col-md-3">
                                                <label for="MO_Type">Modus</label>
                                                <select id="MO_Type" class="form-control" name="MO_Type">
                                                    <option value="">Select Modus</option>
                                                    @if(isset($moduses))
                                                        @foreach($moduses AS $modus)
                                                            <option value="{{$modus->ID}}">{{$modus->Modus}}</option>
                                                            @endforeach
                                                        @endif
                                                </select>
                                            </div>

                                            <div class="form-group col-md-3">
                                                <label for="PropCatID">Property</label>
                                                <select id="PropCatID" class="form-control" name="PropCatID">
                                                    <option value="">Select Property</option>
                                                    @if(isset($categories))
                                                        @foreach($categories AS $category)
                                                            <option value="{{$category->ID}}">{{$category->Category}}</option>
                                                        @endforeach
                                                    @endif
                                                </select>
                                            </div>
                                            <div class="form-group col-md-3">
                                                <label for="MobileNo">Mobile No</label>
                                                <input type="text" class="form-control" id="MobileNo" name="MobileNo" value="" placeholder="Mobile Number">
                                            </div>

                                            <div class="form-group col-md-3">
                                                <label for="Address1">Address</label>
                                                <input type="text" class="form-control" id="Address1" name="Address1" value="" placeholder="Address">
                                            </div>

                                        </div>
                                        <div class="form-row">
                                            <div class="form-group col-md-3">
                                                <label for="PS">Police Station</label>
                                                <select id="PS" class="form-control" name="PS">
                                                    <option value="">Select Police Station</option>
                                                    @if(isset($psnames))
                                                        @foreach($psnames AS $psname)
                                                            <option value="{{$psname->PSName}}">{{$psname->PSName}}</option>
                                                        @endforeach
                                                    @endif
                                                </select>
                                            </div>
                                            <div class="form-group col-md-3">
                                                <label for="Year">Case Year</label>
                                                <input type="text" class="form-control" id="Year" name="Year" value="" placeholder="Case Year">
                                            </div>

                                            <div class="form-group col-md-3">
                                                <label for="CaseNo">Case No</label>
                                                <input type="text" class="form-control" id="CaseNo" name="CaseNo" value="" placeholder="Case No">
                                            </div>

                                            <div class="form-group col-md-3">
                                                <label for="Gang_ID">Gang</label>
                                                <select id="Gang_ID" class="form-control" name="Gang_ID">
                                                    <option value="">Select Gang</option>
                                                    @if(isset($gangs))
                                                        @foreach($gangs AS $gang)
                                                            <option value="{{$gang->ID}}">{{$gang->Name}}</option>
                                                        @endforeach
                                                    @endif
                                                </select>
                                            </div>


                                            <div class="form-group col-md-3">
                                                <label for="Associate">Associate</label>
                                                <input type="text" class="form-control" id="Associate" name="Associate" value="" placeholder="Associate">
                                            </div>


                                        </div>
                                    </div>
                                </div>
                            </form>

                        <br>
                        @if(isset($accuseds))

                                <table class="table" id="accused-tbl">
                                    <thead>
                                    <tr>
                                        <th scope="col">Accused ID</th>
                                        <th scope="col">Accused Name</th>
                                        <th scope="col">Accused Father's Name</th>
                                        <th scope="col">Address</th>
                                        <th scope="col">Status</th>
                                        <th scope="col">Case Detail</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($accuseds AS $accused)
                                        <tr>
                                            <td>{{$accused->AccusedID}}</td>
                                            <td>{{$accused->Name.' '.$accused->Short_Name}}</td>
                                            <td>{{$accused->Accused_FName}}</td>
                                            <td>{{$accused->Address1.' , '.$accused->Address2.' , '.$accused->Address3.' , '.$accused->Police_Station.' , '.$accused->State}}</td>
                                            <td>{{$accused->Status}}</td>
                                            <td>{{$accused->PS.' Case No.'.$accused->CaseNo.'/'.$accused->Year.', '.$accused->Modus}}</td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                        @endif

                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal -->
@endsection

@push('js')

    <script>
        $('#accused-tbl').DataTable();

        $(document).ready(function () {

        });
    </script>
@endpush