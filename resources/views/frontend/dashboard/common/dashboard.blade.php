@extends('frontend.dashboard.page')

@section('content')
<div class="container-fluid">
    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-primary">{{ __('Tableau de bord') }}</h1>

    <!-- Cards for Reservation Tracking -->
    <div class="row">
        <div class="col-xl-4 col-md-6 mb-4">
            <div class="card shadow border-left-primary">
                <div class="card-body">
                    <h5 class="card-title font-weight-bold">
                        <i class="fas fa-calendar-check text-primary"></i> {{ __('Suivi des Réservations') }}
                    </h5>
                    <p class="card-text">
                        <strong><i class="fas fa-check-circle text-success"></i> {{ __('Total de réservations autorisées :') }} </strong> {{ $totalSessionsAllowed }}
                    </p>
                </div>
            </div>
        </div>
        <div class="col-xl-4 col-md-6 mb-4">
            <div class="card shadow border-left-warning">
                <div class="card-body">
                    <h5 class="card-title font-weight-bold">
                        <i class="fas fa-hourglass-half text-warning"></i> {{ __('Sessions utilisées cette semaine:') }}
                    </h5>
                    <p class="card-text">
                        <strong>{{ $sessionsUsed }}/{{ $totalSessionsAllowed }}</strong>
                    </p>
                </div>
            </div>
        </div>
        <div class="col-xl-4 col-md-6 mb-4">
            <div class="card shadow border-left-danger">
                <div class="card-body">
                    <h5 class="card-title font-weight-bold">
                        <i class="fas fa-hourglass-end text-danger"></i> {{ __('Sessions restantes') }}
                    </h5>
                    <p class="card-text">
                        <strong>{{ $sessionsRemaining }}</strong>
                    </p>
                    <!-- Notification for sessions remaining -->
                    @if($sessionsRemaining <= 0)
                        <div class="alert alert-warning mt-2">
                            <strong><i class="fas fa-exclamation-triangle"></i> {{ __('Attention !') }}</strong> {{ __('Vous avez atteint la limite hebdomadaire de sessions.') }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Reservations History Table -->
    <div class="card mb-4">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="card-title font-weight-bold text-primary">{{ __('Historique des Réservations') }}</h5>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                {{ $dataTable->table() }}
            </div>
        </div>
    </div>
</div>

@endsection

@push('scripts')
{{ $dataTable->scripts(attributes: ['type' => 'module']) }}
@endpush