@extends('frontend.dashboard.page')

@section('content')
    <!-- Begin Page Content -->
    <div class="container-fluid">
        <div class="card">
            <div class="card-header m-0 font-weight-bold text-primary">
                <h4>{{ __('Réserver une machine') }}</h4>
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

                    {{-- Select reservation time --}}
                    <div class="form-group">
                        <label for="start_time">{{ __('Heure de début :') }}</label>
                        <input type="datetime-local" name="start_time" id="start_time" class="form-control" required min="{{ $sessionStartTime->format('Y-m-d\TH:i') }}" max="{{ $sessionResetTime->format('Y-m-d\TH:i') }}">
                        <small class="form-text text-muted">{{ __('Les réservations doivent être faites entre ') }}{{ $sessionStartTime->format('H:i') }}{{ __(' et ') }}{{ $sessionResetTime->format('H:i') }}.</small>
                    </div>

                    <div class="form-group">
                        <label for="end_time">{{ __('Heure de fin :') }}</label>
                        <input type="datetime-local" name="end_time" id="end_time" class="form-control" required min="{{ $sessionStartTime->format('Y-m-d\TH:i') }}" required max="{{ $sessionResetTime->format('Y-m-d\TH:i') }}">
                        <small class="form-text text-muted">{{ __('Les réservations doivent se terminer avant ') }}{{ $sessionResetTime->format('H:i') }}.</small>
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
