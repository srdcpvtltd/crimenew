@extends('layouts.app')
@section('content')
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Add Police Station</div>

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
                        <form action="{{route('register.user')}}" id="add-hazira-form" method="POST" enctype="multipart/form-data">

                            @csrf

                            <div class="form-group col-md-12">
                                <label for="PSName">UserName</label>
                                <input type="text" class="form-control" id="UserName" name="UserName" placeholder="UserName" value="" required>
                            </div>
                            <div class="form-group col-md-12">
                                <label for="password">Password</label>
                                <input type="password" class="form-control" id="password" name="password" placeholder="Password" value="" required>
                            </div>
                             <div class="form-group col-md-2">
                                <button type="submit" class="btn btn-primary" id="ps-add-btn">Add</button>
                             </div>

                        </form>

                        <br>
                    
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

@push('js')

    <script>
     

    </script>
@endpush