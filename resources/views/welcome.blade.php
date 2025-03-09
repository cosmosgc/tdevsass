<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Bem-vindo ao Tangerina Dev</title>
        @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
            @vite(['resources/css/app.css', 'resources/js/app.js'])
        @else
            <style>
                /* Adicione seus estilos adicionais, se necessário */
            </style>
        @endif
    </head>
    <body class="bg-[#FDFDFC] dark:bg-[#0a0a0a] text-[#1b1b18] dark:text-[#EDEDEC] flex items-center justify-center min-h-screen flex-col p-6">

        <div class="text-center mb-8">
            <h1 class="text-4xl font-extrabold text-[#1b1b18] dark:text-[#EDEDEC] mb-4">Bem-vindo ao nosso site!</h1>
            <p class="text-lg text-[#1b1b18] dark:text-[#EDEDEC] mb-6">
                Conecte-se com outras pessoas, compartilhe suas ideias e muito mais!
            </p>

            <!-- Botões de Login e Registro -->
            <div class="space-x-4">
                @if (Route::has('login'))
                    @auth
                        <a href="{{ url('/dashboard') }}" class="inline-block px-6 py-3 bg-indigo-600 text-white rounded-lg text-lg hover:bg-indigo-700 dark:bg-indigo-700 dark:hover:bg-indigo-600 transition duration-200">
                            Acessar Dashboard
                        </a>
                    @else
                        <a href="{{ route('login') }}" class="inline-block px-6 py-3 bg-indigo-600 text-white rounded-lg text-lg hover:bg-indigo-700 dark:bg-indigo-700 dark:hover:bg-indigo-600 transition duration-200">
                            Login
                        </a>
                        @if (Route::has('register'))
                            <a href="{{ route('register') }}" class="inline-block px-6 py-3 bg-transparent border-2 border-indigo-600 text-indigo-600 rounded-lg text-lg hover:bg-indigo-600 hover:text-white dark:text-[#EDEDEC] dark:border-[#3E3E3A] dark:hover:bg-indigo-700 dark:hover:text-white transition duration-200">
                                Registrar
                            </a>
                        @endif
                    @endauth
                @endif
            </div>
        </div>

        <!-- Seção informativa adicional (opcional) -->
        <div class="text-center mt-12">
            <h2 class="text-2xl font-semibold text-[#1b1b18] dark:text-[#EDEDEC] mb-4">O que oferecemos</h2>
            <p class="text-lg text-[#1b1b18] dark:text-[#EDEDEC] mb-6">
                Nosso site oferece uma plataforma segura e interativa onde você pode explorar novos conteúdos, conectar-se com outras pessoas e muito mais.
            </p>
            <a href="#features" class="text-indigo-600 hover:text-indigo-500 dark:text-[#3B82F6] dark:hover:text-[#2563EB] text-lg">
                Saiba mais sobre as funcionalidades
            </a>
        </div>

        <!-- Seção de funcionalidades (opcional) -->
        <div id="features" class="w-full max-w-screen-xl mx-auto mt-12 text-center">
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
                <div class="p-6 bg-white dark:bg-[#1b1b18] rounded-lg shadow-md">
                    <h3 class="text-xl font-semibold text-[#1b1b18] dark:text-[#EDEDEC] mb-2">Funcionalidade 1</h3>
                    <p class="text-gray-600 dark:text-gray-400">Uma breve descrição da funcionalidade que você oferece. Exemplo: Sistema de mensagens instantâneas.</p>
                </div>
                <div class="p-6 bg-white dark:bg-[#1b1b18] rounded-lg shadow-md">
                    <h3 class="text-xl font-semibold text-[#1b1b18] dark:text-[#EDEDEC] mb-2">Funcionalidade 2</h3>
                    <p class="text-gray-600 dark:text-gray-400">Outra descrição sobre uma funcionalidade interessante. Exemplo: Gerenciamento de contas e permissões.</p>
                </div>
                <div class="p-6 bg-white dark:bg-[#1b1b18] rounded-lg shadow-md">
                    <h3 class="text-xl font-semibold text-[#1b1b18] dark:text-[#EDEDEC] mb-2">Funcionalidade 3</h3>
                    <p class="text-gray-600 dark:text-gray-400">Descrição de mais uma funcionalidade legal. Exemplo: Relatórios detalhados sobre atividades.</p>
                </div>
            </div>
        </div>

    </body>
</html>
