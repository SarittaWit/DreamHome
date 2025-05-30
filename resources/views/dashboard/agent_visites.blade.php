<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Demandes de visite | DreamHome</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        .status-pending {
            background-color: #fef3c7;
            color: #92400e;
        }
        .status-confirmed {
            background-color: #d1fae5;
            color: #065f46;
        }
        .status-cancelled {
            background-color: #fee2e2;
            color: #991b1b;
        }
        .status-completed {
            background-color: #dbeafe;
            color: #1e40af;
        }
        .property-card {
            transition: all 0.3s ease;
        }
        .property-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
        }
    </style>
</head>
<body class="bg-gray-100">
    <div class="flex h-screen">
        <!-- Sidebar (identique à agent_dashboard.blade.php) -->
        <div class="sidebar w-64 bg-gray-800 text-white fixed h-full">
            <div class="p-4 flex items-center justify-between border-b border-gray-700">
                <div class="flex items-center space-x-2">
                    <i class="fas fa-home text-blue-400 text-xl"></i>
                    <span class="text-xl font-bold">DreamHome</span>
                </div>
                <button id="sidebarToggle" class="text-gray-400 hover:text-white">
                    <i class="fas fa-bars"></i>
                </button>
            </div>
            <div class="p-4 border-b border-gray-700">
                <div class="flex items-center space-x-4">
                    <div>
                        <h4 class="font-semibold">{{ auth('agent')->user()->name ?? 'Agent' }}</h4>
                        <p class="text-gray-400 text-sm">Agent immobilier</p>
                    </div>
                </div>
            </div>
            <nav class="mt-4">
                <div>
                    <a href="{{ route('agent.dashboard') }}" class="flex items-center px-4 py-3 text-sm font-medium text-gray-300 hover:text-white hover:bg-gray-700">
                        <i class="fas fa-tachometer-alt mr-3"></i>
                        Tableau de bord
                    </a>
                    <a href="{{ route('agent.visites') }}" class="flex items-center px-4 py-3 text-sm font-medium text-white bg-gray-700">
                        <i class="fas fa-calendar-check mr-3 text-blue-400"></i>
                        Demandes de visite
                    </a>

                    <!-- Autres liens du menu -->
                </div>
            </nav>
            <div class="absolute bottom-0 w-full p-4 border-t border-gray-700">
                <form method="POST" action="{{ route('agent.logout') }}">
                    @csrf
                    <button class="flex items-center text-gray-300 hover:text-white text-sm font-medium">
                        <i class="fas fa-sign-out-alt mr-2"></i> Déconnexion
                    </button>
                </form>
            </div>
        </div>

        <!-- Main Content -->
        <div class="flex-1 ml-64">
            <!-- Top Navigation -->
            <header class="bg-white shadow">
                <div class="px-6 py-4 flex justify-between items-center">
                    <h1 class="text-2xl font-bold text-gray-800">Demandes de visite</h1>
                </div>
            </header>

            <!-- Main Content Area -->
            <main class="p-6">
                <div class="bg-white shadow rounded-lg p-6 mb-6">
                    <div class="flex justify-between items-center mb-6">
                        <h2 class="text-lg font-medium text-gray-900">Toutes les demandes de visite</h2>
                        <div class="flex space-x-4">
                            <form method="GET" action="{{ route('agent.visites') }}" class="flex items-center">
                                <select name="status" onchange="this.form.submit()"
                                    class="border border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500 text-sm py-2 px-3">
                                    <option value="" {{ request('status') == '' ? 'selected' : '' }}>Tous les statuts</option>
                                    <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>En attente</option>
                                    <option value="confirmed" {{ request('status') == 'confirmed' ? 'selected' : '' }}>Confirmées</option>
                                    <option value="cancelled" {{ request('status') == 'cancelled' ? 'selected' : '' }}>Annulées</option>
                                    <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>Terminées</option>
                                </select>
                            </form>
                            <button class="px-4 py-2 border border-gray-300 rounded-md text-sm font-medium text-gray-700 bg-white hover:bg-gray-50">
                                <i class="fas fa-download mr-2"></i> Exporter
                            </button>
                        </div>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Propriété</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Client</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Téléphone</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Statut</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @forelse($visites as $visit)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $visit->id }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        {{ $visit->property->title ?? '---' }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $visit->client_name }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $visit->client_phone }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        {{ \Carbon\Carbon::parse($visit->scheduled_date)->format('d/m/Y H:i') }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm">
                                        <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium
                                            @if($visit->status === 'pending') status-pending
                                            @elseif($visit->status === 'confirmed') status-confirmed
                                            @elseif($visit->status === 'cancelled') status-cancelled
                                            @else status-completed @endif">
                                            {{ ucfirst($visit->status) }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 space-x-2">
                                        @if($visit->status === 'pending')
                                            <form action="{{ route('agent.visites.confirmer', $visit->id) }}" method="POST" class="inline">
                                                @csrf
                                                <button type="submit" class="text-green-600 hover:text-green-800">
                                                    <i class="fas fa-check-circle"></i> Confirmer
                                                </button>
                                            </form>
                                            <form action="{{ route('agent.visites.annuler', $visit->id) }}" method="POST" class="inline">
                                                @csrf
                                                <button type="submit" class="text-red-600 hover:text-red-800 ml-2">
                                                    <i class="fas fa-times-circle"></i> Annuler
                                                </button>
                                            </form>
                                        @else
                                            <span class="text-gray-400 italic">Aucune action</span>
                                        @endif
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="7" class="px-6 py-4 text-center text-sm text-gray-500">
                                        Aucune demande de visite trouvée
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </main>
        </div>
    </div>

    <script>
        // Scripts pour gérer le sidebar (identique à agent_dashboard.blade.php)
        document.addEventListener('DOMContentLoaded', function() {
            // Sidebar toggle
            const sidebarToggle = document.getElementById('sidebarToggle');
            const sidebar = document.querySelector('.sidebar');

            if (sidebarToggle && sidebar) {
                sidebarToggle.addEventListener('click', function() {
                    sidebar.classList.toggle('-ml-64');
                });
            }
        });
    </script>
</body>
</html>
