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
                    <form method="POST" action="{{ route('song.update', $song->id) }}">
                        @csrf
                        @method('PUT')

                        <div class="mt-4">
                            <x-label for="title" :value="__('Title')" />

                            <x-input id="title" class="block mt-1 w-full" type="text" name="title" :value="$song->title" required autofocus />
                        </div>

                        <div class="mt-4">
                            <x-label for="author_id" :value="__('Author')" />

                            <select id="author_id" name="author_id" class="block mt-1 w-full">
                                @foreach ($authors as $author)
                                    <option value="{{ $author->id }}" {{ $song->author_id == $author->id ? 'selected' : '' }}>{{ $author->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="flex items-center justify-end mt-4">
                            <x-button class="ml-4">
                                {{ __('Update') }}
                            </x-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
