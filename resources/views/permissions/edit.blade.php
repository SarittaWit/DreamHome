@extends('layouts.app')

@section('page-title', 'Modifier la permission')

@section('content')
<div class="max-w-lg mx-auto bg-white shadow-md rounded-lg p-6 mt-6">
    <h2 class="text-xl font-bold mb-4 text-gray-800">Modifier la permission</h2>

    @if($errors->any())
        <div class="mb-4 p-3 bg-red-100 text-red-800 rounded">
            <ul class="list-disc list-inside text-sm">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('permissions.update', $permission->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-4">
            <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Nom de la permission</label>
            <input type="text" name="name" id="name" value="{{ old('name', $permission->name) }}" required
                   class="w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 px-3 py-2">
        </div>

        <div class="mb-6">
            <label for="role_id" class="block text-sm font-medium text-gray-700 mb-1">Rôle associé</label>
            <select name="role_id" id="role_id" required
                    class="w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 px-3 py-2">
                @foreach($roles as $role)
                    <option value="{{ $role->id }}" {{ $permission->role_id == $role->id ? 'selected' : '' }}>
                        {{ ucfirst($role->name) }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="flex justify-end">
            <div class="flex items-center space-x-2 ml-4">
                <button
                    @click="showModal = true; editMode = true; form = {
                        id: {{ $permission->id }},
                        name: '{{ $permission->name }}',
                        role_id: '{{ $role->id }}'
                    }"
                    class="text-sm text-blue-600 hover:underline">Modifier</button>

                <form action="{{ route('permissions.destroy', $permission->id) }}" method="POST"
                      onsubmit="return confirm('Confirmer la suppression ?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="text-sm text-red-600 hover:underline">Supprimer</button>
                </form>
            </div>

            <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 text-sm">
                Mettre à jour
            </button>
        </div>
    </form>
</div>
@endsection
