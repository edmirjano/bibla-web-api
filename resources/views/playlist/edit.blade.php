<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Manage Songs for Playlist: ') }} {{ $playlist->title }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <div class="p-6 sm:px-20 bg-white border-b border-gray-200">
                    <div class="mt-8 text-2xl">
                        Add or Remove Songs for Playlist
                    </div>

                    <!-- Search Songs -->
                    <div class="mt-6">
                        <form method="GET" action="{{ route('playlist.edit', $playlist->id) }}" class="mb-4">
                            <input type="text" name="search" value="{{ request('search') }}" class="border rounded px-3 py-2 w-full" placeholder="Search for songs...">
                        </form>
                    </div>

                    <!-- Add Songs to Playlist -->
                    <form method="POST" action="{{ route('playlist.songs.update', $playlist->id) }}">
                        @csrf
                        @method('PUT')
                        <div class="grid grid-cols-1 gap-4">
                            <label for="songs" class="block text-sm font-medium text-gray-700">Select Songs:</label>
                            <select id="songs" name="songs[]" class="w-full bg-gray-200 border border-gray-200 text-black text-xs py-3 px-4 pr-8 mb-3 rounded"  multiple>
                                @foreach($songs as $song)
                                    <option value="{{ $song->id }}"
                                        {{ in_array($song->id, $playlist->songs->pluck('id')->toArray()) ? 'selected' : '' }}>
                                        {{ $song->title }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="flex items-center justify-end mt-4">
                            <button type="submit" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-500 active:bg-blue-700 focus:outline-none focus:border-blue-700 focus:ring focus:ring-blue-200 disabled:opacity-25 transition">
                                {{ __('Update Playlist') }}
                            </button>
                        </div>
                    </form>

                    <!-- Current Songs in Playlist -->
                    <div class="mt-6">
                        <h3 class="text-xl">Current Songs in Playlist:</h3>
                        <ul class="list-disc list-inside">
                            @foreach($playlist->songs as $song)
                                <li>{{ $song->title }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
