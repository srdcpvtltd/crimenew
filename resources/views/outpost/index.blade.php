@extends('layouts.app')
@section('content')
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Add Outpost</div>

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
                        <form action="{{route('outpost.add')}}" id="add-outpost-form" method="POST" enctype="multipart/form-data">

                            @csrf
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label for="PSName">Outpost Name</label>
                                    <input type="text" class="form-control" id="outpost_name" name="outpost_name" placeholder="Outpost Name" value="" required>
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="PSID">Police Station</label>
                                    <select id="PSID" name="PSID" class="form-control" required>
                                        <option value="">Select Police Station</option>
                                        @if(isset($policeStations))
                                            @foreach($policeStations AS $policeStation)
                                                <option value="{{$policeStation->ID}}">{{$policeStation->PSName}}</option>
                                            @endforeach
                                        @endif
                                    </select>
                                </div>

                                <div class="form-group col-md-2">
                                    <button type="submit" class="btn btn-primary" id="ps-add-btn">Add</button>
                                </div>

                            </div>

                        </form>

                        <br>
                        @if(isset($records[0]))

                            <div class="col-md-12">
                                <table width="100%" class="table" id="dt-tbl">
                                    <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Police Station</th>
                                        <th>Outpost Name</th>
                                        <th>Action</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($records AS $record)
                                        <tr>
                                            <td>{{$record->ID}}</td>
                                            <td>{{$record->PSName}}</td>
                                            <td>{{$record->outpost_name}}</td>
                                            <td>
                                                <a href="javascript:void(0);" class="btn btn-sm btn-primary" data-id="{{$record->ID}}" data-name="{{$record->outpost_name}}" data-psid="{{$record->PSID}}" data-toggle="modal" data-target="#editModal">Edit</a>
                                                <a href="javascript:void(0);" class="btn btn-sm btn-danger del-btn"  data-id="{{$record->ID}}">Delete</a>
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
                <form action="{{route('outpost.edit')}}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="id" id="id" value="">
                    <div class="modal-body">
                        <div class="form-row">
                            <div class="form-group col-md-12">
                                <label for="status_name">Status</label>
                                <input type="text" class="form-control" id="name" name="name" value="" required>
                            </div>
                            <div class="form-group col-md-12">
                                <label for="PSID">Police Station</label>
                                <select id="PSIDEdit" name="PSIDEdit" class="form-control" required>
                                    <option value="">Select Police Station</option>
                                    @if(isset($policeStations))
                                        @foreach($policeStations AS $policeStation)
                                            <option value="{{$policeStation->ID}}">{{$policeStation->PSName}}</option>
                                        @endforeach
                                    @endif
                                </select>
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
            $('#dt-tbl').DataTable({
                responsive: true
            });
            $('#editModal').on('show.bs.modal', function (event) {
                var button = $(event.relatedTarget) // Button that triggered the modal
                var id = button.data('id');
                var name = button.data('name');
                var psid = button.data('psid');// Extract info from data-* attributes
                // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
                // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
                var modal = $(this)
                modal.find('#id').val(id);
                modal.find('#name').val(name);
                modal.find('#PSIDEdit').val(psid).change();
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
                        url: "{{ route('outpost.destroy') }}",
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