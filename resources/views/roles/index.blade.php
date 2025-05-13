@extends('layouts.app')

@section('page-title', 'Gestion des rôles')

@section('content')
<div x-data="{ open: false, editMode: false, form: { id: null, name: '' } }" class="bg-white shadow rounded-lg p-6">

    <div class="flex justify-between items-center mb-4">
        <h2 class="text-lg font-bold text-gray-800">Liste des rôles</h2>
        <button @click="open = true; editMode = false; form = { id: null, name: '' }"
            class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 text-sm">
            <i class="fas fa-plus mr-1"></i> Nouveau rôle
        </button>
    </div>

    @if(session('success'))
        <div class="mb-4 p-3 bg-green-100 text-green-800 rounded">
            {{ session('success') }}
        </div>
    @endif

    <table class="min-w-full divide-y divide-gray-200">
        <thead class="bg-gray-50">
            <tr>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Nom</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase"># Permissions</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Actions</th>
            </tr>
        </thead>
        <tbody class="bg-white divide-y divide-gray-200">
            @foreach($roles as $role)
                <tr>
                    <td class="px-6 py-4 text-sm text-gray-900">{{ $role->name }}</td>
                    <td class="px-6 py-4 text-sm text-gray-600">{{ $role->permissions_count }}</td>
                    <td class="px-6 py-4 text-sm flex space-x-2">
                        <button @click="open = true; editMode = true; form = { id: {{ $role->id }}, name: '{{ $role->name }}' }"
                            class="text-blue-600 hover:underline text-sm">Modifier</button>

                        <form action="{{ route('roles.destroy', $role) }}" method="POST" onsubmit="return confirm('Confirmer la suppression ?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-600 hover:underline text-sm">Supprimer</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <!-- Modal -->
    <div x-show="open" x-transition class="fixed inset-0 bg-gray-800 bg-opacity-75 flex items-center justify-center z-50">
        <div @click.outside="open = false" class="bg-white p-6 rounded shadow-lg w-full max-w-md">
            <h2 class="text-lg font-bold mb-4 text-gray-800" x-text="editMode ? 'Modifier rôle' : 'Ajouter un rôle'"></h2>
            <form :action="editMode ? `/roles/${form.id}` : '{{ route('roles.store') }}'" method="POST">
                @csrf
                <template x-if="editMode">
                    <input type="hidden" name="_method" value="PUT">
                </template>
                <input type="text" name="name" x-model="form.name" required class="w-full px-3 py-2 border rounded mb-4" placeholder="Nom du rôle">
                <div class="flex justify-end">
                    <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                        <span x-text="editMode ? 'Modifier' : 'Ajouter'"></span>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
