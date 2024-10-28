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
                                <h4>{{__('Ajouter une nouvelle machine')}}</h4>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="form-group col-md-6 col-12">
                                        <label>{{__('Nom')}}</label>
                                        <input type="text" name="name" class="form-control" required>
                                    </div>
                                    <div class="form-group col-md-6 col-12">
                                        <label>{{__('Type')}}</label>
                                        <select name="type" class="form-control" required>
                                            <option value="washing-machine">{{__('Machine à laver')}}</option>
                                            <option value="dryer">{{__('Sèche-linge')}}</option>
                                        </select>
                                    </div>
                                    <div class="form-group col-md-6 col-12">
                                        <label>{{__('Statut')}}</label>
                                        <select id="inputState" name="status" class="form-control" required>
                                            <option value="" disabled selected>{{__('Sélectionner le statut')}}</option>
                                            <option value="pending" {{ old('status') == 'pending' ? 'selected' : '' }}>{{__('En attente')}}</option>
                                            <option value="in-use" {{ old('status') == 'in-use' ? 'selected' : '' }}>{{__('En cours d\'utilisation')}}</option>
                                            <option value="available" {{ old('status') == 'available' ? 'selected' : '' }}>{{__('Disponible')}}</option>
                                            <option value="under maintenance" {{ old('status') == 'under maintenance' ? 'selected' : '' }}>{{__('En maintenance')}}</option>
                                            <option value="out of order" {{ old('status') == 'out of order' ? 'selected' : '' }}>{{__('Hors service')}}</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer text-right">
                                <button class="btn btn-primary">{{__('Créer')}}</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- /.container-fluid -->
@endsection
