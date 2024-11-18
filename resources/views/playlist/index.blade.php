<x-app-layout>
    <x-slot name="header">
        <form method="GET" action="{{ route('playlist.index') }}" class="flex">
            <input type="text" name="search" value="{{ old('search', $query ?? '') }}" placeholder="Search songs..."
                   class="border rounded px-4 py-2">
            <button type="submit" class="ml-2 bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                Search
            </button>
        </form>
    </x-slot>
    <div class="h-screen min-h-screen p-4">
        <div class="mx-auto  h-full">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <div class="sm:px-20 container mx-auto px-4 sm:px-8">
                    <div class="flex justify-between">
                        <div class="mt-8 text-2xl font-semibold leading-tight">
                            Playlists
                        </div>

                        <div class="mt-6">
                            <x-add-button id="addPlaylistBtn">
                                {{ '+ ADD' }}
                            </x-add-button>
                        </div>
                    </div>

                    <div id="addPlaylistModal" class="modal hidden fixed inset-0 flex justify-center items-center z-50">
                        <div class="modal-content p-8 rounded-lg shadow-xl bg-modal-gray relative">
                            <span id="closeModal" class="absolute top-4 right-4 cursor-pointer">&times;</span>
                            <form id="addPlaylistForm" action="{{ route('playlist.store') }}" method="POST">
                                @csrf
                                <div class="mb-4">
                                    <label for="title"
                                        class="uppercase tracking-wide text-black text-xs font-bold mb-2">Playlist
                                        Title:</label>
                                    <input type="text" id="title" name="title" required
                                        class="w-full bg-gray-200 text-black border border-gray-200 rounded py-3 px-4 mb-3">
                                </div>
                                <x-add-button id="addPlaylistBtn">
                                    {{ 'Add Playlist' }}
                                </x-add-button>
                            </form>
                        </div>
                    </div>

                    <!-- Playlists Table -->
                    <div class="mt-6 inline-block min-w-full shadow-md rounded-md overflow-hidden">
                        <table class="min-w-full leading-normal">
                            <thead>
                                <tr>
                                    <th
                                        class="px-5 py-3 border-b-2 border-200-gray bg-light-gray text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">
                                        ID
                                    </th>
                                    <th
                                        class="px-5 py-3 border-b-2 border-200-gray bg-light-gray text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">
                                        Title
                                    </th>
                                    <th
                                        class="px-5 py-3 border-b-2 border-200-gray bg-light-gray text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">
                                        Delete
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($playlists as $playlist)
                                    <tr class="border-b border-table-gray">
                                        <td class="px-5 py-5 bg-white text-sm whitespace-nowrap">
                                            {{ $playlist->id }}
                                        </td>
                                        <td class="px-5 py-5 bg-white text-sm whitespace-nowrap">
                                            <input type="text" name="playlist_title" id="{{ $playlist->id }}"
                                                value="{{ $playlist->title }}"
                                                class="w-full bg-gray-200 text-black border border-gray-200 rounded py-3 px-4 mb-3">
                                        </td>
                                        <td class="px-5 py-5 bg-white text-sm whitespace-nowrap">
                                            <div class="flex justify-around">
                                                <a href="{{ route('playlist.edit', $playlist->id) }}">
                                                    <img src="{{ asset('icons/edit.svg') }}" alt="Edit">
                                                </a>
                                                <form action="{{ route('playlist.destroy', $playlist->id) }}" method="POST"
                                                    class="inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit">
                                                        <img src="{{ asset('icons/delete.svg') }}" alt="Delete">
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- JavaScript Section -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script>
        $(document).ready(function () {
            // Show Add Playlist Modal on button click
            $("#addPlaylistBtn").click(function () {
                $("#addPlaylistModal").removeClass('hidden');
            });

            // Hide the modal when the close button is clicked
            $("#closeModal").click(function () {
                $("#addPlaylistModal").addClass('hidden');
            });

            // Hide the modal when clicked outside of it
            $(window).click(function (event) {
                if (event.target == document.getElementById("addPlaylistModal")) {
                    $("#addPlaylistModal").addClass('hidden');
                }
            });

            // AJAX request to update playlist title on input change
            $('input[name="playlist_title"]').on('input', function () {
                var playlistId = $(this).attr('id');
                var newTitle = $(this).val();
                updatePlaylistTitle(playlistId, newTitle);
            });

            function updatePlaylistTitle(playlistId, newTitle) {
                $.ajax({
                    url: '{{ route('playlist.update', ['playlist' => '__playlist__']) }}'.replace(
                        '__playlist__', playlistId),
                    type: 'PUT',
                    data: {
                        title: newTitle,
                        _token: '{{ csrf_token() }}'
                    },
                    success: function (response) {
                        console.log('Playlist title updated successfully');
                    },
                    error: function (xhr) {
                        console.log('Error updating playlist title');
                    }
                });
            }
        });
    </script>
</x-app-layout>
