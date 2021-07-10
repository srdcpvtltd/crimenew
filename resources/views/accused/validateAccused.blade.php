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

                            <form action="javascript:void(0);" id="validate-accused-form" method="POST" enctype="multipart/form-data">
                                @csrf
                                <div class="form-row">
                                    <div class="form-group col-md-6">
                                        <label for="name">Name</label>
                                        <input type="text" class="form-control" id="name" name="name" placeholder="Name">
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="shortName">Short Name</label>
                                        <input type="text" class="form-control" id="shortName" name="shortName" placeholder="Short Name">
                                    </div>
                                </div>
                                <div class="form-row">

                                <div class="form-group col-md-6">
                                    <label for="fatherName">Father Name</label>
                                    <input type="text" class="form-control" id="fatherName" name="fatherName" placeholder="Father Name">
                                </div>
                                   {{-- <div class="form-group col-md-3">
                                        <label for="cast">Cast</label>
                                        <select id="cast" name="cast" class="form-control">
                                            <option value="">Select Cast</option>
                                            <option value="ST">ST</option>
                                            <option value="SC">SC</option>
                                            <option value="SEBC">SEBC</option>
                                            <option value="UR">UR</option>
                                        </select>
                                    </div>--}}
                                    <div class="form-group col-md-6">
                                        <label for="gender">Gender</label>
                                        <select id="gender" name="gender" class="form-control">
                                            <option value="">Select Gender</option>
                                            <option value="Male">Male</option>
                                            <option value="Female">Female</option>
                                            <option value="Other">Other</option>
                                        </select>
                                    </div>

                                </div>
                                <button type="button" class="btn btn-primary" id="accused-validate-btn">Add</button>
                            </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('js')

    <script>
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
                    if(result.type){
                        window.location.href = '{{url('')}}'+'/accused/'+result.id+'/edit';
                        /*$('#validate-accused-form').attr('action','{{route('add.accused.form')}}');
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
                        })*/
                    }
                    /*if(result.type == "edit"){
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
                    }*/
                },
                error: function(data) {
                    console.log(data);
                },

            });
        });
    </script>
@endpush