<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Login - {{ config('app.name', 'Laravel') }}</title>
    <link rel="icon" href="{{ asset('daipolres.webp') }}" type="image/webp">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="https://unpkg.com/lucide@latest" onload="lucide.createIcons()"></script>
</head>

<body class="bg-gradient-to-br from-gray-50 to-gray-100 min-h-screen">
    <div class="flex min-h-screen">
        <!-- Left Panel (Branding) - Enhanced -->
        <div class="hidden lg:flex lg:w-1/2 xl:w-2/5 items-center justify-center bg-gradient-to-br from-primary via-orange-400 to-yellow-300 p-8 xl:p-12 relative overflow-hidden">
            <!-- Decorative Background Elements -->
            <div class="absolute top-0 left-0 w-full h-full opacity-10">
                <div class="absolute top-10 left-10 w-72 h-72 bg-white rounded-full blur-3xl"></div>
                <div class="absolute bottom-10 right-10 w-96 h-96 bg-white rounded-full blur-3xl"></div>
            </div>
            
            <div class="text-center relative z-10 max-w-lg">
                <div class="bg-white/20 backdrop-blur-sm rounded-3xl p-8 shadow-2xl">
                    <h1 class="text-2xl xl:text-3xl font-extrabold mb-4 leading-tight text-gray-800 drop-shadow-lg">
                        Sistem Manajemen Keuangan
                    </h1>
                    <div class="w-20 h-1 bg-gray-800 mx-auto mb-4 rounded-full"></div>
                    <p class="text-sm xl:text-base font-semibold text-gray-700 drop-shadow-md leading-relaxed">
                        Pengawasan & Optimalisasi <br>
                        Berbasis Teknologi
                    </p>
                </div>
            </div>
        </div>

        <!-- Right Panel (Form) - Enhanced -->
        <div class="w-full lg:w-1/2 xl:w-3/5 flex items-center justify-center p-4 sm:p-6 lg:p-8">
            <div class="w-full max-w-md lg:max-w-lg">

                <!-- Mobile Branding - Enhanced -->
                <div class="lg:hidden text-center mb-8 p-6 sm:p-8 bg-gradient-to-br from-primary via-orange-400 to-yellow-300 rounded-2xl shadow-xl">
                    <h1 class="text-xl sm:text-2xl font-extrabold mb-2 leading-snug text-gray-800 drop-shadow-lg">
                        Sistem Manajemen Keuangan
                    </h1>
                    <p class="text-xs sm:text-sm font-medium text-gray-700 mt-2">
                        Perusahaan
                    </p>
                </div>

                <!-- Welcome Section -->
                <div class="flex items-center justify-center mb-8 lg:mb-10">
                    <div class="text-center lg:text-left">
                        <h2 class="text-2xl sm:text-3xl lg:text-4xl font-bold text-gray-800 mb-2">
                            Selamat Datang
                        </h2>
                        <p class="text-center text-sm sm:text-base text-gray-600">
                            Silakan masuk untuk melanjutkan
                        </p>
                    </div>
                </div>

                <!-- Session Status -->
                @if(session('status'))
                    <div class="mb-4 p-3 bg-green-50 border border-green-200 rounded-lg">
                        <p class="font-medium text-sm text-green-600">
                            {{ session('status') }}
                        </p>
                    </div>
                @endif

                <!-- Form Card -->
                <div class="bg-white rounded-2xl shadow-xl p-6 sm:p-8 lg:p-10">
                    <form method="POST" action="{{ route('login') }}" class="space-y-5 sm:space-y-6">
                        @csrf

                        <!-- Login Field -->
                        <div>
                            <label for="login" class="block text-sm font-semibold text-gray-700 mb-2">
                                Username
                            </label>
                            <div class="relative">
                                <span class="absolute inset-y-0 left-0 flex items-center pl-4">
                                    <i data-lucide="user-round" class="w-5 h-5 text-gray-400"></i>
                                </span>
                                <input id="login" name="login" type="text" value="{{ old('login') }}" 
                                       required autofocus
                                       placeholder="Masukkan username Anda"
                                       class="block w-full pl-12 pr-4 py-3 sm:py-3.5 border border-gray-300 rounded-xl shadow-sm placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent transition-all duration-200 text-sm sm:text-base">
                            </div>
                            @error('login')
                                <p class="mt-2 text-xs sm:text-sm text-red-600 flex items-center">
                                    <i data-lucide="alert-circle" class="w-4 h-4 mr-1"></i>
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>

                        <!-- Password -->
                        <div>
                            <label for="password" class="block text-sm font-semibold text-gray-700 mb-2">
                                Password
                            </label>
                            <div class="relative">
                                <span class="absolute inset-y-0 left-0 flex items-center pl-4">
                                    <i data-lucide="key-round" class="w-5 h-5 text-gray-400"></i>
                                </span>
                                <input id="password" name="password" type="password" required
                                       autocomplete="current-password"
                                       placeholder="Masukkan password"
                                       class="block w-full pl-12 pr-4 py-3 sm:py-3.5 border border-gray-300 rounded-xl shadow-sm placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent transition-all duration-200 text-sm sm:text-base">
                            </div>
                            @error('password')
                                <p class="mt-2 text-xs sm:text-sm text-red-600 flex items-center">
                                    <i data-lucide="alert-circle" class="w-4 h-4 mr-1"></i>
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>

                        <!-- Remember Me -->
                        <div class="flex items-center justify-between">
                            <div class="flex items-center">
                                <input id="remember_me" name="remember" type="checkbox"
                                       class="h-4 w-4 text-primary focus:ring-primary border-gray-300 rounded cursor-pointer">
                                <label for="remember_me" class="ml-2 block text-sm text-gray-700 cursor-pointer">
                                    Ingat saya
                                </label>
                            </div>
                        </div>

                        <!-- Submit Button -->
                        <div class="pt-2">
                            <button type="submit"
                                    class="group relative w-full flex justify-center items-center py-3 sm:py-3.5 px-4 border border-transparent text-sm sm:text-base font-semibold rounded-xl text-white bg-gradient-to-r from-primary to-orange-500 hover:from-orange-500 hover:to-primary focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary shadow-lg hover:shadow-xl transform hover:-translate-y-0.5 transition-all duration-200">
                                <span>Masuk</span>
                                <i data-lucide="log-in" class="w-5 h-5 ml-2"></i>
                            </button>
                        </div>
                    </form>
                </div>

                <!-- Register Link -->
                <div class="mt-6 text-center">
                    <p class="text-sm sm:text-base text-gray-600">
                        Belum punya akun?
                        <a href="{{ route('register') }}" 
                           class="font-semibold text-primary hover:text-orange-500 transition-colors duration-200 underline-offset-4 hover:underline">
                            Daftar di sini
                        </a>
                    </p>
                </div>

                <!-- Footer Info -->
                <div class="mt-8 text-center">
                    <p class="text-xs text-gray-500">
                        © 2026 One Seulanga Nusantara. All rights reserved.
                    </p>
                </div>

            </div>
        </div>
    </div>

    <script>
        // Reinitialize Lucide icons after form loads
        document.addEventListener('DOMContentLoaded', function() {
            if (typeof lucide !== 'undefined') {
                lucide.createIcons();
            }
        });
    </script>
</body>

</html>