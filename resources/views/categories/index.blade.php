<x-app-layout>
    <x-slot name="header">

    </x-slot>
    <div class="h-screen min-h-screen p-4">
        <div class="mx-auto  h-full">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg h-96">
                <div class="sm:px-20 bg-white border-b border-gray-200">
                    <div class="flex justify-between">
                        <div class="mt-8 text-2xl">
                            Categories
                        </div>

                        <x-add-button id="addCategoryBtn" class="mt-6">
                            {{ '+ ADD' }}
                        </x-add-button>
                    </div>
                    <div id="addCategoryModal"
                        class="modal hidden fixed inset-0 bg-gray-900 bg-opacity-50 flex justify-center items-center ">
                        <div class="modal-content bg-white p-8 rounded-lg">
                            <span id="closeModal" class="absolute top-4 right-4 cursor-pointer">&times;</span>
                            <form id="addCategoryForm" action="{{ route('category.store') }}" method="POST">
                                @csrf
                                <div class="mb-4">
                                    <label for="category_name" class="block text-gray-700">Category Name:</label>
                                    <input type="text" id="name" name="name" required
                                        class="border rounded px-3 py-2 w-full">
                                </div>
                                <button type="submit"
                                    class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Add
                                    Category</button>
                            </form>
                        </div>
                    </div>

                    <div class="mt-6">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th
                                        class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">
                                        ID
                                    </th>
                                    <th
                                        class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">
                                        Name
                                    </th>
                                    <th
                                        class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">
                                        Delete
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach ($categories as $category)
                                    <tr>
                                        <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                                            {{ $category->id }}
                                        </td>
                                        <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                                            <input type="text"
                                                class="w-full bg-gray-200 text-black border border-gray-200 rounded py-3 px-4 mb-3"
                                                name="category_name" id="{{ $category->id }}" value="{{ $category->name }}">
                                        </td>
                                        <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                                            <form action="{{ route('category.destroy', $category->id) }}" method="POST"
                                                class="inline">
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

            // AJAX request to update category name on input change
            $('input[name="category_name"]').on('input', function () {
                var categoryId = $(this).attr('id');
                var newName = $(this).val();
                updateCategoryName(categoryId, newName);
            });

            function updateCategoryName(categoryId, newName) {
                $.ajax({
                    url: '{{ route('category.update', ['category' => '__category__']) }}'.replace(
                        '__category__', categoryId),
                    type: 'PUT',
                    data: {
                        name: newName,
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