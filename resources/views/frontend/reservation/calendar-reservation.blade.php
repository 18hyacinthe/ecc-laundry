@extends('frontend.dashboard.page-sans-footer')

@section('content')
<!-- Légende des Machines -->
<div id="legend" style="margin: 20px auto; max-width: 800px; text-align: center;">
    {{-- <h2 style="margin-bottom: 20px; color: #0c9683;">{{ __('Légende des Machines') }}</h2> --}}

    <!-- Barre de recherche pour les machines -->
    <input type="text" id="searchInput" placeholder="Rechercher une machine..." 
           style="width: 80%; padding: 8px; margin-bottom: 20px; border: 1px solid #ddd; border-radius: 4px;" 
           onkeyup="filterMachines()">

    <table style="width: 100%; border-collapse: collapse; margin-bottom: 20px; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); border-radius: 8px;">
        <thead>
            <tr>
                <th style="background-color: #0c9683; color: white; padding: 10px; border: 1px solid #ddd;">{{ __('Machines à laver') }}</th>
                <th style="background-color: #0c9683; color: white; padding: 10px; border: 1px solid #ddd;">{{ __('Sèche-linge') }}</th>
            </tr>
        </thead>
        <tbody id="machineTable">
            <tr>
                <td style="vertical-align: top; padding: 10px; border: 1px solid #ddd;">
                    <div style="display: flex; flex-wrap: wrap; gap: 10px;">
                        @foreach ($machines->where('type', 'washing-machine') as $machine)
                            <div class="machine-item" style="display: flex; align-items: center; margin: 5px; transition: transform 0.2s;" onclick="showMachineDetails({{ $machine->id }})">
                                <span style="background-color: {{ $machine->color ?? '#3a04cc' }}; color: white; padding: 5px 10px; border-radius: 4px;">{{ $machine->name }}</span>
                                <i class="fas fa-tshirt" style="color: {{ $machine->color ?? '#3a04cc' }}; margin-left: 8px;"></i>
                            </div>
                        @endforeach
                    </div>
                </td>
                <td style="vertical-align: top; padding: 10px; border: 1px solid #ddd;">
                    <div style="display: flex; flex-wrap: wrap; gap: 10px;">
                        @foreach ($machines->where('type', 'dryer') as $machine)
                            <div class="machine-item" style="display: flex; align-items: center; margin: 5px; transition: transform 0.2s;" onclick="showMachineDetails({{ $machine->id }})">
                                <span style="background-color: {{ $machine->color ?? '#05ad21' }}; color: white; padding: 5px 10px; border-radius: 4px;">{{ $machine->name }}</span>
                                <i class="fas fa-wind" style="color: {{ $machine->color ?? '#05ad21' }}; margin-left: 8px;"></i>
                            </div>
                        @endforeach
                    </div>
                </td>
            </tr>
        </tbody>        
    </table>

    <!-- Bouton Réserver en bas à droite de la légende avec effet d'animation -->
    <div style="text-align: right; margin-top: 10px;">
        <a href="{{ route('user.showReservationForm') }}" class="reserve-button" style="display: inline-block; transition: transform 0.3s;">
            {{ __('Réserver') }}
        </a>
    </div>
</div>
<hr>
<!-- Calendrier -->
<div id="calendar"></div>


