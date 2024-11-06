@extends('admin.dashboard.page')
@section('content')
    <!-- Begin Page Content -->
    <div class="container-fluid">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">{{__('Ajouter une nouvelle machine')}}</h6>
            </div>
            <div class="card-body">
                <form method="post" class="needs-validation" novalidate="" action="{{route('admin.machines.store')}}" enctype="multipart/form-data">
                    @csrf
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="name">{{__('Nom')}}</label>
                            <input type="text" name="name" class="form-control" id="name" required>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="type">{{__('Type')}}</label>
                            <select name="type" class="form-control" id="type" required>
                                <option value="washing-machine">{{__('Machine à laver')}}</option>
                                <option value="dryer">{{__('Sèche-linge')}}</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="status">{{__('Statut')}}</label>
                            <select id="status" name="status" class="form-control" required>
                                <option value="" disabled selected>{{__('Sélectionner le statut')}}</option>
                                <option value="reserved" {{ old('status') == 'reserved' ? 'selected' : '' }}>{{__('Reservé')}}</option>
                                <option value="in-use" {{ old('status') == 'in-use' ? 'selected' : '' }}>{{__('En cours d\'utilisation')}}</option>
                                <option value="available" {{ old('status') == 'available' ? 'selected' : '' }}>{{__('Disponible')}}</option>
                                <option value="under maintenance" {{ old('status') == 'under maintenance' ? 'selected' : '' }}>{{__('En maintenance')}}</option>
                                <option value="out of order" {{ old('status') == 'out of order' ? 'selected' : '' }}>{{__('Hors service')}}</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group text-right">
                        <button type="submit" class="btn btn-primary">{{__('Créer')}}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- /.container-fluid -->
@endsection
