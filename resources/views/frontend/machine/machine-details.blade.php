<div class="container mt-4">
    <div class="row">
        <div class="col-md-8 offset-md-2">
            <div class="card">
                <div class="card-header text-white" style="background: #0c9683;">
                    <h5 class="mb-0"><strong>{{ $machine->name }}</strong></h5>
                </div>
                <div class="card-body">
                    <p><strong>{{ __('Type') }} :</strong> {{ $machine->type == 'washing-machine' ? 'Lave-linge' : 'Sèche-linge' }}</p>
                    <p><strong>{{ __('Statut') }} :</strong> {{ ucfirst($machine->status) }}</p>
                    <p><strong>{{ __('Réservations Aujourd\'hui') }} :</strong></p>
                </div>
            </div>

            <div class="card mt-3">
                <div class="card-header text-white" style="background: #0c9683;">
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
                            <span class="ml-2">{{ $startTime->format('H:i') }} - {{ $endTime->format('H:i') }}</span>
                        </li>
                    @endforeach
                </ul>
            </div>

            <div class="text-center mt-4">
                <small>{{ __('Pour en savoir plus, consultez le calendrier') }}</small>
                <a href="{{ route('user.calendar.index') }}" class="btn btn-primary ml-2">{{ __('Calendrier') }}</a>
            </div>
        </div>
    </div>
</div>
