<x-app-layout>
    <div class="container mx-auto px-4 py-8 text-white">
        <h1 class="text-3xl font-bold mb-6 text-center">Available Services</h1>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach ($services as $service)
                <div class="bg-gray-800 rounded-lg shadow-lg p-6">
                    <h5 class="text-xl font-semibold mb-2">{{ $service->name }}</h5>
                    <p class="text-gray-300 mb-4">{{ $service->description }}</p>
                    <p class="text-lg font-bold text-green-400">Price: ${{ number_format($service->price, 2) }}</p>
                    <a href="{{ route('services.show', $service->slug) }}" class="mt-4 inline-block bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded transition duration-200">
                        Open Service
                    </a>
                </div>
            @endforeach
        </div>
    </div>
</x-app-layout>
