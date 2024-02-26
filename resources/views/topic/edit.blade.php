<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ isset($topic) ? __('Edit Topic') : __('Create Topic') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <div class="p-6 sm:px-20 bg-white border-b border-gray-200">
                    <form method="POST"
                        action="{{ isset($topic) ? route('topic.update', $topic->id) : route('topic.store') }}"
                        enctype="multipart/form-data">
                        @csrf
                        @if (isset($topic))
                            @method('PUT')
                        @endif
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label for="name" class="block font-medium text-sm text-gray-700">Name</label>
                                <input id="name"
                                    class="block mt-1 w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                    type="text" name="name"
                                    value="{{ isset($topic) ? $topic->name : old('name') }}" required autofocus />
                                @error('name')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                            <div>
                                <label for="description" class="block font-medium text-sm text-gray-700">Description</label>
                                <input id="description"
                                    class="block mt-1 w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                    type="text" name="description"
                                    value="{{ isset($topic) ? $topic->description : old('description') }}" required autofocus />
                                @error('description')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                            <div>
                                <label for="book_id" class="block font-medium text-sm text-gray-700">Select
                                    Book</label>
                                <select id="book_id" name="book_id"
                                    class="block w-full mt-1 rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                    required autofocus>
                                    <option value="">Select Book</option>
                                    @foreach ($books as $book)
                                        <option value="{{ $book->id }}"
                                            {{ isset($topic) && $topic->book_id == $book->id ? 'selected' : '' }}>
                                            {{ $book->name }}</option>
                                    @endforeach
                                </select>
                                @error('group_id')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                            <div>
                                <label for="group_id" class="block font-medium text-sm text-gray-700">Select
                                    Group</label>
                                <select id="group_id" name="group_id"
                                    class="block w-full mt-1 rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                    required autofocus>
                                    <option value="">Select Group</option>
                                </select>
                                @error('group_id')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <div class="flex items-center justify-end mt-4">
                            <button type="submit"
                                class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-500 active:bg-blue-700 focus:outline-none focus:border-blue-700 focus:ring focus:ring-blue-200 disabled:opacity-25 transition">
                                {{ isset($topic) ? 'Update' : 'Create' }}
                            </button>
                        </div>

                        @if (isset($topic))
                            <input type="hidden" name="topic_id" value="{{ $topic->id }}">
                        @endif
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#book_id').change(function() {
                var bookId = $(this).val();
                $('#group_id').find('option').remove().end().append(
                    '<option value="">Select Group</option>');
                if (bookId) {
                    var groups = @json($books).find(book => book.id == bookId).groups;
                    $.each(groups, function(key, group) {
                        $('#group_id').append('<option value="' + group.id + '">' + group.name +
                            '</option>');
                    });
                }
            });
        });
    </script>
</x-app-layout>
