@extends('admin.dashboard.page')
@section('content')
    <!-- Begin Page Content -->
    <div class="container-fluid">
        <div class="card-body">
            <div class="table-responsive">
                <div class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <div class="card">
                        <form method="post" class="needs-validation" novalidate="" action="{{route('admin.machines.store')}}" enctype="multipart/form-data">
                            @csrf
                            <div class="card-header m-0 font-weight-bold text-primary">
                                <h4>{{__('Add New Machine')}}</h4>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="form-group col-md-6 col-12">
                                        <label>{{__('Name')}}</label>
                                        <input type="text" name="name" class="form-control" required>
                                    </div>
                                    <div class="form-group col-md-6 col-12">
                                        <label>{{__('Type')}}</label>
                                        <select name="type" class="form-control" required>
                                            <option value="washing-machine">{{__('Washing Machine')}}</option>
                                            <option value="dryer">{{__('Dryer')}}</option>
                                        </select>
                                    </div>
                                    <div class="form-group col-md-6 col-12">
                                        <label>{{__('Status')}}</label>
                                        <select id="inputState" name="status" class="form-control" required>
                                            <option value="" disabled selected>{{__('Select Status')}}</option>
                                            <option value="pending" {{ old('status') == 'pending' ? 'selected' : '' }}>{{__('Pending')}}</option>
                                            <option value="in-use" {{ old('status') == 'in-use' ? 'selected' : '' }}>{{__('In Use')}}</option>
                                            <option value="available" {{ old('status') == 'available' ? 'selected' : '' }}>{{__('Available')}}</option>
                                            <option value="under maintenance" {{ old('status') == 'under maintenance' ? 'selected' : '' }}>{{__('Under Maintenance')}}</option>
                                            <option value="out of order" {{ old('status') == 'out of order' ? 'selected' : '' }}>{{__('Out of Order')}}</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer text-right">
                                <button class="btn btn-primary">{{__('Create')}}</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- /.container-fluid -->
@endsection
