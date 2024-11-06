@extends('admin.dashboard.page')
@section('content')
    <!-- Begin Page Content -->
    <div class="container-fluid">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">{{__('Mettre à jour le profil')}}</h6>
            </div>
            <div class="card-body">
                <form method="post" class="needs-validation" novalidate="" action="{{route('admin.profile.update')}}" enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <div class="col-md-4 text-center">
                            <div class="mb-3">
                                <img alt="image" src="{{ Auth::user()->image ? asset(Auth::user()->image) : asset('img/undraw_profile.svg') }}" class="rounded-circle img-thumbnail" width="150px" height="150px">
                            </div>
                            <div class="form-group">
                                <label>{{__('Image')}}</label>
                                <input type="file" name="image" class="form-control">
                            </div>
                        </div>
                        <div class="col-md-8">
                            <div class="form-group">
                                <label>{{__('Nom')}}</label>
                                <input type="text" name="name" class="form-control" value="{{Auth::user()->name}}">
                            </div>
                            <div class="form-group">
                                <label>{{__('Prénom')}}</label>
                                <input type="text" name="surname" class="form-control" value="{{Auth::user()->surname}}">
                            </div>
                            <div class="form-group">
                                <label>{{__('Email')}}</label>
                                <input type="email" name="email" class="form-control" value="{{Auth::user()->email}}">
                            </div>
                            <div class="form-group">
                                <label>{{__('Numéro de téléphone')}}</label>
                                <input type="text" name="phone" class="form-control" value="{{Auth::user()->phone}}">
                            </div>
                        </div>
                    </div>
                    <div class="text-right">
                        <button class="btn btn-primary">{{__('Enregistrer les modifications')}}</button>
                    </div>
                </form>
            </div>
        </div>

        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">{{__('Mettre à jour le mot de passe')}}</h6>
            </div>
            <div class="card-body">
                <form method="post" class="needs-validation" novalidate="" action="{{route('admin.profile.update.password')}}">
                    @csrf
                    <div class="form-group">
                        <label>{{__('Mot de passe actuel')}}</label>
                        <input type="password" name="current_password" class="form-control">
                    </div>
                    <div class="form-group">
                        <label>{{__('Nouveau mot de passe')}}</label>
                        <input type="password" name="password" class="form-control">
                    </div>
                    <div class="form-group">
                        <label>{{__('Confirmer le mot de passe')}}</label>
                        <input type="password" name="password_confirmation" class="form-control">
                    </div>
                    <div class="text-right">
                        <button class="btn btn-primary">{{__('Enregistrer les modifications')}}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- /.container-fluid -->
@endsection
