@extends('admin.dashboard.page')

@section('content')
    <!-- Begin Page Content -->
    <div class="container-fluid">
        <div class="card">
            <div class="card-header m-0 font-weight-bold text-primary">
                <h4>{{ __('Reserve a Machine') }}</h4>
            </div>
            <div class="card-body">
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
                <form action="{{ route('admin.reserve') }}" method="POST" class="needs-validation" novalidate>
                    @csrf

                    {{-- Select machine --}}
                    <div class="form-group">
                        <label for="machine_id">{{ __('Choose a machine:') }}</label>
                        <select name="machine_id" id="machine_id" class="form-control" required>
                            <option value="">{{ __('Select a machine') }}</option>
                            @foreach($machines as $machine)
                                <option value="{{ $machine->id }}">{{ $machine->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Select reservation time --}}
                    <div class="form-group">
                        <label for="requested_time">{{ __('Reservation time:') }}</label>
                        <input type="datetime-local" name="requested_time" id="requested_time" class="form-control" required>
                        <small class="form-text text-muted">{{ __('Reservations must be made between 6:00 AM and 11:59 PM, every 2 hours.') }}</small>
                    </div>

                    {{-- Confirmation button --}}
                    <div class="text-right">
                        <button type="submit" class="btn btn-primary">{{ __('Reserve') }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- /.container-fluid -->
@endsection