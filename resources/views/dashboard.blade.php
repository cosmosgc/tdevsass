<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-orange-400 dark:text-orange-300 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-gray-900 dark:bg-gray-800 overflow-hidden shadow-lg sm:rounded-lg border border-orange-500">
                <div class="p-6 text-gray-300 dark:text-gray-100">
                    {{ __("You're logged in!") }}
                </div>
            </div>

            <!-- Botão para a rota de Serviços -->
            <div class="mt-6 text-center">
                <a href="{{ url('/services') }}"
                   class="bg-orange-500 hover:bg-orange-600 text-white font-bold py-2 px-4 rounded-lg transition duration-200 shadow-md">
                    📌 Ver Serviços
                </a>
            </div>
        </div>
    </div>
</x-app-layout>
