@extends('admin.dashboard.page')

@section('content')
<div class="container-fluid">
    <div class="card shadow-sm">
        <div class="card-header text-white" style="background: #0c9683;">
            <h4 class="m-0">{{ __('Modifier la réservation') }}</h4>
        </div>
        <div class="card-body">
            {{-- Affichage de la limite de sessions restantes --}}
            <div class="alert alert-info">
                <strong>{{ __('Réservations hebdomadaires restantes :') }}</strong>
                {{ $weeklySessionLimitRemaining ?? __('Aucune limite trouvée') }}
            </div>

            {{-- Affichage des messages de succès ou d'erreur --}}
            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            @if($errors->any())
                <div class="alert alert-danger">
                    @foreach($errors->all() as $error)
                        <p>{{ $error }}</p>
                    @endforeach
                </div>
            @endif

            {{-- Formulaire de modification de réservation --}}
            <form action="{{ route('admin.reservation.update', Hashids::encode($reservation->id)) }}" method="POST" class="needs-validation" novalidate>
                @csrf
                @method('PUT')

                {{-- Sélection de la machine --}}
                <div class="form-group">
                    <label for="machine_id">{{ __('Choisissez une machine :') }}</label>
                    <select name="machine_id" id="machine_id" class="form-control" required>
                        @foreach($machines as $machine)
                            <option value="{{ $machine->id }}" {{ $machine->id == $reservation->machine_id ? 'selected' : '' }}>
                                {{ $machine->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                {{-- Heure de début --}}
                <div class="form-group">
                    <label for="start_time">{{ __('Heure de début :') }}</label>
                    <input type="datetime-local" name="start_time" id="start_time" class="form-control" required 
                           value="{{ $reservation->start_time->format('Y-m-d\TH:i') }}"
                           min="{{ $sessionStartTime->format('Y-m-d\TH:i') }}" 
                           max="{{ $sessionResetTime->format('Y-m-d\TH:i') }}">
                    <small class="form-text text-muted">{{ __('Les réservations doivent être faites entre ') }}{{ $sessionStartTime->format('Y-m-d H:i') }}{{ __(' et ') }}{{ $sessionResetTime->format('Y-m-d H:i') }}.</small>
                </div>
                
                {{-- Heure de fin --}}
                <div class="form-group">
                    <label for="end_time">{{ __('Heure de fin :') }}</label>
                    <input type="datetime-local" name="end_time" id="end_time" class="form-control" required 
                           value="{{ $reservation->end_time->format('Y-m-d\TH:i') }}"
                           min="{{ $sessionStartTime->format('Y-m-d\TH:i') }}" 
                           max="{{ $sessionResetTime->format('Y-m-d\TH:i') }}">
                    <small class="form-text text-muted">{{ __('Les réservations doivent se terminer avant ') }}{{ $sessionResetTime->format('Y-m-d H:i') }}.</small>
                </div>

                {{-- Bouton de confirmation --}}
                <div class="text-right">
                    <button type="submit" class="btn btn-primary">{{ __('Mettre à jour') }}</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener("DOMContentLoaded", function() {
        const startTimeInput = document.getElementById('start_time');
        const endTimeInput = document.getElementById('end_time');

        function fixMinutes(input) {
            const value = input.value;
            if (value) {
                const [date, time] = value.split('T');
                const [hour, minute] = time.split(':');
                if (minute !== '00') {
                    input.value = `${date}T${hour}:00`;
                }
            }
        }

        startTimeInput.addEventListener('change', function() {
            fixMinutes(startTimeInput);
        });

        endTimeInput.addEventListener('change', function() {
            fixMinutes(endTimeInput);
        });

        // Fix initial values on page load
        fixMinutes(startTimeInput);
        fixMinutes(endTimeInput);
    });
</script>
@endpush
