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
            body {
                background-color: #121212; /* Preto profundo */
                color: #f5f5f5; /* Branco suave */
            }
            header {
                background-color: #1e1e1e; /* Cinza escuro */
                border-bottom: 2px solid #ff6600; /* Laranja vibrante */
            }
            .min-h-screen {
                background-color: #181818; /* Fundo dark */
            }
            .shadow {
                box-shadow: 0 4px 6px rgba(255, 102, 0, 0.4); /* Sombra laranja */
            }
            a {
                color: #ff6600;
            }
            a:hover {
                color: #ffa64d;
            }
        </style>
    </head>
    <body class="font-sans antialiased">
        <div class="min-h-screen">
            @include('layouts.navigation')

            <!-- Page Heading -->
            @isset($header)
                <header class="shadow">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @endisset

            <!-- Page Content -->
            <main>
                {{ $slot }}
            </main>
        </div>
    </body>
</html>
