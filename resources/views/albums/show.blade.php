<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                💿 {{ $album->title }}
            </h2>
            <div class="flex space-x-2">
                <a href="{{ route('albums.edit', $album) }}" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">
                    ✏️ Editar
                </a>
                <a href="{{ route('albums.index') }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                    ↩️ Volver
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <!-- Información del Álbum -->
                    <div class="flex flex-col md:flex-row gap-8 mb-8">
                        <!-- Portada -->
                        <div class="flex-shrink-0">
                            @if($album->cover_image)
                            <img src="{{ asset('storage/' . $album->cover_image) }}" alt="{{ $album->title }}" class="h-64 w-64 rounded-lg object-cover shadow-lg">
                            @else
                            <div class="h-64 w-64 bg-gradient-to-br from-purple-400 to-blue-500 rounded-lg flex items-center justify-center text-6xl text-white shadow-lg">
                                💿
                            </div>
                            @endif
                        </div>

                        <!-- Información -->
                        <div class="flex-grow">
                            <h1 class="text-3xl font-bold text-gray-900 mb-2">{{ $album->title }}</h1>
                            <p class="text-xl text-gray-600 mb-4">por <span class="font-semibold">{{ $album->artist->name }}</span></p>
                            
                            <div class="grid grid-cols-2 gap-4 mb-6">
                                <div>
                                    <span class="font-semibold text-gray-700">📅 Año:</span>
                                    <span class="ml-2 text-gray-600">{{ $album->release_year }}</span>
                                </div>
                                
                                <div>
                                    <span class="font-semibold text-gray-700">🎵 Canciones:</span>
                                    <span class="ml-2 text-gray-600">{{ $album->total_tracks }}</span>
                                </div>
                                
                                <div>
                                    <span class="font-semibold text-gray-700">⏱️ Duración:</span>
                                    <span class="ml-2 text-gray-600">{{ $album->formatted_duration }}</span>
                                </div>
                            </div>

                            @if($album->description)
                            <div>
                                <h3 class="font-semibold text-gray-700 mb-2">📖 Descripción:</h3>
                                <p class="text-gray-600 leading-relaxed">{{ $album->description }}</p>
                            </div>
                            @endif
                        </div>
                    </div>

                    <!-- Lista de Canciones -->
                    <div>
                        <h3 class="text-xl font-semibold text-gray-900 mb-4">🎵 Lista de Canciones</h3>
                        @if($album->songs->count() > 0)
                        <div class="space-y-2">
                            @foreach($album->songs as $song)
                            <div class="flex items-center justify-between p-4 bg-gray-50 rounded-lg hover:bg-gray-100 transition">
                                <div class="flex items-center">
                                    <div class="w-8 h-8 bg-blue-100 rounded flex items-center justify-center mr-4">
                                        <span class="text-sm font-medium text-blue-800">{{ $song->track_number }}</span>
                                    </div>
                                    <div>
                                        <h4 class="font-medium text-gray-900">{{ $song->title }}</h4>
                                        <div class="flex items-center space-x-4 text-sm text-gray-600">
                                            <span>🎵 {{ $song->genre->name }}</span>
                                            <span>⏱️ {{ $song->duration_formatted }}</span>
                                            <span>👁️ {{ $song->plays_count }} reproducciones</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="flex space-x-2">
                                    <a href="{{ route('songs.show', $song) }}" class="text-blue-600 hover:text-blue-900 text-sm">
                                        👁️ Ver
                                    </a>
                                    <a href="{{ route('songs.edit', $song) }}" class="text-green-600 hover:text-green-900 text-sm">
                                        ✏️ Editar
                                    </a>
                                </div>
                            </div>
                            @endforeach
                        </div>
                        @else
                        <div class="text-center py-8">
                            <div class="text-gray-400 text-4xl mb-4">🎵</div>
                            <p class="text-gray-500">No hay canciones en este álbum.</p>
                            <a href="{{ route('songs.create') }}" class="inline-block mt-2 bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                                ➕ Agregar Canción
                            </a>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>