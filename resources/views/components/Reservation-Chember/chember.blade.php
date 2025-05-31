@extends('layouts.app')
@section('content')
<div class="mt-4">
    <!-- Success Alert (hidden by default) -->
    <div id="successAlert" class="hidden mb-4 bg-blue-100 border-t-4 border-blue-500 rounded-b text-blue-900 px-4 py-3 shadow-md" role="alert">
        <div class="flex">
            <div class="py-1"><svg class="fill-current h-6 w-6 text-blue-500 mr-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M2.93 17.07A10 10 0 1 1 17.07 2.93 10 10 0 0 1 2.93 17.07zm12.73-1.41A8 8 0 1 0 4.34 4.34a8 8 0 0 0 11.32 11.32zM9 11V9h2v6H9v-4zm0-6h2v2H9V5z"/></svg></div>
            <div>
                <p class="font-bold">Réservation envoyée avec succès</p>
            </div>
        </div>
    </div>

    <form method="POST" action="{{ route('reservation.store')}}" id="reservationForm">
        @csrf
        <div class="mb-4">
            <label for="visitDate" class="block text-sm font-medium text-gray-700">Date souhaitée</label>
            <input type="date" name="dateDemande" required
                class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
        </div>
        <div class="mb-4">
            <label for="visitTime" class="block text-sm font-medium text-gray-700">Heure souhaitée</label>
            <select id="visitTime" name="nbHours" required
                class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                <option value="9h-12h">9h-12h</option>
                <option value="14h-18h">14h-18h</option>
                <option value="Soirée">Soirée</option>
                <option value="Week-end">Week-end</option>
            </select>
        </div>
        <div class="mb-4">
            <label for="visitName" class="block text-sm font-medium text-gray-700">Votre nom complet</label>
            <input type="text" id="visitName" name="nameComplait" required
                class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
        </div>
        <div class="mb-4">
            <label for="visitPhone" class="block text-sm font-medium text-gray-700">Téléphone</label>
            <input type="tel" id="visitPhone" name="phone" required
                class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
        </div>
        <div class="mb-4">
            <label for="visitMessage" class="block text-sm font-medium text-gray-700">Message (optionnel)</label>
            <textarea id="visitMessage" name="message" rows="3"
                class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm"></textarea>
        </div>

        <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
            <button type="submit" id="submitBtn" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-blue-600 text-base font-medium text-white hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 sm:ml-3 sm:w-auto sm:text-sm">
                Envoyer la demande
            </button>
            <button type="button" onclick="window.location.href='{{ route('HomePage') }}'" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                Annuler
            </button>
        </div>
    </form>
</div>

<script>
    document.getElementById('reservationForm').addEventListener('submit', function(e) {
        e.preventDefault();

        // Show the success alert
        document.getElementById('successAlert').classList.remove('hidden');

        // Disable the submit button to prevent multiple submissions
        document.getElementById('submitBtn').disabled = true;

        // Submit the form after a short delay
        setTimeout(() => {
            this.submit();
        }, 1500);

        // Hide the alert after 3 seconds
        setTimeout(() => {
            document.getElementById('successAlert').classList.add('hidden');
        }, 3000);
    });
</script>

@endsection
