<x-app-layout>
    <x-slot name="header">

    </x-slot>

    <div class="p-4">
        <div class=" mx-auto ">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <div class="sm:px-20 bg-white border-b border-gray-200">
                    <div class="mt-6  flex flex-row justify-between">
                        <h4 class="text-2xl font-semibold leading-tight">Users</h4>

                        <x-add-button href="{{ route('users.create') }}">
                            {{ '+ ADD' }}
                        </x-add-button>
                    </div>


                    <div class="mt-6">

                        <form action="{{ route('users.index') }}" method="GET">
                            <div class="flex items-center mb-4 justify-end">
                                <input type="text" name="search" value="{{ request('search') }}"
                                    placeholder="Search users..." class="form-input rounded-md shadow-sm mr-2">
                                <button type="submit"
                                    class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Search</button>
                            </div>
                        </form>
                        <table class="min-w-full leading-normal">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th
                                        class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">
                                        ID</th>
                                    <th
                                        class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">
                                        Name</th>
                                    <th
                                        class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">
                                        Email</th>
                                    <th
                                        class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">
                                        Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($users as $user)
                                    <tr>
                                        <td
                                            class="px-5 py-5 whitespace-nowrap border-b border-gray-200 bg-white text-gray-900 text-sm">
                                            {{ $user->id }}</td>
                                        <td
                                            class="px-5 py-5 whitespace-nowrap border-b border-gray-200 bg-white text-gray-900 text-sm">
                                            {{ $user->name }}</td>
                                        <td
                                            class="px-5 py-5 whitespace-nowrap border-b border-gray-200 bg-white text-gray-900 text-sm">
                                            {{ $user->email }}</td>
                                        <td
                                            class="px-5 py-5 whitespace-nowrap border-b border-gray-200 bg-white text-gray-900 text-sm">
                                            <a href="{{ route('users.edit', $user->id) }}" class="inline-block mr-3">
                                                <img src="{{ asset('icons/edit.svg') }}" alt="Edit">
                                            </a>
                                            <form action="{{ route('users.destroy', $user->id) }}" method="POST"
                                                class="inline-block">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit">
                                                    <img src="{{ asset('icons/delete.svg') }}" alt="Delete">
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>

                        <!-- Pagination links -->
                        <div class="mt-6">
                            {{ $users->appends(request()->query())->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
