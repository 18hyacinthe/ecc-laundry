@component('mail::message')
# Bonjour {{ $userName }},

Votre réservation pour la machine **{{ $machineName }}** vient de commencer.

**Heure de début :** {{ $startTime }}

Merci d'utiliser notre service.

@component('mail::button', ['url' => route('user.reservation.index')])
Voir mes réservations
@endcomponent

Cordialement,  
{{ config('app.name') }}
@endcomponent
