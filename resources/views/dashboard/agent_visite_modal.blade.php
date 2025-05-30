<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Détails de la visite</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    @vite(['resources/css/app.css', 'resources/js/app.js']) {{-- si tu utilises Vite --}}
</head>
<body class="bg-gray-100">

    {{-- Inclure le même sidebar ou header si nécessaire --}}

    {{-- Le modal qui s'affiche directement --}}
    <div class="flex items-center justify-center min-h-screen p-6">
        <div class="bg-white rounded-lg shadow-lg p-6 w-full max-w-2xl">
            <h2 class="text-xl font-bold text-gray-800 mb-4">📅 Détails de la visite</h2>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm">
                <div>
                    <h4 class="text-gray-600 font-semibold">Propriété</h4>
                    <p class="text-gray-900">{{ $visit->property->title ?? '---' }}</p>
                </div>
                <div>
                    <h4 class="text-gray-600 font-semibold">Client</h4>
                    <p class="text-gray-900">{{ $visit->client_name }} ({{ $visit->client_phone }})</p>
                </div>
                <div>
                    <h4 class="text-gray-600 font-semibold">Date</h4>
                    <p class="text-gray-900">{{ \Carbon\Carbon::parse($visit->scheduled_date)->format('d/m/Y') }}</p>
                </div>
                <div>
                    <h4 class="text-gray-600 font-semibold">Statut</h4>
                    <span class="px-2 py-1 inline-flex text-xs font-semibold rounded-full bg-blue-100 text-blue-800">
                        {{ ucfirst($visit->status) }}
                    </span>
                </div>
                <div class="md:col-span-2">
                    <h4 class="text-gray-600 font-semibold">Message du client</h4>
                    <p class="text-gray-900">{{ $visit->message ?? 'Aucun message' }}</p>
                </div>
            </div>

            <div class="mt-6 text-right">
                <a href="{{ route('agent.visites') }}"
                   class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 text-sm">
                    Fermer
                </a>
            </div>
        </div>
    </div>

</body>
</html>
