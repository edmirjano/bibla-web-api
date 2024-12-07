<x-app-layout>
    <x-slot name="header"></x-slot>

    <div class="p-4">
        <div class="mx-auto">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <div class="sm:px-20 container mx-auto px-4 sm:px-8">
                    <div class="flex justify-between">
                        <div class="mt-8 text-2xl font-semibold leading-tight">
                            Users
                        </div>

                        <div class="mt-6">
                            <x-add-button href="{{ route('users.create') }}">
                                {{ '+ ADD' }}
                            </x-add-button>
                        </div>
                    </div>

                    <div class="mt-6 inline-block w-full shadow-md rounded-md sm:overflow-x-visible overflow-x-auto">
                        <form action="{{ route('users.index') }}" method="GET">
                            <div class="flex items-center mb-4 justify-end">
                                <input type="text" name="search" value="{{ request('search') }}"
                                       placeholder="Search users..." class="form-input rounded-md shadow-sm mr-2">
                                <button type="submit"
                                        class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Search</button>
                            </div>
                        </form>
                        <table class="min-w-full leading-normal">
                            <thead>
                            <tr>
                                <th
                                    class="px-5 py-3 border-b-2 border-200-gray bg-light-gray text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">
                                    ID</th>
                                <th
                                    class="px-5 py-3 border-b-2 border-200-gray bg-light-gray text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">
                                    Name</th>
                                <th
                                    class="px-5 py-3 border-b-2 border-200-gray bg-light-gray text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">
                                    Email</th>
                                <th
                                    class="px-5 py-3 border-b-2 border-200-gray bg-light-gray text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">
                                    Actions</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach ($users as $user)
                                <tr class="border-b border-table-gray">
                                    <td class="px-5 py-5 bg-white text-sm whitespace-nowrap">
                                        {{ $user->id }}
                                    </td>
                                    <td class="px-5 py-5 bg-white text-sm whitespace-nowrap">
                                        {{ $user->name }}
                                    </td>
                                    <td class="px-5 py-5 bg-white text-sm whitespace-nowrap">
                                        {{ $user->email }}
                                    </td>
                                    <td class="px-5 py-5 bg-white text-sm whitespace-nowrap">
                                        <a href="{{ route('users.edit', $user->id) }}" class="inline-block mr-3">
                                            <img src="{{ asset('icons/edit.svg') }}" alt="Edit">
                                        </a>
                                        <button type="button" onclick="showModal('deleteConfirmModal_{{ $user->id }}')" class="inline-block">
                                            <img src="{{ asset('icons/delete.svg') }}" alt="Delete">
                                        </button>

                                        <!-- Delete Confirmation Modal -->
                                        <div id="deleteConfirmModal_{{ $user->id }}"
                                             class="modal hidden fixed inset-0 flex justify-center items-center z-50">
                                            <div class="modal-content p-6 w-1/3 rounded-lg shadow-xl bg-white relative">
                                                <h2 class="text-lg font-semibold mb-4">Confirm Deletion</h2>
                                                <p>Are you sure you want to delete this user?</p>
                                                <div class="mt-4 flex justify-end space-x-4">
                                                    <button
                                                        onclick="hideModal('deleteConfirmModal_{{ $user->id }}')"
                                                        class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                                                        Cancel
                                                    </button>
                                                    <form action="{{ route('users.destroy', $user->id) }}" method="POST">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit"
                                                                class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded">
                                                            Delete
                                                        </button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- End Delete Confirmation Modal -->
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

    <script>
        function showModal(modalId) {
            document.getElementById(modalId).classList.remove('hidden');
        }

        function hideModal(modalId) {
            document.getElementById(modalId).classList.add('hidden');
        }

        // Close modal if clicked outside
        window.addEventListener('click', function (e) {
            if (e.target.classList.contains('modal')) {
                e.target.classList.add('hidden');
            }
        });
    </script>
</x-app-layout>
