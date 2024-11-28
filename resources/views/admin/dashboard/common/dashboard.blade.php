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
                                    {{ __($status) }}
                                </div>
                                @foreach($machineTypes as $type => $label)
                                <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                    {{ __($label) }}
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

    <!-- Graphiques -->
    <div class="row">
        <div class="col-xl-8 col-lg-7 mb-4">
            <div class="card shadow">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">{{ __('Reservations Overview') }}</h6>
                </div>
                <div class="card-body">
                    <canvas id="reservationsChart"></canvas>
                </div>
            </div>
        </div>
        <div class="col-xl-4 col-lg-5 mb-4">
            <div class="card shadow">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">{{ __('Page Views') }}</h6>
                </div>
                <div class="card-body">
                    <ul class="list-group">
                        @foreach($pageViews as $page)
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <span>{{ $page->url }}</span>
                            <span class="badge badge-primary badge-pill">{{ $page->views }}</span>
                        </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
        
        <h3>Activités des utilisateurs</h3>
        <ul>
            @foreach($userActivities as $activity)
                <li>{{ $activity->created_at }} - {{ $activity->user ? $activity->user->name : 'Un utilisateur' }} a {{ $activity->activity }} {{ $activity->url ? 'sur ' . $activity->url : '' }}</li>
            @endforeach
        </ul>

        <h3>Nombre de connexions</h3>
        <p>{{ $loginCount }} utilisateurs se sont connectés.</p>
    </div>

    <!-- Tableau -->
    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex justify-content-between align-items-center">
            <h6 class="m-0 font-weight-bold text-primary">{{ __('Historique des Réservations') }}</h6>
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
                <tbody></tbody>
            </table>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const reservationsData = @json($reservationsByDay);

        const labels = reservationsData.map(item => item.date);
        const data = reservationsData.map(item => item.count);

        const ctx = document.getElementById('reservationsChart').getContext('2d');
        new Chart(ctx, {
            type: 'line',
            data: {
                labels: labels,
                datasets: [{
                    label: '{{ __("Reservations per Day") }}',
                    data: data,
                    borderColor: 'rgba(75, 192, 192, 1)',
                    backgroundColor: 'rgba(75, 192, 192, 0.2)',
                    fill: true,
                }],
            },
            options: {
                responsive: true,
                scales: {
                    x: {
                        title: { display: true, text: '{{ __("Date") }}' },
                    },
                    y: {
                        title: { display: true, text: '{{ __("Number of Reservations") }}' },
                        beginAtZero: true,
                    },
                },
            },
        });
    });
</script>
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
