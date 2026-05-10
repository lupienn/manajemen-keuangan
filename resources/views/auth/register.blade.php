<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Daftar - {{ config('app.name', 'Laravel') }}</title>
    <link rel="icon" href="{{ asset('daipolres.webp') }}" type="image/webp">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="https://unpkg.com/lucide@latest" onload="lucide.createIcons()"></script>
</head>
<body class="bg-gradient-to-br from-gray-50 to-gray-100 min-h-screen">
    <div class="flex min-h-screen">
        <!-- Left Panel (Form) - Enhanced -->
        <div class="w-full lg:w-1/2 xl:w-3/5 flex items-center justify-center p-4 sm:p-6 lg:p-8">
            <div class="w-full max-w-md lg:max-w-lg">

                <!-- Mobile Branding - Enhanced -->
                <div class="lg:hidden text-center mb-8 p-6 sm:p-8 bg-gradient-to-br from-primary via-orange-400 to-yellow-300 rounded-2xl shadow-xl">
                    <img src="{{ asset('daipolres.webp') }}" alt="Logo Polres Langsa" 
                         class="w-32 h-32 sm:w-40 sm:h-40 mx-auto mb-4 drop-shadow-2xl">
                    <h1 class="text-xl sm:text-2xl font-extrabold mb-2 leading-snug text-gray-800 drop-shadow-lg">
                        DUTA PELAJAR KAMTIBMAS <br> DAN DA'I POLRI
                    </h1>
                    <p class="text-xs sm:text-sm font-medium text-gray-700 mt-2">
                        Polres Langsa
                    </p>
                </div>

                <!-- Welcome Section -->
                <div class="flex items-center justify-center mb-8 lg:mb-10">
                    <div class="text-center lg:text-left">
                    <h2 class="text-2xl sm:text-3xl lg:text-4xl font-bold text-gray-800 mb-2">
                        Buat Akun Baru
                    </h2>
                    <p class="text-center text-sm sm:text-base text-gray-600">
                        Daftarkan diri Anda untuk mengikuti lomba
                    </p>
                    </div>
                </div>

                <!-- Form Card -->
                <div class="bg-white rounded-2xl shadow-xl p-6 sm:p-8 lg:p-10">
                    <form method="POST" action="{{ route('register') }}" class="space-y-4 sm:space-y-5">
                        @csrf

                        <!-- Nama -->
                        <div>
                            <label for="nama" class="block text-sm font-semibold text-gray-700 mb-2">
                                Nama Lengkap
                            </label>
                            <div class="relative">
                                <span class="absolute inset-y-0 left-0 flex items-center pl-4">
                                    <i data-lucide="user" class="w-5 h-5 text-gray-400"></i>
                                </span>
                                <input id="nama" name="nama" type="text" value="{{ old('nama') }}" 
                                       required autofocus
                                       placeholder="Masukkan nama lengkap Anda"
                                       class="block w-full pl-12 pr-4 py-3 sm:py-3.5 border border-gray-300 rounded-xl shadow-sm placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent transition-all duration-200 text-sm sm:text-base">
                            </div>
                            @error('nama')
                                <p class="mt-2 text-xs sm:text-sm text-red-600 flex items-center">
                                    <i data-lucide="alert-circle" class="w-4 h-4 mr-1"></i>
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>

                        <!-- Asal Sekolah -->
                        <div>
                            <label for="asal_sekolah" class="block text-sm font-semibold text-gray-700 mb-2">
                                Asal Sekolah
                            </label>
                            <div class="relative">
                                <span class="absolute inset-y-0 left-0 flex items-center pl-4">
                                    <i data-lucide="school" class="w-5 h-5 text-gray-400"></i>
                                </span>
                                <input id="asal_sekolah" name="asal_sekolah" type="text" value="{{ old('asal_sekolah') }}" 
                                       required
                                       placeholder="Contoh: SMA Negeri 1 Langsa"
                                       class="block w-full pl-12 pr-4 py-3 sm:py-3.5 border border-gray-300 rounded-xl shadow-sm placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent transition-all duration-200 text-sm sm:text-base">
                            </div>
                            @error('asal_sekolah')
                                <p class="mt-2 text-xs sm:text-sm text-red-600 flex items-center">
                                    <i data-lucide="alert-circle" class="w-4 h-4 mr-1"></i>
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>

                        <!-- NISN -->
                        <div>
                            <label for="nisn" class="block text-sm font-semibold text-gray-700 mb-2">
                                NISN
                            </label>
                            <div class="relative">
                                <span class="absolute inset-y-0 left-0 flex items-center pl-4">
                                    <i data-lucide="hash" class="w-5 h-5 text-gray-400"></i>
                                </span>
                                <input id="nisn" name="nisn" type="text" value="{{ old('nisn') }}" 
                                       required
                                       placeholder="Masukkan 10 digit NISN"
                                       maxlength="10"
                                       class="block w-full pl-12 pr-4 py-3 sm:py-3.5 border border-gray-300 rounded-xl shadow-sm placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent transition-all duration-200 text-sm sm:text-base">
                            </div>
                            @error('nisn')
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
                                    <i data-lucide="lock" class="w-5 h-5 text-gray-400"></i>
                                </span>
                                <input id="password" name="password" type="password" 
                                       required autocomplete="new-password"
                                       placeholder="Minimal 8 karakter"
                                       class="block w-full pl-12 pr-4 py-3 sm:py-3.5 border border-gray-300 rounded-xl shadow-sm placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent transition-all duration-200 text-sm sm:text-base">
                            </div>
                            @error('password')
                                <p class="mt-2 text-xs sm:text-sm text-red-600 flex items-center">
                                    <i data-lucide="alert-circle" class="w-4 h-4 mr-1"></i>
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>
                        
                        <!-- Confirm Password -->
                        <div>
                            <label for="password_confirmation" class="block text-sm font-semibold text-gray-700 mb-2">
                                Konfirmasi Password
                            </label>
                            <div class="relative">
                                <span class="absolute inset-y-0 left-0 flex items-center pl-4">
                                    <i data-lucide="check-circle" class="w-5 h-5 text-gray-400"></i>
                                </span>
                                <input id="password_confirmation" name="password_confirmation" type="password" 
                                       required
                                       placeholder="Ulangi password Anda"
                                       class="block w-full pl-12 pr-4 py-3 sm:py-3.5 border border-gray-300 rounded-xl shadow-sm placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent transition-all duration-200 text-sm sm:text-base">
                            </div>
                            @error('password_confirmation')
                                <p class="mt-2 text-xs sm:text-sm text-red-600 flex items-center">
                                    <i data-lucide="alert-circle" class="w-4 h-4 mr-1"></i>
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>

                        <!-- Info Box -->
                        <div class="bg-blue-50 border border-blue-200 rounded-xl p-3 sm:p-4">
                            <div class="flex">
                                <div class="flex-shrink-0">
                                    <i data-lucide="info" class="w-5 h-5 text-blue-500"></i>
                                </div>
                                <div class="ml-3">
                                    <p class="text-xs sm:text-sm text-blue-700">
                                        Pastikan data yang Anda masukkan sudah benar. NISN akan digunakan sebagai identitas login Anda.
                                    </p>
                                </div>
                            </div>
                        </div>

                        <!-- Submit Button -->
                        <div class="pt-2">
                            <button type="submit"
                                    class="group relative w-full flex justify-center items-center py-3 sm:py-3.5 px-4 border border-transparent text-sm sm:text-base font-semibold rounded-xl text-white bg-gradient-to-r from-primary to-orange-500 hover:from-orange-500 hover:to-primary focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary shadow-lg hover:shadow-xl transform hover:-translate-y-0.5 transition-all duration-200">
                                <span>Daftar Sekarang</span>
                                <i data-lucide="user-plus" class="w-5 h-5 ml-2"></i>
                            </button>
                        </div>
                    </form>
                </div>

                <!-- Login Link -->
                <div class="mt-6 text-center">
                    <p class="text-sm sm:text-base text-gray-600">
                        Sudah punya akun?
                        <a href="{{ route('login') }}" 
                           class="font-semibold text-primary hover:text-orange-500 transition-colors duration-200 underline-offset-4 hover:underline">
                            Masuk di sini
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
        
        <!-- Right Panel (Branding) - Enhanced -->
        <div class="hidden lg:flex lg:w-1/2 xl:w-2/5 items-center justify-center bg-gradient-to-br from-primary via-orange-400 to-yellow-300 p-8 xl:p-12 relative overflow-hidden">
            <!-- Decorative Background Elements -->
            <div class="absolute top-0 left-0 w-full h-full opacity-10">
                <div class="absolute top-10 left-10 w-72 h-72 bg-white rounded-full blur-3xl"></div>
                <div class="absolute bottom-10 right-10 w-96 h-96 bg-white rounded-full blur-3xl"></div>
            </div>
            
            <div class="text-center relative z-10 max-w-lg">
                <div class="bg-white/20 backdrop-blur-sm rounded-3xl p-8 shadow-2xl">
                    <img src="{{ asset('daipolres.webp') }}" alt="Logo Polres Langsa" 
                         class="w-48 h-48 xl:w-56 xl:h-56 mx-auto mb-6 drop-shadow-2xl hover:scale-105 transition-transform duration-300">
                    <h1 class="text-2xl xl:text-3xl font-extrabold mb-4 leading-tight text-gray-800 drop-shadow-lg">
                        DUTA PELAJAR KAMTIBMAS <br> DAN DA'I POLRI
                    </h1>
                    <div class="w-20 h-1 bg-gray-800 mx-auto mb-4 rounded-full"></div>
                    <p class="text-sm xl:text-base font-semibold text-gray-700 drop-shadow-md leading-relaxed">
                        Tingkat Pelajar SMP/Sederajat, SMA/Sederajat, dan Bhabinkamtibmas <br>
                        Polsek Wilkum Polres Langsa
                    </p>
                    
                    <!-- Additional Info Card -->
                    <div class="mt-8 bg-white/30 backdrop-blur-sm rounded-2xl p-6 text-left">
                        <h3 class="text-lg font-bold text-gray-800 mb-3 flex items-center">
                            <i data-lucide="clipboard-check" class="w-5 h-5 mr-2"></i>
                            Persyaratan Pendaftaran
                        </h3>
                        <ul class="space-y-2 text-sm text-gray-700">
                            <li class="flex items-start">
                                <i data-lucide="check" class="w-4 h-4 mr-2 mt-0.5 flex-shrink-0"></i>
                                <span>Siswa aktif SMP/SMA sederajat</span>
                            </li>
                            <li class="flex items-start">
                                <i data-lucide="check" class="w-4 h-4 mr-2 mt-0.5 flex-shrink-0"></i>
                                <span>Memiliki NISN yang valid</span>
                            </li>
                            <li class="flex items-start">
                                <i data-lucide="check" class="w-4 h-4 mr-2 mt-0.5 flex-shrink-0"></i>
                                <span>Mengisi data dengan benar</span>
                            </li>
                        </ul>
                    </div>
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

        // NISN input validation (only numbers)
        document.getElementById('nisn').addEventListener('input', function(e) {
            this.value = this.value.replace(/[^0-9]/g, '');
        });
    </script>
</body>
</html>