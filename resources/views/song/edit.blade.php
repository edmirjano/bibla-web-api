<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Song') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <div class="p-6 sm:px-20 bg-white border-b border-gray-200">
                    <form method="POST"
                        action="{{ isset($song) ? route('song.update', $song->id) : route('song.store') }}"  enctype="multipart/form-data">
                        @csrf
                        @if (isset($song))
                            @method('PUT')
                        @endif
                        <div class="mt-4">
                            <label for="title" :value="__('Title')" />

                            <input id="title" class="block mt-1 w-full" type="text" name="title"
                                :value="$song - > title" required autofocus />
                        </div>

                        <div class="mt-4">
                            <label for="author_id" :value="__('Author')" />

                            <select id="author_id" name="author_id" class="block mt-1 w-full">
                                @foreach ($authors as $author)
                                    <option value="{{ $author->id }}"
                                        {{ isset($song) && $song->author_id == $author->id ? 'selected' : '' }}>
                                        {{ $author->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label for="mp3link" class="block font-medium text-sm text-gray-700">Music</label>
                            <input id="mp3link"
                                class="block mt-1 w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                type="file" name="mp3link" value="{{ $song->mp3link ?? old('mp3link') }}"
                                autofocus /> @error('mp3link')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <label for="cover" class="block font-medium text-sm text-gray-700">Cover</label>
                            <input id="cover"
                                class="block mt-1 w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                type="file" name="cover" value="{{ $song->cover ?? old('cover') }}" autofocus
                                onchange="previewImage(event)" /> @error('cover')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        <div id="imagePreview" class="mt-2"></div>
                        @isset($song->cover)
                        <div  class="mt-2 w-48">
                            <img src={{asset($song->cover)}} alt={{$song->title}}>
                        </div>
                        @endisset
                        <div class="flex items-center justify-end mt-4">
                            <button class="ml-4">
                                {{ __('Update') }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script>
        function previewImage(event) {
            const reader = new FileReader();
            reader.onload = function() {
                const output = document.getElementById('imagePreview');
                output.innerHTML = `<img src="${reader.result}" class="mt-2 max-w-xs">`;
            }
            reader.readAsDataURL(event.target.files[0]);
        }
    </script>
</x-app-layout>
