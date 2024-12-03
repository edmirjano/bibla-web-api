<x-app-layout>
    <x-slot name="header">
        <form method="GET" action="{{ route('album.index') }}" class="flex">
            <input type="text" name="search" value="{{ old('search', $query ?? '') }}" placeholder="Search ..."
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
                            Albums
                        </div>

                        <div class="mt-6">
                            <x-add-button id="addAlbumBtn">
                                {{ '+ ADD' }}
                            </x-add-button>
                        </div>
                    </div>

                    <div id="addAlbumModal" class="modal hidden fixed inset-0 flex justify-center items-center z-50">
                        <div class="modal-content p-8 rounded-lg shadow-xl bg-modal-gray relative">
                            <span id="closeModal" class="absolute top-4 right-4 cursor-pointer">&times;</span>
                            <form id="addAlbumForm" action="{{ route('album.store') }}" method="POST">
                                @csrf
                                <div class="mb-4">
                                    <label for="title"
                                        class="uppercase tracking-wide text-black text-xs font-bold mb-2">Album
                                        Title:</label>
                                    <input type="text" id="title" name="title" required
                                        class="w-full bg-gray-200 text-black border border-gray-200 rounded py-3 px-4 mb-3">
                                </div>
                                <x-add-button id="addAlbumBtn">
                                    {{ 'Add Album' }}
                                </x-add-button>
                            </form>
                        </div>
                    </div>

                    <!-- Albums Table -->
                    <div class="mt-6 inline-block w-full shadow-md rounded-md sm:overflow-x-visible overflow-x-auto">
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
                                @foreach ($albums as $album)
                                    <tr class="border-b border-table-gray">
                                        <td class="px-5 py-5 bg-white text-sm whitespace-nowrap">
                                            {{ $album->id }}
                                        </td>
                                        <td class="px-5 py-5 bg-white text-sm whitespace-nowrap">
                                            <input type="text" name="album_title" id="{{ $album->id }}"
                                                value="{{ $album->title }}"
                                                class="w-full bg-gray-200 text-black border border-gray-200 rounded py-3 px-4 mb-3">
                                        </td>
                                        <td class="px-5 py-5 bg-white text-sm whitespace-nowrap">
                                            <div class="flex justify-around">
                                                <a href="{{ route('album.edit', $album->id) }}">
                                                    <img src="{{ asset('icons/edit.svg') }}" alt="Edit">
                                                </a>
                                                <form action="{{ route('album.destroy', $album->id) }}" method="POST"
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
                        @if ($errors->has('songs'))
                            <div id="song-error" class="text-error-red text-sm m-2">
                                {{ $errors->first('songs') }}
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- JavaScript Section -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script>
        $(document).ready(function () {
            // Show Add Album Modal on button click
            $("#addAlbumBtn").click(function () {
                $("#addAlbumModal").removeClass('hidden');
            });

            // Hide the modal when the close button is clicked
            $("#closeModal").click(function () {
                $("#addAlbumModal").addClass('hidden');
            });

            // Hide the modal when clicked outside of it
            $(window).click(function (event) {
                if (event.target == document.getElementById("addAlbumModal")) {
                    $("#addAlbumModal").addClass('hidden');
                }
            });

            // AJAX request to update album title on input change
            $('input[name="album_title"]').on('input', function () {
                var albumId = $(this).attr('id');
                var newTitle = $(this).val();
                updateAlbumTitle(albumId, newTitle);
            });

            function updateAlbumTitle(albumId, newTitle) {
                $.ajax({
                    url: '{{ route('album.update', ['album' => '__album__']) }}'.replace(
                        '__album__', albumId),
                    type: 'PUT',
                    data: {
                        title: newTitle,
                        _token: '{{ csrf_token() }}'
                    },
                    success: function (response) {
                        console.log('Album title updated successfully');
                    },
                    error: function (xhr) {
                        console.log('Error updating album title');
                    }
                });
            }
        });
        setTimeout(function () {
            const errorElement = document.getElementById('song-error');
            if (errorElement) {
                errorElement.style.transition = 'opacity 0.5s ease-out';
                errorElement.style.opacity = '0';
                setTimeout(() => {
                    errorElement.style.display = 'none';
                }, 500);
            }
        }, 5000); // 5000 milliseconds = 5 seconds
    </script>
</x-app-layout>