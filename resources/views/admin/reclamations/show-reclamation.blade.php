<!-- Modale pour afficher les détails de la réclamation -->
<div class="modal fade" id="reclamationModal" tabindex="-1" aria-labelledby="reclamationModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="reclamationModalLabel" style="color: #0c9683;">{{ __('Détails de la Réclamation') }}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <!-- Contenu de la modale pour les détails de la réclamation -->
                <div id="reclamationDetailsContent">
                    <!-- Détails chargés via AJAX ici -->
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" data-bs-dismiss="modal">{{ __('Fermer') }}</button>
            </div>
        </div>
    </div>
</div>

