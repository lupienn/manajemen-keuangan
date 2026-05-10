<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ isset($title) ? $title . ' — ' : '' }}{{ config('app.name', 'Manajemen Keuangan') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])

        @stack('head')
    </head>
    <body class="font-sans antialiased bg-gray-50 dark:bg-gray-900">
        <div class="min-h-screen">
            @include('layouts.header')
            @include('layouts.sidebar')

            <main class="p-4 sm:ml-64 pt-24 min-h-screen">
                {{-- Flash Messages --}}
                @if(session('success'))
                    <div id="flash-success" class="mb-4 flex items-center p-4 bg-emerald-50 border border-emerald-200 text-emerald-800 rounded-lg text-sm" role="alert">
                        <x-lucide-check-circle class="w-5 h-5 me-2 text-emerald-600 flex-shrink-0" />
                        {{ session('success') }}
                        <button onclick="document.getElementById('flash-success').remove()" class="ms-auto text-emerald-500 hover:text-emerald-700">
                            <x-lucide-x class="w-4 h-4" />
                        </button>
                    </div>
                @endif
                @if(session('error'))
                    <div id="flash-error" class="mb-4 flex items-center p-4 bg-rose-50 border border-rose-200 text-rose-800 rounded-lg text-sm" role="alert">
                        <x-lucide-alert-circle class="w-5 h-5 me-2 text-rose-600 flex-shrink-0" />
                        {{ session('error') }}
                        <button onclick="document.getElementById('flash-error').remove()" class="ms-auto text-rose-500 hover:text-rose-700">
                            <x-lucide-x class="w-4 h-4" />
                        </button>
                    </div>
                @endif

                {{ $slot }}
            </main>
        </div>

        @stack('scripts')
    </body>
</html>
