<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Playlist Page') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <div class="p-6 sm:px-20 bg-white border-b border-gray-200">
                    <div class="mt-8 text-2xl">
                        Playlists
                    </div>

                    <!-- Button to trigger Add Playlist Modal -->
                    <div class="mt-6">
                        <button id="addPlaylistBtn" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                            Create Playlist
                        </button>
                    </div>

                    <!-- Add Playlist Modal -->
                    <div id="addPlaylistModal" class="modal hidden fixed inset-0 bg-gray-900 bg-opacity-50 flex justify-center items-center ">
                        <div class="modal-content bg-white p-8 rounded-lg">
                            <span id="closeModal" class="absolute top-4 right-4 cursor-pointer">&times;</span>
                            <form id="addPlaylistForm" action="{{ route('playlist.store') }}" method="POST">
                                @csrf
                                <div class="mb-4">
                                    <label for="title" class="block text-gray-700">Playlist Title:</label>
                                    <input type="text" id="title" name="title" required class="border rounded px-3 py-2 w-full">
                                </div>
                                <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Add Playlist</button>
                            </form>
                        </div>
                    </div>

                    <!-- Playlists Table -->
                    <div class="mt-6">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    ID
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Title
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Delete
                                </th>
                            </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($playlists as $playlist)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        {{ $playlist->id }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <input type="text" name="playlist_title" id="{{ $playlist->id }}" value="{{ $playlist->title }}">
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex justify-around">
                                            <a href="{{ route('playlist.edit', $playlist->id) }}"
                                               class="text-yellow-600 hover:text-yellow-900">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="16"
                                                     height="16" fill="currentColor" class="bi bi-pencil"
                                                     viewBox="0 0 16 16">
                                                    <path
                                                        d="M12.146.146a.5.5 0 0 1 .708 0l3 3a.5.5 0 0 1 0 .708l-10 10a.5.5 0 0 1-.168.11l-5 2a.5.5 0 0 1-.65-.65l2-5a.5.5 0 0 1 .11-.168zM11.207 2.5 13.5 4.793 14.793 3.5 12.5 1.207zm1.586 3L10.5 3.207 4 9.707V10h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.293zm-9.761 5.175-.106.106-1.528 3.821 3.821-1.528.106-.106A.5.5 0 0 1 5 12.5V12h-.5a.5.5 0 0 1-.5-.5V11h-.5a.5.5 0 0 1-.468-.325"/>
                                                </svg>                                                </a>
                                            <form action="{{ route('playlist.destroy', $playlist->id) }}" method="POST" class="inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-red-600 hover:text-red-900">Delete</button>
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
        $(document).ready(function() {
            // Show Add Playlist Modal on button click
            $("#addPlaylistBtn").click(function() {
                $("#addPlaylistModal").removeClass('hidden');
            });

            // Hide the modal when the close button is clicked
            $("#closeModal").click(function() {
                $("#addPlaylistModal").addClass('hidden');
            });

            // Hide the modal when clicked outside of it
            $(window).click(function(event) {
                if (event.target == document.getElementById("addPlaylistModal")) {
                    $("#addPlaylistModal").addClass('hidden');
                }
            });

            // AJAX request to update playlist title on input change
            $('input[name="playlist_title"]').on('input', function() {
                var playlistId = $(this).attr('id');
                var newTitle = $(this).val();
                updatePlaylistTitle(playlistId, newTitle);
            });

            function updatePlaylistTitle(playlistId, newTitle) {
                $.ajax({
                    url: '{{ route("playlist.update", ["playlist" => "__playlist__"]) }}'.replace('__playlist__', playlistId),
                    type: 'PUT',
                    data: {
                        title: newTitle,
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        console.log('Playlist title updated successfully');
                    },
                    error: function(xhr) {
                        console.log('Error updating playlist title');
                    }
                });
            }
        });
    </script>
</x-app-layout>
