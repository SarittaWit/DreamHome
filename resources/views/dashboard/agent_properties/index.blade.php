<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
@extends('layouts.agent')

@section('content')
<div class="flex-1 ml-64">
    <header class="bg-white shadow">
        <div class="px-6 py-4 flex justify-between items-center">
            <h1 class="text-2xl font-bold text-gray-800">Mes propriétés</h1>
            <a href="{{ route('agent.properties.create') }}"
               class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
                <i class="fas fa-plus mr-2"></i> Ajouter
            </a>
        </div>
    </header>

    <main class="p-6">
        <div class="bg-white shadow rounded-lg p-6">
            <!-- Filtre -->
            <div class="mb-6 flex justify-between items-center">
                <h2 class="text-lg font-medium text-gray-900">Liste des propriétés</h2>
                <form method="GET" action="{{ route('agent.properties.index') }}">
                    <select name="status" onchange="this.form.submit()"
                        class="border border-gray-300 rounded-md shadow-sm py-2 px-3">
                        <option value="">Tous les statuts</option>
                        <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Actives</option>
                        <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>En attente</option>
                        <option value="sold" {{ request('status') == 'sold' ? 'selected' : '' }}>Vendues</option>
                        <option value="rented" {{ request('status') == 'rented' ? 'selected' : '' }}>Louées</option>
                    </select>
                </form>
            </div>

            <!-- Liste des propriétés -->
            @if($properties->count() > 0)
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach($properties as $property)
                        <div class="property-card bg-white rounded-lg shadow-md overflow-hidden hover:shadow-lg transition-shadow">
                            <!-- Image -->
                            <div class="h-48 overflow-hidden">
                                <img src="{{ $property->image ? asset('storage/'.$property->image) : asset('images/default-house.jpg') }}"
                                     alt="{{ $property->title }}" class="w-full h-full object-cover">
                            </div>

                            <!-- Details -->
                            <div class="p-4">
                                <div class="flex justify-between items-start">
                                    <div>
                                        <h3 class="font-bold text-lg">{{ $property->title }}</h3>
                                        <p class="text-gray-600 text-sm">
                                            <i class="fas fa-map-marker-alt mr-1"></i> {{ $property->location }}
                                        </p>
                                    </div>
                                    <span class="px-2 py-1 text-xs rounded-full
                                        {{ $property->status == 'active' ? 'bg-green-100 text-green-800' :
                                           ($property->status == 'pending' ? 'bg-yellow-100 text-yellow-800' :
                                           'bg-blue-100 text-blue-800') }}">
                                        {{ ucfirst($property->status) }}
                                    </span>
                                </div>

                                <p class="text-blue-600 font-bold my-2">
                                    {{ number_format($property->price, 0, ',', ' ') }} MAD
                                </p>

                                <div class="flex justify-between text-sm text-gray-500 mt-3">
                                    <span><i class="fas fa-bed mr-1"></i> {{ $property->bedrooms }} chambres</span>
                                    <span><i class="fas fa-bath mr-1"></i> {{ $property->bathrooms }} sdb</span>
                                    <span><i class="fas fa-ruler-combined mr-1"></i> {{ $property->area }} m²</span>
                                </div>

                                <div class="mt-4 pt-4 border-t border-gray-100 flex justify-between">
                                    <a href="{{ route('agent.properties.edit', $property->id) }}"
                                       class="text-blue-600 hover:text-blue-800">
                                        <i class="fas fa-edit"></i> Modifier
                                    </a>
                                    <form action="{{ route('agent.properties.destroy', $property->id) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:text-red-800"
                                                onclick="return confirm('Êtes-vous sûr ?')">
                                            <i class="fas fa-trash"></i> Supprimer
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <!-- Pagination -->
                <div class="mt-6">
                    {{ $properties->links() }}
                </div>
            @else
                <div class="text-center py-8">
                    <i class="fas fa-home text-gray-300 text-5xl mb-4"></i>
                    <p class="text-gray-500">Aucune propriété trouvée</p>
                    <a href="{{ route('agent.properties.create') }}"
                       class="mt-4 inline-block px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
                        Ajouter votre première propriété
                    </a>
                </div>
            @endif
        </div>
    </main>
</div>
@endsection
</body>
</html>
