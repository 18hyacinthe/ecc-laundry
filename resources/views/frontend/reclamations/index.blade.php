@extends('frontend.dashboard.page')

@section('content')
<div class="container-fluid">
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h3 class="card-title text-primary">{{ __('Historique des Réclamations') }}</h3>
            <a href="{{ route('user.reclamations.create') }}" class="btn btn-primary">
                <i class="fas fa-plus"></i> {{ __('Soumettre une Réclamation') }}
            </a>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-striped" id="user-reclamation-table" width="100%" cellspacing="0">
                    <thead class="thead-dark">
                        <tr>
                            <th>{{ __('No') }}</th>
                            <th>{{ __('Titre') }}</th>
                            <th>{{ __('Machine') }}</th>
                            <th>{{ __('Type de Machine') }}</th>
                            <th>{{ __('Type de Problème') }}</th>
                            <th>{{ __('Description') }}</th>
                            <th>{{ __('Statut') }}</th>
                            <th>{{ __('Créé à') }}</th>
                            <th>{{ __('Actions') }}</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
</div>
@include('frontend.reclamations.show-reclamation')
@endsection

@push('scripts')
<script type="module">
    $(function() {
        let lang = '{{ app()->getLocale() }}'; // Récupère la langue actuelle de l'utilisateur
        let langUrl = `{{ asset('i18n/${lang}.json') }}`; // Récupère le fichier de langue correspondant
        $('#user-reclamation-table').DataTable({
            processing: true,
            serverSide: true,
            responsive: true,
            ajax: '{{ route('user.reclamations.index') }}',
            columns: [
                { data: 'id', name: 'id', className: 'text-center' },
                { data: 'title', name: 'title', className: 'text-center' },
                { data: 'machine_id', name: 'machine_id', className: 'text-center' },
                { data: 'machine_type', name: 'machine_type', className: 'text-center' },
                { data: 'issue_type', name: 'issue_type', className: 'text-center' },
                { data: 'description', name: 'description', className: 'text-center' },
                { data: 'status', name: 'status', className: 'text-center', orderable: false, searchable: false },
                { data: 'created_at', name: 'created_at', className: 'text-center' },
                { data: 'action', name: 'action', className: 'text-center', orderable: false, searchable: false }
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
<script>
    function showReclamationDetails(id) {
        $.ajax({
            url: '/user/reclamations/' + id,
            method: 'GET',
            success: function(response) {
                $('#reclamationDetailsContent').html(response);
                $('#reclamationModal').modal('show');
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
