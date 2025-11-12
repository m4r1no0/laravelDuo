<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                💿 Álbumes
            </h2>
            <a href="{{ route('albums.create') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                ➕ Nuevo Álbum
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
                @foreach($albums as $album)
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg card-hover">
                    <div class="p-6">
                        <div class="flex items-center mb-4">
                            @if($album->cover_image)
                            <img src="{{ asset('storage/' . $album->cover_image) }}" alt="{{ $album->title }}" class="h-16 w-16 rounded-lg object-cover">
                            @else
                            <div class="h-16 w-16 bg-gray-200 rounded-lg flex items-center justify-center text-2xl">
                                💿
                            </div>
                            @endif
                            <div class="ml-4">
                                <h3 class="text-lg font-semibold text-gray-900">{{ $album->title }}</h3>
                                <p class="text-sm text-gray-600">{{ $album->artist->name }}</p>
                            </div>
                        </div>
                        
                        @if($album->description)
                        <p class="text-sm text-gray-600 mb-4 line-clamp-2">
                            {{ Str::limit($album->description, 100) }}
                        </p>
                        @endif
                        
                        <div class="flex justify-between items-center text-sm text-gray-500 mb-4">
                            <span>📅 {{ $album->release_year }}</span>
                            <span>🎵 {{ $album->total_tracks }} canciones</span>
                        </div>
                        
                        <div class="flex space-x-2">
                            <a href="{{ route('albums.show', $album) }}" class="flex-1 bg-blue-100 text-blue-700 text-center py-2 px-4 rounded hover:bg-blue-200 transition">
                                👁️ Ver
                            </a>
                            <a href="{{ route('albums.edit', $album) }}" class="flex-1 bg-green-100 text-green-700 text-center py-2 px-4 rounded hover:bg-green-200 transition">
                                ✏️ Editar
                            </a>
                            <form action="{{ route('albums.destroy', $album) }}" method="POST" class="flex-1">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="w-full bg-red-100 text-red-700 py-2 px-4 rounded hover:bg-red-200 transition" onclick="return confirm('¿Eliminar este álbum?')">
                                    🗑️ Eliminar
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>

            @if($albums->isEmpty())
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-12 text-center">
                    <div class="text-gray-400 text-6xl mb-4">💿</div>
                    <h3 class="text-lg font-medium text-gray-900 mb-2">No hay álbumes registrados</h3>
                    <p class="text-gray-600 mb-4">Comienza agregando el primer álbum a tu biblioteca musical.</p>
                    <a href="{{ route('albums.create') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                        ➕ Agregar Primer Álbum
                    </a>
                </div>
            </div>
            @endif
        </div>
    </div>
</x-app-layout>