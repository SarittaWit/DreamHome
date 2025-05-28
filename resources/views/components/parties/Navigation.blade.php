<!-- Alpine.js -->
<script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>

<!-- Navigation Bar -->
<nav class="bg-white shadow-lg" x-data="{ mobileMenu: false }">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <!-- Logo -->
            <div class="flex items-center">
                <i class="fas fa-home text-blue-600 text-2xl mr-2"></i>
                <span class="text-xl font-bold text-blue-600">DreamHome</span>
            </div>

            <!-- Desktop Nav Links -->
            <div class="hidden sm:flex space-x-8 items-center">
                <a href="{{route('HomePage')}}" class="text-gray-700 hover:text-blue-600 font-medium">Accueil</a>
                <a href="{{route('HomePage')}}" class="text-gray-700 hover:text-blue-600 font-medium">Propriétés</a>
                <a href="#agents" class="text-gray-700 hover:text-blue-600 font-medium">Agents</a>
            </div>

            <!-- Profile Dropdown -->
            <div class="hidden sm:flex sm:items-center">
                @auth
                <div x-data="{ open: false, confirmLogout: false }" class="relative">
                    <button @click="open = !open" class="flex items-center space-x-2 focus:outline-none">
                        <div class="text-right">
                            <div class="text-sm font-medium text-gray-800">{{ Auth::user()->name }}</div>
                            <div class="text-xs text-gray-500">{{ Auth::user()->email }}</div>
                        </div>
                        <svg class="h-4 w-4 text-gray-500" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M5.23 7.21a1 1 0 011.42 0L10 10.59l3.36-3.38a1 1 0 111.41 1.42l-4.07 4.08a1 1 0 01-1.41 0L5.23 8.63a1 1 0 010-1.42z" clip-rule="evenodd" />
                        </svg>
                    </button>

                    <!-- Dropdown -->
                    <div x-show="open" @click.away="open = false" x-transition class="absolute right-0 mt-2 w-56 bg-white border rounded shadow-lg z-50">

                        <button @click="confirmLogout = true" class="w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Déconnexion</button>
                    </div>

                    <!-- Logout Confirmation -->
                    <div x-show="confirmLogout" @click.away="confirmLogout = false" x-transition class="absolute right-0 mt-2 w-64 bg-white border border-red-500 rounded p-4 shadow-lg z-50">
                        <p class="text-sm text-gray-700 mb-2">Êtes-vous sûr de vouloir vous déconnecter ?</p>
                        <div class="flex justify-end space-x-2">
                            <button @click="confirmLogout = false" class="px-3 py-1 text-sm text-gray-700 hover:bg-gray-100 rounded">Annuler</button>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="px-3 py-1 text-sm text-white bg-red-500 hover:bg-red-600 rounded">Déconnexion</button>
                            </form>
                        </div>
                    </div>
                </div>
                @else
                <div class="space-x-4">
                    <a href="{{ route('login') }}" class="text-gray-700 hover:text-blue-600 font-medium">Connexion</a>
                    <a href="{{ route('register') }}" class="text-gray-700 hover:text-blue-600 font-medium">Inscription</a>
                </div>
                @endauth
            </div>

            <!-- Mobile Menu Button -->
            <div class="sm:hidden flex items-center">
                <button @click="mobileMenu = !mobileMenu" class="text-gray-700 hover:text-blue-600 focus:outline-none">
                    <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path :class="{'hidden': mobileMenu, 'inline-flex': !mobileMenu }" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                        <path :class="{'inline-flex': mobileMenu, 'hidden': !mobileMenu }" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Mobile Menu -->
    <div x-show="mobileMenu" x-transition class="sm:hidden px-4 pb-3">
        <a href="{{route('HomePage')}}" class="block py-2 text-gray-700 hover:text-blue-600">Accueil</a>
        <a href="{{route('HomePage')}}" class="block py-2 text-gray-700 hover:text-blue-600">Propriétés</a>
        <a href="" class="block py-2 text-gray-700 hover:text-blue-600">Agents</a>

        @auth
        <div class="mt-2 border-t pt-2">
            <p class="text-sm font-medium text-gray-800">{{ Auth::user()->name }}</p>
            <p class="text-xs text-gray-500 mb-2">{{ Auth::user()->email }}</p>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="text-red-500 hover:underline text-sm">Déconnexion</button>
            </form>
        </div>
        @else
        <div class="mt-2 border-t pt-2">
            <a href="{{ route('login') }}" class="block py-1 text-sm text-gray-700 hover:text-blue-600">Connexion</a>
            <a href="{{ route('register') }}" class="block py-1 text-sm text-gray-700 hover:text-blue-600">Inscription</a>
        </div>
        @endauth
    </div>
</nav>
