<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion Agent | DreamHome</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        .login-card {
            transition: all 0.3s ease;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
        .login-card:hover {
            box-shadow: 0 10px 15px rgba(0, 0, 0, 0.1);
        }
        .input-field:focus {
            border-color: #3B82F6;
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.2);
        }
    </style>
</head>
<body class="bg-gray-100 min-h-screen flex items-center justify-center">
    <div class="w-full max-w-md mx-4">
        <div class="login-card bg-white rounded-lg shadow-md overflow-hidden">
            <div class="bg-blue-600 py-4 px-6">
                <div class="flex items-center justify-center space-x-2">
                    <i class="fas fa-home text-white text-2xl"></i>
                    <h1 class="text-white text-xl font-bold">DreamHome</h1>
                </div>
                <h2 class="text-white text-center mt-2">Connexion Agent</h2>
            </div>

            <div class="p-6">
                @if(session('error'))
                <div class="mb-4 p-3 bg-red-100 border-l-4 border-red-500 text-red-700">
                    <p>{{ session('error') }}</p>
                </div>
                @endif

                <form method="POST" action="{{ route('agent.login.submit') }}">
                    @csrf
                    <div class="mb-4">
                        <label class="block text-gray-700 text-sm font-bold mb-2" for="email">
                            <i class="fas fa-envelope mr-2 text-blue-500"></i>Email
                        </label>
                        <input type="email" name="email" id="email" required
                            class="input-field w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none">
                    </div>

                    <div class="mb-6">
                        <label class="block text-gray-700 text-sm font-bold mb-2" for="password">
                            <i class="fas fa-lock mr-2 text-blue-500"></i>Mot de passe
                        </label>
                        <input type="password" name="password" id="password" required
                            class="input-field w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none">
                    </div>

                    <div class="flex items-center justify-between">
                        <button type="submit"
                            class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-md focus:outline-none focus:shadow-outline transition duration-300">
                            <i class="fas fa-sign-in-alt mr-2"></i>Se connecter
                        </button>
                    </div>
                </form>
            </div>

         
        </div>
    </div>
</body>
</html>
