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
                        <form action="{{route('r110.add')}}" id="add-r110-form" method="POST" enctype="multipart/form-data">

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
                                    <label for="PS">Police Station</label>
                                    <select id="PS" name="PS" class="form-control" required>
                                        <option value="">Select Police Station</option>
                                        @if(isset($policeStations))
                                            @foreach($policeStations AS $policeStation)
                                                <option value="{{$policeStation->PSName}}">{{$policeStation->PSName}}</option>
                                            @endforeach
                                        @endif
                                    </select>
                                </div>

                                <div class="form-group col-md-3">
                                    <label for="cmc_no">CMC No</label>
                                    <input type="text" class="form-control" id="cmc_no" name="cmc_no" placeholder="CMC No" value="" required>
                                </div>

                                <div class="form-group col-md-3">
                                    <label for="non_fir_no">Non FIR No</label>
                                    <input type="text" class="form-control" id="non_fir_no" name="non_fir_no" placeholder="Non FIR NO" value="" required>
                                </div>


                                <div class="form-group col-md-3">
                                    <label for="date_of_release">Date of Release</label>
                                    <input type="date" class="form-control" id="date_of_release" name="date_of_release" placeholder="Date of Release" value="" required>
                                </div>
                                <div class="form-group col-md-3">
                                    <label for="status">Status</label>
                                    <select id="status" name="status" class="form-control">
                                        <option value="">Select Status</option>
                                        <option value="Jailed">Jailed</option>
                                        <option value="Bailed">Bailed</option>
                                        <option value="Present">Present</option>
                                        <option value="Absconder">Absconder</option>
                                    </select>
                                </div>
                                <div class="form-group col-md-3">
                                    <label for="remarks">Remarks</label>
                                    <input type="text" class="form-control" id="remarks" name="remarks" placeholder="" value="" required>
                                </div>



                            </div>
                            <button type="submit" class="btn btn-primary" id="r110-add-btn">Add</button>
                        </form>

                        <br>
                        @if(isset($records[0]))

                            <div class="col-md-12">
                                <table width="100%" class="table table-responsive " id="r110-tbl">
                                    <thead>
                                    <tr>
                                        <th>Criminal ID</th>
                                        <th>Accused Name</th>
                                        <th>Short Name</th>
                                        <th>Father Name</th>
                                        <th>Address</th>
                                        <th>Police Station</th>
                                        <th>CMC No.</th>
                                        <th>Non FIR No.</th>
                                        <th>Date of Release</th>
                                        <th>Status</th>
                                        <th>Remarks</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($records AS $record)
                                        <tr>
                                            <td>{{$record->Criminal}}</td>
                                            <td>{{$record->Accused_Name}}</td>
                                            <td>{{$record->Short_Name}}</td>
                                            <td>{{$record->Accused_FName}}</td>
                                            <td>{{$record->address}}</td>
                                            <td>{{$record->PS}}</td>
                                            <td>{{$record->cmc_no}}</td>
                                            <td>{{$record->non_fir_no}}</td>
                                            <td>{{$record->date_of_release}}</td>
                                            <td>{{$record->status}}</td>
                                            <td>{{$record->remarks}}</td>
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
            $('#r110-tbl').DataTable({
                responsive: true
            });
            $('#Criminal').select2();

            $('#Criminal').on('change', function(){
                var id = $(this).val();
                 $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                url: "{{ route('get.crimial110') }}",
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