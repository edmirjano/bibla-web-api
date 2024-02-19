<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Classroom') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <div class="p-6 sm:px-20 bg-white border-b border-gray-200">
                    <form action="{{ route('classroom.update', $classroom->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="mt-4">
                            <label for="name" class="block font-medium text-sm text-gray-700">Name:</label>
                            <input type="text" name="name" id="name" value="{{ $classroom->name }}" class="form-input rounded-md shadow-sm mt-1 block w-full" />
                        </div>

                        <div class="mt-4">
                            <label for="description" class="block font-medium text-sm text-gray-700">Description:</label>
                            <textarea name="description" id="description" class="form-textarea rounded-md shadow-sm mt-1 block w-full">{{ $classroom->description }}</textarea>
                        </div>

                        <div class="mt-4">
                            <h3 class="text-lg font-semibold">Classroom Users:</h3>
                            <ul>
                                @foreach($classroom->users as $user)
                                    <li>{{ $user->name }} <a href="{{ route('classroom.removeUser', ['classroomId' => $classroom->id, 'userId' => $user->id]) }}" class="text-red-600 hover:text-red-900">Remove</a></li>
                                @endforeach
                            </ul>
                        </div>
                        <div class="mt-4">
                            <label class="block font-medium text-sm text-gray-700">Add New Users:</label>
                            @foreach($users as $user)
                                <div class="flex items-center">
                                    <input type="checkbox" name="new_user_ids[]" id="user_{{ $user->id }}" value="{{ $user->id }}" class="form-checkbox h-5 w-5 text-indigo-600">
                                    <label for="user_{{ $user->id }}" class="ml-2 block text-sm text-gray-900">{{ $user->name }}</label>
                                </div>
                            @endforeach
                            @error('new_user_ids')
                            <span class="text-red-600">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="flex items-center justify-end mt-4">
                            <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                                Update Classroom
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
