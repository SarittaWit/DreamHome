<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Demandes de visite</title>
</head>
<body class="p-6">

    <h1 class="text-2xl font-bold mb-4">Toutes les demandes de visite</h1>

    <form method="GET" action="{{ route('agent.visites') }}" class="mb-4">
        <label for="status">Filtrer par statut:</label>
        <select name="status" onchange="this.form.submit()">
            <option value="">Tous</option>
            <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>En attente</option>
            <option value="confirmed" {{ request('status') == 'confirmed' ? 'selected' : '' }}>Confirmée</option>
            <option value="cancelled" {{ request('status') == 'cancelled' ? 'selected' : '' }}>Annulée</option>
            <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>Terminée</option>
        </select>
    </form>

    <table class="w-full border">
        <thead>
            <tr>
                <th>ID</th>
                <th>Propriété</th>
                <th>Client</th>
                <th>Date</th>
                <th>Statut</th>
            </tr>
        </thead>
        <tbody>
            @forelse($visites as $visit)
                <tr class="border-t">
                    <td class="p-2">{{ $visit->id }}</td>
                    <td>{{ $visit->property->title ?? '---' }}</td>
                    <td>{{ $visit->client_name }} ({{ $visit->client_phone }})</td>
                    <td>{{ \Carbon\Carbon::parse($visit->scheduled_date)->format('d/m/Y') }}</td>
                    <td>{{ ucfirst($visit->status) }}</td>
                </tr>
            @empty
                <tr><td colspan="5" class="p-4 text-center text-gray-500">Aucune demande trouvée.</td></tr>
            @endforelse
        </tbody>
    </table>
</body>
</html>
