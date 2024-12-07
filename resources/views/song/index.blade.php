<x-app-layout>
    <x-slot name="header">

        <form method="GET" action="{{ route('song.index') }}" class="flex">
            <input type="text" name="search" value="{{ old('search', $query ?? '') }}" placeholder="Search songs..."
                class="border rounded px-4 py-2">
            <button type="submit" class="ml-2 bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                Search
            </button>
        </form>
    </x-slot>

    <div class="h-full min-h-screen p-4">
        <div class="mx-auto h-full">
            <div class="bg-button-white overflow-hidden sm:rounded-lg">
                <div class="sm:px-20 container mx-auto px-4 sm:px-8">
                    <div class="flex justify-between">
                        <div class="mt-8 text-2xl font-semibold leading-tight">
                            Songs
                        </div>

                        <div class="flex space-x-4 mt-6">
                            <x-add-button href="{{ route('song.create') }}">
                                {{ '+ ADD' }}
                            </x-add-button>

                        </div>
                    </div>
                    <div class="mt-6 inline-block w-full shadow-md sm:overflow-x-visible overflow-x-auto">
                        <table class="min-w-full leading-normal">
                            <thead>
                                <tr>
                                    <th
                                        class="px-5 py-3 border-b-2 border-200-gray bg-light-gray text-left text-s font-semibold text-gray-700 uppercase tracking-wider">
                                        Title
                                    </th>
                                    <th
                                        class="px-5 py-3 border-b-2 border-200-gray bg-light-gray text-left text-s font-semibold text-gray-700 uppercase tracking-wider">
                                        Author
                                    </th>
                                    <th
                                        class="px-5 py-3 border-b-2 border-200-gray bg-light-gray text-left text-s font-semibold text-gray-700 uppercase tracking-wider">
                                        Action
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($songs as $song)
                                    <tr class="border-b border-table-gray">
                                        <td class="px-5 py-5 bg-white text-sm whitespace-nowrap">
                                            <img src="{{ asset($song->cover) }}" alt="{{ $song->name }}"
                                                class="w-8 h-8 mr-1 rounded-full inline-block"
                                                onerror="this.onerror=null;this.src='{{ asset('icons/song.png') }}';">
                                            {{ $song->title }}
                                        </td>
                                        <td class="px-5 py-5 bg-white text-sm whitespace-nowrap">
                                            @if ($song->authors->isNotEmpty())
                                                <ul>
                                                    @foreach ($song->authors as $author)
                                                        <li>
                                                            <img src="{{ asset($author->cover) }}"
                                                                alt="{{ $author->name }}"
                                                                class="w-8 h-8 mr-1 mb-1 rounded-full inline-block"
                                                                onerror="this.onerror=null;this.src='{{ asset('icons/profile_icon.png') }}';">
                                                            {{ $author->name }}
                                                        </li>
                                                    @endforeach
                                                </ul>
                                            @endif
                                        </td>
                                        <td class="px-5 py-5 bg-white text-sm whitespace-nowrap">
                                            <div class="flex space-x-3 align-middle">
                                                <a href="{{ route('song.edit', $song->id) }}" class="inline-block">
                                                    <img src="{{ asset('icons/edit.svg') }}" alt="Edit">
                                                </a>

                                                <!-- Soft-deleted songs will have a restore button -->
                                                @if ($song->trashed())
                                                    <form action="{{ route('song.restore', $song->id) }}"
                                                        method="POST">
                                                        @csrf
                                                        <button type="submit"
                                                            class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                                                            Restore
                                                        </button>
                                                    </form>
                                                @else
                                                    <form action="{{ route('song.destroy', $song->id) }}"
                                                        method="POST" id="deleteForm_{{ $song->id }}">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="button"
                                                            onclick="showDeleteModal({{ $song->id }})">
                                                            <img src="{{ asset('icons/delete.svg') }}" alt="Delete">
                                                        </button>
                                                    </form>
                                                @endif
                                                <div class="align-left">
                                                    <audio id="audioPlayer-{{ $song->id }}">
                                                        <source src="{{ asset($song->mp3link) }}" type="audio/mpeg">
                                                        Your browser does not support the audio element.
                                                    </audio>
                                                    <button id="playButton-{{ $song->id }}"
                                                        onclick="togglePlayStop({{ $song->id }})"
                                                        class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-1 rounded">
                                                        Play
                                                    </button>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="pagination p-4 ">
                        {{ $songs->links() }}
                    </div>
                </div>
            </div>
        </div>
        <div id="deleteModal" class="modal hidden fixed inset-0 flex justify-center items-center z-50">
            <div class="modal-content p-6 w-1/3 bg-white rounded-lg shadow-xl relative">
                <button onclick="hideModal('deleteModal')"
                    class="absolute top-0 right-1 text-3xl text-gray-700 hover:text-gray-900">
                    &times;
                </button>
                <h3 class="text-xl font-semibold mb-4">Are you sure you want to delete this song?</h3>
                <div class="flex justify-between">
                    <form id="deleteForm" action="" method="POST" class="w-full">
                        @csrf
                        @method('DELETE')
                        <button onclick="document.getElementById('deleteForm').submit()"
                            class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded w-full">
                            Yes, Delete
                        </button>

                    </form>
                    <button onclick="hideModal('deleteModal')"
                        class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded w-full">
                        Cancel
                    </button>
                </div>
            </div>
        </div>
    </div>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script>
        let formToDelete = null;

        // Show delete confirmation modal
        function showDeleteModal(songId) {
            const deleteForm = document.getElementById('deleteForm');
            deleteForm.action = `/song/${songId}`; // Update with the specific song delete route

            // Show the delete modal
            document.getElementById('deleteModal').classList.remove('hidden');
        }

        // Hide modal
        function hideModal(modalId) {
            document.getElementById(modalId).classList.add('hidden');
        }

        // Submit the form to delete the song
        function deleteSong() {
            if (formToDelete) {
                formToDelete.submit(); // Submit the form to delete the song
            }
        }

        function togglePlayStop(songId) {
            var audioPlayer = document.getElementById('audioPlayer-' + songId);
            var playButton = document.getElementById('playButton-' + songId);

            if (audioPlayer.paused) {
                // If the audio is paused, play it and change the button text to "Stop"
                audioPlayer.play();
                playButton.textContent = "Stop";
            } else {
                // If the audio is playing, pause it and change the button text to "Play"
                audioPlayer.pause();
                playButton.textContent = "Play";
            }
        }

        function showModal(modalId) {
            document.getElementById(modalId).classList.remove('hidden');
        }

        function hideModal(modalId) {
            document.getElementById(modalId).classList.add('hidden');
        }

        function confirmDelete(event) {
            return confirm('Are you sure you want to delete this song?');
        }

        $(document).ready(function() {
            // Show Add Category Modal on button click
            $("#addCategoryBtn").click(function() {
                $("#addCategoryModal").removeClass('hidden');
            });

            // Hide the modal when clicked outside of it
            $(window).click(function(event) {
                if (event.target == document.getElementById("addCategoryModal")) {
                    $("#addCategoryModal").addClass('hidden');
                }
            });
        })
    </script>
</x-app-layout>
