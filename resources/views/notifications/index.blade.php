@extends('layouts.app')

@section('page-title', 'Gestion des notifications')

@section('content')
<div class="bg-white shadow rounded-lg p-6 mb-6">
    <div class="flex justify-between items-center mb-4">
        <h2 class="text-lg font-medium text-gray-900">Gestion des notifications</h2>
        <div class="flex space-x-2">
            <button onclick="openModal('sendNotificationModal')"
                class="px-3 py-1 border border-transparent rounded-md text-sm font-medium text-white bg-blue-600 hover:bg-blue-700">
                <i class="fas fa-paper-plane mr-1"></i> Envoyer
            </button>
        </div>
    </div>

    @if(session('success'))
        <div class="mb-4 p-3 bg-green-100 text-green-800 rounded">
            {{ session('success') }}
        </div>
    @endif

    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200 text-sm">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left font-medium text-gray-500 uppercase">Date</th>
                    {{-- <th class="px-6 py-3 text-left font-medium text-gray-500 uppercase">Type</th> --}}
                    <th class="px-6 py-3 text-left font-medium text-gray-500 uppercase">Destinataires</th>
                    <th class="px-6 py-3 text-left font-medium text-gray-500 uppercase">Message</th>
                    <th class="px-6 py-3 text-left font-medium text-gray-500 uppercase">Statut</th>
                    <th class="px-6 py-3 text-left font-medium text-gray-500 uppercase">Actions</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse($notifications as $notification)
                    <tr>
                        <td class="px-6 py-4 text-gray-700">
                            {{ \Carbon\Carbon::parse($notification->created_at)->format('d/m/Y H:i') }}
                        </td>
                        {{-- <td class="px-6 py-4 text-gray-600">
                            {{ $notification->data['action'] ?? 'Notification' }}
                        </td> --}}
                        <td class="px-6 py-4 text-gray-800">
                            @php
                                // استخدم إذا كنت مشغل admin mode
                                $recipient = \App\Models\User::find($notification->notifiable_id);
                            @endphp
                            {{ $recipient->name ?? '---' }}
                        </td>
                        @php
                            $data = is_string($notification->data) ? json_decode($notification->data, true) : $notification->data;
                        @endphp
                                            
                        <td class="px-6 py-4 text-gray-600">
                            {{ $data['message'] ?? $data['title'] ?? '-' }}
                        </td>

                        <td class="px-6 py-4">
                            @if(is_null($notification->read_at))
                                <span class="px-2 py-1 text-xs bg-yellow-100 text-yellow-800 rounded">Non lue</span>
                            @else
                                <span class="px-2 py-1 text-xs bg-green-100 text-green-800 rounded">Lue</span>
                            @endif
                        </td>
                        <td class="px-6 py-4">
                            <form action="{{ route('notifications.destroy', $notification->id) }}" method="POST" onsubmit="return confirm('Supprimer cette notification ?')">
                                @csrf
                                @method('DELETE')
                                <button class="text-red-600 hover:text-red-800">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center text-gray-400 py-6 italic">Aucune notification trouvée.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-6">
        {{ $notifications->links() }}
    </div>
</div>
<!-- Modal d'envoi de notification -->
<div id="sendNotificationModal"
     class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 hidden"
     style="display: none;">
    <div class="bg-white rounded-lg p-6 w-full max-w-md relative">
        <button onclick="closeModal('sendNotificationModal')" class="absolute top-2 right-3 text-gray-600 text-xl">&times;</button>
        <h2 class="text-lg font-bold mb-4 text-gray-800">Envoyer une notification</h2>
        <form action="{{ route('notifications.send') }}" method="POST">
            @csrf
            <div class="mb-4">
                <label for="title" class="block text-sm font-medium text-gray-700 mb-1">Titre</label>
                <input type="text" name="title" id="title" required
                       class="w-full border border-gray-300 rounded px-3 py-2 focus:ring-blue-500 focus:border-blue-500">
            </div>

            <div class="mb-4">
                <label for="message" class="block text-sm font-medium text-gray-700 mb-1">Message</label>
                <textarea name="message" id="message" rows="4" required
                          class="w-full border border-gray-300 rounded px-3 py-2 focus:ring-blue-500 focus:border-blue-500"></textarea>
            </div>

            <div class="mb-4">
                <label for="user_id" class="block text-sm font-medium text-gray-700 mb-1">Destinataire</label>
                <select name="user_id" id="user_id"
                        class="w-full border border-gray-300 rounded px-3 py-2 focus:ring-blue-500 focus:border-blue-500">
                    <option value="">-- Tous les utilisateurs --</option>
                    @foreach(\App\Models\User::all() as $user)
                        <option value="{{ $user->id }}">{{ $user->name }} ({{ $user->email }})</option>
                    @endforeach
                </select>
            </div>

            <div class="flex justify-end">
                <button type="button" onclick="closeModal('sendNotificationModal')"
                        class="text-gray-500 hover:underline mr-4 text-sm">Annuler</button>
                <button type="submit"
                        class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 text-sm">Envoyer</button>
            </div>
        </form>
    </div>
</div>

<script>
    function openModal(id) {
        document.getElementById(id).style.display = 'flex';
    }

    function closeModal(id) {
        document.getElementById(id).style.display = 'none';
    }
</script>

@endsection
