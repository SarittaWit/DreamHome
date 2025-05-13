@extends('layouts.app')

@section('page-title', 'Gestion des propriétés')

@section('content')
<div id="properties-tab" class="tab-content">
    <div class="bg-white shadow rounded-lg p-6 mb-6">
        <!-- Header + Filters -->
        <div class="flex justify-between items-center mb-4">
            <h2 class="text-lg font-medium text-gray-900">Gestion des propriétés</h2>
            <div class="flex space-x-2">
                <form method="GET" class="flex space-x-2">
                    <select name="status" class="border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500 text-sm">
                        <option value="">Toutes les propriétés</option>
                        <option value="disponible" {{ request('status') == 'disponible' ? 'selected' : '' }}>Disponibles</option>
                        <option value="vendu" {{ request('status') == 'vendu' ? 'selected' : '' }}>Vendues</option>
                    </select>
                    <input type="text" name="location" value="{{ request('location') }}" placeholder="Emplacement..." class="border-gray-300 rounded-md text-sm px-3 py-2" />
                    <input type="number" name="max_price" step="0.01" value="{{ request('max_price') }}" placeholder="Prix max" class="border-gray-300 rounded-md text-sm px-3 py-2" />
                    <button type="submit" class="px-3 py-1 bg-white border border-gray-300 rounded-md text-sm hover:bg-gray-50">
                        <i class="fas fa-search mr-1"></i> Rechercher
                    </button>
                </form>
                <a href="{{ route('properties.create') }}" class="px-3 py-1 border border-transparent rounded-md text-sm font-medium text-white bg-blue-600 hover:bg-blue-700">
                    <i class="fas fa-plus mr-1"></i> Ajouter
                </a>
            </div>
        </div>

        <!-- Cards View -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6" id="propertiesGrid">
            @forelse($properties as $property)
                <div class="bg-white rounded-lg overflow-hidden shadow-md">
                    @if($property->image)
                        <img class="w-full h-48 object-cover" src="{{ asset('storage/' . $property->image) }}" alt="{{ $property->title }}">
                    @else
                        <div class="w-full h-48 bg-gray-200 flex items-center justify-center text-gray-500">Pas d'image</div>
                    @endif
                    <div class="p-4">
                        <div class="flex justify-between items-start">
                            <div>
                                <h3 class="text-lg font-bold text-gray-900">{{ $property->title }}</h3>
                                <p class="text-gray-500 text-sm"><i class="fas fa-map-marker-alt text-blue-600 mr-1"></i>{{ $property->location }}</p>
                            </div>
                            <div class="text-blue-600 font-bold text-xl">{{ number_format($property->price, 0, ',', ' ') }} DH</div>
                        </div>
                        <div class="mt-2">
                            <span class="text-sm px-2 py-1 rounded-full bg-{{ $property->status == 'disponible' ? 'green' : 'red' }}-100 text-{{ $property->status == 'disponible' ? 'green' : 'red' }}-700">
                                {{ ucfirst($property->status) }}
                            </span>
                        </div>
                        <div class="mt-4 pt-4 border-t border-gray-100 flex justify-between items-center">
                            <div>
                                <a href="{{ route('properties.edit', $property) }}" class="text-blue-600 hover:text-blue-800 text-sm font-medium mr-2">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('properties.destroy', $property) }}" method="POST" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:text-red-800 text-sm font-medium">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                            <small class="text-gray-400">{{ $property->created_at->diffForHumans() }}</small>
                        </div>
                    </div>
                </div>
            @empty
                <p class="text-gray-500">Aucune propriété trouvée.</p>
            @endforelse
        </div>

        <!-- Pagination + Info -->
        <div class="mt-6 flex justify-between items-center">
            <div class="text-sm text-gray-500">
                Affichage de {{ $properties->firstItem() }} à {{ $properties->lastItem() }} sur {{ $properties->total() }} propriétés
            </div>
            {{ $properties->withQueryString()->links() }}
        </div>
    </div>
</div>
@endsection
