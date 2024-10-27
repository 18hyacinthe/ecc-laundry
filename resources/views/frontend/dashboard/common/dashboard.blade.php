@extends('frontend.dashboard.page')

@section('content')
<div class="container-fluid">
    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-primary">Dashboard</h1>

    <!-- Carte de Suivi des Réservations -->
    <div class="row">
        <div class="col-xl-4 col-md-6 mb-4">
            <div class="card shadow h-100">
                <div class="card-body">
                    <h5 class="card-title font-weight-bold">
                        <i class="fas fa-calendar-check text-primary"></i> Suivi des Réservations
                    </h5>
                    <p class="card-text">
                        <strong><i class="fas fa-check-circle text-success"></i> Total de réservations autorisées : </strong> {{ $totalSessionsAllowed }}
                    </p>
                    <p class="card-text">
                        <strong><i class="fas fa-hourglass-half text-warning"></i> Sessions utilisées cette semaine : </strong> {{ $sessionsUsed }}/{{ $totalSessionsAllowed }}
                    </p>
                    <p class="card-text">
                        <strong><i class="fas fa-hourglass-end text-danger"></i> Sessions restantes : </strong> {{ $sessionsRemaining }}
                    </p>
                    <!-- Ajout de notifications -->
                    @if($sessionsRemaining <= 0)
                        <div class="alert alert-warning mt-2">
                            <strong><i class="fas fa-exclamation-triangle"></i> Attention !</strong> Vous avez atteint la limite hebdomadaire de sessions.
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <div class="table-responsive">
        <div class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
            <div class="card">
                <div class="card-header d-flex justify-content-between">
                    <h5 class="card-title font-weight-bold text-primary">Historique des Réservations</h5>
                </div>
                <div class="card-body p-3">
                    {{ $dataTable->table() }}
                </div>
            </div>
        </div>
    </div>
</div>
        
@endsection
@push('scripts')
{{ $dataTable->scripts(attributes: ['type' => 'module']) }}
@endpush