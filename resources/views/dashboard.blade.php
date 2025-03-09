<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-3xl text-orange-400 dark:text-orange-300 leading-tight text-center">
            Tangerina Dev - <span id="typewriter"></span>
        </h2>
    </x-slot>

    <div class="py-12 bg-gray-950 bg-opacity-90 backdrop-blur-lg">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Hero Section -->
            <div class="bg-gray-900 bg-opacity-80 backdrop-blur-xl shadow-xl sm:rounded-lg border border-orange-500 p-10 text-center">
                <h1 class="text-5xl font-extrabold text-orange-400 dark:text-orange-300 mb-4 animate-pulse">Transformamos Ideias em Tecnologia</h1>
                <p class="text-lg text-gray-300 dark:text-gray-100 mb-6">Soluções SaaS e aplicativos customizados para empresas que querem inovar.</p>
                <a href="#services" class="bg-orange-500 hover:bg-orange-600 text-white font-bold py-3 px-6 rounded-lg transition duration-300 shadow-md text-lg">Conheça Nossos Serviços</a>
            </div>

            <!-- Sobre Nós -->
            <div class="mt-12 grid grid-cols-1 md:grid-cols-2 gap-8" id="services">
                <div class="bg-gray-900 bg-opacity-80 backdrop-blur-lg shadow-lg sm:rounded-lg border border-orange-500 p-6">
                    <h3 class="text-2xl font-semibold text-orange-400 dark:text-orange-300">O que Fazemos</h3>
                    <p class="mt-4 text-gray-300 dark:text-gray-100">A <strong>Tangerina Dev</strong> desenvolve plataformas SaaS e aplicativos personalizados, ajudando empresas a automatizar processos e crescer no digital.</p>
                </div>

                <div class="bg-gray-900 bg-opacity-80 backdrop-blur-lg shadow-lg sm:rounded-lg border border-orange-500 p-6">
                    <h3 class="text-2xl font-semibold text-orange-400 dark:text-orange-300">Nossos Serviços</h3>
                    <ul class="mt-4 text-gray-300 dark:text-gray-100 list-disc list-inside">
                        <li>Plataformas SaaS sob medida</li>
                        <li>Desenvolvimento de aplicativos web e mobile</li>
                        <li>Integração de APIs e automação</li>
                        <li>Consultoria em tecnologia</li>
                    </ul>
                </div>
            </div>

            <!-- Planos -->
            <div class="mt-12 grid grid-cols-1 md:grid-cols-3 gap-6 text-center">
                <div class="bg-gray-900 bg-opacity-80 backdrop-blur-lg shadow-lg sm:rounded-lg border border-orange-500 p-6">
                    <h3 class="text-xl font-semibold text-orange-400 dark:text-orange-300">Start</h3>
                    <p class="mt-2 text-gray-300 dark:text-gray-100">Ideal para startups e pequenas empresas.</p>
                </div>
                <div class="bg-gray-900 bg-opacity-80 backdrop-blur-lg shadow-lg sm:rounded-lg border border-orange-500 p-6">
                    <h3 class="text-xl font-semibold text-orange-400 dark:text-orange-300">Growth</h3>
                    <p class="mt-2 text-gray-300 dark:text-gray-100">Para negócios em expansão.</p>
                </div>
                <div class="bg-gray-900 bg-opacity-80 backdrop-blur-lg shadow-lg sm:rounded-lg border border-orange-500 p-6">
                    <h3 class="text-xl font-semibold text-orange-400 dark:text-orange-300">Enterprise</h3>
                    <p class="mt-2 text-gray-300 dark:text-gray-100">Soluções customizadas para grandes empresas.</p>
                </div>
            </div>

            <!-- CTA Final -->
            <div class="mt-12 text-center">
                <a href="{{ url('/services') }}"
                   class="bg-orange-500 hover:bg-orange-600 text-white font-bold py-3 px-8 rounded-lg transition duration-300 shadow-md text-lg">
                    🚀 Vamos Começar
                </a>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/typewriter-effect@latest/dist/core.js"></script>
    <script>
        var typewriter = new Typewriter(document.getElementById('typewriter'), {
            loop: true,
            delay: 75,
        });

        typewriter.typeString('Soluções Inteligentes para o Seu Negócio')
            .pauseFor(2000)
            .deleteAll()
            .typeString('Desenvolvimento de Software Sob Medida')
            .pauseFor(2000)
            .deleteAll()
            .typeString('Tecnologia para Impulsionar sua Empresa')
            .pauseFor(2000)
            .start();
    </script>
</x-app-layout>
