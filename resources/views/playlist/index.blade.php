<x-app-layout>
    <x-slot name="header">
        <form method="GET" action="{{ route('playlist.index') }}" class="flex">
            <input type="text" name="search" value="{{ old('search', $query ?? '') }}" placeholder="Search ..."
                class="border rounded px-4 py-2">
            <button type="submit" class="ml-2 bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                Search
            </button>
        </form>
    </x-slot>
    <div class="h-full min-h-screen p-4">
        <div class="mx-auto h-full">
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

                            <x-add-button href="{{ route('playlist.trashed') }}">
                                <img src="{{ asset('icons/delete-white.svg') }}" class="w-[14px] mr-2" alt="Delete">
                                {{ ' TRASH' }}
                            </x-add-button>
                        </div>
                    </div>

                    <div id="addPlaylistModal" class="modal hidden fixed inset-0 flex justify-center items-center z-50">
                        <div class="modal-content p-8 rounded-lg shadow-xl bg-button-white relative">
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
                    <div class="mt-6 inline-block w-full shadow-md sm:overflow-x-visible overflow-x-auto">
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
                                            <div class="flex">
                                                <a href="{{ route('playlist.edit', $playlist->id) }}" class="pr-2">
                                                    <img src="{{ asset('icons/edit.svg') }}" alt="Edit">
                                                </a>
                                                <button type="button"
                                                    onclick="showModal('deleteConfirmModal_{{ $playlist->id }}')"
                                                    class="inline">
                                                    <img src="{{ asset('icons/delete.svg') }}" alt="Delete">
                                                </button>
                                            </div>

                                            <!-- Delete Confirmation Modal -->
                                            <div id="deleteConfirmModal_{{ $playlist->id }}"
                                                class="modal hidden fixed inset-0 flex justify-center items-center z-50">
                                                <div
                                                    class="modal-content p-6 w-1/3 rounded-lg shadow-xl bg-white relative">
                                                    <h2 class="text-lg font-semibold mb-4">Confirm Deletion</h2>
                                                    <p>Are you sure you want to delete this playlist?</p>
                                                    <div class="mt-4 flex justify-end space-x-4">
                                                        <button
                                                            onclick="hideModal('deleteConfirmModal_{{ $playlist->id }}')"
                                                            class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                                                            Cancel
                                                        </button>
                                                        <form action="{{ route('playlist.destroy', $playlist->id) }}"
                                                            method="POST">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit"
                                                                class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded">
                                                                Delete
                                                            </button>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- End Delete Confirmation Modal -->
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="pagination p-4">
                        {{ $playlists->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- JavaScript Section -->
    <script>
        var modal = document.getElementById('addPlaylistModal');
        var openButton = document.getElementById('addPlaylistBtn');
        var closeButton = document.getElementById('closeModal');

        // Function to show the modal
        function showModal() {
            modal.classList.remove('hidden');
        }

        // Function to hide the modal
        function hideModal() {
            modal.classList.add('hidden');
        }

        // Show modal when the open button is clicked
        openButton.addEventListener('click', showModal);

        // Hide modal when the close button is clicked
        closeButton.addEventListener('click', hideModal);

        // Hide modal when clicking outside the modal content
        window.addEventListener('click', function(event) {
            if (event.target === modal) {
                hideModal();
            }
        });
    </script>
</x-app-layout>
