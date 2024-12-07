<x-app-layout>
    <x-slot name="header">

        <form method="GET" action="{{ route('playlist.trashed') }}" class="flex">
            <input type="text" name="search" value="{{ old('search', $query ?? '') }}" placeholder="Search ..."
                   class="border rounded px-4 py-2">
            <button type="submit" class="ml-2 bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                Search
            </button>
        </form>
    </x-slot>
    <div class="h-screen min-h-screen p-4">
        <div class="mx-auto h-full">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <div class="sm:px-20 container mx-auto px-4 sm:px-8">
                    <div class="flex justify-between">
                        <div class="mt-8  font-semibold leading-tight flex justify-between	 w-full">
                           <div class="text-xl">

                               Trashed Playlist
                           </div>

                            <x-add-button href="{{ route('playlist.index') }}">
                                {{ 'Index' }}
                            </x-add-button>
                        </div>

                    </div>

                    <!-- Trashed Playlists Table -->
                    <div class="mt-6 inline-block w-full shadow-md rounded-md sm:overflow-x-visible overflow-x-auto">
                        <table class="min-w-full leading-normal">
                            <thead>
                            <tr>
                                <th class="px-5 py-3 border-b-2 border-200-gray bg-light-gray text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">
                                    ID
                                </th>
                                <th class="px-5 py-3 border-b-2 border-200-gray bg-light-gray text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">
                                    Title
                                </th>
                                <th class="px-5 py-3 border-b-2 border-200-gray bg-light-gray text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">
                                    Restore
                                </th>
                            </tr>
                            </thead>
                            <tbody>
                            @forelse ($playlists as $playlist)
                                <tr class="border-b border-table-gray">
                                    <td class="px-5 py-5 bg-white text-sm whitespace-nowrap">
                                        {{ $playlist->id }}
                                    </td>
                                    <td class="px-5 py-5 bg-white text-sm whitespace-nowrap">
                                        {{ $playlist->title }}
                                    </td>
                                    <td class="px-5 py-5 bg-white text-sm whitespace-nowrap">
                                        <form action="{{ route('playlist.restore', $playlist->id) }}" method="POST">
                                            @csrf
                                            <button type="submit" class="bg-green-500 text-white px-4 py-2 rounded hover:bg-green-700">
                                                Restore
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="3" class="px-5 py-5 bg-white text-sm text-center">
                                        No trashed playlists found.
                                    </td>
                                </tr>
                            @endforelse
                            </tbody>
                        </table>
                        <div class="mt-4">
                            {{ $playlists->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
