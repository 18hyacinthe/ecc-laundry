@extends('frontend.dashboard.page-sans-footer')

@section('content')
<div id="legend" style="display: flex; justify-content: space-around; margin-bottom: 10px;">
    <div style="display: flex; align-items: center;">
        <span style="background-color: #3a04cc; color: white; padding: 4px; margin-right: 5px;">{{ __('Machine à laver') }}</span>
        <i class="fas fa-tshirt" style="color: #3a04cc;"></i>
    </div>
    <div style="display: flex; align-items: center;">
        <span style="background-color: #05ad21; color: white; padding: 4px; margin-right: 5px;">{{ __('Sèche-linge') }}</span>
        <i class="fas fa-wind" style="color: #05ad21;"></i>
    </div>
</div>

<div id="calendar"></div>

<!-- Modale pour afficher les détails de la réservation -->
<div id="eventModal" style="display: none; position: fixed; top: 20%; left: 50%; transform: translate(-50%, -20%); padding: 20px; background-color: white; border: 1px solid #ccc; border-radius: 10px; z-index: 1000; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);">
    <h3 style="margin-bottom: 20px; color: #333; text-align: center;"><strong>{{ __('Détails de la Réservation') }}</strong></h3>
    <div style="display: flex; align-items: center; margin-bottom: 10px;">
        <i class="fas fa-user" style="color: #0c9683; margin-right: 10px;"></i>
        <p style="margin: 0;"><strong>{{ __('Nom de l\'utilisateur') }} :</strong> <span id="modalUserName"></span></p>
    </div>
    <div style="display: flex; align-items: center; margin-bottom: 10px;">
        <i class="fas fa-phone" style="color: #0c9683; margin-right: 10px;"></i>
        <p style="margin: 0;"><strong>{{ __('Téléphone') }} :</strong> <span id="modalUserPhone"></span></p>
    </div>
    <div style="display: flex; align-items: center; margin-bottom: 10px;">
        <i class="fas fa-envelope" style="color: #0c9683; margin-right: 10px;"></i>
        <p style="margin: 0;"><strong>{{ __('Email') }} :</strong> <span id="modalUserEmail"></span></p>
    </div>
    <div style="display: flex; align-items: center; margin-bottom: 10px;">
        <i class="fas fa-cogs" style="color: #0c9683; margin-right: 10px;"></i>
        <p style="margin: 0;"><strong>{{ __('Nom de la machine') }} :</strong> <span id="modalMachineName"></span></p>
    </div>
    <div style="display: flex; align-items: center; margin-bottom: 10px;">
        <i class="fas fa-clock" style="color: #0c9683; margin-right: 10px;"></i>
        <p style="margin: 0;"><strong>{{ __('Heure de début') }} :</strong> <span id="modalStartTime"></span></p>
    </div>
    <div style="display: flex; align-items: center; margin-bottom: 10px;">
        <i class="fas fa-clock" style="color: #0c9683; margin-right: 10px;"></i>
        <p style="margin: 0;"><strong>{{ __('Heure de fin') }} :</strong> <span id="modalEndTime"></span></p>
    </div>
    <div style="display: flex; align-items: center; margin-bottom: 20px;">
        <i class="fas fa-info-circle" style="color: #0c9683; margin-right: 10px;"></i>
        <p style="margin: 0;"><strong>{{ __('Statut') }} :</strong> <span id="modalMachineStatus"></span></p>
    </div>
    <button onclick="document.getElementById('eventModal').style.display = 'none';" style="background-color: #0c9683; color: white; padding: 10px 20px; border: none; border-radius: 5px; cursor: pointer;">{{ __('Fermer') }}</button>
</div>
@endsection

@push('scripts')
<link href="https://cdn.jsdelivr.net/npm/@fullcalendar/core/main.css" rel="stylesheet" />
<link href="https://cdn.jsdelivr.net/npm/@fullcalendar/daygrid/main.css" rel="stylesheet" />
<link href="https://cdn.jsdelivr.net/npm/@fullcalendar/timegrid/main.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/main.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        var calendarEl = document.getElementById('calendar');
        
        var calendar = new FullCalendar.Calendar(calendarEl, {
            initialView: 'timeGridWeek',
            slotMinTime: '00:00:00',
            slotMaxTime: '23:59:59',
            locale: 'fr',  // Définit le calendrier en français
            events: @json($events),
            eventClick: function(info) {
                // Récupérer les informations de l'événement
                var event = info.event;
                var extendedProps = event.extendedProps;

                // Mettre à jour le contenu de la modale
                document.getElementById('modalUserName').innerText = extendedProps.user_name;
                document.getElementById('modalUserPhone').innerText = extendedProps.user_phone;
                document.getElementById('modalUserEmail').innerText = extendedProps.user_email;
                document.getElementById('modalMachineName').innerText = event.title;
                document.getElementById('modalStartTime').innerText = event.start.toLocaleTimeString('fr-FR', { hour: '2-digit', minute: '2-digit' });
                document.getElementById('modalEndTime').innerText = event.end.toLocaleTimeString('fr-FR', { hour: '2-digit', minute: '2-digit' });
                document.getElementById('modalMachineStatus').innerText = extendedProps.machine_status;

                // Afficher la modale
                document.getElementById('eventModal').style.display = 'block';
            },
        });
        
        calendar.render();
    });
</script>
@endpush
