<x-app-layout>
    @php
        $enabledNetworks = json_decode($settings->enabled_networks ?? '[]', true);
    @endphp

    <div class="container mx-auto max-w-2xl px-6 py-8">
        <h1 class="text-3xl font-bold text-white text-center mb-6">📅 Agendador de Postagens</h1>

        <div class="flex justify-between mb-4">
            <a href="{{ url('social-scheduler/settings') }}"
                class="text-blue-400 hover:text-blue-300 underline">⚙️ Configurações</a>
        </div>

        <div class="bg-gray-800 p-6 rounded-lg shadow-lg">
            <form action="{{ url('social-scheduler/store') }}" method="POST" class="space-y-4">
                @csrf
                <textarea
                    name="content"
                    placeholder="Escreva sua postagem..."
                    class="w-full p-3 rounded-lg bg-gray-900 text-white placeholder-gray-400 focus:ring focus:ring-blue-500"
                    required
                ></textarea>

                <input
                    type="datetime-local"
                    name="scheduled_at"
                    required
                    class="w-full p-3 rounded-lg bg-gray-900 text-white focus:ring focus:ring-blue-500"
                >

                <fieldset class="space-y-2">
                    <legend class="text-white font-bold mb-2">📢 Publicar em:</legend>

                    <label class="flex items-center space-x-2">
                        <input type="checkbox" name="platforms[]" value="facebook" class="hidden peer">
                        <span class="w-5 h-5 border-2 border-white peer-checked:bg-blue-500"></span>
                        <span class="text-white">Facebook</span>
                    </label>

                    <label class="flex items-center space-x-2">
                        <input type="checkbox" name="platforms[]" value="twitter" class="hidden peer">
                        <span class="w-5 h-5 border-2 border-white peer-checked:bg-blue-400"></span>
                        <span class="text-white">Twitter</span>
                    </label>

                    <label class="flex items-center space-x-2">
                        <input type="checkbox" name="platforms[]" value="wordpress" class="hidden peer">
                        <span class="w-5 h-5 border-2 border-white peer-checked:bg-green-500"></span>
                        <span class="text-white">WordPress</span>
                    </label>
                </fieldset>

                <button
                    type="submit"
                    class="w-full bg-blue-500 hover:bg-blue-600 text-white font-bold py-3 px-4 rounded-lg transition duration-200"
                >
                    📌 Agendar Postagem
                </button>
            </form>
        </div>

        <h2 class="text-2xl font-semibold text-white mt-8 mb-4">📜 Postagens Agendadas</h2>

        <ul class="space-y-3">
            @foreach($posts as $post)
                <li class="bg-gray-800 p-4 rounded-lg shadow-lg text-white">
                    <div class="flex justify-between">
                        <span class="flex-1">{{ $post->content }}</span>
                        <span class="text-gray-400 text-sm">
                            {{ \Carbon\Carbon::parse($post->scheduled_at)->format('d/m/Y H:i') }}
                        </span>
                    </div>
                    <div class="mt-2 text-gray-400 text-sm">
                        📢 Publicado em: {{ implode(', ', json_decode($post->platforms ?? '[]', true)) ?: 'Nenhuma' }}
                    </div>
                </li>
            @endforeach
        </ul>

        @if ($posts->isEmpty())
            <p class="text-gray-400 text-center mt-4">Nenhuma postagem agendada no momento.</p>
        @endif
    </div>
</x-app-layout>
