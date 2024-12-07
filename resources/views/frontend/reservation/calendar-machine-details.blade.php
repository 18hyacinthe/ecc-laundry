<style>
    .card {
        margin-top: 20px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }
    .card-header {
        background: linear-gradient(45deg, #0c9683, #0c6b8e);
        border-bottom: 2px solid #0c6b8e;
        color: white;
        padding: 15px;
        font-size: 1.25rem;
    }
    .list-group-item {
        display: flex;
        justify-content: space-between;
        align-items: center;
        border: none;
        border-bottom: 1px solid #ddd;
        padding: 10px 15px;
    }
    .list-group-item:last-child {
        border-bottom: none;
    }
    .badge-info {
        background-color: #0c6b8e;
        padding: 5px 10px;
        font-size: 0.9rem;
    }
    .btn-primary {
        background-color: #0c9683;
        border-color: #0c9683;
        transition: background-color 0.3s, border-color 0.3s;
    }
    .btn-primary:hover {
        background-color: #0c6b8e;
        border-color: #0c6b8e;
    }
    .alert {
        margin: 20px 0;
        padding: 15px;
        font-size: 1rem;
    }
</style>

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8 card">
            <div class="card-header text-white">
                {{ __('Réservations') }}
            </div>
            @if($machine->reservations->isEmpty())
                <div class="alert alert-danger" role="alert">
                    {{ __('Pas de réservation enregistrée sur la machine aujourd\'hui') }}
                </div>
            @else
                <ul class="list-group list-group-flush">
                    @foreach($machine->reservations as $reservation)
                        @php
                            $startTime = \Carbon\Carbon::parse($reservation->start_time);
                            $endTime = \Carbon\Carbon::parse($reservation->end_time);
                        @endphp
                        <li class="list-group-item">
                            <span class="badge badge-info">{{ $startTime->format('Y-m-d') }}</span>
                            <span>{{ $startTime->format('H:i') }} - {{ $endTime->format('H:i') }}</span>
                        </li>
                    @endforeach
                </ul>
            @endif
        </div>
    </div>
</div>