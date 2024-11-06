@extends('frontend.dashboard.page')
@section('content')

<div class="container-fluid">
    <h1 class="h3 mb-4 text-primary">{{ __('Aperçu des Machines') }}</h1>

    <!-- Légende -->
    <div class="alert alert-info">
        {{ __('Tout machine dont le statut est différent de "Disponible" ne sont pas autorisés à être réservés et le système ne prendra pas la réservation en compte!') }}
    </div>

    <!-- Onglets de sélection de type de machine -->
    <div class="btn-group mb-4" role="group" aria-label="{{ __('Type de Machine') }}">
        <button type="button" class="btn btn-primary active" onclick="showMachines('washing')">{{ __('Lave-linge (' . $washingMachinesCount . ')') }}</button>
        <button type="button" class="btn btn-primary" onclick="showMachines('dryer')">{{ __('Sèche-linge (' . $dryerMachinesCount . ')') }}</button>
    </div>

    <!-- Conteneur pour les lave-linge -->
    <div class="row machine-group" id="washing-machines">
        @foreach($machinesData as $machine)
            @if($machine['type'] == 'washing-machine')
                <div class="col-lg-4 col-md-6 mb-4">
                    <div class="card shadow h-100">
                        <div class="card-body">
                            <h5 class="card-title font-weight-bold">{{ $machine['name'] }}</h5>
                            <p><strong>{{ __('Type') }} :</strong> {{ __('Lave-linge') }}</p>
                            <p><strong>{{ __('Statut Actuel') }} :</strong> 
                                <span class="{{ $machine['status'] == 'available' ? 'text-success' : 'text-warning' }}">
                                    {{ ucfirst($machine['status']) }}
                                </span>
                            </p>
                            @if($machine['status'] == 'available')
                                <a href="{{ route('user.reservation.index') }}" class="btn btn-success btn-sm">{{ __('Réserver') }}</a>
                            @else
                                <button class="btn btn-secondary btn-sm" disabled>{{ __('Indisponible') }}</button>
                            @endif
                            <button class="btn btn-info btn-sm" onclick="showMachineDetails({{ $machine['id'] }})">{{ __('Voir plus') }}</button>
                        </div>
                    </div>
                </div>
            @endif
        @endforeach
    </div>

    <!-- Conteneur pour les sèche-linge -->
    <div class="row machine-group d-none" id="dryer-machines">
        @foreach($machinesData as $machine)
            @if($machine['type'] == 'dryer') 
                <div class="col-lg-4 col-md-6 mb-4">
                    <div class="card shadow h-100">
                        <div class="card-body">
                            <h5 class="card-title font-weight-bold">{{ $machine['name'] }}</h5>
                            <p><strong>{{ __('Type') }} :</strong> {{ __('Sèche-linge') }}</p>
                            <p><strong>{{ __('Statut Actuel') }} :</strong> 
                                <span class="{{ $machine['status'] == 'available' ? 'text-success' : 'text-warning' }}">
                                    {{ ucfirst($machine['status']) }}
                                </span>
                            </p>
                            @if($machine['status'] == 'available')
                                <a href="{{ route('user.reservation.index') }}" class="btn btn-success btn-sm">{{ __('Réserver') }}</a>
                            @else
                                <button class="btn btn-secondary btn-sm" disabled>{{ __('Indisponible') }}</button>
                            @endif
                            <button class="btn btn-info btn-sm" onclick="showMachineDetails({{ $machine['id'] }})">{{ __('Voir plus') }}</button>
                        </div>
                    </div>
                </div>
            @endif
        @endforeach
    </div>
</div>

<!-- Vue modale pour les détails de la machine -->
<div class="modal fade" id="machineDetailsModal" tabindex="-1" aria-labelledby="machineDetailsModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="machineDetailsModalLabel">{{ __('Détails de la Machine') }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" id="machineDetailsContent">
                <!-- Les détails de la machine seront chargés ici via AJAX -->
                <p>{{ __('Pour en savoir plus, consultez le calendrier.') }}</p>
            </div>
        </div>
    </div>
</div>

<script>
    function showMachineDetails(machineId) {
        // Charger les détails de la machine via AJAX
        fetch(`/user/machines/${machineId}/details`)
            .then(response => response.text())
            .then(data => {
                document.getElementById('machineDetailsContent').innerHTML = data;
                $('#machineDetailsModal').modal('show');
            });
    }

    function showMachines(type) {
        document.querySelectorAll('.machine-group').forEach(group => group.classList.add('d-none'));
        document.getElementById(type === 'washing' ? 'washing-machines' : 'dryer-machines').classList.remove('d-none');
        document.querySelectorAll('.btn-group .btn').forEach(btn => btn.classList.remove('active'));
        event.target.classList.add('active');
    }
</script>

@endsection
