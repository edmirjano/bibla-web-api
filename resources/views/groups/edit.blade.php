<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Group') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <div class="p-6 sm:px-20 bg-white border-b border-gray-200">
                    <form action="{{ route('groups.update', $group->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="mt-4">
                            <label for="name" class="block font-medium text-sm text-gray-700">Name:</label>
                            <input type="text" name="name" id="name" value="{{ $group->name }}" class="form-input rounded-md shadow-sm mt-1 block w-full" />
                        </div>

                        <div>
                            <label for="book_id" class="block font-medium text-sm text-gray-700">Select Book</label>
                            <select id="book_id" name="book_id"
                                    class="block w-full mt-1 rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                    required autofocus>
                                <option value="">Select Category</option>
                                @foreach($books as $book)
                                    @php
                                        $isSelected = $book->id == old('book_id', $group->book_id);
                                    @endphp
                                    <option value="{{ $book->id }}" {{ $isSelected ? 'selected' : '' }}>{{ $book->name }}</option>
                                @endforeach
                            </select>
                            @error('book_id')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="flex items-center justify-end mt-4">
                            <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                                Update
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
