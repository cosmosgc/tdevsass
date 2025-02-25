<x-app-layout>
    @php
        //$enabledNetworks = json_decode($settings->enabled_networks ?? '[]', true);
        //$apiKeys = json_decode($settings->api_keys ?? '{}', true); // Decodes stored API keys
    @endphp

    <div class="container mx-auto max-w-2xl px-6 py-8">
        <h1 class="text-3xl font-bold text-white text-center mb-6">⚙️ Configurações do Agendador</h1>

        <div class="bg-gray-800 p-6 rounded-lg shadow-lg">
            <form action="{{ url('social-scheduler/settings/save') }}" method="POST" class="space-y-4">
                @csrf

                <div>
                    <label class="text-white">🔵 Facebook API Key</label>
                    <input type="text" name="facebook_api" value="{{ $apiKeys['facebook'] ?? '' }}"
                        class="w-full p-3 rounded-lg bg-gray-900 text-white focus:ring focus:ring-blue-500">
                </div>

                <div>
                    <label class="text-white">🐦 Twitter API Key</label>
                    <input type="text" name="twitter_api" value="{{ $apiKeys['twitter'] ?? '' }}"
                        class="w-full p-3 rounded-lg bg-gray-900 text-white focus:ring focus:ring-blue-500">
                </div>

                <div>
                    <label class="text-white">🌐 WordPress API URL</label>
                    <input type="text" name="wordpress_api" value="{{ $apiKeys['wordpress'] ?? '' }}"
                        class="w-full p-3 rounded-lg bg-gray-900 text-white focus:ring focus:ring-blue-500">
                </div>

                <!-- Checkboxes de Redes Sociais -->
                <div class="mt-4">
                    <h2 class="text-white font-semibold mb-2">📢 Ativar Redes Sociais</h2>

                    <div class="flex flex-col space-y-2">
                        @foreach(['facebook' => 'Facebook', 'twitter' => 'Twitter', 'wordpress' => 'WordPress'] as $key => $label)
                            <label class="inline-flex items-center text-white">
                                <input type="checkbox" name="enabled_networks[]" value="{{ $key }}"
                                    class="form-checkbox h-5 w-5 text-blue-500 rounded"
                                    {{ in_array($key, $enabledNetworks) ? 'checked' : '' }}>
                                <span class="ml-2">{{ $label }}</span>
                            </label>
                        @endforeach
                    </div>
                </div>

                <button type="submit"
                    class="w-full bg-green-500 hover:bg-green-600 text-white font-bold py-3 px-4 rounded-lg transition duration-200">
                    💾 Salvar Configurações
                </button>
            </form>
        </div>
    </div>
</x-app-layout>
