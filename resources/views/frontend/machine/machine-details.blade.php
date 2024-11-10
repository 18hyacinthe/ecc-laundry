<style>
    .card-header {
        background: linear-gradient(45deg, #0c9683, #0c6b8e);
        border-bottom: 2px solid #0c6b8e;
        color: white;
    }
    .list-group-item {
        display: flex;
        justify-content: space-between;
        align-items: center;
        border: none;
        border-bottom: 1px solid #ddd;
    }
    .list-group-item:last-child {
        border-bottom: none;
    }
    .badge-info {
        background-color: #0c6b8e;
    }
    .btn-primary {
        background-color: #0c9683;
        border-color: #0c9683;
    }
    .btn-primary:hover {
        background-color: #0c6b8e;
        border-color: #0c6b8e;
    }
</style>

<div class="container mt-4">
    <div class="row">
        <div class="col-md-8 offset-md-2">
            <div class="card mt-3 shadow-sm">
                <div class="card-header text-white">
                    {{ __('Réservations') }}
                </div>
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
            </div>

            <div class="text-center mt-4">
                <small>{{ __('Pour en savoir plus, consultez le calendrier.') }}</small>
                <a href="{{ route('user.calendar.index') }}" class="btn btn-primary ml-2">{{ __('Calendrier') }}</a>
            </div>
        </div>
    </div>
</div>