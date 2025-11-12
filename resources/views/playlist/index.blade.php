<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                🎧 Mis Playlists
            </h2>
            <a href="{{ route('playlists.create') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                ➕ Nueva Playlist
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if(session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-6">
                {{ session('success') }}
            </div>
            @endif

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($playlists as $playlist)
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg card-hover">
                    <div class="p-6">
                        <div class="flex items-center justify-between mb-4">
                            <div class="flex items-center">
                                @if($playlist->cover_image)
                                <img src="{{ asset('storage/' . $playlist->cover_image) }}" alt="{{ $playlist->name }}" class="h-12 w-12 rounded-lg object-cover">
                                @else
                                <div class="h-12 w-12 bg-gradient-to-r from-purple-400 to-pink-500 rounded-lg flex items-center justify-center text-white">
                                    🎵
                                </div>
                                @endif
                                <div class="ml-4">
                                    <h3 class="text-lg font-semibold text-gray-900">{{ $playlist->name }}</h3>
                                    <p class="text-sm text-gray-600">por {{ $playlist->user->name }}</p>
                                </div>
                            </div>
                            @if($playlist->is_public)
                            <span class="bg-green-100 text-green-800 text-xs px-2 py-1 rounded-full">Pública</span>
                            @else
                            <span class="bg-gray-100 text-gray-800 text-xs px-2 py-1 rounded-full">Privada</span>
                            @endif
                        </div>
                        
                        @if($playlist->description)
                        <p class="text-sm text-gray-600 mb-4 line-clamp-2">
                            {{ Str::limit($playlist->description, 100) }}
                        </p>
                        @endif
                        
                        <div class="flex justify-between items-center text-sm text-gray-500 mb-4">
                            <span>🎵 {{ $playlist->songs_count }} canciones</span>
                            <span>⏱️ {{ $playlist->formatted_duration }}</span>
                        </div>
                        
                        <div class="flex space-x-2">
                            <a href="{{ route('playlists.show', $playlist) }}" class="flex-1 bg-blue-100 text-blue-700 text-center py-2 px-4 rounded hover:bg-blue-200 transition">
                                👁️ Ver
                            </a>
                            @if($playlist->user_id === auth()->id())
                            <a href="{{ route('playlists.edit', $playlist) }}" class="flex-1 bg-green-100 text-green-700 text-center py-2 px-4 rounded hover:bg-green-200 transition">
                                ✏️ Editar
                            </a>
                            <form action="{{ route('playlists.destroy', $playlist) }}" method="POST" class="flex-1">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="w-full bg-red-100 text-red-700 py-2 px-4 rounded hover:bg-red-200 transition" onclick="return confirm('¿Eliminar esta playlist?')">
                                    🗑️ Eliminar
                                </button>
                            </form>
                            @endif
                        </div>
                    </div>
                </div>
                @endforeach
            </div>

            @if($playlists->isEmpty())
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-12 text-center">
                    <div class="text-gray-400 text-6xl mb-4">🎧</div>
                    <h3 class="text-lg font-medium text-gray-900 mb-2">No hay playlists</h3>
                    <p class="text-gray-600 mb-4">Crea tu primera playlist para organizar tus canciones favoritas.</p>
                    <a href="{{ route('playlists.create') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                        ➕ Crear Primera Playlist
                    </a>
                </div>
            </div>
            @endif
        </div>
    </div>
</x-app-layout>