<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ isset($title) ? $title . ' — ' : '' }}{{ config('app.name', 'Manajemen Keuangan') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700,800,900&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])

        @stack('head')
        
        <style>
            [x-cloak] { display: none !important; }
            body { background-color: #0f172a; } /* Deep Slate 950 */
        </style>
    </head>
    <body class="font-sans antialiased text-slate-200 overflow-x-hidden bg-[#0f172a]">
        <div class="min-h-screen">
            @include('layouts.header')
            @include('layouts.sidebar')

            <main class="p-4 sm:ml-64 pt-24 min-h-screen">
                <div class="max-w-7xl mx-auto">
                    {{ $slot }}
                </div>
            </main>
        </div>

        @stack('scripts')
    </body>
</html>
