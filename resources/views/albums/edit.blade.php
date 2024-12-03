<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Manage Songs for Album: ') }} {{ $album->title }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <div class="p-6 sm:px-20 bg-white border-b border-gray-200">
                    <div class="mt-8 text-2xl">
                        Add or Remove Songs for Album
                    </div>

                    <!-- Search Songs -->
                    <div class="mt-6">
                        <form method="GET" action="{{ route('album.edit', $album->id) }}" class="mb-4">
                            <input type="text" name="search" value="{{ request('search') }}" class="border rounded px-3 py-2 w-full" placeholder="Search for songs...">
                        </form>
                    </div>

                    <!-- Add Songs to Album -->
                    <form method="POST" action="{{ route('album.songs.update', $album->id) }}">
                        @csrf
                        @method('PUT')
                        <div class="grid grid-cols-1 gap-4">
                            <label for="songs" class="block text-sm font-medium text-gray-700">Select Songs:</label>
                            <select id="songs" name="songs[]" class="w-full bg-gray-200 border border-gray-200 text-black text-xs py-3 px-4 pr-8 mb-3 rounded"  multiple>
                                @foreach($songs as $song)
                                    <option value="{{ $song->id }}"
                                        {{ in_array($song->id, $album->songs->pluck('id')->toArray()) ? 'selected' : '' }}>
                                        {{ $song->title }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mt-4">
                            <label for="authors" :value="__('Author')" class="block font-medium text-m text-gray-700">Authors</label>
                                <select id="authors" name="authors[]" class="block mt-1 w-full" multiple>
                                    @foreach ($authors as $author)
                                        <option value="{{ $author->id }}" 
                                            {{ isset($album) && $album->authors->contains($author->id) ? 'selected' : '' }}>
                                            {{ $author->name }}
                                        </option>
                                    @endforeach
                                </select>
                            <p class="text-xs">Press Control + Left Mouse Click to remove</p>
                        </div>


                        <div class="flex items-center justify-end mt-4">
                            <button type="submit" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-500 active:bg-blue-700 focus:outline-none focus:border-blue-700 focus:ring focus:ring-blue-200 disabled:opacity-25 transition">
                                {{ __('Update Album') }}
                            </button>
                        </div>
                    </form>

                    <!-- Current Songs in Album -->
                    <div class="mt-6">
                        <h3 class="text-xl">Current Songs in Album:</h3>
                        <ul class="list-disc list-inside">
                            @if (isset($album))
                                @foreach($album->songs as $song)
                                    <li>{{ $song->title }}</li>
                                @endforeach
                            @endif    
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
