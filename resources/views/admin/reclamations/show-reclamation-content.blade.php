<table class="table table-striped">
    <tr>
        <th>Titre :</th>
        <td>{{ $reclamation->title }}</td>
    </tr>
    <tr>
        <th>Machine :</th>
        <td>{{ $reclamation->machine->name ?? 'N/A' }}</td>
    </tr>
    <tr>
        <th>Type de Machine :</th>
        <td>{{ ucfirst($reclamation->machine_type) }}</td>
    </tr>
    <tr>
        <th>Type de Problème :</th>
        <td>{{ $reclamation->issue_type }}</td>
    </tr>
    <tr>
        <th>Description :</th>
        <td>{{ $reclamation->description }}</td>
    </tr>
    <tr>
        <th>Statut :</th>
        <td>
            @if($reclamation->status === 'Important')
                <span class="badge badge-success">Important</span>
            @elseif($reclamation->status === 'Urgent')
                <span class="badge badge-warning">Urgent</span>
            @else
                <span class="badge badge-danger">Très Urgent</span>
            @endif
        </td>
    </tr>
    <tr>
        <th>Utilisateur :</th>
        <td>{{ $reclamation->user->name }}</td>
    <tr>
        <th>Date de Création :</th>
        <td>{{ $reclamation->created_at->format('d/m/Y H:i') }}</td>
    </tr>
</table>
