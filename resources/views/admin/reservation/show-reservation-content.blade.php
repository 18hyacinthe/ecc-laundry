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
        <th>Status :</th>
        <td>
            <button style="font-weight: bold; color: {{ $reservation->end_time && $reservation->end_time->isPast() ? 'red' : 'green' }};">
                {{ $reservation->end_time && $reservation->end_time->isPast() ? 'Expiré' : 'Réservé' }}
            </button>
        </td>
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