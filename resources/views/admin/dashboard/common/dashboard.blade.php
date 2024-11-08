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
                'reserved' => $machines->where('status', 'reserved')->count(),
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
                <div class="card border-left-{{ $status == 'available' ? 'success' : ($status == 'under maintenance' ? 'info' : ($status == 'reserved' ? 'warning' : ($status == 'in-use' ? 'primary' : 'danger'))) }} shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-{{ $status == 'available' ? 'success' : ($status == 'under maintenance' ? 'info' : ($status == 'reserved' ? 'warning' : ($status == 'in-use' ? 'primary' : 'danger'))) }} text-uppercase mb-1">
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
                                <i class="fas fa-{{ $status == 'available' ? 'check-circle' : ($status == 'under maintenance' ? 'tools' : ($status == 'reserved' ? 'calendar-check' : ($status == 'in-use' ? 'play-circle' : 'exclamation-triangle'))) }} fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>

    <div class="container-fluid">
        <div class="card shadow mb-4">
            <div class="card-header py-3 d-flex justify-content-between align-items-center">
                <h6 class="m-0 font-weight-bold text-primary">{{ __('Historique des Réservations') }}</h6>
                {{-- <button class="btn btn-primary btn-sm">{{ __('Ajouter Réservation') }}</button> --}}
            </div>
            <div class="card-body p-3 table-responsive">
                <table class="table table-bordered table-striped table-hover" id="admin-historique-reservation-table" width="100%" cellspacing="0">
                    <thead class="thead-light">
                        <tr>
                            <th>{{ __('No') }}</th>
                            <th>{{ __('Utilisateur') }}</th>
                            <th>{{ __('Machine') }}</th>
                            <th>{{ __('Date de début') }}</th>
                            <th>{{ __('Date de fin') }}</th>
                            <th>{{ __('Créé à') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- Data will be populated by DataTables -->
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
<script type="module">
    $(function() {
        let lang = '{{ app()->getLocale() }}'; // Récupère la langue actuelle de l'utilisateur
        let langUrl = `{{ asset('i18n/${lang}.json') }}`; // Récupère le fichier de langue correspondant

        $('#admin-historique-reservation-table').DataTable({
            processing: true,
            serverSide: true,
            responsive: true,
            ajax: '', // Assurez-vous de définir l'URL correcte pour l'ajax
            columns: [
                { data: 'id', name: 'id', className: 'text-center' },
                { data: 'user_id', name: 'user_id', className: 'text-center' },
                { data: 'machine_id', name: 'machine_id', className: 'text-center' },
                { data: 'start_time', name: 'start_time', className: 'text-center' },
                { data: 'end_time', name: 'end_time', className: 'text-center' },
                { data: 'created_at', name: 'created_at', className: 'text-center' },
            ],
            order: [[0, 'desc']],
            rowReorder: {
                selector: 'td:nth-child(2)'
            },
            language: {
                url: langUrl
            }
        });
    });
</script>
@endpush
