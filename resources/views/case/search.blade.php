@extends('layouts.app')
@section('content')
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Search Case</div>

                    <div class="card-body">
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif

                        <form action="{{route('search.case')}}" method="POST" id="case-form" enctype="multipart/form-data">
                            @csrf
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
                                <div class="form-group col-md-4">
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


                                <div class="form-group col-md-2" style="margin-top: 32px">
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
                                        <div class="form-group col-md-3">
                                            <label for="Status">Status</label>
                                            <select class="form-control" id="Status" name="Status">
                                                <option value="">Select Status</option>
                                                <option value="PI">PI</option>
                                                <option value="CS">CS</option>
                                                <option value="CS PI">CS PI</option>
                                                <option value="FRT(N C)">FRT(N C)</option>
                                                <option value="FR False">FR False</option>
                                                <option value="FRT">FRT</option>
                                                <option value="MF">MF</option>
                                                <option value="MOL">MOL</option>
                                                <option value="FR(R)">FR(R)</option>
                                                <option value="FR(I.E)">FR(I.E)</option>
                                                <option value="NOT CS">NOT CS</option>
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
                                            <label for="Sections">Section</label>
                                            <input type="text" class="form-control" id="Sections" name="Sections" value="" placeholder="Section">
                                        </div>

                                        <div class="form-group col-md-3">
                                            <label for="Place">Place Of Occurrence</label>
                                            <input type="text" class="form-control" id="Place" name="Place" value="" placeholder="Place">
                                        </div>


                                        <div class="form-group col-md-3">
                                            <label for="Date_Start">Date Of Occurrence</label>
                                            <input type="date" class="form-control" id="Date_Start" name="Date_Start" value="">
                                        </div>
                                        <span style="margin-top: 35px"> To </span>
                                        <div class="form-group col-md-3">

                                            <input style="margin-top: 30px" type="date" class="form-control" id="Date_End" name="Date_End" value="" placeholder="Max">
                                        </div>

                                        <div class="form-group col-md-5">
                                            <label for="Complainant_Name">Complainant</label>
                                            <input type="text" class="form-control" id="Complainant_Name" name="Complainant_Name" value="" placeholder="Complainant Name">
                                        </div>



                                    </div>
                                    <div class="form-row">
                                        <div class="form-group col-md-3">
                                            <label for="Time_Start">Time</label>
                                            <input type="time" class="form-control" id="Time_Start" name="Time_Start" value="">
                                        </div>
                                        <span style="margin-top: 35px"> To </span>
                                        <div class="form-group col-md-3">

                                            <input style="margin-top: 30px" type="time" class="form-control" id="Time_End" name="Time_End" value="" placeholder="">
                                        </div>

                                        <div class="form-group col-md-5">
                                            <label for="Accused">Accused</label>
                                            <input type="text" class="form-control" id="Accused" name="Accused" value="" placeholder="Accused">
                                        </div>

                                    </div>
                                    <div class="form-row">
                                        <div class="form-group col-md-3">
                                            <label for="reporting_date_start">Reporting Date</label>
                                            <input type="date" class="form-control" id="reporting_date_start" name="reporting_date_start" value="">
                                        </div>
                                        <span style="margin-top: 35px"> To </span>
                                        <div class="form-group col-md-3">

                                            <input style="margin-top: 30px" type="date" class="form-control" id="reporting_date_end" name="reporting_date_end" value="" placeholder="">
                                        </div>

                                        <div class="form-group col-md-5">
                                            <label for="CaseNo">Case No</label>
                                            <input type="text" class="form-control" id="CaseNo" name="CaseNo" value="" placeholder="CaseNo">
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </form>

                        <br>
                        @if(isset($cases))

                            <table class="table" id="accused-tbl">
                                <thead>
                                <tr>
                                    <th scope="col">Crime ID</th>
                                    <th scope="col">Case ID</th>
                                    <th scope="col">Police Station</th>
                                    <th scope="col">Year</th>
                                    <th scope="col">Criminal Name</th>
                                    <th scope="col">Criminal Father Name</th>
                                    <th scope="col">Aadhar No</th>
                                    <th scope="col">Address</th>

                                </tr>
                                </thead>
                                <tbody>
                                @foreach($cases AS $case)
                                    <tr>
                                        <td>{{$case->CrimeID}}</td>
                                        <td>{{$case->CaseNo}}</td>
                                        <td>{{$case->PS}}</td>
                                        <td>{{$case->Year}}</td>
                                        <td>{{$case->Name}}</td>
                                        <td>{{$case->Accused_FName}}</td>
                                        <td>{{$case->aadhar_no}}</td>
                                        <td>{{$case->Address1}}</td>

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