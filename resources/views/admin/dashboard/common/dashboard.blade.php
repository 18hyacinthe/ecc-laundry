@extends('admin.dashboard.page')
@section('content')

    <!-- Begin Page Content -->
    <div class="container-fluid">
        <!-- Page Heading -->
        <h1 class="h3 mb-4 text-primary">{{ __('Dashboard Admin') }}</h1>
    
        <!-- Résumé des Machines -->
        <div class="row mb-4">
            @php
            $statusCounts = [
            'pending' => $machines->where('status', 'pending')->count(),
            'in-use' => $machines->where('status', 'in-use')->count(),
            'available' => $machines->where('status', 'available')->count(),
            'under maintenance' => $machines->where('status', 'under maintenance')->count(),
            'out of order' => $machines->where('status', 'out of order')->count(),
            ];

            $machineTypes = [
            'washing-machine' => 'Washing Machines',
            'dryer' => 'Dryers',
            ];
            @endphp

            @foreach($statusCounts as $status => $count)
            <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-{{ $status == 'available' ? 'success' : ($status == 'under maintenance' ? 'info' : ($status == 'pending' ? 'warning' : ($status == 'in-use' ? 'primary' : 'danger'))) }} shadow h-100 py-2">
                <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                    <div class="text-xs font-weight-bold text-{{ $status == 'available' ? 'success' : ($status == 'under maintenance' ? 'info' : ($status == 'pending' ? 'warning' : ($status == 'in-use' ? 'primary' : 'danger'))) }} text-uppercase mb-1">
                        {{ ucfirst($status) }}
                    </div>
                    @foreach($machineTypes as $type => $label)
                    <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                        {{ $label }}
                    </div>
                    <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $machines->where('status', $status)->where('type', $type)->count() }}</div>
                    @endforeach
                    </div>
                    <div class="col-auto">
                    <i class="fas fa-{{ $status == 'available' ? 'check-circle' : ($status == 'under maintenance' ? 'tools' : 'exclamation-triangle') }} fa-2x text-gray-300"></i>
                    </div>
                </div>
                </div>
            </div>
            </div>
            @endforeach
        </div>
    



















        <!-- Cartes des Utilisateurs -->
        <div class="row">
            <div class="col-lg-4 col-md-6 mb-4">
                <div class="card shadow h-100">
                    <div class="card-body">
                        <h5 class="card-title font-weight-bold">Nom de l'utilisateur</h5>
                        <p class="card-text"><strong>Email :</strong> user@example.com</p>
                        <p class="card-text"><strong>Rôle :</strong> Admin</p>
                        <p class="card-text"><strong>Créé le :</strong> 12 Oct 2024</p>
                        <div class="d-flex justify-content-between">
                            <a href="#" class="btn btn-danger btn-sm">Supprimer</a>
                            <a href="#" class="btn btn-primary btn-sm">Voir Détails</a>
                        </div>
                    </div>
                </div>
            </div>
    
            <!-- Répétez la structure de la carte ci-dessus pour chaque utilisateur -->
        </div>
    </div>
    
    <!-- /.container-fluid -->
@endsection
