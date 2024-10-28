@extends('admin.dashboard.page')
@section('content')
    <!-- Begin Page Content -->
    <div class="container-fluid">
            <div class="card-body">
                <div class="table-responsive">

                    <div class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <div class="card">
                            <div class="card-header d-flex justify-content-between">
                                <h3 class="card-title text-primary">{{ __('Gestion des utilisateurs') }}</h3>
                                <a href="{{ route('admin.users.create') }}" class="btn btn-primary">
                                    <i class="fas fa-plus"></i> {{ __('Créer') }}
                                </a>
                            </div>
                            <div class="card-body p-3">
                                {{ $dataTable->table() }}
                            </div>
                        </div>
                    </div>
        
                </div>
            </div>
    </div>
    <!-- /.container-fluid -->
@endsection
@push('scripts')
    {{ $dataTable->scripts(attributes: ['type' => 'module']) }}

    <script>
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
                    // Envoyer la requête AJAX pour supprimer le slider
                    $.ajax({
                        url: document.getElementById('delete-form-' + id).action, // URL de l'action du formulaire
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
                                    // Rafraîchir le tableau après suppression
                                    location.reload();
                                    // $('#slider-table').DataTable().ajax.reload();
                                });
                            }else {
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