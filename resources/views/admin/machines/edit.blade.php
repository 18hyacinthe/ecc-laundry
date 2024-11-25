@extends('admin.dashboard.page')
@section('content')
    <!-- Begin Page Content -->
    <div class="container-fluid">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">{{__('Modifier la machine')}}</h6>
            </div>
            <div class="card-body">
                <form method="post" class="needs-validation" novalidate="" action="{{route('admin.machines.update', $machine->id)}}" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="name">{{__('Nom')}}</label>
                            <input type="text" name="name" class="form-control" id="name" value="{{ $machine->name }}" required>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="type">{{__('Type')}}</label>
                            <select name="type" class="form-control" id="type" required>
                                <option value="washing-machine" {{ $machine->type == 'washing-machine' ? 'selected' : '' }}>{{__('Machine à laver')}}</option>
                                <option value="dryer" {{ $machine->type == 'dryer' ? 'selected' : '' }}>{{__('Sèche-linge')}}</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="status">{{__('Statut')}}</label>
                            <select id="status" name="status" class="form-control" required>
                                <option value="reserved" {{ $machine->status == 'reserved' ? 'selected' : '' }}>{{__('Reservé')}}</option>
                                <option value="in-use" {{ $machine->status == 'in-use' ? 'selected' : '' }}>{{__('En cours d\'utilisation')}}</option>
                                <option value="available" {{ $machine->status == 'available' ? 'selected' : '' }}>{{__('Disponible')}}</option>
                                <option value="under maintenance" {{ $machine->status == 'under maintenance' ? 'selected' : '' }}>{{__('En maintenance')}}</option>
                                <option value="out of order" {{ $machine->status == 'out of order' ? 'selected' : '' }}>{{__('Hors service')}}</option>
                            </select>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="color">{{__('Couleur')}}</label>
                            <input type="color" name="color" class="form-control text-center" id="color" value="{{ $machine->color }}" required>
                        </div>
                    </div>
                    <div class="form-group text-right">
                        <button type="submit" class="btn btn-primary">{{__('Mettre à jour')}}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- /.container-fluid -->
@endsection
