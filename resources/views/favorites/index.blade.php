<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            ❤️ Mis Canciones Favoritas
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if($favorites->count() > 0)
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <div class="space-y-4">
                        @foreach($favorites as $favorite)
                        <div class="flex items-center justify-between p-4 bg-gray-50 rounded-lg hover:bg-gray-100 transition">
                            <div class="flex items-center">
                                <div class="w-12 h-12 bg-red-100 rounded-lg flex items-center justify-center text-red-600">
                                    ❤️
                                </div>
                                <div class="ml-4">
                                    <h4 class="font-medium text-gray-900">{{ $favorite->song->title }}</h4>
                                    <div class="flex items-center space-x-4 text-sm text-gray-600">
                                        <span>🎤 {{ $favorite->song->artist->name }}</span>
                                        <span>💿 {{ $favorite->song->album->title }}</span>
                                        <span>🎵 {{ $favorite->song->genre->name }}</span>
                                        <span>⏱️ {{ $favorite->song->duration_formatted }}</span>
                                    </div>
                                </div>
                            </div>
                            <div class="flex space-x-2">
                                <a href="{{ route('songs.show', $favorite->song) }}" class="text-blue-600 hover:text-blue-900">
                                    👁️ Ver
                                </a>
                                <form action="{{ route('songs.toggle-favorite', $favorite->song) }}" method="POST" class="inline">
                                    @csrf
                                    <button type="submit" class="text-red-600 hover:text-red-900" onclick="return confirm('¿Remover de favoritos?')">
                                        🗑️ Remover
                                    </button>
                                </form>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
            @else
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-12 text-center">
                    <div class="text-gray-400 text-6xl mb-4">❤️</div>
                    <h3 class="text-lg font-medium text-gray-900 mb-2">No tienes canciones favoritas</h3>
                    <p class="text-gray-600 mb-4">Agrega algunas canciones a tus favoritos para verlas aquí.</p>
                    <a href="{{ route('songs.index') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                        🎵 Explorar Canciones
                    </a>
                </div>
            </div>
            @endif
        </div>
    </div>
</x-app-layout>