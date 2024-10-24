@extends('frontend.dashboard.page')
@section('content')
    <!-- Begin Page Content -->
    <div class="container-fluid">
            <div class="card-body">
                <div class="table-responsive">

                    <div class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <div class="card">
                            <form method="post" class="needs-validation" novalidate="" action="{{route('user.profile.update')}}" enctype="multipart/form-data">
                                @csrf
                                <div class="card-header m-0 font-weight-bold text-primary">
                                    <h4>{{__('Update Profile')}}</h4>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="form-group col-12">
                                            <div class="mb-3">
                                                <img alt="image" src="{{ Auth::user()->image ? asset(Auth::user()->image) : asset('img/undraw_profile.svg') }}" class="rounded-circle" width="100px" height="100px">
                                            </div>
                                            <label>{{__('Image')}}</label>
                                            <input type="file" name="image" class="form-control">
                                        </div>
                                    </div>
                                </div>
                                <div class="card-footer text-right">
                                    <button class="btn btn-primary">{{__('Save Changes')}}</button>
                                </div>
                            </form>
                        </div>
                    </div>
        
                </div>
            </div>
    </div>
    <!-- /.container-fluid -->
@endsection
