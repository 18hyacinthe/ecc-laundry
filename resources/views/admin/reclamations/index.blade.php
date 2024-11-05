@extends('admin.dashboard.page')

@section('content')
<div class="container-fluid">
    <div class="card-body">
        <div class="card">
            <div class="card-header d-flex justify-content-between">
                <h3 class="card-title text-primary">{{ __('Historique des Réclamations') }}</h3>
            <div class="btn-group">
                <button id="printButton" class="btn btn-secondary">
                    <i class="fas fa-print"></i> {{ __('Imprimer') }}
                </button>
                <button id="excelButton" class="btn btn-success">
                    <i class="fas fa-file-excel"></i> {{ __('Exporter en Excel') }}
                </button>
                <button id="pdfButton" class="btn btn-danger">
                    <i class="fas fa-file-pdf"></i> {{ __('Exporter en PDF') }}
                </button>
            </div>
            </div>
            <div class="card-body p-3 table-responsive">
                <div class="table-responsive">
                    <table class="table table-bordered table-striped" id="admin-reclamation-table" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>{{ __('No') }}</th>
                                <th>{{ __('Titre') }}</th>
                                <th>{{ __('Machine') }}</th>
                                <th>{{ __('Type de Machine') }}</th>
                                <th>{{ __('Type de Problème') }}</th>
                                <th>{{ __('Description') }}</th>
                                <th>{{ __('Statut') }}</th>
                                <th>{{ __('Utilisateur') }}</th>
                                <th>{{ __('Créé à') }}</th>
                                <th>{{ __('Actions') }}</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@include('admin.reclamations.show-reclamation')
@endsection
@push('scripts')
<script type="module">
    $(function() {
        var table = $('#admin-reclamation-table').DataTable({
            processing: true,
            serverSide: true,
            responsive: true,
            ajax: '{{ route('admin.reclamations.index') }}',
            columns: [
                { data: 'id', name: 'id', className: 'text-center' },
                { data: 'title', name: 'title', className: 'text-center' },
                { data: 'machine_id', name: 'machine_id', className: 'text-center' },
                { data: 'machine_type', name: 'machine_type', className: 'text-center' },
                { data: 'issue_type', name: 'issue_type', className: 'text-center' },
                { data: 'description', name: 'description', className: 'text-center' },
                { data: 'status', name: 'status', className: 'text-center', orderable: false, searchable: false },
                { data: 'user_id', name: 'user_id', className: 'text-center' },
                { data: 'created_at', name: 'created_at', className: 'text-center' },
                { data: 'action', name: 'action', className: 'text-center', orderable: false, searchable: false }
            ],
            order: [[0, 'desc']],
            rowReorder: {
                selector: 'td:nth-child(2)'
            },
            buttons: [
                {
                    extend: 'print',
                    text: '<i class="fas fa-print"></i> {{ __('Imprimer') }}',
                    className: 'd-none'
                },
                {
                    extend: 'excel',
                    text: '<i class="fas fa-file-excel"></i> {{ __('Exporter en Excel') }}',
                    className: 'd-none'
                },
                {
                    extend: 'pdf',
                    text: '<i class="fas fa-file-pdf"></i> {{ __('Exporter en PDF') }}',
                    className: 'd-none'
                }
            ]
        });

        $('#printButton').on('click', function() {
            table.button('.buttons-print').trigger();
        });

        $('#excelButton').on('click', function() {
            table.button('.buttons-excel').trigger();
        });

        $('#pdfButton').on('click', function() {
            table.button('.buttons-pdf').trigger();
        });
    });
</script>
<script>
    function showReclamationDetails(id) {
        $.ajax({
            url: '/admin/reclamations/' + id,  // Assurez-vous que cette route pointe vers le contrôleur correct
            method: 'GET',
            success: function(response) {
                $('#reclamationDetailsContent').html(response); // Charger le contenu dans la modale
                $('#reclamationModal').modal('show'); // Afficher la modale
            },
            error: function(xhr) {
                console.error("Erreur lors du chargement des détails de la réclamation :", xhr);
                Swal.fire({
                    title: '{{ __('Erreur!') }}',
                    text: '{{ __('Impossible de charger les détails de la réclamation.') }}',
                    icon: 'error',
                    confirmButtonText: '{{ __('OK') }}'
                });
            }
        });
    }
</script>
@endpush
