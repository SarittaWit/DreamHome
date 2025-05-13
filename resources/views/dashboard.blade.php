@extends('layouts.app')

@section('page-title', 'Tableau de bord')

@section('content')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<!-- كروت الإحصائيات -->
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-6">
    <div class="bg-white p-6 rounded-lg shadow">
        <div class="flex items-center">
            <div class="p-3 rounded-full bg-blue-100 text-blue-600">
                <i class="fas fa-users text-xl"></i>
            </div>
            <div class="ml-4">
                <h3 class="text-sm font-medium text-gray-500">Utilisateurs</h3>
                <p class="text-2xl font-bold text-gray-900">{{ $usersCount }}</p>
            </div>
        </div>
    </div>

    <div class="bg-white p-6 rounded-lg shadow">
        <div class="flex items-center">
            <div class="p-3 rounded-full bg-green-100 text-green-600">
                <i class="fas fa-user-tie text-xl"></i>
            </div>
            <div class="ml-4">
                <h3 class="text-sm font-medium text-gray-500">Agents</h3>
                <p class="text-2xl font-bold text-gray-900">{{ $agentsCount }}</p>
            </div>
        </div>
    </div>

    <div class="bg-white p-6 rounded-lg shadow">
        <div class="flex items-center">
            <div class="p-3 rounded-full bg-purple-100 text-purple-600">
                <i class="fas fa-home text-xl"></i>
            </div>
            <div class="ml-4">
                <h3 class="text-sm font-medium text-gray-500">Propriétés</h3>
                <p class="text-2xl font-bold text-gray-900">{{ $propertiesCount }}</p>
            </div>
        </div>
    </div>

    <div class="bg-white p-6 rounded-lg shadow">
        <div class="flex items-center">
            <div class="p-3 rounded-full bg-yellow-100 text-yellow-600">
                <i class="fas fa-chart-line text-xl"></i>
            </div>
            <div class="ml-4">
                <h3 class="text-sm font-medium text-gray-500">Ventes (vendues)</h3>
                <p class="text-2xl font-bold text-gray-900">{{ $soldCount }}</p>
            </div>
        </div>
    </div>
</div>

<!-- الرسوم البيانية جنب بعض -->
<div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
    <div class="bg-white p-6 rounded shadow">
        <h2 class="text-lg font-semibold mb-4 text-gray-800">Répartition des propriétés</h2>
        <canvas id="propertyChart" height="200"></canvas>
        <script>
            const ctx = document.getElementById('propertyChart').getContext('2d');
            new Chart(ctx, {
                type: 'pie',
                data: {
                    labels: ['Disponibles', 'Vendues'],
                    datasets: [{
                        data: [{{ $availableCount }}, {{ $soldCount }}],
                        backgroundColor: ['#10B981', '#EF4444'],
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    plugins: { legend: { position: 'bottom' } }
                }
            });
        </script>
    </div>

    <div class="bg-white p-6 rounded shadow">
        <h2 class="text-lg font-semibold mb-4 text-gray-800">Propriétés ajoutées par mois</h2>
        <canvas id="monthlyChart" height="200"></canvas>
        <script>
            const monthlyCtx = document.getElementById('monthlyChart').getContext('2d');
            new Chart(monthlyCtx, {
                type: 'bar',
                data: {
                    labels: {!! json_encode($months) !!},
                    datasets: [{
                        label: 'Nombre de propriétés',
                        data: {!! json_encode($propertyCounts) !!},
                        backgroundColor: '#3B82F6'
                    }]
                },
                options: {
                    responsive: true,
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: { stepSize: 1 }
                        }
                    }
                }
            });
        </script>
    </div>
</div>

<!-- ✅ الأنشطة الأخيرة -->
<div class="bg-white shadow rounded-lg p-6 mb-6">
    <div class="flex justify-between items-center mb-4">
        <h2 class="text-lg font-medium text-gray-900">Activités récentes</h2>
    </div>
    <div class="space-y-4">
        @foreach($recentAgents as $agent)
            <div class="flex items-start">
                <div class="h-10 w-10 rounded-full bg-blue-100 flex items-center justify-center text-blue-600">
                    <i class="fas fa-user-plus"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-900">Nouvel agent enregistré</p>
                    <p class="text-sm text-gray-500">{{ $agent->name }} a créé un compte agent</p>
                    <p class="text-xs text-gray-400 mt-1">{{ $agent->created_at->diffForHumans() }}</p>
                </div>
            </div>
        @endforeach
    </div>
</div>

<!-- ✅ العقارات الأخيرة -->
<div class="bg-white shadow rounded-lg p-6">
    <div class="flex justify-between items-center mb-4">
        <h2 class="text-lg font-medium text-gray-900">Dernières propriétés ajoutées</h2>
    </div>
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @foreach($latestProperties as $property)
            <div class="property-card bg-white rounded-lg overflow-hidden shadow-md">
                <div class="relative">
                    <img class="w-full h-48 object-cover" src="{{ asset('storage/' . $property->image) }}" alt="{{ $property->title }}">
                    @if($property->status == 'vendu')
                        <div class="absolute top-2 right-2 bg-green-600 text-white text-xs font-bold px-2 py-1 rounded">Vendu</div>
                    @else
                        <div class="absolute top-2 right-2 bg-blue-600 text-white text-xs font-bold px-2 py-1 rounded">Nouveau</div>
                    @endif
                </div>
                <div class="p-4">
                    <div class="flex justify-between items-start">
                        <div>
                            <h3 class="text-lg font-bold text-gray-900">{{ $property->title }}</h3>
                            <p class="text-gray-500 text-sm"><i class="fas fa-map-marker-alt text-blue-600 mr-1"></i> {{ $property->location }}</p>
                        </div>
                        <div class="text-blue-600 font-bold text-xl">{{ number_format($property->price, 0, ',', ' ') }} DH</div>
                    </div>
                    <div class="mt-4 pt-4 border-t border-gray-100 flex justify-between items-center">
                        <span class="text-sm text-gray-500">Ajouté par {{ $property->user->name ?? 'Inconnu' }}</span>
                        <div>
                            <a href="{{ route('properties.edit', $property) }}" class="text-blue-600 hover:text-blue-800 text-sm font-medium mr-2">
                                <i class="fas fa-edit"></i>
                            </a>
                            <form action="{{ route('properties.destroy', $property) }}" method="POST" class="inline">
                                @csrf @method('DELETE')
                                <button type="submit" class="text-red-600 hover:text-red-800 text-sm font-medium">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>
@endsection
