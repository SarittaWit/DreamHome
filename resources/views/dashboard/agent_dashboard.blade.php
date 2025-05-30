<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Agent Immobilier | DreamHome</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        .sidebar {
            transition: all 0.3s;
        }
        .notification-badge {
            position: absolute;
            top: -5px;
            right: -5px;
        }
        .property-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
        }
        .property-card {
            transition: all 0.3s ease;
        }
        .tab-content {
            display: none;
        }
        .tab-content.active {
            display: block;
        }
        .status-pending {
            background-color: #fef3c7;
            color: #92400e;
        }
        .status-confirmed {
            background-color: #d1fae5;
            color: #065f46;
        }
        .status-canceled {
            background-color: #fee2e2;
            color: #991b1b;
        }
        .status-completed {
            background-color: #dbeafe;
            color: #1e40af;
        }
    </style>
</head>
<body class="bg-gray-100">
    <div class="flex h-screen">
        <!-- Sidebar -->
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
                    <a href="{{ route('agent.dashboard') }}" class="tab-button active flex items-center px-4 py-3 text-sm font-medium text-white bg-gray-700" data-tab="dashboard">
                        <i class="fas fa-tachometer-alt mr-3 text-blue-400"></i>
                        Tableau de bord
                    </a>
                    <a href="{{ route('agent.visites') }}" class="tab-button flex items-center px-4 py-3 text-sm font-medium text-gray-300 hover:text-white hover:bg-gray-700" data-tab="requests">
                        <i class="fas fa-calendar-check mr-3"></i>
                        Demandes de visite
                        <span id="requestBadge" class="ml-auto bg-red-500 text-white text-xs font-bold px-2 py-1 rounded-full">{{ $visitsToday }}</span>
                    </a>
                    {{-- <a href="{{ route('agent.properties.index') }}" class="tab-button flex items-center px-4 py-3 text-sm font-medium text-gray-300 hover:text-white hover:bg-gray-700" data-tab="properties">
                        <i class="fas fa-home mr-3"></i>
                        Mes propriétés
                    </a> --}}

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
                    <h1 class="text-2xl font-bold text-gray-800" id="pageTitle">Tableau de bord</h1>
                </div>
            </header>

            <!-- Main Content Area -->
            <main class="p-6">
                <!-- Dashboard Tab -->
                <div id="dashboard-tab" class="tab-content active">
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
                        <!-- Stats Card 1 -->
                        <div class="bg-white p-6 rounded-lg shadow">
                            <div class="flex items-center">
                                <div class="p-3 rounded-full bg-blue-100 text-blue-600">
                                    <i class="fas fa-calendar-day text-xl"></i>
                                </div>
                                <div class="ml-4">
                                    <h3 class="text-lg font-medium text-gray-500">Visites aujourd'hui</h3>
                                    <p class="text-2xl font-bold text-gray-900">{{ $visitsToday }}</p>
                                </div>
                            </div>
                        </div>
                        <!-- Stats Card 2 -->
                        <div class="bg-white p-6 rounded-lg shadow">
                            <div class="flex items-center">
                                <div class="p-3 rounded-full bg-green-100 text-green-600">
                                    <i class="fas fa-home text-xl"></i>
                                </div>
                                <div class="ml-4">
                                    <h3 class="text-lg font-medium text-gray-500">Propriétés actives</h3>
                                    <p class="text-2xl font-bold text-gray-900">{{ $activeProperties }}</p>
                                </div>
                            </div>
                        </div>
                        <!-- Stats Card 3 -->
                        <div class="bg-white p-6 rounded-lg shadow">
                            <div class="flex items-center">
                                <div class="p-3 rounded-full bg-purple-100 text-purple-600">
                                    <i class="fas fa-handshake text-xl"></i>
                                </div>
                                <div class="ml-4">
                                    <h3 class="text-lg font-medium text-gray-500">Ventes ce mois</h3>
                                    <p class="text-2xl font-bold text-gray-900">{{ $salesThisMonth }}</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Upcoming Visits -->
                    <div class="bg-white shadow rounded-lg p-6 mb-6">
                        <div class="flex justify-between items-center mb-4">
                            <h2 class="text-lg font-medium text-gray-900">Visites à venir</h2>
                             <table class="w-full text-left">
            <thead>
                <tr class="text-gray-600">
                    <th class="pb-2">Client</th>
                    <th class="pb-2">Date</th>
                    <th class="pb-2">Téléphone</th>
                    <th class="pb-2">Statut</th>
                </tr>
            </thead>
            <tbody>
                @forelse($upcomingVisits as $visit)
                <tr class="border-t">
                    <td class="py-2">{{ $visit->client_name }}</td>
                    <td class="py-2">{{ \Carbon\Carbon::parse($visit->scheduled_date)->format('d/m/Y') }}</td>
                    <td class="py-2">{{ $visit->client_phone }}</td>
                    <td class="py-2 capitalize">{{ $visit->status }}</td>
                </tr>
                @empty
                <tr><td colspan="4" class="text-gray-500 py-4">Aucune visite prévue.</td></tr>
                @endforelse
            </tbody>
        </table>
                        </div>
                    </div>

                    <!-- Recent Properties -->
                    <div class="bg-white shadow rounded-lg p-6">
                        <div class="flex justify-between items-center mb-4">
                            <h2 class="text-lg font-medium text-gray-900">Mes dernières propriétés</h2>
                              <ul class="space-y-2">
            @forelse($latestProperties as $property)
                <li class="flex justify-between items-center border-b pb-2">
                    <div>
                        <p class="font-semibold">{{ $property->title }}</p>
                        <p class="text-sm text-gray-500">{{ $property->location }}</p>
                    </div>
                    <span class="text-sm">{{ number_format($property->price, 0, ',', ' ') }} MAD</span>
                </li>
            @empty
                <li class="text-gray-500">Aucune propriété disponible.</li>
            @endforelse
        </ul>
                </div>

                </div>

                <!-- Visit Requests Tab -->
                <div id="requests-tab" class="tab-content">
                    <div class="bg-white shadow rounded-lg p-6 mb-6">
                        <div class="flex justify-between items-center mb-4">
                            <h2 class="text-lg font-medium text-gray-900">Toutes les demandes de visite</h2>
                            <div class="flex space-x-2">
                                <form method="GET" action="{{ route('agent.visites') }}">
    <select name="status" onchange="this.form.submit()"
        class="border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500 text-sm">
        <option value="" {{ request('status') == '' ? 'selected' : '' }}>Tous les statuts</option>
        <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>En attente</option>
        <option value="confirmed" {{ request('status') == 'confirmed' ? 'selected' : '' }}>Confirmées</option>
        <option value="cancelled" {{ request('status') == 'cancelled' ? 'selected' : '' }}>Annulées</option>
        <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>Terminées</option>
    </select>
