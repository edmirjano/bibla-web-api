<x-app-layout>
    <x-slot name="header">

    </x-slot>
    <div class="h-screen min-h-screen p-4">
        <div class="mx-auto  h-full">
            <div class="bg-white sm:px-20 overflow-hidden shadow-xl sm:rounded-lg h-screen">
                <div class="flex justify-between">
                    <div class="mt-8 text-2xl">
                        Playlists
                    </div>

                    <div class="mt-6">
                        <x-add-button id="addPlaylistBtn">
                            {{ '+ ADD' }}
                        </x-add-button>
                    </div>
                </div>

                <div id="addPlaylistModal"
                    class="modal hidden fixed inset-0 bg-gray-900 bg-opacity-50 flex justify-center items-center ">
                    <div class="modal-content bg-white p-8 rounded-lg">
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
                <div class="mt-6">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    ID
                                </th>
                                <th
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Title
                                </th>
                                <th
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Delete
                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach ($playlists as $playlist)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        {{ $playlist->id }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <input type="text" name="playlist_title" id="{{ $playlist->id }}"
                                            value="{{ $playlist->title }}"
                                            class="w-full bg-gray-200 text-black border border-gray-200 rounded py-3 px-4 mb-3">
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
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