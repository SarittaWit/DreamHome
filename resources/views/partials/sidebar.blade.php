<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
    <div class="sidebar w-64 bg-gray-800 text-white fixed h-full">
        <div class="p-4 flex items-center justify-between border-b border-gray-700">
            <div class="flex items-center space-x-2">
                <i class="fas fa-home text-blue-400 text-xl"></i>
                <span class="text-xl font-bold">DreamHome</span>
            </div>
        </div>

        <div class="p-4 border-b border-gray-700">
            <div class="flex items-center space-x-4">
                {{-- <img class="h-10 w-10 rounded-full" src="https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?auto=format&fit=facearea&facepad=2&w=256&h=256&q=80" alt="Admin"> --}}
                <div>
                    <h4 class="font-semibold">{{ Auth::user()->name ?? 'Invité' }}</h4>
                    <p class="text-gray-400 text-sm">Administrateur</p>
                </div>
            </div>
        </div>

        <nav class="mt-4">
            <a href="{{ route('dashboard') }}" class="flex items-center px-4 py-3 text-sm font-medium text-white bg-gray-700">
                <i class="fas fa-tachometer-alt mr-3 text-blue-400"></i>
                Tableau de bord
            </a>
            <a href="{{ route('users.index') }}" class="flex items-center px-4 py-3 text-sm font-medium text-gray-300 hover:text-white hover:bg-gray-700">
                <i class="fas fa-users mr-3"></i>
                Utilisateurs
            </a>
            <a href="{{ route('properties.index') }}" class="flex items-center px-4 py-3 text-sm font-medium text-gray-300 hover:text-white hover:bg-gray-700">
                <i class="fas fa-home mr-3"></i>
                Propriétés
            </a>
            <a href="{{ route('permissions.index') }}" class="flex items-center px-4 py-3 text-sm font-medium text-gray-300 hover:text-white hover:bg-gray-700">
                <i class="fas fa-key mr-3"></i>
                Permissions
            </a>
            <a href="{{ route('notifications.index') }}" class="flex items-center px-4 py-3 text-sm font-medium text-gray-300 hover:text-white hover:bg-gray-700">
                <i class="fas fa-bell mr-3"></i>
                Notifications
            </a>
            {{-- <a href="{{ route('settings') }}" class="flex items-center px-4 py-3 text-sm font-medium text-gray-300 hover:text-white hover:bg-gray-700">
                <i class="fas fa-cog mr-3"></i>
                Paramètres
            </a> --}}
        </nav>

        <div class="absolute bottom-0 w-full p-4 border-t border-gray-700">
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="flex items-center text-gray-300 hover:text-white text-sm font-medium">
                    <i class="fas fa-sign-out-alt mr-2"></i> Déconnexion
                </button>
            </form>
        </div>
    </div>

</body>
</html>
