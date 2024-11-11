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
                                            {{ $song->title }}
                                        </td>
                                        <td class="px-5 py-5 bg-white text-sm whitespace-nowrap">
                                            @if($song->authors->isNotEmpty())
                                                <ul>
                                                    @foreach($song->authors as $author)
                                                        <li>{{ $author->name }}</li>
                                                    @endforeach
                                                </ul>
                                            @endif
                                        </td>
                                        <td class="px-5 py-5 bg-white text-sm whitespace-nowrap">
                                            <div class="flex space-x-3 align-middle">
                                                <a href="{{ route('song.edit', $song->id) }}" class="inline-block">
                                                    <img src="{{ asset('icons/edit.svg') }}" alt="Edit">
                                                </a>
                                                <form action="{{ route('song.destroy', $song->id) }}" method="POST"
                                                    onsubmit="return confirmDelete(event);">
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
        function confirmDelete(event) {
            return confirm('Are you sure you want to delete this song?');
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