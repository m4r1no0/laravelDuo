<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                🎤 {{ $artist->name }}
            </h2>
            <div class="flex space-x-2">
                <a href="{{ route('artists.edit', $artist) }}" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">
                    ✏️ Editar
                </a>
                <a href="{{ route('artists.index') }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                    ↩️ Volver
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <!-- Información del Artista -->
                    <div class="flex flex-col md:flex-row gap-8 mb-8">
                        <!-- Imagen -->
                        <div class="flex-shrink-0">
                            @if($artist->image)
                            <img src="{{ asset('storage/' . $artist->image) }}" alt="{{ $artist->name }}" class="h-48 w-48 rounded-lg object-cover shadow-lg">
                            @else
                            <div class="h-48 w-48 bg-gray-200 rounded-lg flex items-center justify-center text-6xl shadow-lg">
                                🎤
                            </div>
                            @endif
                        </div>

                        <!-- Información -->
                        <div class="flex-grow">
                            <h1 class="text-3xl font-bold text-gray-900 mb-4">{{ $artist->name }}</h1>
                            
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
                                @if($artist->country)
                                <div>
                                    <span class="font-semibold text-gray-700">🌍 País:</span>
                                    <span class="ml-2 text-gray-600">{{ $artist->country }}</span>
                                </div>
                                @endif
                                
                                @if($artist->birth_date)
                                <div>
                                    <span class="font-semibold text-gray-700">📅 Fecha:</span>
                                    <span class="ml-2 text-gray-600">{{ $artist->birth_date->format('d/m/Y') }}</span>
                                </div>
                                @endif
                                
                                <div>
                                    <span class="font-semibold text-gray-700">🎵 Canciones:</span>
                                    <span class="ml-2 text-gray-600">{{ $artist->total_songs }}</span>
                                </div>
                                
                                <div>
                                    <span class="font-semibold text-gray-700">💿 Álbumes:</span>
                                    <span class="ml-2 text-gray-600">{{ $artist->total_albums }}</span>
                                </div>
                            </div>

                            @if($artist->bio)
                            <div>
                                <h3 class="font-semibold text-gray-700 mb-2">📖 Biografía:</h3>
                                <p class="text-gray-600 leading-relaxed">{{ $artist->bio }}</p>
                            </div>
                            @endif
                        </div>
                    </div>

                    <!-- Álbumes del Artista -->
                    <div class="mb-8">
                        <h3 class="text-xl font-semibold text-gray-900 mb-4">💿 Álbumes</h3>
                        @if($artist->albums->count() > 0)
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                            @foreach($artist->albums as $album)
                            <div class="border border-gray-200 rounded-lg p-4 hover:shadow-md transition">
                                <h4 class="font-semibold text-gray-900">{{ $album->title }}</h4>
                                <p class="text-sm text-gray-600">{{ $album->release_year }} • {{ $album->total_tracks }} canciones</p>
                                @if($album->description)
                                <p class="text-sm text-gray-500 mt-2">{{ Str::limit($album->description, 80) }}</p>
                                @endif
                            </div>
                            @endforeach
                        </div>
                        @else
                        <p class="text-gray-500 text-center py-4">No hay álbumes registrados para este artista.</p>
                        @endif
                    </div>

                    <!-- Canciones Populares -->
                    <div>
                        <h3 class="text-xl font-semibold text-gray-900 mb-4">🎵 Canciones Populares</h3>
                        @if($artist->songs->count() > 0)
                        <div class="space-y-2">
                            @foreach($artist->songs->take(5) as $song)
                            <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                                <div class="flex items-center">
                                    <div class="w-8 h-8 bg-blue-100 rounded flex items-center justify-center mr-3">
                                        🎵
                                    </div>
                                    <div>
                                        <h4 class="font-medium text-gray-900">{{ $song->title }}</h4>
                                        <p class="text-sm text-gray-600">{{ $song->album->title }} • {{ $song->duration_formatted }}</p>
                                    </div>
                                </div>
                                <div class="text-right">
                                    <span class="text-sm text-gray-500">{{ $song->plays_count }} reproducciones</span>
                                </div>
                            </div>
                            @endforeach
                        </div>
                        @else
                        <p class="text-gray-500 text-center py-4">No hay canciones registradas para este artista.</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>