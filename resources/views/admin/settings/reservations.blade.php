@extends('admin.dashboard.page')
@section('content')
    <!-- Begin Page Content -->
    <div class="container-fluid">
        <!-- Reservation Settings Card -->
        <div class="card mb-4">
            <div class="card-header m-0 font-weight-bold text-primary">
                <h4>{{ __('Paramètres de Réservation') }}</h4>
            </div>
            <form method="POST" action="{{ route('admin.settings.reservations') }}" class="needs-validation" novalidate>
                @csrf
                <div class="card-body">
                    <div class="row">
                        <!-- Session Duration -->
                        <div class="form-group col-md-6 col-12">
                            <label for="session_duration">{{ __('Durée de la Session (en minutes)') }}</label>
                            <input type="number" name="session_duration" id="session_duration" 
                                   class="form-control" value="{{ $sessionDuration }}" min="1" required>
                        </div>

                        <!-- Session Start Time -->
                        <div class="form-group col-md-6 col-12">
                            <label for="session_start_time">{{ __('Heure de Début de la Session') }}</label>
                            <input type="time" name="session_start_time" id="session_start_time" 
                                   class="form-control" value="{{ $sessionStartTime }}" required>
                        </div>

                        <!-- Weekly Session Limit -->
                        <div class="form-group col-md-6 col-12">
                            <label for="weekly_session_limit">{{ __('Limite Hebdomadaire de Sessions') }}</label>
                            <input type="number" name="weekly_session_limit" id="weekly_session_limit" 
                                   class="form-control" value="{{ $weeklySessionLimit }}" min="1" required>
                        </div>
                    </div>
                </div>
                <div class="card-footer text-right">
                    <button type="submit" class="btn btn-primary">{{ __('Enregistrer les Paramètres') }}</button>
                </div>
            </form>
        </div>

        <!-- Reset System Settings Card -->
        <div class="card mb-4">
            <div class="card-header m-0 font-weight-bold text-primary">
                <h4>{{ __('Réinitialiser les Paramètres du Système') }}</h4>
            </div>
            <form action="{{ route('admin.settings.reset-system.update') }}" method="POST">
                @csrf
                <div class="card-body">
                    <div class="form-group">
                        <label for="reset_time">{{ __('Heure de Réinitialisation') }}</label>
                        <input type="time" id="reset_time" name="reset_time" class="form-control" value="{{ old('reset_time', $resetTime) }}" required>
                    </div>
                </div>
                <div class="card-footer text-right">
                    <button type="submit" class="btn btn-primary">{{ __('Enregistrer les Paramètres') }}</button>
                </div>
            </form>
        </div>

        <!-- Manual Reset Card -->
        <div class="card mb-4">
            <div class="card-header m-0 font-weight-bold text-primary">
                <h4>{{ __('Réinitialisation Manuelle') }}</h4>
            </div>
            <form action="{{ route('admin.settings.reset-system.reset') }}" method="POST">
                @csrf
                <div class="card-body text-center">
                    <button type="submit" class="btn btn-danger" onclick="return confirm('{{ __('Êtes-vous sûr de vouloir réinitialiser toutes les sessions ?') }}')">
                        {{ __('Réinitialisation Manuelle') }}
                    </button>
                </div>
            </form>
        </div>
    </div>
    <!-- /.container-fluid -->
@endsection