</form>

                                <button class="px-3 py-1 border border-gray-300 rounded-md text-sm font-medium text-gray-700 bg-white hover:bg-gray-50">
                                    <i class="fas fa-download mr-1"></i> Exporter
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
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date demandée</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Statut</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200" id="requestsTableBody">
                                    @forelse($visites as $visit)
<tr>
    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $visit->id }}</td>
    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $visit->property->title ?? '---' }}</td>
    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $visit->client_name }}</td>
    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ \Carbon\Carbon::parse($visit->scheduled_date)->format('d/m/Y') }}</td>
    <td class="px-6 py-4 whitespace-nowrap text-sm">
        <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium
            {{ $visit->status === 'pending' ? 'bg-yellow-100 text-yellow-800' :
               ($visit->status === 'confirmed' ? 'bg-green-100 text-green-800' :
               ($visit->status === 'cancelled' ? 'bg-red-100 text-red-800' : 'bg-gray-100 text-gray-800')) }}">
            {{ ucfirst($visit->status) }}
        </span>
    </td>
    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 space-x-2">
        @if($visit->status === 'pending')
            <form action="{{ route('agent.visites.confirmer', $visit->id) }}" method="POST" class="inline">
                @csrf
                <button class="text-green-600 hover:underline">Confirmer</button>
            </form>
            <form action="{{ route('agent.visites.annuler', $visit->id) }}" method="POST" class="inline">
                @csrf
                <button class="text-red-600 hover:underline">Annuler</button>
            </form>
        @else
            <span class="text-gray-400 italic">Aucune action</span>
        @endif
    </td>
