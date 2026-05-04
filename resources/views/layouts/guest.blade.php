<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        <style>
            .sm\:max-w-md label {
                color: #e2e8f0 !important;
            }
            .sm\:max-w-md .text-gray-600 {
                color: #cbd5e1 !important;
            }
        </style>
    </head>
    <body class="font-sans text-gray-900 antialiased">
        <video autoplay loop muted playsinline id="video-background" style="position: fixed; right: 0; bottom: 0; min-width: 100%; min-height: 100%; width: auto; height: auto; z-index: -100;">
            <source src="/images/Fondo2.mp4" type="video/mp4">
        </video>
        <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0" style="background-color: rgba(238, 242, 255, 0.4);">
            <div>
                <a href="/">
                    <x-application-logo class="w-20 h-20 fill-current text-indigo-600" style="filter: drop-shadow(0 0 10px rgba(59, 91, 219, 0.3));" />
                </a>
            </div>

            <div class="w-full sm:max-w-md mt-6 px-6 py-4 shadow-xl overflow-hidden sm:rounded-lg" style="background-color: #1e2a45; border: 1px solid rgba(116, 143, 252, 0.4); color: white;">
                {{ $slot }}
            </div>
        </div>
    </body>
</html>
