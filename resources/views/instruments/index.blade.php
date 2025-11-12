<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                🎹 Instrumentos Musicales
            </h2>
            <a href="{{ route('instruments.create') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                ➕ Nuevo Instrumento
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

            <!-- Filtros por tipo -->
            <div class="mb-6 flex flex-wrap gap-2">
                <a href="{{ route('instruments.index') }}" class="px-4 py-2 rounded-full {{ !request('type') ? 'bg-blue-500 text-white' : 'bg-gray-200 text-gray-700' }}">
                    Todos
                </a>
                @foreach(['cuerda', 'viento', 'percusion', 'electrico'] as $type)
                <a href="{{ route('instruments.index', ['type' => $type]) }}" class="px-4 py-2 rounded-full {{ request('type') == $type ? 'bg-blue-500 text-white' : 'bg-gray-200 text-gray-700' }}">
                    {{ ucfirst($type) }}
                </a>
                @endforeach
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($instruments as $instrument)
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg card-hover">
                    <div class="p-6">
                        <div class="flex items-center justify-between mb-4">
                            <h3 class="text-lg font-semibold text-gray-900">{{ $instrument->name }}</h3>
                            <span class="bg-gray-100 text-gray-800 text-xs px-2 py-1 rounded-full capitalize">
                                {{ $instrument->type }}
                            </span>
                        </div>
                        
                        @if($instrument->description)
                        <p class="text-sm text-gray-600 mb-4">
                            {{ Str::limit($instrument->description, 120) }}
                        </p>
                        @endif
                        
                        <div class="flex justify-between items-center text-sm text-gray-500 mb-4">
                            <span>🎵 {{ $instrument->songs_count }} canciones</span>
                        </div>
                        
                        <div class="flex space-x-2">
                            <a href="{{ route('instruments.edit', $instrument) }}" class="flex-1 bg-green-100 text-green-700 text-center py-2 px-4 rounded hover:bg-green-200 transition">
                                ✏️ Editar
                            </a>
                            <form action="{{ route('instruments.destroy', $instrument) }}" method="POST" class="flex-1">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="w-full bg-red-100 text-red-700 py-2 px-4 rounded hover:bg-red-200 transition" onclick="return confirm('¿Eliminar este instrumento?')">
                                    🗑️ Eliminar
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>

            @if($instruments->isEmpty())
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-12 text-center">
                    <div class="text-gray-400 text-6xl mb-4">🎹</div>
                    <h3 class="text-lg font-medium text-gray-900 mb-2">No hay instrumentos registrados</h3>
                    <p class="text-gray-600 mb-4">Comienza agregando el primer instrumento musical.</p>
                    <a href="{{ route('instruments.create') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                        ➕ Agregar Primer Instrumento
                    </a>
                </div>
            </div>
            @endif
        </div>
    </div>
</x-app-layout>