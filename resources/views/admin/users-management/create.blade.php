@extends('admin.dashboard.page')
@section('content')
    <!-- Begin Page Content -->
    <div class="container-fluid">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">{{__('Créer un nouvel utilisateur')}}</h6>
            </div>
            <div class="card-body">
                <form method="post" class="needs-validation" novalidate="" action="{{ route('admin.users.store') }}" enctype="multipart/form-data">
                    @csrf
                    <div class="form-row">
                        <!-- Champ Nom -->
                        <div class="form-group col-md-6">
                            <label>{{__('Nom')}}</label>
                            <input type="text" name="name" class="form-control" required>
                        </div>
                        <!-- Champ Prénom -->
                        <div class="form-group col-md-6">
                            <label>{{__('Prénom')}}</label>
                            <input type="text" name="surname" class="form-control" required>
                        </div>
                    </div>
                    <div class="form-row">
                        <!-- Champ Email -->
                        <div class="form-group col-md-6">
                            <label>{{__('Email')}}</label>
                            <input type="email" name="email" class="form-control" required>
                        </div>
                        <!-- Champ Numéro de Téléphone -->
                        <div class="form-group col-md-6">
                            <label>{{__('Numéro de Téléphone')}}</label>
                            <input type="text" name="phone" class="form-control" required>
                        </div>
                    </div>
                    <div class="form-row">
                        <!-- Champ Statut -->
                        <div class="form-group col-md-6">
                            <label>{{__('Statut')}}</label>
                            <select id="inputState" name="status" class="form-control" required>
                                <option value="1" {{ old('status') == 1 ? 'selected' : '' }}>{{__('Actif')}}</option>
                                <option value="0" {{ old('status') == 0 ? 'selected' : '' }}>{{__('Inactif')}}</option>
                            </select>
                        </div>
                        <!-- Champ Mot de Passe avec Génération Automatique -->
                        <div class="form-group col-md-6">
                            <label>{{__('Mot de passe')}}</label>
                            <div class="input-group">
                                <input type="text" id="password" name="password" class="form-control" required readonly>
                                <div class="input-group-append">
                                    <button type="button" class="btn btn-primary" onclick="generatePassword()">{{__('Générer')}}</button>
                                </div>
                            </div>
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
