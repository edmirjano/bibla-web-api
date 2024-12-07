<x-app-layout>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <div class="p-6">
                    <h3 class="text-2xl font-bold mb-4">Trashed Songs</h3>

                    @if ($songs->isEmpty())
                        <p>No trashed songs found.</p>
                    @else
                        <table class="min-w-full leading-normal">
                            <thead>
                            <tr>
                                <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-sm font-semibold text-gray-600 uppercase tracking-wider">
                                    Title
                                </th>
                                <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-sm font-semibold text-gray-600 uppercase tracking-wider">
                                    Author(s)
                                </th>
                                <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-sm font-semibold text-gray-600 uppercase tracking-wider">
                                    Action
                                </th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach ($songs as $song)
                                <tr class="border-b border-gray-200">
                                    <td class="px-5 py-5 bg-white text-sm">
                                        <div class="flex items-center">
                                            <img src="{{ asset($song->cover ?? 'icons/song.png') }}" alt="Cover" class="w-10 h-10 rounded-full mr-3">
                                            <div>
                                                {{ $song->title }}
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-5 py-5 bg-white text-sm">
                                        @if ($song->authors->isNotEmpty())
                                            <ul>
                                                @foreach ($song->authors as $author)
                                                    <li>{{ $author->name }}</li>
                                                @endforeach
                                            </ul>
                                        @else
                                            <span>No authors</span>
                                        @endif
                                    </td>
                                    <td class="px-5 py-5 bg-white text-sm">
                                        <form action="{{ route('song.restore', $song->id) }}" method="POST">
                                            @csrf
                                            <button type="submit" class="bg-green-500 text-white px-4 py-2 rounded hover:bg-green-700">
                                                Restore
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                        <div class="mt-4">
                            {{ $songs->links() }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
