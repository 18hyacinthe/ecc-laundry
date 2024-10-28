@extends('frontend.dashboard.page')

@section('content')
<div class="container-fluid">
    
    <!-- Reservations History Table -->
    <div class="card mb-4">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="card-title font-weight-bold text-primary">{{ __('Historique des Réservations') }}</h5>
            <!-- Create Button -->
            <a href="{{ route('user.showReservationForm') }}" class="btn btn-primary">
                <i class="fas fa-plus"></i> {{ __('Créer une Réservation') }}
            </a>
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