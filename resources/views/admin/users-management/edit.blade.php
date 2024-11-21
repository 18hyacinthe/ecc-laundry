@extends('admin.dashboard.page')
@section('content')
    <!-- Begin Page Content -->
    <div class="container-fluid">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">{{__('Mettre à jour l\'utilisateur')}}</h6>
            </div>
            <div class="card-body">
                <form method="post" class="needs-validation" novalidate="" action="{{ route('admin.users.update', Hashids::encode($user->id)) }}" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="form-row">
                        <!-- Champ Nom -->
                        <div class="form-group col-md-6">
                            <label for="name">{{__('Nom')}}</label>
                            <input type="text" id="name" name="name" class="form-control" value="{{ $user->name }}" required>
                        </div>
                        <!-- Champ Prénom -->
                        <div class="form-group col-md-6">
                            <label for="surname">{{__('Prénom')}}</label>
                            <input type="text" id="surname" name="surname" class="form-control" value="{{ $user->surname }}" required>
                        </div>
                    </div>
                    <div class="form-row">
                        <!-- Champ Email -->
                        <div class="form-group col-md-6">
                            <label for="email">{{__('Email')}}</label>
                            <input type="email" id="email" name="email" class="form-control" value="{{ $user->email }}" required>
                        </div>
                        <!-- Champ Numéro de Téléphone -->
                        <div class="form-group col-md-6">
                            <label for="phone">{{__('Numéro de Téléphone')}}</label>
                            <input type="text" id="phone" name="phone" class="form-control" value="{{ $user->phone }}" required>
                        </div>
                    </div>
                    <div class="form-row">
                        <!-- Champ Role -->
                        <div class="form-group col-md-6">
                            <label for="role">{{__('Rôle')}}</label>
                            <select id="role" name="role" class="form-control" required>
                                <option value="admin" {{ old('role', $user->role) == 'admin' ? 'selected' : '' }}>{{__('Admin')}}</option>
                                <option value="user" {{ old('role', $user->role) == 'user' ? 'selected' : '' }}>{{__('Utilisateur')}}</option>
                            </select>
                        </div>
                        <!-- Champ Statut -->
                        <div class="form-group col-md-6">
                            <label for="status">{{__('Statut')}}</label>
                            <select id="status" name="status" class="form-control" required>
                                <option value="1" {{ old('status', $user->status) == 1 ? 'selected' : '' }}>{{__('Actif')}}</option>
                                <option value="0" {{ old('status', $user->status) == 0 ? 'selected' : '' }}>{{__('Inactif')}}</option>
                            </select>
                        </div>
                        <!-- Champ Mot de Passe (Optionnel) -->
                        <div class="form-group col-md-6">
                            <label for="password">{{__('Nouveau mot de passe (optionnel)')}}</label>
                            <div class="input-group">
                                <input type="text" id="password" name="password" class="form-control" placeholder="{{__('Laissez vide si inchangé')}}">
                                <div class="input-group-append">
                                    <button type="button" class="btn btn-primary" onclick="generatePassword()">{{__('Générer')}}</button>
                                </div>
                            </div>
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