<!-- Modale de Détails de la Réservation -->
<div id="eventModal" style="display: none; position: fixed; top: 20%; left: 50%; transform: translate(-50%, -20%); padding: 30px; background-color: #fff; border-radius: 10px; z-index: 1000; box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1); max-width: 500px; width: 100%; border: 1px solid #ddd;">
    <!-- Titre de la modale -->
    <h3 style="margin-bottom: 20px; color: #333; text-align: center; font-family: 'Roboto', sans-serif; font-size: 22px; font-weight: 600;">
        <i class="fas fa-calendar-check" style="color: #0c9683; margin-right: 10px;"></i>{{ __('Détails de la Réservation') }}
    </h3>
    
    <!-- Contenu de la modale -->
    <div style="font-family: 'Roboto', sans-serif;">
        <!-- Ligne de détails utilisateur -->
        <div style="display: flex; align-items: center; margin-bottom: 15px;">
            <i class="fas fa-user" style="color: #0c9683; font-size: 20px; margin-right: 15px;"></i>
            <p style="margin: 0; font-size: 16px;"><strong>{{ __('Nom de l\'utilisateur') }} :</strong> <span id="modalUserName" style="color: #333;"></span></p>
        </div>

        <!-- Ligne de téléphone -->
        <div style="display: flex; align-items: center; margin-bottom: 15px;">
            <i class="fas fa-phone" style="color: #0c9683; font-size: 20px; margin-right: 15px;"></i>
            <p style="margin: 0; font-size: 16px;"><strong>{{ __('Téléphone') }} :</strong> <span id="modalUserPhone" style="color: #333;"></span></p>
        </div>

        <!-- Ligne d'email -->
        <div style="display: flex; align-items: center; margin-bottom: 15px;">
            <i class="fas fa-envelope" style="color: #0c9683; font-size: 20px; margin-right: 15px;"></i>
            <p style="margin: 0; font-size: 16px;"><strong>{{ __('Email') }} :</strong> <span id="modalUserEmail" style="color: #333;"></span></p>
        </div>

        <!-- Ligne de machine -->
        <div style="display: flex; align-items: center; margin-bottom: 15px;">
            <i class="fas fa-cogs" style="color: #0c9683; font-size: 20px; margin-right: 15px;"></i>
            <p style="margin: 0; font-size: 16px;"><strong>{{ __('Nom de la machine') }} :</strong> <span id="modalMachineName" style="color: #333;"></span></p>
        </div>

        <!-- Ligne de l'heure de début -->
        <div style="display: flex; align-items: center; margin-bottom: 15px;">
            <i class="fas fa-clock" style="color: #0c9683; font-size: 20px; margin-right: 15px;"></i>
            <p style="margin: 0; font-size: 16px;"><strong>{{ __('Heure de début') }} :</strong> <span id="modalStartTime" style="color: #333;"></span></p>
        </div>

        <!-- Ligne de l'heure de fin -->
        <div style="display: flex; align-items: center; margin-bottom: 15px;">
            <i class="fas fa-clock" style="color: #0c9683; font-size: 20px; margin-right: 15px;"></i>
            <p style="margin: 0; font-size: 16px;"><strong>{{ __('Heure de fin') }} :</strong> <span id="modalEndTime" style="color: #333;"></span></p>
        </div>

        {{-- <!-- Ligne de statut -->
        <div style="display: flex; align-items: center; margin-bottom: 20px;">
            <i class="fas fa-info-circle" style="color: #0c9683; font-size: 20px; margin-right: 15px;"></i>
            <p style="margin: 0; font-size: 16px;"><strong>{{ __('Statut') }} :</strong> <span id="modalMachineStatus" style="color: #333;"></span></p>
        </div> --}}

        <!-- Bouton de fermeture -->
        <div style="text-align: center;">
            <button onclick="document.getElementById('eventModal').style.display = 'none';" 
                    style="background-color: #0c9683; color: white; padding: 12px 25px; border: none; border-radius: 5px; font-size: 16px; cursor: pointer; transition: background-color 0.3s;">
                <i class="fas fa-times" style="margin-right: 10px;"></i>{{ __('Fermer') }}
            </button>
        </div>
    </div>
</div>

<!-- Vue modale pour les détails de la machine -->
<div class="modal fade" id="machineDetailsModal" tabindex="-1" aria-labelledby="machineDetailsModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="machineDetailsModalLabel" style="color: #0c9683;">{{ __('Détails de la Machine') }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" id="machineDetailsContent">
                <!-- Les détails de la machine seront chargés ici via AJAX -->
                <p>{{ __('Pour en savoir plus, consultez le calendrier.') }}</p>
            </div>
        </div>
    </div>
</div>

{{--  Styles --}}
<style>
/* Styles supplémentaires */
.reserve-button {
    background-color: #0c9683; color: white; padding: 10px 20px; border-radius: 5px; text-decoration: none;
    transition: background-color 0.3s, transform 0.3s;
}
.reserve-button:hover {
    background-color: #088675; transform: translateY(-2px);
}

