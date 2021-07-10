@extends('layouts.app')
@section('content')
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Add NBW</div>

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
                        <form action="{{route('nbw.add')}}" id="add-nbw-form" method="POST" enctype="multipart/form-data">

                            @csrf
                            <div class="form-row">
                                <div class="form-group col-md-3">
                                    <label for="criminal_id">Criminal</label>
                                    <select id="criminal_id" name="criminal_id" class="form-control" required>
                                        <option value="">Select Criminal</option>
                                        @if(isset($criminals))
                                            @foreach($criminals AS $criminal)
                                            <option value="{{$criminal->ID}}">{{$criminal->Name .' @ '.$criminal->Short_Name}}</option>
                                            @endforeach
                                            @endif
                                       </select>
                                </div>

                                <div class="form-group col-md-3">
                                    <label for="name">Name</label>
                                    <input type="text" class="form-control" id="Name" name="Name" placeholder="Name" value="" required>
                                </div>
                                <div class="form-group col-md-3">
                                    <label for="Short_Name">Short Name</label>
                                    <input type="text" class="form-control" id="Short_Name" name="Short_Name" placeholder="Short Name" value="" required>
                                </div>
                                <div class="form-group col-md-3">
                                    <label for="Accused_FName">Father Name</label>
                                    <input type="text" class="form-control" id="Accused_FName" name="Accused_FName" placeholder="Father Name" value="" required>
                                </div>
                                <div class="form-group col-md-3">
                                    <label for="Address">Address</label>
                                    <input type="text" class="form-control" id="Address" name="Address" placeholder="Address" value="" required>
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
                                    <label for="Warrant_No">Warrant No</label>
                                    <input type="text" class="form-control" id="Warrant_No" name="Warrant_No" placeholder="Warrant No" value="" required>
                                </div>

                                <div class="form-group col-md-3">
                                    <label for="date_of_issue">Date Of Issue</label>
                                    <input type="date" class="form-control" id="date_of_issue" name="date_of_issue" placeholder="Date Of Issue" value="" required>
                                </div>


                                <div class="form-group col-md-3">
                                    <label for="issuing_court">Issuing Court</label>
                                    <input type="text" class="form-control" id="issuing_court" name="issuing_court" placeholder="Issuing Court" value="" required>
                                </div>
                                <div class="form-group col-md-3">
                                    <label for="Date_of_hearing">Date Of Hearing</label>
                                    <input type="date" class="form-control" id="Date_of_hearing" name="Date_of_hearing" placeholder="Date Of Hearning" value="" required>
                                </div>
                                <div class="form-group col-md-3">
                                    <label for="U_s">U S</label>
                                    <input type="text" class="form-control" id="U_s" name="U_s" placeholder="" value="" required>
                                </div>



                            </div>
                            <button type="submit" class="btn btn-primary" id="nbw-add-btn">Add</button>
                        </form>

                        <br>
                        @if(isset($nbws[0]))

                            <div class="col-md-12">
                                <table width="100%" class="table table-responsive " id="nbw-tbl">
                                    <thead>
                                    <tr>
                                        <th>Criminal ID</th>
                                        <th>Name</th>
                                        <th>Short Name</th>
                                        <th>Father Name</th>
                                        <th>Address</th>
                                        <th>Police Station</th>
                                        <th>Warrant No.</th>
                                        <th>Date of Issue</th>
                                        <th>Issuing Court</th>
                                        <th>Date Of Hearing</th>
                                        <th>US</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($nbws AS $nbw)
                                        <tr>
                                            <td>{{$nbw->criminal_id}}</td>
                                            <td>{{$nbw->Name}}</td>
                                            <td>{{$nbw->Short_Name}}</td>
                                            <td>{{$nbw->Accused_FName}}</td>
                                            <td>{{$nbw->Address}}</td>
                                            <td>{{$nbw->PS}}</td>
                                            <td>{{$nbw->Warrant_No}}</td>
                                            <td>{{$nbw->date_of_issue}}</td>
                                            <td>{{$nbw->issuing_court}}</td>
                                            <td>{{$nbw->Date_of_hearing}}</td>
                                            <td>{{$nbw->U_s}}</td>
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
            $('#nbw-tbl').DataTable({
                responsive: true
            });
            $('#criminal_id').select2();

             $('#criminal_id').on('change', function(){
                var id = $(this).val();
                 $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                url: "{{ route('get.crimialNBW') }}",
                method: 'POST',
                data: {
                    id: id
                },
                success: function(result){
                    console.log(result);
                    if(result.type){
                        $('#Name').val(result.data.Name);
                        $('#Short_Name').val(result.data.Short_Name);
                        $('#Accused_FName').val(result.data.Accused_FName);
                        $('#Address').val(result.data.Address1)
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