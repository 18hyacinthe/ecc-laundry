<!-- Modale pour afficher les détails de la réclamation -->
<div class="modal fade" id="reclamationModal" tabindex="-1" aria-labelledby="reclamationModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header text-white" style="background-color: #0c9683">
                <h5 class="modal-title" id="reclamationModalLabel">{{ __('Détails de la Réclamation') }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <!-- Contenu de la modale pour les détails de la réclamation -->
                <div id="reclamationDetailsContent" class="p-3">
                    <!-- Détails chargés via AJAX ici -->
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" data-bs-dismiss="modal">{{ __('Fermer') }}</button>
            </div>
        </div>
    </div>
</div>
