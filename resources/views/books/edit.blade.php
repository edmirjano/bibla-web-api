<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Books') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <div class="p-6 sm:px-20 bg-white border-b border-gray-200">
                    <div class="mt-6">
                        <button id="addGroupBtn" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Create Group</button>
                    </div>
                    <div id="addCategoryModal" class="modal  fixed inset-0 bg-gray-900 bg-opacity-50 flex justify-center items-center ">
                        <div class="modal-content bg-white p-8 rounded-lg">
                            <span id="closeModal" class="absolute top-4 right-4 cursor-pointer">&times;</span>
                            <form id="addCategoryForm" action="{{ route('group.store') }}" method="POST">
                                @csrf
                                <div class="mb-4">

                                    <label for="category_name" class="block text-gray-700">Group Name:</label>
                                    <input type="text" id="name" name="name" required class="border rounded px-3 py-2 w-full">
                                    <input type="hidden" id="book_id" name="book_id" value="{{$books->id}}" class="border rounded px-3 py-2 w-full">
                                </div>
                                <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Add Gro</button>
                            </form>
                        </div>
                    </div>

                    @foreach($books->groups as $group)
                        <div class="bg-gray-100 p-2 m-3.5" >
                            <h3>{{$group->name}}</h3>
                            <div class="bg-gray-100">
                                @foreach($group->topics as $topic)
                                    <div>{{$topic->name}}</div>
                                    <div>{{$topic->description}}</div>
                                @endforeach
                            </div>
                        </div>
                    @endforeach

                </div>
            </div>
        </div>
    </div>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script>
        $(document).ready(function() {
            // Show Add Category Modal on button click
            $("#addGroupBtn").click(function() {
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
        });
    </script>
</x-app-layout>
