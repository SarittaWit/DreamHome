@extends('layouts.app')

@section('page-title', 'Modifier la propriété')

@section('content')
<div class="bg-white shadow rounded-lg p-6">
    <h2 class="text-xl font-bold text-gray-800 mb-4">Modifier la propriété</h2>

    <form action="{{ route('properties.update', $property) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="space-y-4">
            <input type="text" name="title" value="{{ $property->title }}" required class="border rounded w-full px-3 py-2">
            <textarea name="description" class="border rounded w-full px-3 py-2">{{ $property->description }}</textarea>
            <input type="text" name="location" value="{{ $property->location }}" required class="border rounded w-full px-3 py-2">
            <input type="number" name="price" step="0.01" value="{{ $property->price }}" required class="border rounded w-full px-3 py-2">
            <select name="status" class="border rounded w-full px-3 py-2">
                <option value="disponible" {{ $property->status == 'disponible' ? 'selected' : '' }}>Disponible</option>
                <option value="vendu" {{ $property->status == 'vendu' ? 'selected' : '' }}>Vendu</option>
            </select>
            <input type="file" name="image" accept="image/*" class="border rounded w-full px-3 py-2">
            <div class="flex justify-end space-x-2">
                <a href="{{ route('properties.index') }}" class="bg-gray-300 px-4 py-2 rounded text-gray-800 hover:bg-gray-400 text-sm">Annuler</a>
                <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 text-sm">Mettre à jour</button>
            </div>
        </div>
    </form>
</div>
@endsection
