@extends('layouts.agent')

@section('content')
<div class="flex-1 ml-64">
    <header class="bg-white shadow">
        <div class="px-6 py-4 flex justify-between items-center">
            <h1 class="text-2xl font-bold text-gray-800">{{ $property->title }}</h1>
            <div class="flex space-x-2">
                <a href="{{ route('agent.properties.edit', $property->id) }}" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
                    <i class="fas fa-edit mr-2"></i> Modifier
                </a>
                <form action="{{ route('agent.properties.destroy', $property->id) }}" method="POST" class="inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="px-4 py-2 bg-red-600 text-white rounded hover:bg-red-700" onclick="return confirm('Êtes-vous sûr de vouloir supprimer cette propriété ?')">
                        <i class="fas fa-trash mr-2"></i> Supprimer
                    </button>
                </form>
            </div>
        </div>
    </header>

    <main class="p-6">
        <div class="bg-white shadow rounded-lg overflow-hidden">
            <div class="md:flex">
                <div class="md:w-1/2">
                    <img class="w-full h-full object-cover" src="{{ $property->image ? asset('storage/'.$property->image) : asset('images/default-property.jpg') }}" alt="{{ $property->title }}">
                </div>
                <div class="p-6 md:w-1/2">
                    <div class="flex justify-between items-start">
                        <div>
                            <span class="inline-block px-3 py-1 text-sm font-semibold rounded-full
                                @if($property->status == 'active') bg-blue-100 text-blue-800
                                @elseif($property->status == 'pending') bg-yellow-100 text-yellow-800
                                @elseif($property->status == 'sold') bg-green-100 text-green-800
                                @else bg-purple-100 text-purple-800 @endif">
                                {{ ucfirst($property->status) }}
                            </span>
                            <h2 class="text-2xl font-bold text-gray-800 mt-2">{{ $property->title }}</h2>
                            <p class="text-gray-600 mt-1">
                                <i class="fas fa-map-marker-alt mr-1"></i> {{ $property->location }}
                            </p>
                        </div>
                        <div class="text-blue-600 font-bold text-2xl">{{ number_format($property->price, 0, ',', ' ') }} MAD</div>
                    </div>

                    <div class="mt-6 grid grid-cols-3 gap-4 text-center">
                        <div class="p-3 bg-gray-50 rounded-lg">
                            <div class="text-gray-500 text-sm">Surface</div>
                            <div class="font-bold">{{ $property->area }} m²</div>
                        </div>
                        <div class="p-3 bg-gray-50 rounded-lg">
                            <div class="text-gray-500 text-sm">Chambres</div>
                            <div class="font-bold">{{ $property->bedrooms }}</div>
                        </div>
                        <div class="p-3 bg-gray-50 rounded-lg">
                            <div class="text-gray-500 text-sm">Salles de bain</div>
                            <div class="font-bold">{{ $property->bathrooms }}</div>
                        </div>
                    </div>

                    <div class="mt-6">
                        <h3 class="text-lg font-medium text-gray-900">Description</h3>
                        <p class="text-gray-600 mt-2">{{ $property->description }}</p>
                    </div>

                    <div class="mt-6 pt-6 border-t border-gray-200">
                        <div class="flex justify-between text-sm text-gray-500">
                            <span>Créé le {{ $property->created_at->format('d/m/Y') }}</span>
                            <span>Dernière modification le {{ $property->updated_at->format('d/m/Y') }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
</div>
@endsection
