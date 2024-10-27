@extends('frontend.dashboard.page')
@section('content')

<div class="container-fluid">
    <h1 class="h3 mb-4 text-primary">Aperçu des Machines</h1>

    <!-- Onglets de sélection de type de machine -->
    <div class="btn-group mb-4" role="group" aria-label="Type de Machine">
        <button type="button" class="btn btn-outline-primary active" onclick="showMachines('washing')">Lave-linge</button>
        <button type="button" class="btn btn-outline-primary" onclick="showMachines('dryer')">Sèche-linge</button>
    </div>

    <!-- Conteneur pour les machines à laver -->
    <div class="row machine-group" id="washing-machines">
        @foreach($machinesData as $machine)
            @if($machine['type'] == 'washing-machine')
                <div class="col-lg-4 col-md-6 mb-4">
                    <div class="card shadow h-100">
                        <div class="card-body">
                            <h5 class="card-title font-weight-bold">{{ $machine['name'] }}</h5>
                            <p class="card-text">
                                <strong>Statut :</strong> 
                                <span class="{{ $machine['status'] == 'available' ? 'text-success' : 'text-warning' }}">
                                    {{ ucfirst($machine['status']) }}
                                </span>
                            </p>
                            <p class="card-text">
                                <strong>Prochaine Disponibilité :</strong> 
                                {{ $machine['next_available_time'] }}
                            </p>
                            @if($machine['status'] != 'available')
                                <button class="btn btn-primary btn-sm" disabled>Non Disponible</button>
                            @else
                                <button class="btn btn-success btn-sm">Disponible</button>
                            @endif
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
                            <p class="card-text">
                                <strong>Statut :</strong> 
                                <span class="{{ $machine['status'] == 'available' ? 'text-success' : 'text-warning' }}">
                                    {{ ucfirst($machine['status']) }}
                                </span>
                            </p>
                            <p class="card-text">
                                <strong>Prochaine Disponibilité :</strong> 
                                {{ $machine['next_available_time'] }}
                            </p>
                            @if($machine['status'] != 'available')
                                <button class="btn btn-primary btn-sm" disabled>Non Disponible</button>
                            @else
                                <button class="btn btn-success btn-sm">Disponible</button>
                            @endif
                        </div>
                    </div>
                </div>
            @endif
        @endforeach
    </div>
</div>

<!-- Script JavaScript pour gérer le fuseau horaire -->
<script>
    // Obtenez le décalage de fuseau horaire en minutes
    const timezoneOffset = new Date().getTimezoneOffset();

    // Faites une requête pour récupérer les données ajustées au fuseau horaire
    fetch('/machines/status?timezone_offset=' + timezoneOffset)
        .then(response => response.text())
        .then(html => {
            document.querySelector('#machine-status-container').innerHTML = html;
        })
        .catch(error => console.error('Erreur:', error));
</script>

<!-- Script JavaScript pour basculer entre les types de machines -->
<script>
    function showMachines(type) {
        // Masquer tous les groupes de machines
        document.querySelectorAll('.machine-group').forEach(group => {
            group.classList.add('d-none');
        });

        // Activer le bon groupe
        if (type === 'washing') {
            document.getElementById('washing-machines').classList.remove('d-none');
        } else {
            document.getElementById('dryer-machines').classList.remove('d-none');
        }

        // Mettre à jour les boutons pour indiquer le bouton actif
        document.querySelectorAll('.btn-group .btn').forEach(btn => {
            btn.classList.remove('active');
        });
        event.target.classList.add('active');
    }
</script>

@endsection
