<x-app-layout>
    <x-slot name="header">
    </x-slot>

    <div class="h-screen min-h-screen p-4">
        <div class="mx-auto  h-full">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <div class="sm:px-20 container mx-auto px-4 sm:px-8">
                    <div class="flex justify-between">
                        <div class="mt-8 text-2xl font-semibold leading-tight">
                            Songs
                        </div>

                        <x-add-button href="{{ route('song.create') }}" class="mt-6">
                            {{ '+ ADD' }}
                        </x-add-button>
                    </div>
                    <div class="mt-6 inline-block min-w-full shadow-md rounded-md overflow-hidden">
                        <table class="min-w-full leading-normal">
                            <thead>
                                <tr>
                                    <th
                                        class="px-5 py-3 border-b-2 border-200-gray bg-light-gray text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">
                                        Title
                                    </th>
                                    <th
                                        class="px-5 py-3 border-b-2 border-200-gray bg-light-gray text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">
                                        Author
                                    </th>
                                    <th
                                        class="px-5 py-3 border-b-2 border-200-gray bg-light-gray text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">
                                        Player
                                    </th>
                                    <th
                                        class="px-5 py-3 border-b-2 border-200-gray bg-light-gray text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">
                                        Links
                                    </th>
                                    <th
                                        class="px-5 py-3 border-b-2 border-200-gray bg-light-gray text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">
                                        Lyrics
                                    </th>
                                    <th
                                        class="px-5 py-3 border-b-2 border-200-gray bg-light-gray text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">
                                        Action
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($songs as $song)

                                    <tr class="border-b border-table-gray">
                                        <td class="px-5 py-5 bg-white text-sm whitespace-nowrap">
                                            {{ $song->title }}
                                        </td>
                                        <td class="px-5 py-5 bg-white text-sm whitespace-nowrap">
                                            {{ $song->author->name }}
                                        </td>
                                        <td class="px-5 py-5 bg-white text-sm whitespace-nowrap">
                                            <audio id="audioPlayer-{{ $song->id }}">
                                                <source src="{{ asset($song->mp3link) }}" type="audio/mpeg">
                                                Your browser does not support the audio element.
                                            </audio>
                                            <button id="playButton-{{ $song->id }}"
                                                onclick="togglePlayStop({{ $song->id }})"
                                                class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">
                                                Play
                                            </button>
                                        </td>
                                        <td class="px-5 py-5 bg-white text-sm whitespace-nowrap">
                                            <div>
                                                Play on
                                                <a href="{{ $song->yt_link }}" class="hover:underline" target="_blank">
                                                    Youtube
                                                </a>/
                                                <a href="{{ $song->spotify_link }}" class="hover:underline" target="_blank">
                                                    Spotify
                                                </a>
                                            </div>
                                        </td>
                                        <td class="px-5 py-5 bg-white text-sm whitespace-nowrap">

                                            <x-add-button id="addCategoryBtn_{{ $song->id }}" class="bg-transparent"
                                                onclick="showModal('addCategoryModal_{{ $song->id }}')">
                                                {{ 'Show Lyrics' }}
                                            </x-add-button>

                                            <div id="addCategoryModal_{{ $song->id }}"
                                                class="modal hidden fixed inset-0 flex justify-center items-center z-50">
                                                <div
                                                    class="modal-content p-6 w-1/2 h-1/2 rounded-lg shadow-xl bg-light-gray relative">
                                                    <button onclick="hideModal('addCategoryModal_{{ $song->id }}')"
                                                        class="absolute top-0 right-1 text-3xl text-gray-700 hover:text-gray-900">
                                                        &times;
                                                    </button>
                                                    <textarea
                                                        class="w-full h-full p-2 text-base border rounded-md resize-none"
                                                        readonly>
                                                        {{ $song->lyrics }}
                                                    </textarea>
                                                </div>
                                            </div>
                                        </td>

                                        <td class="px-5 py-5 bg-white text-sm whitespace-nowrap">
                                            <div class="flex space-x-3 align-middle">
                                                <a href="{{ route('song.edit', $song->id) }}" class="inline-block">
                                                    <img src="{{ asset('icons/edit.svg') }}" alt="Edit">
                                                </a>
                                                <form action="{{ route('song.destroy', $song->id) }}" method="POST">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="self-center">
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
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script>
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

        $(document).ready(function () {
            // Show Add Category Modal on button click
            $("#addCategoryBtn").click(function () {
                $("#addCategoryModal").removeClass('hidden');
            });

            // Hide the modal when clicked outside of it
            $(window).click(function (event) {
                if (event.target == document.getElementById("addCategoryModal")) {
                    $("#addCategoryModal").addClass('hidden');
                }
            });
        })
    </script>
</x-app-layout>