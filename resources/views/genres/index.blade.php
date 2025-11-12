<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                🎼 Géneros Musicales
            </h2>
            <a href="{{ route('genres.create') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                ➕ Nuevo Género
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
                @foreach($genres as $genre)
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg card-hover border-l-4" style="border-left-color: {{ $genre->color ?? '#6b7280' }}">
                    <div class="p-6">
                        <div class="flex items-center justify-between mb-4">
                            <h3 class="text-lg font-semibold text-gray-900">{{ $genre->name }}</h3>
                            <div class="w-6 h-6 rounded-full" style="background-color: {{ $genre->color ?? '#6b7280' }}"></div>
                        </div>
                        
                        @if($genre->description)
                        <p class="text-sm text-gray-600 mb-4">{{ Str::limit($genre->description, 120) }}</p>
                        @endif
                        
                        <div class="flex items-center justify-between text-sm text-gray-500 mb-4">
                            <span>🎵 {{ $genre->songs_count }} canciones</span>
                        </div>
                        
                        <div class="flex space-x-2">
                            <a href="{{ route('genres.edit', $genre) }}" class="flex-1 bg-green-100 text-green-700 text-center py-2 px-4 rounded hover:bg-green-200 transition">
                                ✏️ Editar
                            </a>
                            <form action="{{ route('genres.destroy', $genre) }}" method="POST" class="flex-1">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="w-full bg-red-100 text-red-700 py-2 px-4 rounded hover:bg-red-200 transition" onclick="return confirm('¿Eliminar este género?')">
                                    🗑️ Eliminar
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>

            @if($genres->isEmpty())
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-12 text-center">
                    <div class="text-gray-400 text-6xl mb-4">🎼</div>
                    <h3 class="text-lg font-medium text-gray-900 mb-2">No hay géneros registrados</h3>
                    <p class="text-gray-600 mb-4">Comienza agregando el primer género musical.</p>
                    <a href="{{ route('genres.create') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                        ➕ Agregar Primer Género
                    </a>
                </div>
            </div>
            @endif
        </div>
    </div>
</x-app-layout>