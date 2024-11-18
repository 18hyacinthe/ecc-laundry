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
                            <th>{{ __('Actions') }}</th>
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
@include('frontend.reservation.show-reservation')
@endsection

@push('scripts')
<script type="module">
    $(function() {
        let lang = '{{ app()->getLocale() }}'; // Récupère la langue actuelle de l'utilisateur
        let langUrl = `{{ asset('i18n/${lang}.json') }}`; // Récupère le fichier de langue correspondant // Récupère le fichier de langue correspondant
        $('#historique-reservation-table').DataTable({
            processing: true,
            serverSide: true,
            responsive: true,
            ajax: '{{ route('user.reservation.index') }}',
            columns: [
                { data: 'created_at', name: 'created_at', className: 'text-center' },
                { data: 'start_time', name: 'start_time', className: 'text-center' },
                { data: 'end_time', name: 'end_time', className: 'text-center' },
                { data: 'machine_id', name: 'machine_id', className: 'text-center' },
                { data: 'action', name: 'action', orderable: false, searchable: false, className: 'text-center', width: '200px' }
            ],
            order: [[0, 'desc']],
            language: {
                url: langUrl
            },
            rowReorder: {
                selector: 'td:nth-child(2)'
            }
        });
    });
</script>
<script>
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    function showReservationDetails(hashedId) {
        $.ajax({
            url: '/user/reservations/' + hashedId,
            method: 'GET',
            success: function(response) {
                $('#reservationDetailsContent').html(response);
                $('#reservationModal').modal('show');
            },
            error: function(xhr) {
                console.error("Erreur lors du chargement des détails de la réservation :", xhr);
                Swal.fire({
                    title: '{{ __('Erreur!') }}',
                    text: '{{ __('Impossible de charger les détails de la réservation.') }}',
                    icon: 'error',
                    confirmButtonText: '{{ __('OK') }}'
                });
            }
        });
    }

    function deleteReservation(hashedId) {
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
                    url: document.getElementById('delete-form-' + hashedId).action,
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
