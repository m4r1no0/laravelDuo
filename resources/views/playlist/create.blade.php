<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            🎧 Crear Nueva Playlist
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <form action="{{ route('playlists.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        
                        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                            <!-- Información Básica -->
                            <div class="lg:col-span-1 space-y-6">
                                <div>
                                    <label for="name" class="block text-sm font-medium text-gray-700">Nombre de la Playlist *</label>
                                    <input type="text" name="name" id="name" value="{{ old('name') }}" required
                                           class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                                    @error('name')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="cover_image" class="block text-sm font-medium text-gray-700">Imagen de Portada</label>
                                    <input type="file" name="cover_image" id="cover_image" accept="image/*"
                                           class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                                    @error('cover_image')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label class="flex items-center">
                                        <input type="checkbox" name="is_public" value="1" {{ old('is_public') ? 'checked' : '' }}
                                               class="rounded border-gray-300 text-blue-600 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                                        <span class="ml-2 text-sm text-gray-600">Playlist pública</span>
                                    </label>
                                    <p class="mt-1 text-sm text-gray-500">Las playlists públicas son visibles para todos los usuarios.</p>
                                </div>
                            </div>

                            <!-- Descripción -->
                            <div class="lg:col-span-2">
                                <label for="description" class="block text-sm font-medium text-gray-700">Descripción</label>
                                <textarea name="description" id="description" rows="4" 
                                          class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500">{{ old('description') }}</textarea>
                                @error('description')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <!-- Selección de Canciones -->
                        <div class="mt-8">
                            <label class="block text-sm font-medium text-gray-700 mb-4">🎵 Seleccionar Canciones</label>
                            
                            @if($songs->count() > 0)
                            <div class="bg-gray-50 rounded-lg p-4 max-h-96 overflow-y-auto">
                                <div class="space-y-2">
                                    @foreach($songs as $song)
                                    <label class="flex items-center p-3 bg-white rounded-lg border border-gray-200 hover:bg-blue-50 cursor-pointer">
                                        <input type="checkbox" name="songs[]" value="{{ $song->id }}" 
                                               class="rounded border-gray-300 text-blue-600 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                                        <div class="ml-3 flex-grow">
                                            <span class="text-sm font-medium text-gray-900">{{ $song->title }}</span>
                                            <div class="flex text-xs text-gray-500">
                                                <span class="mr-3">{{ $song->artist->name }}</span>
                                                <span>{{ $song->album->title }}</span>
                                                <span class="ml-auto">{{ $song->duration_formatted }}</span>
                                            </div>
                                        </div>
                                    </label>
                                    @endforeach
                                </div>
                            </div>
                            @else
                            <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-4 text-center">
                                <p class="text-yellow-800">No hay canciones disponibles. Primero agrega algunas canciones a tu biblioteca.</p>
                                <a href="{{ route('songs.create') }}" class="inline-block mt-2 bg-yellow-500 hover:bg-yellow-600 text-white font-bold py-2 px-4 rounded">
                                    ➕ Agregar Canciones
                                </a>
                            </div>
                            @endif
                        </div>

                        <div class="mt-8 flex justify-end space-x-4">
                            <a href="{{ route('playlists.index') }}" class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-bold py-2 px-4 rounded">
                                ↩️ Cancelar
                            </a>
                            <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                                💾 Crear Playlist
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>