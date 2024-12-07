<!DOCTYPE html>
<html>
<head>
    <title>Réservation annulée</title>
</head>
<body>
    <p>Bonjour {{ $reservation->user->name }},</p>
    <p>Votre réservation pour la machine {{ $reservation->machine->name }} a été annulée.</p>
    <p>Pour plus d'informations, veuillez contacter l'administrateur à l'adresse suivante : {{ env('MAIL_USERNAME') }}.</p>
    <p>Cordialement,</p>
    <p>{{ config('app.name') }}</p>
</body>
</html>