<!DOCTYPE html>
<html>
<head>
    <title>Réservation mise à jour</title>
</head>
<body>
    <p>Bonjour {{ $reservation->user->name }},</p>
    <p>Votre réservation pour la machine {{ $reservation->machine->name }} a été mise à jour.</p>
    <p>Voici les nouvelles informations de votre réservation :</p>
    <ul>
        <li>Machine: {{ $reservation->machine->name }}</li>
        <li>Heure de début: {{ $reservation->start_time }}</li>
        <li>Heure de fin: {{ $reservation->end_time }}</li>
    </ul>
    <p>Pour plus d'informations, veuillez contacter l'administrateur à l'adresse suivante : {{ env('MAIL_USERNAME') }}.</p>
    <p>Cordialement,</p>
    <p>{{ config('app.name') }}</p>
</body>
</html>