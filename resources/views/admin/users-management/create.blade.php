@extends('admin.dashboard.page')
@section('content')
    <!-- Begin Page Content -->
    <div class="container-fluid">
        <div class="card-body">
            <div class="table-responsive">
                <div class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <div class="card">
                        <form method="post" class="needs-validation" novalidate="" action="{{ route('admin.users.store') }}" enctype="multipart/form-data">
                            @csrf
                            <div class="card-header m-0 font-weight-bold text-primary">
                                <h4>{{__('Create new user')}}</h4>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <!-- Champ Nom -->
                                    <div class="form-group col-md-6 col-12">
                                        <label>{{__('Name')}}</label>
                                        <input type="text" name="name" class="form-control" required>
                                    </div>
                                    <!-- Champ Prénom -->
                                    <div class="form-group col-md-6 col-12">
                                        <label>{{__('Surname')}}</label>
                                        <input type="text" name="surname" class="form-control" required>
                                    </div>
                                    <!-- Champ Email -->
                                    <div class="form-group col-md-6 col-12">
                                        <label>{{__('Email')}}</label>
                                        <input type="email" name="email" class="form-control" required>
                                    </div>
                                    <!-- Champ Statut -->
                                    <div class="form-group col-md-6 col-12">
                                        <label>{{__('Status')}}</label>
                                        <select id="inputState" name="status" class="form-control" required>
                                            <option value="1" {{ old('status') == 1 ? 'selected' : '' }}>{{__('Active')}}</option>
                                            <option value="0" {{ old('status') == 0 ? 'selected' : '' }}>{{__('Inactive')}}</option>
                                        </select>
                                    </div>
                                    <!-- Champ Mot de Passe avec Génération Automatique -->
                                    <div class="form-group col-md-6 col-12">
                                        <label>{{__('Password')}}</label>
                                        <div class="input-group">
                                            <input type="text" id="password" name="password" class="form-control" required readonly>
                                            <div class="input-group-append">
                                                <button type="button" class="btn btn-primary" onclick="generatePassword()">{{__('Generate')}}</button>
                                            </div>
                                        </div>
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

    <script>
        // Fonction JavaScript pour générer un mot de passe aléatoire
        function generatePassword() {
            var length = 10;
            var charset = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789!@#$%^&*()_+";
            var password = "";
            for (var i = 0, n = charset.length; i < length; ++i) {
                password += charset.charAt(Math.floor(Math.random() * n));
            }
            document.getElementById("password").value = password;
        }
    </script>
@endsection
