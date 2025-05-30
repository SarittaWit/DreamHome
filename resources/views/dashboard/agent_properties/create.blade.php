@extends('layouts.agent')

@section('content')
<div class="flex-1 ml-64">
    <header class="bg-white shadow">
        <div class="px-6 py-4 flex justify-between items-center">
            <h1 class="text-2xl font-bold text-gray-800">Ajouter une propriété</h1>
        </div>
    </header>

    <main class="p-6">
        <div class="bg-white shadow rounded-lg p-6">
            <form action="{{ route('agent.properties.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Colonne de gauche -->
                    <div>
                        <div class="mb-4">
                            <label for="title" class="block text-sm font-medium text-gray-700">Titre *</label>
                            <input type="text" name="title" id="title" required
                                class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                        </div>

                        <div class="mb-4">
                            <label for="location" class="block text-sm font-medium text-gray-700">Localisation *</label>
                            <input type="text" name="location" id="location" required
                                class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                        </div>

                        <div class="mb-4">
                            <label for="price" class="block text-sm font-medium text-gray-700">Prix (MAD) *</label>
                            <input type="number" name="price" id="price" min="0" step="1000" required
                                class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                        </div>

                        <div class="mb-4">
                            <label for="status" class="block text-sm font-medium text-gray-700">Statut *</label>
                            <select name="status" id="status" required
                                class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                                <option value="active">Active</option>
                                <option value="pending">En attente</option>
                                <option value="sold">Vendue</option>
                                <option value="rented">Louée</option>
                            </select>
                        </div>
                    </div>

                    <!-- Colonne de droite -->
                    <div>
                        <div class="mb-4">
                            <label for="area" class="block text-sm font-medium text-gray-700">Surface (m²) *</label>
                            <input type="number" name="area" id="area" min="0" required
                                class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                        </div>

                        <div class="mb-4">
                            <label for="bedrooms" class="block text-sm font-medium text-gray-700">Nombre de chambres *</label>
                            <input type="number" name="bedrooms" id="bedrooms" min="0" required
                                class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                        </div>

                        <div class="mb-4">
                            <label for="bathrooms" class="block text-sm font-medium text-gray-700">Nombre de salles de bain *</label>
                            <input type="number" name="bathrooms" id="bathrooms" min="0" required
                                class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                        </div>

                        <div class="mb-4">
                            <label for="image" class="block text-sm font-medium text-gray-700">Image</label>
                            <input type="file" name="image" id="image" accept="image/*"
                                class="mt-1 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
                        </div>
                    </div>
                </div>

                <div class="mb-4 mt-4">
                    <label for="description" class="block text-sm font-medium text-gray-700">Description *</label>
                    <textarea name="description" id="description" rows="4" required
                        class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500"></textarea>
                </div>

                <div class="flex justify-end mt-6">
                    <a href="{{ route('agent.properties.index') }}" class="bg-white py-2 px-4 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                        Annuler
                    </a>
                    <button type="submit" class="ml-3 inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                        Enregistrer la propriété
                    </button>
                </div>
            </form>
        </div>
    </main>
</div>
@endsection
