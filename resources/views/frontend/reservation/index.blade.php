@extends('frontend.dashboard.page')

@section('content')
<div class="container-fluid">
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h3 class="card-title text-primary">{{ __('Historique des Réservations') }}</h3>
            <a href="{{ route('user.showReservationForm') }}" class="btn btn-primary m-0 font-weight-bold">
                <i class="fas fa-plus"></i> {{ __('Créer une Réservation') }}
            </a>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-striped" id="historique-reservation-table" width="100%" cellspacing="0">
                    <thead class="thead-dark">
                        <tr>
                            <th>{{ __('Créé à') }}</th>
                            <th>{{ __('Date de début') }}</th>
                            <th>{{ __('Date de fin') }}</th>
                            <th>{{ __('Machine') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- Data will be populated by DataTables -->
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script type="module">
    $(function() {
        $('#historique-reservation-table').DataTable({
            processing: true,
            serverSide: true,
            responsive: true,
            ajax: '{{ route('user.reservation.index') }}',
            columns: [
                { data: 'created_at', name: 'created_at', className: 'text-center' },
                { data: 'start_time', name: 'start_time', className: 'text-center' },
                { data: 'end_time', name: 'end_time', className: 'text-center' },
                { data: 'machine_id', name: 'machine_id', className: 'text-center' }
            ],
            order: [[0, 'desc']],
            language: {
                url: '//cdn.datatables.net/plug-ins/1.10.21/i18n/French.json'
            },
            rowReorder: {
                selector: 'td:nth-child(2)'
            }
        });
    });
</script>
@endpush
