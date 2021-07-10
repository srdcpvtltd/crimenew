@extends('layouts.app')
@section('content')
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Add Advocate</div>

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

                            <form action="{{route('advocate.add')}}" id="add-advocate-form" method="POST" enctype="multipart/form-data">

                            @csrf
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label for="name">Advocate Name</label>
                                    <input type="text" class="form-control" id="aName" name="aName" placeholder="Advocate Name" value="" required>
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="shortName">Adovate Father Name</label>
                                    <input type="text" class="form-control" id="aFatherName" name="aFatherName" placeholder="Advocate Father Name" value="" required>
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="name">Address</label>
                                    <input type="text" class="form-control" id="address" name="address" placeholder="Address" value="" required>
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="shortName">Mobile No.</label>
                                    <input type="text" class="form-control" id="mobile" name="mobile" placeholder="Mobile No." value="" required>
                                </div>
                            </div>
                            <button type="submit" class="btn btn-primary" id="advocate-add-btn">Add</button>
                        </form>

                        <br>
                        @if(isset($advocates[0]))

                            <div class="col-md-12">
                                <table width="100%" class="table" id="advocate-tbl">
                                    <thead>
                                    <tr>
                                        <th>Name</th>
                                        <th>Father Name</th>
                                        <th>Address</th>
                                        <th>Mobile No.</th>
                                        <th>Action</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($advocates AS $advocate)
                                        <tr>
                                            <td>{{$advocate->AdvName}}</td>
                                            <td>{{$advocate->AdvF_Name}}</td>
                                            <td>{{$advocate->Address}}</td>
                                            <td>{{$advocate->MobileNo}}</td>
                                            <td>
                                                <a href="javascript:void(0);" class="btn btn-sm btn-primary" data-id="{{$advocate->ID}}" data-name="{{$advocate->AdvName}}" data-father="{{$advocate->AdvF_Name}}" data-address="{{$advocate->Address}}" data-mobile="{{$advocate->MobileNo}}" data-toggle="modal" data-target="#editModal">Edit</a>
                                                <a href="javascript:void(0);" class="btn btn-sm btn-danger del-btn"  data-id="{{$advocate->ID}}">Delete</a>
                                            </td>

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

    <div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="editModalTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editModalTitle">Edit</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{route('advocate.edit')}}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="id" id="id" value="">
                    <div class="modal-body">
                        <div class="form-row">
                            <div class="form-group col-md-12">
                                <label for="status_name">Name</label>
                                <input type="text" class="form-control" id="name" name="name" value="" required>
                            </div>
                            <div class="form-group col-md-12">
                                <label for="status_name">Father Name</label>
                                <input type="text" class="form-control" id="fatherName" name="fatherName" value="" required>
                            </div>
                            <div class="form-group col-md-12">
                                <label for="status_name">Address</label>
                                <input type="text" class="form-control" id="eAddress" name="eAddress" value="" required>
                            </div>
                            <div class="form-group col-md-12">
                                <label for="status_name">Mobile No</label>
                                <input type="text" class="form-control" id="eMobileNo" name="eMobileNo" value="" required>
                            </div>
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Update</button>
                    </div>
                </form>
            </div>
        </div>
    </div>


@endsection

@push('js')

    <script>
        $(document).ready(function () {
            $('#advocate-tbl').DataTable();
            $('#editModal').on('show.bs.modal', function (event) {
                var button = $(event.relatedTarget) // Button that triggered the modal
                var id = button.data('id');
                var name = button.data('name');
                var fatherName = button.data('father');
                var address = button.data('address');
                var mobileNo = button.data('mobile');


                var modal = $(this)
                modal.find('#id').val(id);
                modal.find('#name').val(name);
                modal.find('#fatherName').val(fatherName);
                modal.find('#eAddress').val(address);
                modal.find('#eMobileNo').val(mobileNo);
            })
        });

        $('.del-btn').on('click', function (e) {
            e.preventDefault();
            var id = $(this).data('id');
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: "{{ route('advocate.destroy') }}",
                        method: 'POST',
                        data: {
                            id: id,
                        },
                        success: function(result){
                            console.log(result);
                            if(result.type){
                                Swal.fire(
                                    'Deleted!',
                                    'Record Deleted Successfully.',
                                    'success'
                                );
                                window.location.reload();
                            }
                        }
                    });
                }
            });
        });
    </script>
@endpush