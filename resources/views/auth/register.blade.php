<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Daftar - {{ config('app.name', 'Manajemen Keuangan') }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-gray-50 dark:bg-gray-900 min-h-screen flex items-center justify-center p-6">
    <div class="w-full max-w-lg bg-white rounded-2xl shadow-xl overflow-hidden dark:bg-gray-800 border border-gray-100 dark:border-gray-700">
        <div class="p-8 md:p-12">
            <div class="text-center mb-10">
                <x-lucide-wallet class="w-12 h-12 mx-auto mb-4 text-corporate" />
                <h1 class="text-3xl font-bold text-gray-900 dark:text-white">Buat Akun Baru</h1>
                <p class="text-gray-600 dark:text-gray-400 mt-2">Daftarkan akun perusahaan Anda untuk mulai mengelola keuangan.</p>
            </div>

            <form method="POST" action="{{ route('register') }}" class="space-y-6">
                @csrf

                <!-- Name -->
                <div>
                    <label for="name" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Nama Lengkap</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 flex items-center pl-3.5 pointer-events-none">
                            <x-lucide-user class="w-5 h-5 text-gray-500 dark:text-gray-400" />
                        </div>
                        <input type="text" name="name" id="name" value="{{ old('name') }}" required autofocus
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-corporate focus:border-corporate block w-full pl-10 p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:text-white" 
                            placeholder="John Doe">
                    </div>
                    <x-input-error :messages="$errors->get('name')" class="mt-2" />
                </div>

                <!-- Username -->
                <div>
                    <label for="username" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Username</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 flex items-center pl-3.5 pointer-events-none">
                            <x-lucide-user-check class="w-5 h-5 text-gray-500 dark:text-gray-400" />
                        </div>
                        <input type="text" name="username" id="username" value="{{ old('username') }}" required
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-corporate focus:border-corporate block w-full pl-10 p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:text-white" 
                            placeholder="johndoe123">
                    </div>
                    <x-input-error :messages="$errors->get('username')" class="mt-2" />
                </div>

                <!-- Email Address -->
                <div>
                    <label for="email" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Email Perusahaan</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 flex items-center pl-3.5 pointer-events-none">
                            <x-lucide-mail class="w-5 h-5 text-gray-500 dark:text-gray-400" />
                        </div>
                        <input type="email" name="email" id="email" value="{{ old('email') }}" required
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-corporate focus:border-corporate block w-full pl-10 p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:text-white" 
                            placeholder="name@company.com">
                    </div>
                    <x-input-error :messages="$errors->get('email')" class="mt-2" />
                </div>

                <!-- Password -->
                <div>
                    <label for="password" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Kata Sandi</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 flex items-center pl-3.5 pointer-events-none">
                            <x-lucide-lock class="w-5 h-5 text-gray-500 dark:text-gray-400" />
                        </div>
                        <input type="password" name="password" id="password" required autocomplete="new-password"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-corporate focus:border-corporate block w-full pl-10 p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:text-white" 
                            placeholder="••••••••">
                    </div>
                    <x-input-error :messages="$errors->get('password')" class="mt-2" />
                </div>

                <!-- Confirm Password -->
                <div>
                    <label for="password_confirmation" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Konfirmasi Kata Sandi</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 flex items-center pl-3.5 pointer-events-none">
                            <x-lucide-shield-check class="w-5 h-5 text-gray-500 dark:text-gray-400" />
                        </div>
                        <input type="password" name="password_confirmation" id="password_confirmation" required
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-corporate focus:border-corporate block w-full pl-10 p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:text-white" 
                            placeholder="••••••••">
                    </div>
                    <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
                </div>

                <button type="submit" class="w-full text-white bg-corporate hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-bold rounded-lg text-sm px-5 py-3 text-center transition-all duration-200 shadow-lg">
                    Daftar Akun
                </button>

                <p class="text-sm font-light text-gray-500 dark:text-gray-400 text-center">
                    Sudah punya akun? <a href="{{ route('login') }}" class="font-medium text-corporate hover:underline">Masuk di sini</a>
                </p>
            </form>
        </div>
    </div>
</body>
</html>