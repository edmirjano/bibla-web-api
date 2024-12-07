<x-app-layout>
    <x-slot name="header">

    </x-slot>
    <div class="h-full min-h-screen p-4">
        <div class="mx-auto  h-full">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <div class="sm:px-20 container mx-auto px-4 sm:px-8">
                    <div class="flex justify-between">
                        <div class="mt-8 text-2xl font-semibold leading-tight">
                            Categories
                        </div>

                        <x-add-button id="addCategoryBtn" class="mt-6">
                            {{ '+ ADD' }}
                        </x-add-button>
                    </div>

                    <div id="addCategoryModal" class="modal hidden fixed inset-0 flex justify-center items-center z-50">
                        <div class="modal-content p-8 rounded-lg shadow-xl bg-light-gray relative">
                            <span id="closeModal" class="absolute top-4 right-4 cursor-pointer">&times;</span>
                            <form id="addCategoryForm" action="{{ route('category.store') }}" method="POST">
                                @csrf
                                <div class="mb-4">
                                    <label for="category_name" class="block text-gray-700 pb-2">Category Name:</label>
                                    <input type="text" id="name" name="name" required
                                        class="border rounded px-3 py-2 w-full">
                                </div>
                                <x-add-button id="addPlaylistBtn">
                                    {{ 'Add Playlist' }}
                                </x-add-button>
                            </form>
                        </div>
                    </div>

                    <div class="mt-6 inline-block min-w-full shadow-md overflow-hidden">
                        <table class="min-w-full leading-normal">
                            <thead>
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
                                        Delete
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($categories as $category)
                                    <tr class="border-b border-table-gray">
                                        <td class="px-5 py-5 bg-white text-sm whitespace-nowrap">
                                            {{ $category->id }}
                                        </td>
                                        <td class="px-5 py-5 bg-white text-sm whitespace-nowrap">
                                            <input type="text"
                                                class="w-full bg-gray-200 text-black border border-gray-200 rounded py-3 px-4 mb-3"
                                                name="category_name" id="{{ $category->id }}"
                                                value="{{ $category->name }}">
                                        </td>
                                        <td class="px-5 py-5 bg-white text-sm whitespace-nowrap">
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

            // AJAX request to update category name on input change
            $('input[name="category_name"]').on('input', function() {
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
