<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100">
    <div class="min-h-screen flex items-center justify-center">
        <div class="bg-white p-8 rounded shadow-md w-full max-w-md">
            <h1 class="text-2xl font-bold mb-6">Connexion</h1>

            <form method="POST" action="{{ route('login') }}">
                @csrf

                <div class="mb-4">
                    <label class="block text-gray-700 mb-2" for="email">Email</label>
                    <input type="email" name="email" id="email" class="w-full px-3 py-2 border rounded">
                </div>

                <div class="mb-6">
                    <label class="block text-gray-700 mb-2" for="password">Mot de passe</label>
                    <input type="password" name="password" id="password" class="w-full px-3 py-2 border rounded">
                </div>

                <button type="submit" class="w-full bg-blue-500 text-white py-2 px-4 rounded hover:bg-blue-600">
                    Se connecter
                </button>
            </form>
        </div>
    </div>
</body>
</html>
