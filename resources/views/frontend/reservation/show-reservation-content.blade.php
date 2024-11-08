<table class="table table-striped">
    <tr>
        <th>Utilisateur :</th>
        <td>{{ $reservation->user->name ?? 'N/A' }}</td>
    </tr>
    <tr>
        <th>Machine :</th>
        <td>{{ $reservation->machine->name ?? 'N/A' }}</td>
    </tr>
    <tr>
        <th>Heure de début :</th>
        <td>{{ $reservation->start_time ? $reservation->start_time->format('d/m/Y H:i') : 'N/A' }}</td>
    </tr>
    <tr>
        <th>Heure de fin :</th>
        <td>{{ $reservation->end_time ? $reservation->end_time->format('d/m/Y H:i') : 'N/A' }}</td>
    </tr>
    <tr>
        <th>Notification de début :</th>
        <td>{{ $reservation->notified_start ? 'Oui' : 'Non' }}</td>
    </tr>
    <tr>
        <th>Notification de fin :</th>
        <td>{{ $reservation->notified_end ? 'Oui' : 'Non' }}</td>
    </tr>
    <tr>
        <th>Sessions hebdomadaires restantes :</th>
        <td>{{ $reservation->weekly_session_limit_remaining }}</td>
    </tr>
    <tr>
        <th>Date de Création :</th>
        <td>{{ $reservation->created_at->format('d/m/Y H:i') }}</td>
    </tr>
</table>