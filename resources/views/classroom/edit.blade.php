<x-app-layout>
    <x-slot name="header">

    </x-slot>

    <div class="p-4">
        <div class=" mx-auto">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg min-h-screen">
                <div class="sm:px-20 bg-white border-b border-gray-200">
                    <form action="{{ route('classroom.update', $classroom->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="mt-4">
                            <label for="name" class="uppercase tracking-wide text-black text-xs font-bold mb-2">Name:</label>
                            <input type="text" name="name" id="name" value="{{ $classroom->name }}" class="form-input rounded-md shadow-sm mt-1 block w-full" />
                        </div>

                        <div class="mt-4">
                            <label for="description" class="uppercase tracking-wide text-black text-xs font-bold mb-2">Description:</label>
                            <textarea name="description" id="description" class="w-full bg-gray-200 text-black border border-gray-200 rounded py-3 px-4 mb-3">{{ $classroom->description }}</textarea>
                        </div>
                        <div class="flex items-center justify-end mt-4">
                            <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                                Update Classroom
                            </button>
                        </div>
                    </form>

                    <div class="mt-8">
                            <h3 class="text-lg font-semibold mb-4">Classroom Users:</h3>
                            <div class="overflow-x-auto">
                                <table class="min-w-full divide-y divide-gray-200">
                                    <thead class="bg-gray-50">
                                    <tr>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Name</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                                    </tr>
                                    </thead>
                                    <tbody class="bg-white divide-y divide-gray-200">
                                    @foreach($classroom->users as $user)
                                        <tr>
                                            <td class="px-6 py-4 whitespace-nowrap">{{ $user->name }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <a href="{{ route('classroom.removeUser', ['classroomId' => $classroom->id, 'userId' => $user->id]) }}" class="text-red-600 hover:text-red-900">Remove</a>
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <div class="mt-8">
                            <h3 class="text-lg font-semibold mb-4">Add New Users:</h3>
                            <form action="{{ route('classroom.edit', $classroom->id) }}" method="GET">
                                <div class="flex items-center mb-4">
                                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Search users..." class="w-full bg-gray-200 text-black border border-gray-200 rounded py-3 px-4 mb-3"">
                                    <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Search</button>
                                </div>
                            </form>
                            <div class="overflow-x-auto">
                                <table class="min-w-full divide-y divide-gray-200">
                                    <!-- Table header -->
                                    <thead class="bg-gray-50">
                                    <tr>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Name</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Email</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                                    </tr>
                                    </thead>
                                    <!-- Table body -->
                                    <tbody class="bg-white divide-y divide-gray-200">
                                    @foreach($users as $user)
                                        <tr>
                                            <td class="px-6 py-4 whitespace-nowrap">{{ $user->name }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap">{{ $user->email }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="flex items-center">
                                                    <form action="{{ route('classroom.addUser', ['classroomId' => $classroom->id, 'userId' => $user->id]) }}" method="POST">
                                                        @csrf
                                                        <button type="submit" class="text-indigo-600 hover:text-indigo-900">Add</button>
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                            <!-- Pagination links -->
                            {{ $users->links() }}
                        </div>



                        {{--                        <div class="mt-4">--}}
{{--                            <h3 class="text-lg font-semibold">Classroom Users:</h3>--}}
{{--                            <ul>--}}
{{--                                @foreach($classroom->users as $user)--}}
{{--                                    <li>{{ $user->name }} <a href="{{ route('classroom.removeUser', ['classroomId' => $classroom->id, 'userId' => $user->id]) }}" class="text-red-600 hover:text-red-900">Remove</a></li>--}}
{{--                                @endforeach--}}
{{--                            </ul>--}}
{{--                        </div>--}}
{{--                        <div class="mt-4">--}}
{{--                            <label class="uppercase tracking-wide text-black text-xs font-bold mb-2">Add New Users:</label>--}}
{{--                            @foreach($users as $user)--}}
{{--                                <div class="flex items-center">--}}
{{--                                    <input type="checkbox" name="new_user_ids[]" id="user_{{ $user->id }}" value="{{ $user->id }}" class="form-checkbox h-5 w-5 text-indigo-600">--}}
{{--                                    <label for="user_{{ $user->id }}" class="ml-2 block text-sm text-gray-900">{{ $user->name }}</label>--}}
{{--                                </div>--}}
{{--                            @endforeach--}}
{{--                            @error('new_user_ids')--}}
{{--                            <span class="text-red-600">{{ $message }}</span>--}}
{{--                            @enderror--}}
{{--                        </div>--}}

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
