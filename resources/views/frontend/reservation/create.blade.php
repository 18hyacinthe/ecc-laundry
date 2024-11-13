@extends('frontend.dashboard.page')

@section('content')
    <!-- Begin Page Content -->
    <div class="container-fluid">
        <div class="card shadow-sm">
            <div class="card-header text-white" style="background: #0c9683;">
                <h4 class="m-0">{{ __('Réserver une machine') }}</h4>
            </div>
            <div class="card-body">
                {{-- Display weekly session limit remaining --}}
                <div class="alert alert-info">
                    <strong>{{ __('Réservations hebdomadaires restantes :') }}</strong>
                    {{ $weeklySessionLimitRemaining ?? __('Aucune limite trouvée') }}
                </div>

                {{-- Display success or error messages --}}
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

                {{-- Reservation form --}}
                <form action="{{ route('user.reserve') }}" method="POST" class="needs-validation" novalidate>
                    @csrf

                    {{-- Select machine --}}
                    <div class="form-group">
                        <label for="machine_id">{{ __('Choisissez une machine :') }}</label>
                        <select name="machine_id" id="machine_id" class="form-control" required>
                            <option value="">{{ __('Sélectionnez une machine') }}</option>
                            @foreach($machines as $machine)
                                <option value="{{ $machine->id }}">{{ $machine->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="start_time">{{ __('Heure de début :') }}</label>
                        <input type="datetime-local" name="start_time" id="start_time" class="form-control" required min="{{ $sessionStartTime->format('Y-m-d\TH:i') }}" max="{{ $sessionResetTime->format('Y-m-d\TH:i') }}">
                        @if (isset($reservationMessage))
                            <small class="form-text text-muted">{{ $reservationMessage }}</small>
                        @endif
                    </div>
                    
                    <div class="form-group">
                        <label for="end_time">{{ __('Heure de fin :') }}</label>
                        <input type="datetime-local" name="end_time" id="end_time" class="form-control" required min="{{ $sessionStartTime->format('Y-m-d\TH:i') }}" max="{{ $sessionResetTime->format('Y-m-d\TH:i') }}">
                        <small class="form-text text-muted">{{ __('Les réservations ne doivent pas dépasser ') }}{{ $sessionDuration }}{{ __(' heures.') }}</small>
                    </div>

                    {{-- Confirmation button --}}
                    <div class="text-right">
                        <button type="submit" class="btn btn-primary">{{ __('Réserver') }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- /.container-fluid -->
@endsection
@push('scripts')
<script>
    document.addEventListener("DOMContentLoaded", function() {
        const startTimeInput = document.getElementById('start_time');
        const endTimeInput = document.getElementById('end_time');
        const form = document.getElementById('reservation-form');

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

        startTimeInput.addEventListener('change', () => fixMinutes(startTimeInput));
        endTimeInput.addEventListener('change', () => fixMinutes(endTimeInput));

        form.addEventListener('submit', function(event) {
            event.preventDefault();
            const formData = new FormData(form);

            fetch(form.action, {
                method: 'POST',
                body: formData,
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                },
            })
            .then(response => response.json())
            .then(data => {
                if (data.error) {
                    toastr.warning(data.error);
                } else {
                    toastr.success("Réservation réussie !");
                    // Redirection ou autre action souhaitée
                }
            })
            .catch(error => {
                console.error('Erreur:', error);
                toastr.error("Une erreur est survenue.");
            });
        });

        // Fix initial values on page load
        fixMinutes(startTimeInput);
        fixMinutes(endTimeInput);
    });
</script>
@endpush
