<table class="table table-striped">
    <tr>
        <th>{{ __('Titre') }} :</th>
        <td>{{ $reclamation->title }}</td>
    </tr>
    <tr>
        <th>{{ __('Machine') }} :</th>
        <td>{{ $reclamation->machine->name ?? 'N/A' }}</td>
    </tr>
    <tr>
        <th>{{ __('Type de Machine') }} :</th>
        <td>{{ ucfirst($reclamation->machine_type) }}</td>
    </tr>
    <tr>
        <th>{{ __('Type de Problème') }} :</th>
        <td>{{ $reclamation->issue_type }}</td>
    </tr>
    <tr>
        <th>{{ __('Description') }} :</th>
        <td>{{ $reclamation->description }}</td>
    </tr>
    <tr>
        <th>{{ __('Statut') }} :</th>
        <td>
            @if($reclamation->status === 'Important')
                <span class="badge badge-success">{{ __('Important') }}</span>
            @elseif($reclamation->status === 'Urgent')
                <span class="badge badge-warning">{{ __('Urgent') }}</span>
            @else
                <span class="badge badge-danger">{{ __('Très Urgent') }}</span>
            @endif
        </td>
    </tr>
    <tr>
        <th>{{ __('Date de Création') }} :</th>
        <td>{{ $reclamation->created_at->format('d/m/Y H:i') }}</td>
    </tr>
</table>
