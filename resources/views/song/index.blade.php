<x-app-layout>
    <x-slot name="header">
    </x-slot>

    <div class="h-screen min-h-screen p-4">
        <div class="mx-auto  h-full">
            <div class="bg-white  sm:px-20 overflow-hidden shadow-xl sm:rounded-lg h-96">
                <div class="flex justify-between items-center">
                    <div class="mt-8 text-2xl">
                        Songs
                    </div>

                    <x-add-button href="{{ route('song.create') }}" class="mt-6">
                        {{ '+ ADD' }}
                    </x-add-button>

                </div>
                <div class="mt-6">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Title
                                </th>
                                <th
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Author
                                </th>
                                <th
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach ($songs as $song)
                                <tr class="cursor-pointer">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        {{ $song->title }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        {{ $song->author->name }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        {{ asset($song->mp3link) }}
                                        <audio id="audioPlayer-{{ $song->id }}">
                                            <source src="{{ asset($song->mp3linK) }}" type="audio/mpeg">
                                            Your browser does not support the audio element.
                                        </audio>

                                        <button id="playButton-{{ $song->id }}" onclick="togglePlayStop({{ $song->id }})"
                                            class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">
                                            Play
                                        </button>
                                    </td>

                                    <td class="px-6 py-4 whitespace-nowrap">
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
    </script>
</x-app-layout>