</tr>
@empty
<tr><td colspan="6" class="text-center text-gray-400 py-4">Aucune demande trouvée</td></tr>
@endforelse

                                </tbody>
                            </table>
                        </div>

                    </div>
                </div>

                <!-- Properties Tab -->
                {{-- <div id="properties-tab" class="tab-content">
                    <div class="bg-white shadow rounded-lg p-6 mb-6">
                        <div class="flex justify-between items-center mb-4">
                            <h2 class="text-lg font-medium text-gray-900">Mes propriétés</h2>
                            <div class="flex space-x-2">
                                <form method="GET" action="{{ route('agent.properties.index') }}" class="flex space-x-2">
    <select name="status" onchange="this.form.submit()"
        class="border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500 text-sm">
        <option value="" {{ request('status') == '' ? 'selected' : '' }}>Tous les statuts</option>
        <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Actives</option>
        <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>En attente</option>
        <option value="sold" {{ request('status') == 'sold' ? 'selected' : '' }}>Vendues</option>
        <option value="rented" {{ request('status') == 'rented' ? 'selected' : '' }}>Louées</option>
    </select>
</form>

                                <button class="px-3 py-1 border border-gray-300 rounded-md text-sm font-medium text-gray-700 bg-white hover:bg-gray-50">
                                    <i class="fas fa-search mr-1"></i> Rechercher
                                </button>
                               <a href="{{ route('agent.properties.create') }}"
   class="px-3 py-1 border border-transparent rounded-md text-sm font-medium text-white bg-blue-600 hover:bg-blue-700">
    <i class="fas fa-plus mr-1"></i> Ajouter
</a>

                            </div>
                        </div>
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6" id="propertiesGrid">
    @forelse($properties as $property)
        <div class="bg-white p-4 rounded-lg shadow">
            <h3 class="text-lg font-bold text-gray-800">{{ $property->title }}</h3>
            <p class="text-sm text-gray-600">{{ $property->location }}</p>
            <p class="text-sm font-semibold text-blue-600 mt-1">{{ number_format($property->price, 0, ',', ' ') }} MAD</p>
            <span class="inline-block mt-2 px-2 py-1 text-xs rounded-full bg-gray-100 text-gray-800">
                {{ ucfirst($property->status) }}
            </span>
        </div>
    @empty
        <p class="text-gray-500 col-span-full">Aucune propriété trouvée</p>
    @endforelse
</div>

                    </div>
                </div> --}}

                <!-- Other tabs would follow the same pattern -->
            </main>
        </div>
    </div>

    <!-- Visit Details Modal -->
   <!-- Visit Details Modal -->
{{-- <div id="visitDetailsModal" class="fixed z-50 inset-0 overflow-y-auto hidden">
    <div class="flex items-center justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
        <div class="fixed inset-0 transition-opacity" aria-hidden="true">
            <div class="absolute inset-0 bg-gray-500 opacity-75"></div>
        </div>

        <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

        <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-2xl sm:w-full">
            <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                <div class="sm:flex sm:items-start">
                    <div class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-blue-100 sm:mx-0 sm:h-10 sm:w-10">
                        <i class="fas fa-calendar-alt text-blue-600"></i>
                    </div>
                    <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                        <h3 class="text-lg leading-6 font-medium text-gray-900">
                            Détails de la visite
                        </h3>
                        <div class="mt-2">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <h4 class="font-medium text-gray-700">Propriété</h4>
                                    <p class="text-gray-900">{{ $visit->property->title ?? '---' }}</p>
                                </div>
                                <div>
                                    <h4 class="font-medium text-gray-700">Client</h4>
                                    <p class="text-gray-900">{{ $visit->client_name }} ({{ $visit->client_phone }})</p>
                                </div>
                                <div>
                                    <h4 class="font-medium text-gray-700">Date & Heure</h4>
                                    <p class="text-gray-900">{{ \Carbon\Carbon::parse($visit->scheduled_date)->format('d/m/Y') }}</p>
                                </div>
                                <div>
                                    <h4 class="font-medium text-gray-700">Statut</h4>
                                    <p class="text-gray-900">
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-blue-100 text-blue-800">
                                            {{ ucfirst($visit->status) }}
                                        </span>
                                    </p>
                                </div>
                                <div class="md:col-span-2">
                                    <h4 class="font-medium text-gray-700">Message du client</h4>
                                    <p class="text-gray-900">{{ $visit->message ?? 'Aucun message' }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                <a href="{{ route('agent.visites') }}"
                   class="w-full inline-flex justify-center rounded-md shadow-sm px-4 py-2 bg-blue-600 text-white hover:bg-blue-700 sm:w-auto text-sm">
                    Fermer
                </a>
            </div>
        </div>
    </div>
</div> --}}


    <script>


        // Initialize the dashboard
        document.addEventListener('DOMContentLoaded', function() {
            // Load visit requests
            loadVisitRequests();

            // Load properties
            loadProperties();

            // Setup tab switching
            setupTabs();

            // Setup notification dropdown
            setupNotifications();

            // Setup sidebar toggle for mobile
            setupSidebar();

            // Simulate a new visit request after 3 seconds
            setTimeout(showNewVisitNotification, 3000);
        });

        // Load visit requests into the table
        function loadVisitRequests(filter = 'all') {
            const tbody = document.getElementById('requestsTableBody');
            tbody.innerHTML = '';

            let filteredRequests = visitRequests;
            if (filter !== 'all') {
                filteredRequests = visitRequests.filter(req => req.status === filter);
            }

            filteredRequests.forEach(request => {
                const row = document.createElement('tr');

                let statusClass = '';
                let statusText = '';
                switch(request.status) {
                    case 'pending':
                        statusClass = 'status-pending';
                        statusText = 'En attente';
                        break;
                    case 'confirmed':
                        statusClass = 'status-confirmed';
                        statusText = 'Confirmée';
                        break;
                    case 'canceled':
                        statusClass = 'status-canceled';
                        statusText = 'Annulée';
                        break;
                    case 'completed':
                        statusClass = 'status-completed';
                        statusText = 'Terminée';
                        break;
                }

                row.innerHTML = `
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">${request.id}</td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="text-sm font-medium text-gray-900">${request.property}</div>
                        <div class="text-sm text-gray-500">${request.location}</div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="text-sm text-gray-900">${request.client}</div>
                        <div class="text-sm text-gray-500">${request.phone}</div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">${request.requestedAt}</td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full ${statusClass}">
                            ${statusText}
                        </span>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                        <button class="text-blue-600 hover:text-blue-900 mr-3" onclick="showVisitDetails(${request.id})">
                            <i class="fas fa-eye"></i>
                        </button>
                        ${request.status === 'pending' ? `
                        <button class="text-green-600 hover:text-green-900 mr-3" onclick="confirmVisit(${request.id})">
                            <i class="fas fa-check"></i>
                        </button>
                        <button class="text-red-600 hover:text-red-900" onclick="cancelVisit(${request.id})">
                            <i class="fas fa-times"></i>
                        </button>
                        ` : ''}
                    </td>
                `;

                tbody.appendChild(row);
            });

            // Update pagination info
            document.getElementById('startItem').textContent = '1';
            document.getElementById('endItem').textContent = filteredRequests.length;
            document.getElementById('totalItems').textContent = filteredRequests.length;
        }

        // Load properties into the grid
        function loadProperties(filter = 'all') {
            const grid = document.getElementById('propertiesGrid');
            grid.innerHTML = '';

            let filteredProperties = properties;
            if (filter !== 'all') {
                filteredProperties = properties.filter(prop => prop.status === filter);
            }

            filteredProperties.forEach(property => {
                let statusBadge = '';
                let statusColor = 'blue';

                switch(property.status) {
                    case 'active':
                        statusBadge = '<div class="absolute top-2 right-2 bg-blue-600 text-white text-xs font-bold px-2 py-1 rounded">Active</div>';
                        break;
                    case 'pending':
                        statusBadge = '<div class="absolute top-2 right-2 bg-yellow-500 text-white text-xs font-bold px-2 py-1 rounded">En attente</div>';
                        statusColor = 'yellow';
                        break;
                    case 'sold':
                        statusBadge = '<div class="absolute top-2 right-2 bg-green-600 text-white text-xs font-bold px-2 py-1 rounded">Vendue</div>';
                        statusColor = 'green';
                        break;
                    case 'rented':
                        statusBadge = '<div class="absolute top-2 right-2 bg-purple-600 text-white text-xs font-bold px-2 py-1 rounded">Louée</div>';
                        statusColor = 'purple';
                        break;
                }

                const card = document.createElement('div');
                card.className = 'property-card bg-white rounded-lg overflow-hidden shadow-md';
                card.innerHTML = `
                    <div class="relative">
                        <img class="w-full h-48 object-cover" src="${property.image}" alt="${property.title}">
                        ${statusBadge}
                    </div>
                    <div class="p-4">
                        <div class="flex justify-between items-start">
                            <div>
                                <h3 class="text-lg font-bold text-gray-900">${property.title}</h3>
                                <p class="text-gray-500 text-sm"><i class="fas fa-map-marker-alt text-${statusColor}-600 mr-1"></i> ${property.location}</p>
                            </div>
                            <div class="text-${statusColor}-600 font-bold text-xl">${property.price}</div>
                        </div>
                        <div class="flex justify-between mt-4 text-sm text-gray-500">
                            <span><i class="fas fa-bed text-${statusColor}-600 mr-1"></i> ${property.bedrooms} chambres</span>
                            <span><i class="fas fa-bath text-${statusColor}-600 mr-1"></i> ${property.bathrooms} sdb</span>
                            <span><i class="fas fa-ruler-combined text-${statusColor}-600 mr-1"></i> ${property.area}</span>
                        </div>
                        <div class="mt-4 pt-4 border-t border-gray-100 flex justify-between items-center">
                            <span class="text-sm text-gray-500">Ajouté le ${property.added}</span>
                            <div>
                                <button class="text-blue-600 hover:text-blue-800 text-sm font-medium mr-2">
                                    <i class="fas fa-edit"></i>
                                </button>
                                <button class="text-red-600 hover:text-red-800 text-sm font-medium">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                `;

                grid.appendChild(card);
            });
        }

        // Setup tab switching functionality
        function setupTabs() {
            const tabButtons = document.querySelectorAll('.tab-button');

            tabButtons.forEach(button => {
                button.addEventListener('click', function(e) {
                    e.preventDefault();

                    // Remove active class from all buttons and tabs
                    tabButtons.forEach(btn => btn.classList.remove('active', 'bg-gray-700', 'text-white'));
                    document.querySelectorAll('.tab-content').forEach(tab => tab.classList.remove('active'));

                    // Add active class to clicked button
                    this.classList.add('active', 'bg-gray-700', 'text-white');

                    // Show corresponding tab
                    const tabId = this.getAttribute('data-tab') + '-tab';
                    document.getElementById(tabId).classList.add('active');

                    // Update page title
                    document.getElementById('pageTitle').textContent = this.textContent.trim();
                });
            });

            // Handle filter changes
            document.getElementById('requestFilter').addEventListener('change', function() {
                loadVisitRequests(this.value);
            });

            document.getElementById('propertyFilter').addEventListener('change', function() {
                loadProperties(this.value);
            });
        }

        // Setup notification dropdown
        function setupNotifications() {
            const notificationButton = document.getElementById('notificationButton');
            const notificationDropdown = document.getElementById('notificationDropdown');

            notificationButton.addEventListener('click', function() {
                notificationDropdown.classList.toggle('hidden');
            });

            // Close dropdown when clicking outside
            document.addEventListener('click', function(e) {
                if (!notificationButton.contains(e.target) && !notificationDropdown.contains(e.target)) {
                    notificationDropdown.classList.add('hidden');
                }
            });
        }

        // Setup sidebar toggle for mobile
        function setupSidebar() {
            const sidebarToggle = document.getElementById('sidebarToggle');
            const sidebar = document.querySelector('.sidebar');

            sidebarToggle.addEventListener('click', function() {
                sidebar.classList.toggle('-ml-64');
            });
        }

        // Show visit details in modal
        function showVisitDetails(id) {
            const request = visitRequests.find(req => req.id === id);

            if (request) {
                document.getElementById('visitProperty').textContent = `${request.property} - ${request.location}`;
                document.getElementById('visitClient').textContent = `${request.client} (${request.phone})`;
                document.getElementById('visitDateTime').textContent = `${request.date} - ${request.time}`;
                document.getElementById('visitMessage').textContent = request.message;

                let statusElement = document.getElementById('visitStatus');
                statusElement.innerHTML = '';

                let statusClass = '';
                let statusText = '';
                switch(request.status) {
                    case 'pending':
                        statusClass = 'status-pending';
                        statusText = 'En attente';
                        break;
                    case 'confirmed':
                        statusClass = 'status-confirmed';
                        statusText = 'Confirmée';
                        break;
                    case 'canceled':
                        statusClass = 'status-canceled';
                        statusText = 'Annulée';
                        break;
                    case 'completed':
                        statusClass = 'status-completed';
                        statusText = 'Terminée';
                        break;
                }

                const statusSpan = document.createElement('span');
                statusSpan.className = `px-2 inline-flex text-xs leading-5 font-semibold rounded-full ${statusClass}`;
                statusSpan.textContent = statusText;

                statusElement.appendChild(statusSpan);

                openModal('visitDetailsModal');
            }
        }

        // Confirm a visit request
        function confirmVisit(id) {
            const request = visitRequests.find(req => req.id === id);
            if (request) {
                request.status = 'confirmed';
                loadVisitRequests(document.getElementById('requestFilter').value);

                // Update badge count
                updateRequestBadge();

                // Show success message
                alert('Visite confirmée avec succès!');
            }
        }

        // Cancel a visit request
        function cancelVisit(id) {
            const request = visitRequests.find(req => req.id === id);
            if (request) {
                request.status = 'canceled';
                loadVisitRequests(document.getElementById('requestFilter').value);

                // Update badge count
                updateRequestBadge();

                // Show success message
                alert('Visite annulée avec succès!');
            }
        }

        // Update the request badge count
        function updateRequestBadge() {
            const pendingCount = visitRequests.filter(req => req.status === 'pending').length;
            document.getElementById('requestBadge').textContent = pendingCount;
        }

        // Show a new visit notification
        function showNewVisitNotification() {
            const toast = document.getElementById('newVisitToast');
            toast.classList.remove('hidden');

            // Update badge counts
            document.getElementById('notificationBadge').textContent = parseInt(document.getElementById('notificationBadge').textContent) + 1;
            document.getElementById('requestBadge').textContent = parseInt(document.getElementById('requestBadge').textContent) + 1;
        }

        // Close the notification toast
        function closeToast() {
            document.getElementById('newVisitToast').classList.add('hidden');
        }

        // View the new visit request
        function viewNewVisit() {
            closeToast();

            // Switch to requests tab
            document.querySelector('[data-tab="requests"]').click();
        }

        // Open a modal
        function openModal(id) {
            document.getElementById(id).classList.remove('hidden');
        }

        // Close a modal
        function closeModal(id) {
            document.getElementById(id).classList.add('hidden');
        }
    </script>

</body>
</html>
