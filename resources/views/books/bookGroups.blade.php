<x-app-layout>
    <x-slot name="header">

    </x-slot>
    <div class="p-4">
        <div class="mx-auto">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <div class="sm:px-20 container mx-auto px-4 sm:px-8">
                    <div class="flex justify-between">
                        <div class="mt-8 text-2xl font-semibold leading-tight">
                            Groups
                        </div>

                        <x-add-button id="addCategoryBtn" class="mt-6">
                            {{ '+ ADD' }}
                        </x-add-button>
                    </div>
                    <div id="addCategoryModal" class="modal hidden fixed inset-0 flex justify-center items-center z-50">
                        <div class="modal-content p-8 rounded-lg shadow-xl bg-light-gray relative">
                            <span id="closeModal" class="absolute top-4 right-4 cursor-pointer">&times;</span>
                            <form id="addCategoryForm" action="{{ route('group.store') }}" method="POST">
                                @csrf
                                <div class="mb-4">
                                    <label for="category_name" class="block text-gray-700">Group Name:</label>
                                    <input type="text" id="name" name="name" required
                                        class="border rounded px-3 py-2 w-full">
                                    <input type="hidden" id="book_id" name="book_id" value="{{$book->id}}"
                                        class="border rounded px-3 py-2 w-full">
                                </div>
                                <button type="submit"
                                    class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Add
                                    Group</button>
                            </form>
                        </div>
                    </div>

                    <div class="mt-6">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th
                                        class="px-5 py-3 border-b-2 border-200-gray bg-light-gray text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">
                                        ID
                                    </th>
                                    <th
                                        class="px-5 py-3 border-b-2 border-200-gray bg-light-gray text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">
                                        Name
                                    </th>

                                    <th
                                        class="px-5 py-3 border-b-2 border-200-gray bg-light-gray text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">
                                        Action
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($groups as $group)
                                    <tr class="border-b border-table-gray">
                                        <td class="px-5 py-5 bg-white text-sm whitespace-nowrap">
                                            {{ $group->id }}
                                        </td>
                                        <td class="px-5 py-5 bg-white text-sm whitespace-nowrap">
                                            <input type="text" name="group_name" id="{{ $group->id }}"
                                                value="{{ $group->name }}">
                                        </td>
                                        <td class="px-5 py-5 bg-white text-sm whitespace-nowrap">
                                            <a href="{{route('topic.show', $group->id)}}"
                                                class="text-blue-600 hover:underline">Show topic</a>
                                            <form action="{{ route('group.destroy', $group->id) }}" method="POST"
                                                class="inline m-2">
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
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- JavaScript Section -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script>
        $(document).ready(function () {
            // Show Add Category Modal on button click
            $("#addCategoryBtn").click(function () {
                $("#addCategoryModal").removeClass('hidden');
            });

            // Hide the modal when the close button is clicked
            $(".close").click(function () {
                $("#addCategoryModal").addClass('hidden');
            });

            // Hide the modal when clicked outside of it
            $(window).click(function (event) {
                if (event.target == document.getElementById("addCategoryModal")) {
                    $("#addCategoryModal").addClass('hidden');
                }
            });

            $('input[name="group_name"]').on('input', function () {
                let group_id = $(this).attr('id');
                let newName = $(this).val();
                updateCategoryName(group_id, newName);
            });


            function updateCategoryName(groupId, newName) {
                $.ajax({
                    url: '{{ route("group.update", ["group" => ":groupId"]) }}'.replace(':groupId', groupId),
                    type: 'PUT',
                    data: {
                        name: newName,
                        book_id:{{$book->id}},
                        _token: '{{ csrf_token() }}'
                    },
                    success: function (response) {
                        console.log('Category name updated successfully');
                    },
                    error: function (xhr) {
                        console.log('Error updating category name');
                    }
                });
            }

        });
    </script>
</x-app-layout>