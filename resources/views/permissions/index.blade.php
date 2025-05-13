@extends('layouts.app')

@section('page-title', 'Gestion des permissions')

@section('content')
<div class="bg-white shadow rounded-lg p-6 mb-6">
    <div class="flex justify-between items-center mb-4">
        <h2 class="text-lg font-medium text-gray-900">Gestion des permissions</h2>
        <div class="flex space-x-2">
            <a href="{{ route('permissions.create') }}" class="px-3 py-1 bg-blue-600 text-white rounded text-sm hover:bg-blue-700">
                <i class="fas fa-plus mr-1"></i> Ajouter
            </a>
        </div>
    </div>

    @php
        $allPermissions = \App\Models\Permission::all();
    @endphp

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        @foreach($roles as $role)
        <div class="bg-white border border-gray-200 rounded-lg shadow p-6">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-medium text-gray-900">{{ ucfirst($role->name) }}</h3>
                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-gray-100 text-gray-800">
                    {{ ucfirst($role->name) }}
                </span>
            </div>

            <form action="{{ route('permissions.sync', $role->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="space-y-2">
                    @foreach($allPermissions->where('role_id', $role->id) as $permission)
                        <div class="flex items-center">
                            <input type="checkbox" name="permissions[]" value="{{ $permission->id }}"
                                   class="h-4 w-4 text-blue-600 border-gray-300 rounded"
                                   {{ $role->permissions->contains($permission->id) ? 'checked' : '' }}>
                            <label class="ml-2 block text-sm text-gray-900">{{ $permission->name }}</label>
                        </div>
                    @endforeach
                </div>

                <div class="mt-4 flex justify-end">
                    <button type="submit" class="bg-blue-600 text-white px-3 py-1 text-sm rounded hover:bg-blue-700">
                        Sauvegarder
                    </button>
                </div>
            </form>
        </div>
        @endforeach
    </div>
</div>
@endsection
