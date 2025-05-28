@extends('layouts.app')

@section('content')
<div class="max-w-md mx-auto py-12 px-4 sm:px-6 lg:px-8">
    <div class="bg-white p-8 rounded shadow">
        <h1 class="text-2xl font-bold mb-6">Register</h1>

        @if ($errors->any())
            <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        @if (session('status'))
            <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded">
                {{ session('status') }}
            </div>
        @endif

        <form method="POST" action="{{ route('register') }}">
            @csrf
            <div class="mb-4">
                <label class="block text-gray-700 mb-2">Name</label>
                <input type="text" name="name" class="w-full p-2 border rounded" required value="{{ old('name') }}">
            </div>
            <div class="mb-4">
                <label class="block text-gray-700 mb-2">Email</label>
                <input type="email" name="email" class="w-full p-2 border rounded" required value="{{ old('email') }}">
            </div>
            <div class="mb-4">
                <label class="block text-gray-700 mb-2">Password</label>
                <input type="password" name="password" class="w-full p-2 border rounded" required>
            </div>
            <div class="mb-6">
                <label class="block text-gray-700 mb-2">Confirm Password</label>
                <input type="password" name="password_confirmation" class="w-full p-2 border rounded" required>
            </div>
            <button type="submit" class="w-full bg-blue-600 text-white p-2 rounded hover:bg-blue-700 transition">
                Register
            </button>
        </form>

        <div class="mt-4 text-center">
            <a href="{{ route('login') }}" class="text-blue-600 hover:text-blue-800 text-sm">
                Already have an account? Login here
            </a>
        </div>
    </div>
</div>
@endsection
