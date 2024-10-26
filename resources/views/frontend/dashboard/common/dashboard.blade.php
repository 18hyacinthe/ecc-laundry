@extends('frontend.dashboard.page')

@section('content')
<div class="container-fluid">
    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-primary">Dashboard Utilisateur</h1>

    <!-- Carte de Suivi des Réservations -->
    <div class="row">
        <div class="col-xl-4 col-md-6 mb-4">
            <div class="card shadow h-100">
                <div class="card-body">
                    <h5 class="card-title font-weight-bold">Suivi des Réservations</h5>
                    <p class="card-text">
                        <strong>Total de réservations autorisées : </strong> {{ $totalSessionsAllowed }}
                    </p>
                    <p class="card-text">
                        <strong>Sessions utilisées cette semaine : </strong> {{ $sessionsUsed }}/{{ $totalSessionsAllowed }}
                    </p>
                    <p class="card-text">
                        <strong>Sessions restantes : </strong> {{ $sessionsRemaining }}
                    </p>
                    <!-- Ajout de notifications -->
                    @if($sessionsRemaining <= 0)
                        <div class="alert alert-warning mt-2">
                            <strong>Attention !</strong> Vous avez atteint la limite hebdomadaire de sessions.
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Historique des Réservations -->
    <div class="row mt-4">
        <div class="col-lg-12">
            <div class="card shadow h-100">
                <div class="card-body">
                    <h5 class="card-title font-weight-bold">Historique des Réservations</h5>
                    <table id="reservation-history" class="table table-striped">
                        <thead>
                            <tr>
                                <th>Date</th>
                                <th>Heure de Début</th>
                                <th>Heure de Fin</th>
                                <th>Machine</th>
                            </tr>
                        </thead>
                        <tbody>
                            <!-- Boucle pour afficher les réservations -->
                            @forelse($reservations as $reservation)
                                <tr>
                                    <td>{{ \Carbon\Carbon::parse($reservation->date)->format('d/m/Y') }}</td>
                                    <td>{{ \Carbon\Carbon::parse($reservation->start_time)->format('H:i') }}</td>
                                    <td>{{ \Carbon\Carbon::parse($reservation->end_time)->format('H:i') }}</td>
                                    <td>{{ $reservation->machine->name ?? 'N/A' }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="text-center">Aucune réservation trouvée</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
