<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Groups of book: '.$book->name )}}
        </h2>
    </x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <div class="p-6 sm:px-20 bg-white border-b border-gray-200">
                    <div class="mt-8 text-2xl">
                        Groups
                    </div>

                    <div class="mt-6">
                        <button id="addCategoryBtn" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Create Group</button>
                    </div>
                    <div id="addCategoryModal" class="modal hidden fixed inset-0 bg-gray-900 bg-opacity-50 flex justify-center items-center ">
                        <div class="modal-content bg-white p-8 rounded-lg">
                            <span id="closeModal" class="absolute top-4 right-4 cursor-pointer">&times;</span>
                            <form id="addCategoryForm" action="{{ route('group.store') }}" method="POST">
                                @csrf
                                <div class="mb-4">
                                    <label for="category_name" class="block text-gray-700">Group Name:</label>
                                    <input type="text" id="name" name="name" required class="border rounded px-3 py-2 w-full">
                                    <input type="hidden" id="book_id" name="book_id" value="{{$book->id}}" class="border rounded px-3 py-2 w-full">
                                </div>
                                <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Add Group</button>
                            </form>
                        </div>
                    </div>

                    <div class="mt-6">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    ID
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Name
                                </th>

                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Action
                                </th>
                            </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($groups as $group)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        {{ $group->id }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <input type="text" name="group_name" id="{{ $group->id }}" value="{{ $group->name }}">
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <form action="{{ route('group.destroy', $group->id) }}" method="POST" class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-600 hover:text-red-900">Delete</button>
                                        </form>
                                        <a href="{{route('topic.show',$group->id)}}">Show topic</a>
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
        $(document).ready(function() {
            // Show Add Category Modal on button click
            $("#addCategoryBtn").click(function() {
                $("#addCategoryModal").removeClass('hidden');
            });

            // Hide the modal when the close button is clicked
            $(".close").click(function() {
                $("#addCategoryModal").addClass('hidden');
            });

            // Hide the modal when clicked outside of it
            $(window).click(function(event) {
                if (event.target == document.getElementById("addCategoryModal")) {
                    $("#addCategoryModal").addClass('hidden');
                }
            });

            $('input[name="group_name"]').on('input', function() {
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
                    success: function(response) {
                        console.log('Category name updated successfully');
                    },
                    error: function(xhr) {
                        console.log('Error updating category name');
                    }
                });
            }

        });
    </script>
</x-app-layout>
