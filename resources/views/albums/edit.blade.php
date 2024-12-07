<x-app-layout>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <div class="p-6 sm:px-20 bg-white border-b border-gray-200">
                    <div class="mt-8 text-2xl">
                        Add or Remove Songs for Album
                    </div>

                    <!-- Add Songs to Album -->
                    <form method="POST" action="{{ route('album.songs.update', $album->id) }}">
                        @csrf
                        @method('PUT')
                        <div class="grid grid-cols-1 gap-4">
                            <label for="songs" class="block text-sm font-medium text-gray-700">Select Songs:</label>
                            <select id="songs" name="songs[]" class="block mt-1 w-full js-example-basic-multiple" multiple>
                                @foreach($songs as $song)
                                    <option value="{{ $song->id }}"
                                        {{ in_array($song->id, $album->songs->pluck('id')->toArray()) ? 'selected' : '' }}>
                                        {{ $song->title }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="flex items-center justify-end mt-4">
                            <button type="submit" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-500 active:bg-blue-700 focus:outline-none focus:border-blue-700 focus:ring focus:ring-blue-200 disabled:opacity-25 transition">
                                {{ __('Update Album') }}
                            </button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>

    <!-- Select2 Integration -->
    <script>
        $(document).ready(function() {
            $('.js-example-basic-multiple').select2({
                placeholder: 'Search here',
                width: '100%' // Optional: Adjust the width
            });
        });
    </script>
</x-app-layout>
