@extends('layouts.app')
@section('content')
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Add 110</div>

                    <div class="card-body">
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif
                        @if(session()->has('success'))
                            <div class="alert alert-success">
                                {{ session()->get('success') }}
                            </div>
                        @endif
                        <form action="{{route('hazira.add')}}" id="add-hazira-form" method="POST" enctype="multipart/form-data">

                            @csrf
                            <div class="form-row">
                                <div class="form-group col-md-3">
                                    <label for="Criminal">Criminal</label>
                                    <select id="Criminal" name="Criminal" class="form-control" required>
                                        <option value="">Select Criminal</option>
                                        @if(isset($criminals))
                                            @foreach($criminals AS $criminal)
                                                <option value="{{$criminal->ID}}">{{$criminal->Name .' @ '.$criminal->Short_Name}}</option>
                                            @endforeach
                                        @endif
                                    </select>
                                </div>
                                <div class="form-group col-md-3">
                                    <label for="Forwarding_ps">Forwarding Police Station</label>
                                    <select id="Forwarding_ps" name="Forwarding_ps" class="form-control" required>
                                        <option value="">Select Police Station</option>
                                        @if(isset($policeStations))
                                            @foreach($policeStations AS $policeStation)
                                                <option value="{{$policeStation->PSName}}">{{$policeStation->PSName}}</option>
                                            @endforeach
                                        @endif
                                    </select>
                                </div>


                                <div class="form-group col-md-3">
                                    <label for="Accused_Name">Accused Name</label>
                                    <input type="text" class="form-control" id="Accused_Name" name="Accused_Name" placeholder="Name" value="" required>
                                </div>
                                <div class="form-group col-md-3">
                                    <label for="Short_Name">Short Name</label>
                                    <input type="text" class="form-control" id="Short_Name" name="Short_Name" placeholder="Short Name" value="" required>
                                </div>
                                <div class="form-group col-md-3">
                                    <label for="Accused_FName">Accused Father Name</label>
                                    <input type="text" class="form-control" id="Accused_FName" name="Accused_FName" placeholder="Father Name" value="" required>
                                </div>
                                <div class="form-group col-md-3">
                                    <label for="address">Address</label>
                                    <input type="text" class="form-control" id="address" name="address" placeholder="Address" value="" required>
                                </div>


                                <div class="form-group col-md-3">
                                    <label for="Case_ref">Case Ref</label>
                                    <input type="text" class="form-control" id="Case_ref" name="Case_ref" placeholder="Case Ref" value="" required>
                                </div>

                                <div class="form-group col-md-3">
                                    <label for="Sections">Sections</label>
                                    <input type="text" class="form-control" id="Sections" name="Sections" placeholder="Sections" value="" required>
                                </div>


                                <div class="form-group col-md-3">
                                    <label for="Bail_Condition">Bail Condition</label>
                                    <input type="text" class="form-control" id="Bail_Condition" name="Bail_Condition" placeholder="Date of Release" value="" required>
                                </div>
                                <div class="form-group col-md-3">
                                    <label for="name_of_bailer">Select Name of Bailer</label>
                                    <select id="name_of_bailer" name="name_of_bailer" class="form-control">
                                        <option value="">Select Bailer</option>
                                        @if(isset($bailers))
                                            @foreach($bailers AS $bailer)
                                                <option value="{{$bailer->B_Name}}">{{$bailer->B_Name}}</option>
                                            @endforeach
                                        @endif
                                    </select>
                                    </select>
                                </div>
                                <div class="form-group col-md-3">
                                    <label for="ps_for_hazira">Police Station For Hazira</label>
                                    <select id="ps_for_hazira" name="ps_for_hazira" class="form-control" required>
                                        <option value="">Select Police Station</option>
                                        @if(isset($policeStations))
                                            @foreach($policeStations AS $policeStation)
                                                <option value="{{$policeStation->PSName}}">{{$policeStation->PSName}}</option>
                                            @endforeach
                                        @endif
                                    </select>
                                </div>

                                <div class="form-group col-md-3">
                                    <label for="dof">DOF</label>
                                    <input type="date" class="form-control" id="dof" name="dof" placeholder="" value="" required>
                                </div>

                                <div class="form-group col-md-3">
                                    <label for="dor">DOR</label>
                                    <input type="date" class="form-control" id="dor" name="dor" placeholder="" value="" required>
                                </div>

                                <div class="form-group col-md-3">
                                    <label for="hazira_at_ps">Hazira At PS</label>
                                    <input type="text" class="form-control" id="hazira_at_ps" name="hazira_at_ps" placeholder="" value="" required>
                                </div>


                            </div>
                            <button type="submit" class="btn btn-primary" id="hazira-add-btn">Add</button>
                        </form>

                        <br>
                        @if(isset($records[0]))

                            <div class="col-md-12">
                                <table width="100%" class="table table-responsive " id="hazira-tbl">
                                    <thead>
                                    <tr>
                                        <th>Criminal ID</th>
                                        <th>Forwording PS</th>
                                        <th>Accused Name</th>
                                        <th>Short Name</th>
                                        <th>Father Name</th>
                                        <th>Address</th>
                                        <th>Case Ref</th>
                                        <th>Sections</th>
                                        <th>Bail Condition</th>
                                        <th>Name of Bailer</th>
                                        <th>PS For Hazira</th>
                                        <th>DOF</th>
                                        <th>DOR</th>
                                        <th>Hazira At PS</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($records AS $record)
                                        <tr>
                                            <td>{{$record->Criminal}}</td>
                                            <td>{{$record->Forwarding_ps}}</td>
                                            <td>{{$record->Accused_Name}}</td>
                                            <td>{{$record->Short_Name}}</td>
                                            <td>{{$record->Accused_FName}}</td>
                                            <td>{{$record->address}}</td>
                                            <td>{{$record->Case_ref}}</td>
                                            <td>{{$record->Sections}}</td>
                                            <td>{{$record->Bail_Condition}}</td>
                                            <td>{{$record->name_of_bailer}}</td>
                                            <td>{{$record->ps_for_hazira}}</td>
                                            <td>{{$record->dof}}</td>
                                            <td>{{$record->dor}}</td>
                                            <td>{{$record->hazira_at_ps}}</td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @endif

                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

@push('js')

    <script>
        $(document).ready(function () {
            $('#hazira-tbl').DataTable({
                responsive: true
            });
            $('#Criminal').select2();
            $('#name_of_bailer').select2();

             $('#Criminal').on('change', function(){
                var id = $(this).val();
                 $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                url: "{{ route('get.crimialHazira') }}",
                method: 'POST',
                data: {
                    id: id
                },
                success: function(result){
                    console.log(result);
                    if(result.type){
                        $('#Accused_Name').val(result.data.Name);
                        $('#Short_Name').val(result.data.Short_Name);
                        $('#Accused_FName').val(result.data.Accused_FName);
                        $('#address').val(result.data.Address1)
                    }
                },
                error: function(data) {
                    console.log(data);
                },

            });
            })
        });
    </script>
@endpush