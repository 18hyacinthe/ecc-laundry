@extends('admin.dashboard.page')
@section('content')
<div class="container-fluid">
    <div class="card shadow-sm">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h3 class="card-title text-primary">{{ __('Gestion des utilisateurs') }}</h3>
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
            <a href="{{ route('admin.users.create') }}" class="btn btn-primary">
                <i class="fas fa-plus"></i> {{ __('Créer') }}
            </a>
        </div>
        <div class="card-body table-responsive">
            <table class="table table-bordered table-striped" id="user-table" width="100%" cellspacing="0">
                <thead class="thead-dark">
                    <tr>
                        <th>No</th>
                        <th>Nom</th>
                        <th>Prénom</th>
                        <th>Email</th>
                        <th>Téléphone</th>
                        <th>Statut</th>
                        <th width="200">Action</th>
                    </tr>
                </thead>
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
        var table = $('#user-table').DataTable({
            processing: true,
            serverSide: true,
            responsive: true,
            ajax: '{{ route('admin.users.index') }}',
            columns: [
                { data: 'id', name: 'id', className: 'text-center' },
                { data: 'name', name: 'name', className: 'text-center' },
                { data: 'surname', name: 'surname', className: 'text-center' },
                { data: 'email', name: 'email', className: 'text-center' },
                { data: 'phone', name: 'phone', className: 'text-center' },
                { data: 'status', name: 'status', className: 'text-center' },
                { data: 'action', name: 'action', orderable: false, searchable: false, className: 'text-center' }
            ],
            order: [[0, 'desc']],
            rowReorder: {
                selector: 'td:nth-child(2)'
            },
            language: {
                url: langUrl
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
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    function deleteUser(id) {
        Swal.fire({
            title: '{{ __('Êtes-vous sûr?') }}',
            text: "{{ __('Vous ne pourrez pas revenir en arrière!') }}",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: '{{ __('Oui, supprimez-le!') }}',
            cancelButtonText: '{{ __('Non, annulez!') }}'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: document.getElementById('delete-form-' + id).action,
                    type: 'POST',
                    data: {
                        _token: "{{ csrf_token() }}",
                        _method: 'DELETE'
                    },
                    success: function(response) {
                        if(response.status === 'success') {
                            Swal.fire({
                                title: '{{ __('Supprimé!') }}',
                                text: response.message,
                                icon: 'success',
                                confirmButtonText: '{{ __('OK') }}'
                            }).then(() => {
                                location.reload();
                            });
                        } else {
                            Swal.fire({
                                title: '{{ __('Impossible de supprimer!') }}',
                                text: response.message,
                                icon: 'error',
                                confirmButtonText: '{{ __('OK') }}'
                            });
                        }
                    },
                    error: function(xhr) {
                        Swal.fire({
                            title: '{{ __('Erreur!') }}',
                            text: '{{ __('Quelque chose a mal tourné!') }}',
                            icon: 'error',
                            confirmButtonText: '{{ __('OK') }}'
                        });
                    }
                });
            }
        });
    }
</script>
@endpush
