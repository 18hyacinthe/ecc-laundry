<!-- Modale pour afficher les détails de la réclamation -->
<div class="modal fade" id="reclamationModal" tabindex="-1" aria-labelledby="reclamationModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header text-white" style="background-color: #0c9683">
                <h5 class="modal-title" id="reclamationModalLabel">{{ __('Détails de la Réclamation') }}</h5>
                <button type="button" class="close text-white" data-bs-dismiss="modal" aria-label="{{ __('Fermer') }}">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <!-- Contenu de la modale pour les détails de la réclamation -->
                <div id="reclamationDetailsContent" class="p-3">
                    <!-- Détails chargés via AJAX ici -->
                    <div class="spinner-border text-primary" role="status" id="loadingSpinner">
                        <span class="sr-only">{{ __('Chargement...') }}</span>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" data-bs-dismiss="modal">{{ __('Fermer') }}</button>
            </div>
        </div>
    </div>
</div>

<style>
    .modal-header {
        background-color: #0c9683;
    }
    .modal-title {
        color: #fff;
    }
    .close {
        color: #fff;
    }
    .modal-body {
        background-color: #f8f9fa;
    }
    .modal-footer {
        background-color: #f1f1f1;
    }
    #reclamationDetailsContent {
        min-height: 200px;
    }
    #loadingSpinner {
        display: none;
    }
</style>

<script>
    $(document).ready(function() {
        $('#reclamationModal').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget);
            var reclamationId = button.data('id');
            var modal = $(this);
            modal.find('#loadingSpinner').show();
            $.ajax({
                url: '/reclamation/' + reclamationId,
                method: 'GET',
                success: function(data) {
                    modal.find('#reclamationDetailsContent').html(data);
                    modal.find('#loadingSpinner').hide();
                },
                error: function() {
                    modal.find('#reclamationDetailsContent').html('<p>{{ __('Erreur lors du chargement des détails.') }}</p>');
                    modal.find('#loadingSpinner').hide();
                }
            });
        });
    });
</script>
