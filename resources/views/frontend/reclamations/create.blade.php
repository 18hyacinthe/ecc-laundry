@extends('frontend.dashboard.page')

@section('content')
    <!-- Begin Page Content -->
    <div class="container-fluid">
        <div class="card">
            <div class="card-header m-0 font-weight-bold text-primary">
                <h4>{{ __('Faire une réclamation') }}</h4>
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

                {{-- Reclamation form --}}
                <form action="{{ route('user.reclamations.store') }}" method="POST" class="needs-validation" novalidate>
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

                    {{-- Machine type --}}
                    <div class="form-group">
                        <label for="machine_type">{{ __('Type de machine :') }}</label>
                        <select name="machine_type" id="machine_type" class="form-control" required>
                            <option value="">{{ __('Sélectionnez le type de machine') }}</option>
                            <option value="machine à laver">{{ __('Machine à laver') }}</option>
                            <option value="sèche-linge">{{ __('Sèche-linge') }}</option>
                        </select>
                    </div>

                    {{-- Reclamation title --}}
                    <div class="form-group">
                        <label for="title">{{ __('Titre de la réclamation :') }}</label>
                        <input type="text" name="title" id="title" class="form-control" required>
                    </div>

                    {{-- Issue type --}}
                    <div class="form-group">
                        <label for="issue_type">{{ __('Type de problème :') }}</label>
                        <select name="issue_type" id="issue_type" class="form-control" required>
                            <option value="">{{ __('Sélectionnez le type de problème') }}</option>
                            <option value="Défaut technique">{{ __('Défaut technique') }}</option>
                            <option value="Problème de performance">{{ __('Problème de performance') }}</option>
                            <option value="Problème de sécurité">{{ __('Problème de sécurité') }}</option>
                        </select>
                    </div>

                    {{-- Description --}}
                    <div class="form-group">
                        <label for="description">{{ __('Description du problème :') }}</label>
                        <textarea name="description" id="description" class="form-control" rows="4" required></textarea>
                    </div>

                    {{-- Status --}}
                    <div class="form-group">
                        <label for="status">{{ __('Niveau d’urgence :') }}</label>
                        <select name="status" id="status" class="form-control" required>
                            <option value="">{{ __('Sélectionnez le niveau d’urgence') }}</option>
                            <option value="Important">{{ __('Important') }}</option>
                            <option value="Urgent">{{ __('Urgent') }}</option>
                            <option value="Très urgent">{{ __('Très urgent') }}</option>
                        </select>
                    </div>

                    {{-- Submit button --}}
                    <div class="text-right">
                        <button type="submit" class="btn btn-primary">{{ __('Soumettre la réclamation') }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- /.container-fluid -->
@endsection
