<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ isset($group) ? __('Edit Group') : __('Create Group') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <div class="p-6 sm:px-20 bg-white border-b border-gray-200">
                    <form method="POST"
                          action="{{ isset($group) ? route('group.update', $group->id) : route('group.store') }}"
                          enctype="multipart/form-data">
                        @csrf
                        @if(isset($group))
                            @method('PUT')
                        @endif
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label for="name" class="block font-medium text-sm text-gray-700">Group Name</label>
                                <input id="name"
                                       class="block mt-1 w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                       type="text" name="name" value="{{ isset($group) ? $group->name : old('name') }}"
                                       required autofocus/>
                                @error('name')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            @if(isset($books))
                                <div>
                                    <label for="book_id" class="block font-medium text-sm text-gray-700">Select
                                        Book</label>
                                    <select id="book_id" name="book_id"
                                            class="block w-full mt-1 rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                            required autofocus>
                                        <option value="">Select Book</option>
                                        @foreach($books as $book)
                                            <option
                                                value="{{ $book->id }}" {{ isset($group) && $group->book_id == $book->id ? 'selected' : '' }}>{{ $book->name }}</option>
                                        @endforeach
                                    </select>
                                    @error('book_id')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                    @enderror
                                </div>
                        </div>
                        <div class="flex items-center justify-end mt-4">
                            <button type="submit"
                                    class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-500 active:bg-blue-700 focus:outline-none focus:border-blue-700 focus:ring focus:ring-blue-200 disabled:opacity-25 transition">
                                {{ isset($group) ? 'Update' : 'Create' }}
                            </button>
                        </div>
                        @else
                            <div>
                                <label for="book_id" class="block font-medium text-sm text-gray-700">Selected
                                    Book</label>
                                <select id="book_id" name="book_id"
                                        class="block w-full mt-1 rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                        required autofocus>

                                    <option
                                        value="{{ $book->id }}" {{ isset($group) && $group->book_id == $book->id ? 'selected' : '' }}>{{ $book->name }}</option>

                                </select>

                                @error('book_id')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                                <div class="flex items-center justify-end mt-4">
                                    <button type="submit"
                                            class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-500 active:bg-blue-700 focus:outline-none focus:border-blue-700 focus:ring focus:ring-blue-200 disabled:opacity-25 transition">
                                        {{ isset($group) ? 'Update' : 'Create' }}
                                    </button>
                                </div>
                            </div>

                        @endif


                        @if(isset($group))
                            <input type="hidden" name="group_id" value="{{ $group->id }}">
                        @endif

                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
