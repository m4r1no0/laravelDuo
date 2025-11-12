<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            🎵 Mi Biblioteca Musical
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Estadísticas -->
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <div class="flex items-center">
                        <div class="p-3 bg-blue-100 rounded-lg">
                            🎤
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-gray-600">Artistas</p>
                            <p class="text-2xl font-semibold text-gray-900">{{ \App\Models\Artistas::count() }}</p>
                        </div>
                    </div>
                </div>

                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <div class="flex items-center">
                        <div class="p-3 bg-green-100 rounded-lg">
                            🎵
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-gray-600">Canciones</p>
                            <p class="text-2xl font-semibold text-gray-900">{{ \App\Models\Canciones::count() }}</p>
                        </div>
                    </div>
                </div>

                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <div class="flex items-center">
                        <div class="p-3 bg-purple-100 rounded-lg">
                            💿
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-gray-600">Álbumes</p>
                            <p class="text-2xl font-semibold text-gray-900">{{ \App\Models\Albumes::count() }}</p>
                        </div>
                    </div>
                </div>

                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <div class="flex items-center">
                        <div class="p-3 bg-yellow-100 rounded-lg">
                            🎼
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-gray-600">Playlists</p>
                            <p class="text-2xl font-semibold text-gray-900">{{ \App\Models\Playlist::count() }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Acciones Rápidas -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                <a href="{{ route('canciones.index') }}" class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 card-hover border-l-4 border-blue-500">
                    <div class="flex items-center">
                        <div class="p-2 bg-blue-100 rounded-lg">
                            ➕
                        </div>
                        <div class="ml-4">
                            <h3 class="text-lg font-medium text-gray-900">Agregar Canción</h3>
                            <p class="text-sm text-gray-600">Nueva canción a la biblioteca</p>
                        </div>
                    </div>
                </a>

                <a href="{{ route('playlists.create') }}" class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 card-hover border-l-4 border-green-500">
                    <div class="flex items-center">
                        <div class="p-2 bg-green-100 rounded-lg">
                            📝
                        </div>
                        <div class="ml-4">
                            <h3 class="text-lg font-medium text-gray-900">Crear Playlist</h3>
                            <p class="text-sm text-gray-600">Organiza tus canciones</p>
                        </div>
                    </div>
                </a>

                <a href="{{ route('artistas.index') }}" class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 card-hover border-l-4 border-purple-500">
                    <div class="flex items-center">
                        <div class="p-2 bg-purple-100 rounded-lg">
                            👤
                        </div>
                        <div class="ml-4">
                            <h3 class="text-lg font-medium text-gray-900">Ver Artistas</h3>
                            <p class="text-sm text-gray-600">Explora todos los artistas</p>
                        </div>
                    </div>
                </a>

                <a href="{{ route('favorites.index') }}" class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 card-hover border-l-4 border-red-500">
                    <div class="flex items-center">
                        <div class="p-2 bg-red-100 rounded-lg">
                            ❤️
                        </div>
                        <div class="ml-4">
                            <h3 class="text-lg font-medium text-gray-900">Mis Favoritos</h3>
                            <p class="text-sm text-gray-600">Canciones que te gustan</p>
                        </div>
                    </div>
                </a>
            </div>

            <!-- Canciones Populares -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">🎧 Canciones Populares</h3>
                    <div class="space-y-4">
                        @foreach(\App\Models\Canciones::with(['artista', 'album'])->popular()->limit(5)->get() as $cancion)
                        <div class="flex items-center justify-between p-4 bg-gray-50 rounded-lg">
                            <div class="flex items-center">
                                <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center">
                                    🎵
                                </div>
                                <div class="ml-4">
                                    <h4 class="font-medium text-gray-900">{{ $cancion->titulo }}</h4>
                                    <p class="text-sm text-gray-600">{{ $cancion->artista->nombre }} • {{ $cancion->album->titulo }}</p>
                                </div>
                            </div>
                            <div class="text-right">
                                <p class="text-sm text-gray-600">{{ $cancion->duracion_formateada }}</p>
                                <p class="text-xs text-gray-500">{{ $cancion->reproducciones_count }} reproducciones</p>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>