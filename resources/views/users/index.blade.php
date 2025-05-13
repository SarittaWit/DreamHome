@extends('layouts.app')

@section('page-title', 'Gestion des utilisateurs')

@section('content')
<div
    x-data="{
        open: false,
        editOpen: false,
        deleteOpen: false,
        user: {},
        confirmDelete(u) { this.user = u; this.deleteOpen = true; },
        filter: 'all'
    }"
    class="bg-white shadow rounded-lg p-6 mb-6"
>
    <!-- Header -->
    <div class="flex justify-between items-center mb-4">
        <h2 class="text-lg font-medium text-gray-900">Gestion des utilisateurs</h2>
        <div class="flex space-x-2">
            <select x-model="filter" class="border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500 text-sm">
                <option value="all">Tous les utilisateurs</option>
                <option value="admin">Administrateurs</option>
                <option value="agent">Agents</option>
                <option value="client">Clients</option>
            </select>
            <button @click="open = true" class="px-3 py-1 border border-transparent rounded-md text-sm font-medium text-white bg-blue-600 hover:bg-blue-700">
                <i class="fas fa-plus mr-1"></i> Ajouter
            </button>
        </div>
    </div>

    @if(session('success'))
        <div class="mb-4 p-3 bg-green-100 text-green-800 rounded">
            {{ session('success') }}
        </div>
    @endif

    <!-- Table des utilisateurs -->
    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Nom</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Email</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Téléphone</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Rôle</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Actions</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @foreach($users as $user)
                    <tr x-show="filter === 'all' || '{{ $user->role }}' === filter">
                        <td class="px-6 py-4 text-sm text-gray-900">{{ $user->name }}</td>
                        <td class="px-6 py-4 text-sm text-gray-500">{{ $user->email }}</td>
                        <td class="px-6 py-4 text-sm text-gray-500">{{ $user->phone ?? '-' }}</td>
                        <td class="px-6 py-4 text-sm text-gray-500">{{ ucfirst($user->role ?? 'client') }}</td>
                        <td class="px-6 py-4 text-sm">
                            <a href="#" @click.prevent="editOpen = true; user = {{ $user->toJson() }}" class="text-blue-600 hover:text-blue-900 mr-2">
                                <i class="fas fa-edit"></i>
                            </a>
                            <a href="#" @click.prevent="confirmDelete({{ $user->toJson() }})" class="text-red-600 hover:text-red-800">
                                <i class="fas fa-trash"></i>
                            </a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <!-- Modal: Ajouter -->
    <div x-show="open" x-transition class="fixed inset-0 bg-gray-800 bg-opacity-75 flex items-center justify-center z-50">
        <div @click.outside="open = false" class="bg-white rounded-lg shadow-lg w-full max-w-lg p-6">
            <div class="flex justify-between items-center mb-4">
                <h2 class="text-lg font-bold text-gray-800">Ajouter un utilisateur</h2>
                <button @click="open = false" class="text-gray-500 hover:text-gray-800 text-xl">&times;</button>
            </div>

            <form action="{{ route('users.store') }}" method="POST">
                @csrf
                <div class="space-y-4">
                    <input type="text" name="name" placeholder="Nom complet" required class="border rounded w-full px-3 py-2">
                    <input type="email" name="email" placeholder="Email" required class="border rounded w-full px-3 py-2">
                    <input type="text" name="phone" placeholder="Téléphone" class="border rounded w-full px-3 py-2">
                    <input type="password" name="password" placeholder="Mot de passe" required class="border rounded w-full px-3 py-2">
                    <select name="role" class="border rounded w-full px-3 py-2">
                        <option value="admin">Administrateur</option>
                        <option value="agent">Agent</option>
                        <option value="client" selected>Client</option>
                    </select>
                    <div class="flex justify-end">
                        <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 text-sm inline-flex items-center">
                            Ajouter
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Modal: Modifier -->
    <div x-show="editOpen" x-transition class="fixed inset-0 bg-gray-800 bg-opacity-75 flex items-center justify-center z-50">
        <div @click.outside="editOpen = false" class="bg-white rounded-lg shadow-lg w-full max-w-lg p-6">
            <div class="flex justify-between items-center mb-4">
                <h2 class="text-lg font-bold text-gray-800">Modifier utilisateur</h2>
                <button @click="editOpen = false" class="text-gray-500 hover:text-gray-800 text-xl">&times;</button>
            </div>

            <form :action="'/users/' + user.id" method="POST">
                @csrf
                @method('PUT')
                <div class="space-y-4">
                    <input type="text" name="name" x-model="user.name" required class="border rounded w-full px-3 py-2">
                    <input type="email" name="email" x-model="user.email" required class="border rounded w-full px-3 py-2">
                    <input type="text" name="phone" x-model="user.phone" class="border rounded w-full px-3 py-2">
                    <select name="role" x-model="user.role" class="border rounded w-full px-3 py-2">
                        <option value="admin">Administrateur</option>
                        <option value="agent">Agent</option>
                        <option value="client">Client</option>
                    </select>
                    <div class="flex justify-end">
                        <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 text-sm inline-flex items-center">
                            Modifier
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Modal: Supprimer -->
    <div x-show="deleteOpen" x-transition class="fixed inset-0 bg-gray-800 bg-opacity-75 flex items-center justify-center z-50">
        <div @click.outside="deleteOpen = false" class="bg-white rounded-lg shadow-lg w-full max-w-md p-6">
            <div class="mb-4">
                <h2 class="text-lg font-bold text-gray-800 mb-2">Confirmer la suppression</h2>
                <p class="text-gray-600">Voulez-vous vraiment supprimer <strong x-text="user.name"></strong> ?</p>
            </div>

            <form :action="'/users/' + user.id" method="POST" class="flex justify-end space-x-2">
                @csrf
                @method('DELETE')
                <button type="button" @click="deleteOpen = false" class="px-4 py-2 bg-gray-300 text-gray-800 rounded hover:bg-gray-400 text-sm">
                    Annuler
                </button>
                <button type="submit" class="px-4 py-2 bg-red-600 text-white rounded hover:bg-red-700 text-sm">
                    Supprimer
                </button>
            </form>
        </div>
    </div>
</div>
@endsection
