<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                🎧 {{ $playlist->name }}
            </h2>
            <div class="flex space-x-2">
                @if($playlist->user_id === auth()->id())
                <a href="{{ route('playlists.edit', $playlist) }}" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">
                    ✏️ Editar
                </a>
                @endif
                <a href="{{ route('playlists.index') }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                    ↩️ Volver
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <!-- Información de la Playlist -->
                    <div class="flex flex-col md:flex-row gap-8 mb-8">
                        <!-- Portada -->
                        <div class="flex-shrink-0">
                            @if($playlist->cover_image)
                            <img src="{{ asset('storage/' . $playlist->cover_image) }}" alt="{{ $playlist->name }}" class="h-48 w-48 rounded-lg object-cover shadow-lg">
                            @else
                            <div class="h-48 w-48 bg-gradient-to-br from-purple-400 to-pink-500 rounded-lg flex items-center justify-center text-4xl text-white shadow-lg">
                                🎵
                            </div>
                            @endif
                        </div>

                        <!-- Información -->
                        <div class="flex-grow">
                            <div class="flex items-center justify-between mb-4">
                                <h1 class="text-3xl font-bold text-gray-900">{{ $playlist->name }}</h1>
                                @if($playlist->is_public)
                                <span class="bg-green-100 text-green-800 text-sm px-3 py-1 rounded-full">Pública</span>
                                @else
                                <span class="bg-gray-100 text-gray-800 text-sm px-3 py-1 rounded-full">Privada</span>
                                @endif
                            </div>
                            
                            <p class="text-gray-600 mb-2">Creada por <span class="font-semibold">{{ $playlist->user->name }}</span></p>
                            
                            <div class="grid grid-cols-2 gap-4 mb-6">
                                <div>
                                    <span class="font-semibold text-gray-700">🎵 Canciones:</span>
                                    <span class="ml-2 text-gray-600">{{ $playlist->songs_count }}</span>
                                </div>
                                
                                <div>
                                    <span class="font-semibold text-gray-700">⏱️ Duración:</span>
                                    <span class="ml-2 text-gray-600">{{ $playlist->formatted_duration }}</span>
                                </div>
                            </div>

                            @if($playlist->description)
                            <div>
                                <h3 class="font-semibold text-gray-700 mb-2">📖 Descripción:</h3>
                                <p class="text-gray-600 leading-relaxed">{{ $playlist->description }}</p>
                            </div>
                            @endif
                        </div>
                    </div>

                    <!-- Lista de Canciones -->
                    <div>
                        <div class="flex justify-between items-center mb-4">
                            <h3 class="text-xl font-semibold text-gray-900">🎵 Canciones en la Playlist</h3>
                            @if($playlist->user_id === auth()->id())
                            <a href="{{ route('playlists.edit', $playlist) }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded text-sm">
                                ✏️ Gestionar Canciones
                            </a>
                            @endif
                        </div>

                        @if($playlist->songs->count() > 0)
                        <div class="space-y-2">
                            @foreach($playlist->songs as $song)
                            <div class="flex items-center justify-between p-4 bg-gray-50 rounded-lg hover:bg-gray-100 transition">
                                <div class="flex items-center">
                                    <div class="w-8 h-8 bg-blue-100 rounded flex items-center justify-center mr-4">
                                        <span class="text-sm font-medium text-blue-800">{{ $loop->iteration }}</span>
                                    </div>
                                    <div>
                                        <h4 class="font-medium text-gray-900">{{ $song->title }}</h4>
                                        <div class="flex items-center space-x-4 text-sm text-gray-600">
                                            <span>🎤 {{ $song->artist->name }}</span>
                                            <span>💿 {{ $song->album->title }}</span>
                                            <span>🎵 {{ $song->genre->name }}</span>
                                            <span>⏱️ {{ $song->duration_formatted }}</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="flex space-x-2">
                                    <a href="{{ route('songs.show', $song) }}" class="text-blue-600 hover:text-blue-900 text-sm">
                                        👁️ Ver
                                    </a>
                                    @if($playlist->user_id === auth()->id())
                                    <form action="{{ route('playlists.remove-song', ['playlist' => $playlist, 'song' => $song]) }}" method="POST" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:text-red-900 text-sm" onclick="return confirm('¿Remover esta canción de la playlist?')">
                                            🗑️ Remover
                                        </button>
                                    </form>
                                    @endif
                                </div>
                            </div>
                            @endforeach
                        </div>
                        @else
                        <div class="text-center py-8">
                            <div class="text-gray-400 text-4xl mb-4">🎵</div>
                            <p class="text-gray-500">Esta playlist no tiene canciones aún.</p>
                            @if($playlist->user_id === auth()->id())
                            <a href="{{ route('playlists.edit', $playlist) }}" class="inline-block mt-2 bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                                ➕ Agregar Canciones
                            </a>
                            @endif
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>