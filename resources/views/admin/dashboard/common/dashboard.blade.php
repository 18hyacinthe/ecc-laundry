@extends('admin.dashboard.page')
@section('content')

    <!-- Begin Page Content -->
    <div class="container-fluid">
        <!-- Page Heading -->
        <h1 class="h3 mb-4 text-primary">{{ __('Tableau de bord Admin') }}</h1>
    
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
            <!-- <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                        {{ __('Nombre de Connexions') }}
                        </div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $loginCount }} utilisateurs se sont connectés.</div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-user-check fa-2x text-gray-300"></i>
                    </div>
                    </div>
                </div>
                </div>
            </div> -->
            {{-- <div class="col-12 mb-4">
                <div class="card shadow">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">{{ __('Activités des Utilisateurs') }}</h6>
                    </div>
                    <div class="card-body">
                        <ul class="list-group">
                            @foreach($userActivities as $activity)
                            <li class="list-group-item">
                                {{ $activity->created_at }} - {{ $activity->user ? $activity->user->name : __('Un utilisateur') }} {{ $activity->activity }} {{ $activity->url ? __('sur') . ' ' . $activity->url : '' }}
                            </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div> --}}
        </div>

    <!-- Graphiques -->
    <!-- <div class="row">
        <div class="col-xl-12 col-lg-12 mb-4">
            <div class="card shadow">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">{{ __('Aperçu des Réservations') }}</h6>
            </div>
            <div class="card-body">
                <canvas id="reservationsChart"></canvas>
            </div>
            </div>
        </div>
        <div class="col-xl-12 col-lg-12 mb-4">
            <div class="card shadow">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">{{ __('Réservations par Machine') }}</h6>
                </div>
                <div class="card-body">
                    <canvas id="reservationsByMachineChart"></canvas>
                </div>
            </div>
        </div>
        <div class="col-xl-12 col-lg-12 mb-4">
            <div class="card shadow">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">{{ __('Connexions Utilisateurs Quotidiennes') }}</h6>
                </div>
                <div class="card-body">
                        <canvas id="loginsChart"></canvas>
                </div>
            </div>
        </div>
    </div> -->
    {{-- <div class="row">
        <div class="col-12 mb-4">
            <div class="card shadow">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">{{ __('Vues de Page') }}</h6>
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
    </div> --}}

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

{{-- <script src="https://cdn.jsdelivr.net/npm/chart.js"></script> --}}
<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Convert PHP data to JSON
        const reservationsData = @json($reservationsByDay);

        // Process data for Chart.js
        const types = Object.keys(reservationsData); // Extract machine types (e.g., washer, dryer)
        const allLabels = [...new Set(types.flatMap(type => reservationsData[type].map(item => item.date)))];
        const formattedLabels = allLabels.map(date => {
            const options = { day: '2-digit', month: 'short' }; // Format: 28 Nov, 30 Nov
            return new Date(date).toLocaleDateString('en-GB', options);
        });

        const colors = ['rgba(255, 99, 132, 1)', 'rgba(54, 162, 235, 1)', 'rgba(255, 206, 86, 1)', 'rgba(75, 192, 192, 1)']; // Unique colors for each type
        const datasets = types.map((type, index) => ({
            label: type,
            data: allLabels.map(label =>
                reservationsData[type].find(item => item.date === label)?.count || 0
            ),
            borderColor: colors[index % colors.length], // Assign a unique color
            backgroundColor: colors[index % colors.length], // Same color for background// Transparent background
            borderWidth: 2, // Line width
            tension: 0.4, // Curve the line
        }));

        // Create the chart
        const ctx = document.getElementById('reservationsChart').getContext('2d');
        new Chart(ctx, {
            type: 'bar', // Line chart
            data: {
                labels: formattedLabels,
                datasets: datasets,
            },
            options: {
                responsive: true,
                plugins: {
                    legend: { display: true, position: 'top' },
                },
                scales: {
                    x: {
                        title: { display: true, text: '{{ __("Date") }}' },
                    },
                    y: {
                        title: { display: true, text: '{{ __("Number of Reservations") }}' },
                        beginAtZero: true, // Always start from 0
                    },
                },
            },
        });
    });
</script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const loginsByDay = @json($loginsByDay);

        const labels = loginsByDay.map(item => {
            const options = { day: '2-digit', month: 'short' }; // Format: 28 Nov, 30 Nov
            return new Date(item.date).toLocaleDateString('en-GB', options);
        });
        const data = loginsByDay.map(item => item.count);

        const ctx = document.getElementById('loginsChart').getContext('2d');
        new Chart(ctx, {
            type: 'bar', // Courbes fluides
            data: {
                labels: labels,
                datasets: [{
                    label: '{{ __("Connexions Utilisateurs Quotidiennes") }}',
                    data: data,
                    borderColor: 'rgba(54, 162, 235, 1)', // Bleu
                    backgroundColor: 'rgba(54, 162, 235, 0.2)', // Transparence
                    borderWidth: 2,
                    tension: 0.4, // Courbes lisses
                    fill: true, // Remplir sous la courbe
                }],
            },
            options: {
                responsive: true,
                plugins: {
                    legend: { display: true, position: 'top' },
                },
                scales: {
                    x: {
                        title: { display: true, text: '{{ __("Date") }}' },
                    },
                    y: {
                        title: { display: true, text: '{{ __("Number of Logins") }}' },
                        beginAtZero: true, // Commence à 0
                    },
                },
            },
        });
    });
</script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const reservationsByMachine = @json($reservationsByMachine);
        const machineColors = @json($machineColors); // Associe les noms des machines à leurs couleurs CSS
        const machines = Object.keys(reservationsByMachine); // Noms des machines
        const allLabels = [...new Set(machines.flatMap(machine => reservationsByMachine[machine].map(item => item.date)))];
        const formattedLabels = allLabels.map(date => {
            const options = { day: '2-digit', month: 'short' }; // Format: 28 Nov, 30 Nov
            return new Date(date).toLocaleDateString('en-GB', options);
        });

        // const colors = ['rgb(31, 120, 50)', 'rgb(75, 192, 192)', 'rgb(255, 159, 64)', 'rgb(153, 102, 255)']; // Unique colors
        const datasets = machines.map((machine, index) => ({
            label: machine,
            data: allLabels.map(label =>
                reservationsByMachine[machine].find(item => item.date === label)?.count || 0
            ),
            // borderColor: colors[index % colors.length], // Assign a unique color
            // backgroundColor: colors[index % colors.length] + '55', // Semi-transparent
            borderColor: machineColors[machine] || 'rgb(0, 0, 0)', // Couleur unique de la machine
            backgroundColor: (machineColors[machine] || 'rgb(0, 0, 0)') + '55', // Semi-transparent pour le remplissage
            borderWidth: 2,
            tension: 0.4, // Courbes fluides
            fill: true, // Remplir sous la courbe
        }));

        const ctx = document.getElementById('reservationsByMachineChart').getContext('2d');
        new Chart(ctx, {
            type: 'bar', // Courbes fluides
            data: {
                labels: formattedLabels,
                datasets: datasets,
            },
            options: {
                responsive: true,
                plugins: {
                    legend: { display: true, position: 'top' },
                },
                scales: {
                    x: {
                        title: { display: true, text: '{{ __("Date") }}' },
                    },
                    y: {
                        title: { display: true, text: '{{ __("Number of Reservations") }}' },
                        beginAtZero: true, // Commence à 0
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
