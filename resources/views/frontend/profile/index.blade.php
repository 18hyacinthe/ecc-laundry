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
                                    <h4>{{__('Mettre à jour le profil')}}</h4>
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
                                        <div class="form-group col-md-6 col-12">
                                            <label>{{__('Nom')}}</label>
                                            <input type="text" name="name" class="form-control" value="{{Auth::user()->name}}">
                                        </div>
                                        <div class="form-group col-md-6 col-12">
                                            <label>{{__('Prénom')}}</label>
                                            <input type="text" name="surname" class="form-control" value="{{Auth::user()->surname}}">
                                        </div>
                                        <div class="form-group col-md-6 col-12">
                                            <label>{{__('Email')}}</label>
                                            <input type="text" name="email" class="form-control" value="{{Auth::user()->email}}">
                                        </div>
                                        <div class="form-group col-md-6 col-12">
                                            <label>{{__('Numéro de téléphone')}}</label>
                                            <input type="text" name="phone" class="form-control" value="{{Auth::user()->phone}}">
                                        </div>
                                    </div>
                                </div>
                                <div class="card-footer text-right">
                                    <button class="btn btn-primary">{{__('Enregistrer les modifications')}}</button>
                                </div>
                            </form>
                        </div>
                    </div>

                    <div class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <div class="card">
                            <form method="post" class="needs-validation" novalidate="" action="{{route('user.profile.update.password')}}">
                                @csrf
                                <div class="card-header m-0 font-weight-bold text-primary">
                                    <h4>{{__('Mettre à jour le mot de passe')}}</h4>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="form-group col-12">
                                            <label>{{__('Mot de passe actuel')}}</label>
                                            <input type="password" name="current_password" class="form-control">
                                        </div>
                                        <div class="form-group col-12">
                                            <label>{{__('Nouveau mot de passe')}}</label>
                                            <input type="password" name="password" class="form-control">
                                        </div>
                                        <div class="form-group col-12">
                                            <label>{{__('Confirmer le mot de passe')}}</label>
                                            <input type="password" name="password_confirmation" class="form-control">
                                        </div>
                                    </div>
                                </div>
                                <div class="card-footer text-right">
                                    <button class="btn btn-primary">{{__('Enregistrer les modifications')}}</button>
                                </div>
                            </form>
                        </div>
                    </div>
        
                </div>
            </div>

    </div>
    <!-- /.container-fluid -->
@endsection


