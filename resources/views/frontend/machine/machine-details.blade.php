<h5 style="color: #0c9683;"><strong>{{ $machine->name }}</strong></h5>
<div class="mb-3">
    <p><strong>{{ __('Type') }} :</strong> {{ $machine->type == 'washing-machine' ? 'Lave-linge' : 'Sèche-linge' }}</p>
    <p><strong>{{ __('Statut') }} :</strong> {{ ucfirst($machine->status) }}</p>
    <p><strong>{{ __('Réservations Aujourd\'hui') }} :</strong></p>
</div>

<div class="card">
    <div class="card-header">
        {{ __('Réservations') }}
    </div>
    <ul class="list-group list-group-flush">
        @foreach($machine->reservations as $reservation)
            @php
                $startTime = \Carbon\Carbon::parse($reservation->start_time);
                $endTime = \Carbon\Carbon::parse($reservation->end_time);
            @endphp
            <li class="list-group-item">{{ $startTime->format('Y-m-d') }} - {{ $startTime->format('H:i') }} - {{ $endTime->format('H:i') }}</li>
        @endforeach
    </ul>
</div>

<small class="ml-2 mt-2">{{ __('Pour en savoir plus, consultez le calendrier') }}</small><a href="{{ route('user.calendar.index') }}" class="btn btn-primary ml-2 mt-2">{{ __('Calendrier') }}</a>
