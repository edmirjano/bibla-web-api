<x-app-layout>
    <x-slot name="header">

    </x-slot>
    <div class="h-screen min-h-screen p-4">
        <div class="mx-auto  h-full">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg h-96">
                <div class="sm:px-20 bg-white border-b border-gray-200">
                    <div class="flex justify-between items-center">
                        <div class="mt-8 text-2xl">
                            Books
                        </div>

                        <x-add-button href="{{ route('book.create') }}" class="mt-6">
                            {{ '+ ADD' }}
                        </x-add-button>

                    </div>
                    <div class="mt-6">
                        <table class="w-full divide-gray-200 px-5">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th
                                        class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">
                                        Name
                                    </th>
                                    <th
                                        class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">
                                        Author
                                    </th>
                                    <th
                                        class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">
                                        Category
                                    </th>
                                    <th
                                        class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">
                                        Action
                                    </th>
                                    <th
                                        class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach ($books as $book)
                                    <tr class="cursor-pointer">
                                        <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                                            {{ $book->name }}
                                        </td>

                                        <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                                            {{ $book->author }}
                                        </td>
                                        <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                                            {{ $book->category->name }}
                                        </td>
                                        <td>

                                            <a href="{{ route('group.show', $book->id) }}"
                                                class="text-blue-600 hover:underline">Show Groups</a> |
                                            <a href="{{ route('topic.byBook', $book->id) }}"
                                                class="text-blue-600 hover:underline">Show Topics</a>

                                        </td>
                                        <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                                            <div class="flex items-center space-x-3 align-middle">
                                                <a href="{{ route('book.edit', $book->id) }}" class="inline-block">
                                                    <img src="{{ asset('icons/edit.svg') }}" alt="Edit">
                                                </a>
                                                <form action="{{ route('book.destroy', $book->id) }}" method="POST"
                                                    class="inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="text-red-600 hover:text-red-900">
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
</x-app-layout>