/* Modale avec animation */
.modal {
    display: none; position: fixed; top: 20%; left: 50%; transform: translate(-50%, -20%);
    background-color: white; border: 1px solid #ccc; border-radius: 10px; z-index: 1000; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    width: 80%; max-width: 500px; padding: 20px; animation-duration: 0.3s;
}
.modal-fade-in {
    animation: fadeIn 0.3s;
}
.modal-fade-out {
    animation: fadeOut 0.3s;
}
@keyframes fadeIn { from { opacity: 0; } to { opacity: 1; } }
@keyframes fadeOut { from { opacity: 1; } to { opacity: 0; } }
.close-button {
    background-color: #0c9683; color: white; padding: 10px 20px; border: none; border-radius: 5px; cursor: pointer;
}
.close-button:hover {
    background-color: #088675;
}
</style>
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
            initialView: 'timeGridDay',
            slotMinTime: '00:00:00',
            slotMaxTime: '23:59:59',
            locale: 'fr',  // Définit le calendrier en français
            events: @json($events),
            eventClick: function(info) {
                var event = info.event;
                var extendedProps = event.extendedProps;

                // Mettre à jour les éléments de la modale seulement s'ils existent
                if (document.getElementById('modalUserName')) {
                    document.getElementById('modalUserName').innerText = extendedProps.user_name;
                }
                if (document.getElementById('modalUserPhone')) {
                    document.getElementById('modalUserPhone').innerText = extendedProps.user_phone;
                }
                if (document.getElementById('modalUserEmail')) {
                    document.getElementById('modalUserEmail').innerText = extendedProps.user_email;
                }
                if (document.getElementById('modalMachineName')) {
                    document.getElementById('modalMachineName').innerText = extendedProps.machine_name;
                }
                if (document.getElementById('modalStartTime')) {
                    document.getElementById('modalStartTime').innerText = event.start.toLocaleTimeString('fr-FR', { hour: '2-digit', minute: '2-digit' });
                }
                if (document.getElementById('modalEndTime')) {
                    document.getElementById('modalEndTime').innerText = event.end.toLocaleTimeString('fr-FR', { hour: '2-digit', minute: '2-digit' });
                }
                if (document.getElementById('modalMachineStatus')) {
                    document.getElementById('modalMachineStatus').innerText = extendedProps.machine_status;
                }

                // Ouvrir la modale
                openModal();
            }

        });

        calendar.render();
    });
</script>
<script>
    // Filtrage des machines
    function filterMachines() {
        const input = document.getElementById("searchInput");
        const filter = input.value.toLowerCase();
        const machines = document.querySelectorAll(".machine-item");
        machines.forEach(machine => {
            const machineName = machine.innerText.toLowerCase();
            machine.style.display = machineName.includes(filter) ? "" : "none";
        });
    }
    
    // Effet de survol sur les machines
    document.querySelectorAll('.machine-item').forEach(item => {
        item.addEventListener('mouseenter', () => {
            item.style.transform = 'scale(1.05)';
        });
        item.addEventListener('mouseleave', () => {
            item.style.transform = 'scale(1)';
        });
    });
    
    // Modale avec animation d'ouverture et de fermeture
    function openModal() {
        const modal = document.getElementById('eventModal');
        modal.style.display = 'block';
        modal.classList.add('modal-fade-in');
    }
    
    function closeModal() {
        const modal = document.getElementById('eventModal');
        modal.classList.remove('modal-fade-in');
        modal.classList.add('modal-fade-out');
        setTimeout(() => { modal.style.display = 'none'; modal.classList.remove('modal-fade-out'); }, 300);
    }
</script>
<script>
    function showMachineDetails(machineId) {
        // Charger les détails de la machine via AJAX
        fetch(`/user/calendar/machines/${machineId}/details`)
            .then(response => response.text())
            .then(data => {
                // Mettre à jour le contenu du modal avec les détails de la machine
                document.getElementById('machineDetailsContent').innerHTML = data;
                // Afficher le modal
                $('#machineDetailsModal').modal('show');
            })
            .catch(error => {
                console.error('Erreur lors du chargement des détails de la machine:', error);
            });
    }

    function showMachines(type) {
        document.querySelectorAll('.machine-group').forEach(group => group.classList.add('d-none'));
        document.getElementById(type === 'washing' ? 'washing-machines' : 'dryer-machines').classList.remove('d-none');
        document.querySelectorAll('.btn-group .btn').forEach(btn => btn.classList.remove('active'));
        event.target.classList.add('active');
    }
</script>
@endpush
