<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
    <header class="bg-white shadow">
        <div class="px-6 py-4 flex justify-between items-center">
            <h1 class="text-2xl font-bold text-gray-800">
                @yield('page-title', 'Tableau de bord')
            </h1>
            <div class="flex items-center space-x-4">
                <!-- Notification Bell -->
                <div class="relative mr-4">
                    <button id="notificationToggle" class="relative text-gray-600 hover:text-gray-800 focus:outline-none">
                        <i class="fas fa-bell text-xl"></i>
                        @if(auth()->user()->unreadNotifications->count())
                            <span class="absolute top-0 right-0 inline-block w-4 h-4 bg-red-600 text-white text-xs leading-tight rounded-full text-center">
                                {{ auth()->user()->unreadNotifications->count() }}
                            </span>
                        @endif
                    </button>

                    <!-- Dropdown -->
                    <div id="notificationDropdown" class="hidden absolute right-0 mt-2 w-64 bg-white rounded shadow-lg z-50">
                        <div class="p-4 border-b font-semibold text-gray-700">Notifications</div>
                        <ul class="max-h-64 overflow-y-auto">
                            @forelse(auth()->user()->unreadNotifications as $notification)
                                <li class="px-4 py-2 text-sm text-gray-600 border-b">
                                    📌 {{ $notification->data['title'] ?? 'Notification' }} <br>
                                    <span class="text-xs text-gray-400">{{ $notification->created_at->diffForHumans() }}</span>
                                </li>
                            @empty
                                <li class="px-4 py-2 text-sm text-gray-500 italic">Aucune notification</li>
                            @endforelse
                        </ul>
                        <form action="{{ route('notifications.markAllAsRead') }}" method="POST" class="text-center">
                            @csrf
                            <button type="submit" class="w-full py-2 text-sm text-blue-600 hover:underline">Tout marquer comme lu</button>
                        </form>
                    </div>
                </div>

                {{-- <div class="relative">
                    <img class="h-8 w-8 rounded-full" src="https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?auto=format&fit=facearea&facepad=2&w=256&h=256&q=80" alt="User Avatar">
                </div> --}}
            </div>
        </div>
    </header>
    <script>
        const toggle = document.getElementById('notificationToggle');
        const dropdown = document.getElementById('notificationDropdown');

        toggle.addEventListener('click', () => {
            dropdown.classList.toggle('hidden');
        });

        document.addEventListener('click', function (e) {
            if (!toggle.contains(e.target) && !dropdown.contains(e.target)) {
                dropdown.classList.add('hidden');
            }
        });
    </script>
</body>
</html>
