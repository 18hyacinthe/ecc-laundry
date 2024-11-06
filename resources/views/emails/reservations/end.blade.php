@component('mail::message')
# Bonjour {{ $userName }},

Votre réservation pour la machine **{{ $machineName }}** est maintenant terminée.

**Heure de fin :** {{ $endTime }}

Merci d'utiliser notre service.

@component('mail::button', ['url' => route('user.reservation.index')])
Voir mes réservations
@endcomponent

Cordialement,  
{{ config('app.name') }}
@endcomponent
