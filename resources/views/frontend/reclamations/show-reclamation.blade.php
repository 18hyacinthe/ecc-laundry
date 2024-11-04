@extends('frontend.dashboard.page')

@section('content')
<div class="modal fade" id="showReclamationModal" tabindex="-1" role="dialog" aria-labelledby="showReclamationModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="showReclamationModalLabel">Détails de la Réclamation</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <!-- Le contenu de la réclamation sera chargé ici avec AJAX -->
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Fermer</button>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    // Ouvrir la modale de réclamation lorsque l'on clique sur le bouton "Voir" dans la table
    $(document).on('click', '.btn-view-reclamation', function (e) {
        e.preventDefault();
        let reclamationId = $(this).data('id');

        // Requête AJAX pour charger les détails de la réclamation
        $.ajax({
            url: '/reclamations/' + reclamationId,
            type: 'GET',
            success: function (data) {
                // Injecter les données de réclamation dans la modale
                $('#showReclamationModal .modal-body').html(data);
                $('#showReclamationModal').modal('show');
            },
            error: function () {
                alert('Erreur lors du chargement des détails de la réclamation.');
            }
        });
    });
</script>
@endpush
