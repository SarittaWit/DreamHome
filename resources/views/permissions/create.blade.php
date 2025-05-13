@extends('layouts.app')

@section('page-title', 'Ajouter une permission')

@section('content')
<div class="max-w-lg mx-auto bg-white shadow-md rounded-lg p-6 mt-6">
    <h2 class="text-xl font-bold mb-4 text-gray-800">Ajouter une nouvelle permission</h2>

    @if($errors->any())
        <div class="mb-4 p-3 bg-red-100 text-red-800 rounded">
            <ul class="list-disc list-inside text-sm">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('permissions.store') }}" method="POST">
        @csrf

        <div class="mb-4">
            <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Nom de la permission</label>
            <input type="text" name="name" id="name" required
                   class="w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 px-3 py-2">
        </div>

        <div class="mb-6">
            <label for="role_id" class="block text-sm font-medium text-gray-700 mb-1">Attribuer à un rôle</label>
            <select name="role_id" id="role_id" required
                    class="w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 px-3 py-2">
                <option value="">-- Choisir un rôle --</option>
                @foreach($roles as $role)
                    <option value="{{ $role->id }}">{{ ucfirst($role->name) }}</option>
                @endforeach
            </select>
        </div>

        <div class="flex justify-end">
            <a href="{{ route('permissions.index') }}" class="text-gray-500 hover:underline mr-4 text-sm">Annuler</a>
            <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 text-sm">
                Enregistrer
            </button>
        </div>
    </form>
</div>
@endsection
