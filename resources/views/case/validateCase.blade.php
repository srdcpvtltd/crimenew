@extends('layouts.app')
@section('content')
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Validate Case</div>

                    <div class="card-body">
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif

                            <form action="javascript:void(0);" id="validate-case-form" method="POST" enctype="multipart/form-data">
                                @csrf
                                <div class="form-group">
                                    <label for="policeStation">Police Station</label>
                                    <select class="form-control" id="policeStation" name="policeStation">
                                      @if(isset($policeStations))
                                          @foreach($policeStations AS $policeStation)
                                              <option value="{{$policeStation->PSName}}">{{$policeStation->PSName}}</option>
                                              @endforeach
                                          @endif
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="CaseNo">Case No</label>
                                    <input type="number" class="form-control" id="caseNo" name="caseNo">
                                </div>
                                <div class="form-group">
                                    <label for="year">Year</label>
                                    <input type="text" class="form-control" id="year" name="year">
                                </div>
                                <button type="button" class="btn btn-primary" id="case-validate-btn">Validate</button>


                            </form>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('js')

    <script>
        $('#case-validate-btn').on('click',function (e) {
            e.preventDefault();
            let form_data = new FormData($('#validate-case-form')[0]);
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                url: "{{ route('validate.case') }}",
                method: 'POST',
                data: form_data,
                processData: false,
                contentType: false,
                success: function(result){
                    console.log(result);
                    if(result.type == "add"){
                        $('#validate-case-form').attr('action','{{route('add.case.form')}}');
                        Swal.fire({
                            title: 'This Case doesn\'t exits.',
                            text: "do you want to make a new entry?",
                            icon: 'warning',
                            showCancelButton: true,
                            confirmButtonColor: '#3085d6',
                            cancelButtonColor: '#d33',
                            confirmButtonText: 'Yes'
                        }).then((result) => {
                            if(result.isConfirmed){
                                $('#validate-case-form').submit();
                            }
                        })
                    }
                    if(result.type == "edit"){
                        $('#validate-case-form').attr('action','{{route('edit.case.form')}}');
                        Swal.fire({
                            title: 'This Case already exits.',
                            text: "do you want to Update",
                            icon: 'warning',
                            showCancelButton: true,
                            confirmButtonColor: '#3085d6',
                            cancelButtonColor: '#d33',
                            confirmButtonText: 'Yes'
                        }).then((result) => {
                            if(result.isConfirmed){
                                $('#validate-case-form').submit();
                            }
                        })
                    }
                },
                error: function(data) {
                    $.LoadingOverlay("hide");
                    console.log(data);
                },

            });
        });
    </script>
    @endpush