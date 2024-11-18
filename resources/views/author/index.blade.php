<x-app-layout>
    <x-slot name="header">
    </x-slot>

    <div class="h-screen min-h-screen p-4">
        <div class="mx-auto  h-full">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <div class="sm:px-20 container mx-auto px-4 sm:px-8">
                    <div class="flex justify-between">
                        <div class="mt-8 text-2xl font-semibold leading-tight">
                            Authors
                        </div>

                        <x-add-button href="{{ route('author.create') }}" class="mt-6">
                            {{ '+ ADD' }}
                        </x-add-button>
                    </div>
                    <div class="mt-6 inline-block min-w-full shadow-md rounded-md overflow-hidden">
                        <table class="min-w-full leading-normal">
                            <thead>
                                <tr>
                                    <th
                                        class="px-5 py-3 border-b-2 border-200-gray bg-light-gray text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">
                                        Name
                                    </th>
                                    <th
                                        class="px-5 py-3 border-b-2 border-200-gray bg-light-gray text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">
                                        Bio
                                    </th>
                                    <th
                                        class="px-5 py-3 border-b-2 border-200-gray bg-light-gray text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">
                                        Action
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($authors as $author)
                                    <tr class="border-b border-table-gray">
                                        <td class="px-5 py-5 bg-white text-sm whitespace-nowrap">
                                            {{ $author->name }}
                                        </td>
                                        <td class="px-5 py-5 bg-white text-sm whitespace-nowrap">

                                            <x-add-button id="addCategoryBtn_{{ $author->id }}" class="bg-transparent"
                                                onclick="showModal('addCategoryModal_{{ $author->id }}')">
                                                {{ 'Show Bio' }}
                                            </x-add-button>

                                            <div id="addCategoryModal_{{ $author->id }}"
                                                class="modal hidden fixed inset-0 flex justify-center items-center z-50">
                                                <div
                                                    class="modal-content p-6 w-1/2 h-1/2 rounded-lg shadow-xl bg-light-gray relative">
                                                    <button onclick="hideModal('addCategoryModal_{{ $author->id }}')"
                                                        class="absolute top-0 right-1 text-3xl text-gray-700 hover:text-gray-900">
                                                        &times;
                                                    </button>
                                                    <textarea
                                                        class="w-full h-full p-2 text-base border rounded-md resize-none"
                                                        readonly>
                                                                {{ $author->bio }}
                                                            </textarea>
                                                </div>
                                            </div>
                                        </td>

                                        <td class="px-5 py-5 bg-white text-sm whitespace-nowrap">
                                            <div class="flex space-x-3 align-middle">
                                                <a href="{{ route('author.edit', $author->id) }}">
                                                    <img src="{{ asset('icons/edit.svg') }}" alt="Edit">
                                                </a>
                                                <form action="{{ route('author.destroy', $author->id) }}" method="POST">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit">
                                                        <img src="{{ asset('icons/delete.svg') }}" alt="Delete">
                                                    </button>
                                                </form>
                                            </div>
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
    <script>

        $(window).click(function (event) {
            if (event.target == document.getElementById("addCategoryModal")) {
                $("#addCategoryModal").addClass('hidden');
            }
        });

        function showModal(modalId) {
            document.getElementById(modalId).classList.remove('hidden');
        }

        function hideModal(modalId) {
            document.getElementById(modalId).classList.add('hidden');
        }
    </script>
</x-app-layout>