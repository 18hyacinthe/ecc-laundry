@extends('admin.dashboard.page')

@section('content')
    <!-- Begin Page Content -->
    <div class="container-fluid">
        <div class="card">
            <div class="card-header m-0 font-weight-bold text-primary">
                <h4>{{ __('Restriction de Domaine d\'Email') }}</h4>
            </div>
            <div class="card-body">
                {{-- Affichage des messages de succès ou d'erreur --}}
                @if(session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                @endif

                @if($errors->any())
                    <div class="alert alert-danger">
                        @foreach($errors->all() as $error)
                            <p>{{ $error }}</p>
                        @endforeach
                    </div>
                @endif

                {{-- Formulaire de paramétrage de restriction de domaine --}}
                <form action="{{ route('admin.settings.updateDomainCheck') }}" method="POST" class="needs-validation" novalidate>
                    @csrf

                    {{-- Domaine autorisé --}}
                    <div class="form-group">
                        <label for="allowed_domain">{{ __('Domaine Autorisé pour Inscription:') }}</label>
                        <input type="text" name="allowed_domain" id="allowed_domain" class="form-control" placeholder="centrale-casablanca.ma" value="{{ $settings['allowed_domain'] ?? '' }}" required>
                        <small class="form-text text-muted">{{ __('Les utilisateurs avec ce domaine pourront créer un compte sans approbation.') }}</small>
                    </div>

                    {{-- Option d'autorisation des autres domaines --}}
                    <div class="form-group">
                        <label for="allow_other_domains">{{ __('Autoriser autres domaines:') }}</label>
                        <select name="allow_other_domains" id="allow_other_domains" class="form-control" required>
                            <option value="1" {{ (isset($settings['allow_other_domains']) && $settings['allow_other_domains'] == 1) ? 'selected' : '' }}>{{ __('Oui') }}</option>
                            <option value="0" {{ (isset($settings['allow_other_domains']) && $settings['allow_other_domains'] == 0) ? 'selected' : '' }}>{{ __('Non') }}</option>
                        </select>
                        <small class="form-text text-muted">{{ __('Si activé, les utilisateurs de domaines non autorisés devront contacter l\'admin pour activer leur compte.') }}</small>
                    </div>

                    {{-- Bouton de confirmation --}}
                    <div class="text-right">
                        <button type="submit" class="btn btn-primary">{{ __('Enregistrer les Paramètres') }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- /.container-fluid -->
@endsection
