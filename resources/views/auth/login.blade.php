<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Login - {{ config('app.name', 'Manajemen Keuangan') }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-gray-50 dark:bg-gray-900 min-h-screen">
    <section class="flex flex-col md:flex-row min-h-screen">
        <!-- Branding Section -->
        <div class="hidden md:flex md:w-1/2 bg-corporate items-center justify-center p-12 text-white relative overflow-hidden">
            <div class="absolute inset-0 opacity-10">
                <div class="absolute top-0 left-0 w-64 h-64 bg-white rounded-full -translate-x-1/2 -translate-y-1/2"></div>
                <div class="absolute bottom-0 right-0 w-96 h-96 bg-white rounded-full translate-x-1/3 translate-y-1/3"></div>
            </div>
            
            <div class="relative z-10 text-center">
                <x-lucide-wallet class="w-24 h-24 mx-auto mb-6 text-white opacity-90" />
                <h1 class="text-4xl font-extrabold mb-4">Manajemen Keuangan</h1>
                <p class="text-xl text-blue-100 max-w-md mx-auto">
                    Optimalisasi dan Pengawasan Sistem Keuangan Perusahaan Berbasis Teknologi Terpercaya.
                </p>
            </div>
        </div>

        <!-- Form Section -->
        <div class="w-full md:w-1/2 flex items-center justify-center p-8 sm:p-12">
            <div class="w-full max-w-md">
                <div class="md:hidden text-center mb-8">
                    <x-lucide-wallet class="w-12 h-12 mx-auto mb-2 text-corporate" />
                    <h1 class="text-2xl font-bold text-corporate">Manajemen Keuangan</h1>
                </div>

                <div class="mb-10 text-center md:text-left">
                    <h2 class="text-3xl font-bold text-gray-900 dark:text-white">Selamat Datang</h2>
                    <p class="text-gray-600 dark:text-gray-400 mt-2">Silakan masuk ke akun Anda untuk melanjutkan.</p>
                </div>

                <!-- Session Status -->
                <x-auth-session-status class="mb-4" :status="session('status')" />

                <form method="POST" action="{{ route('login') }}" class="space-y-6">
                    @csrf

                    <!-- Email Address -->
                    <div>
                        <label for="email" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Email Perusahaan</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 flex items-center pl-3.5 pointer-events-none">
                                <x-lucide-mail class="w-5 h-5 text-gray-500 dark:text-gray-400" />
                            </div>
                            <input type="email" name="email" id="email" value="{{ old('email') }}" required autofocus
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-corporate focus:border-corporate block w-full pl-10 p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" 
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
                            <input type="password" name="password" id="password" required autocomplete="current-password"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-corporate focus:border-corporate block w-full pl-10 p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" 
                                placeholder="••••••••">
                        </div>
                        <x-input-error :messages="$errors->get('password')" class="mt-2" />
                    </div>

                    <div class="flex items-center justify-between">
                        <div class="flex items-start">
                            <div class="flex items-center h-5">
                                <input id="remember_me" name="remember" type="checkbox" class="w-4 h-4 border border-gray-300 rounded bg-gray-50 focus:ring-3 focus:ring-blue-300 dark:bg-gray-700 dark:border-gray-600 dark:focus:ring-blue-600 dark:ring-offset-gray-800">
                            </div>
                            <div class="ml-3 text-sm">
                                <label for="remember_me" class="text-gray-500 dark:text-gray-300">Ingat saya</label>
                            </div>
                        </div>
                        @if (Route::has('password.request'))
                            <a href="{{ route('password.request') }}" class="text-sm font-medium text-corporate hover:underline dark:text-blue-500">Lupa sandi?</a>
                        @endif
                    </div>

                    <button type="submit" class="w-full text-white bg-corporate hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-bold rounded-lg text-sm px-5 py-3 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800 transition-all duration-200 shadow-lg">
                        Masuk Sekarang
                    </button>

                    @if (Route::has('register'))
                        <p class="text-sm font-light text-gray-500 dark:text-gray-400 text-center">
                            Belum punya akun? <a href="{{ route('register') }}" class="font-medium text-corporate hover:underline dark:text-blue-500">Daftar di sini</a>
                        </p>
                    @endif
                </form>
            </div>
        </div>
    </section>
</body>
</html>