<x-app-layout>
    <x-slot name="header">

    </x-slot>
    <div class="h-screen min-h-screen p-4">
        <div class="mx-auto  h-full">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <div class="sm:px-20 container mx-auto px-4 sm:px-8">
                    <div class="flex justify-between items-center">
                        <div class="mt-8 text-2xl font-semibold leading-tight">
                            Study plans
                        </div>

                        <x-add-button href="{{ route('book.create') }}" class="mt-6">
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
                                        Author
                                    </th>
                                    <th
                                        class="px-5 py-3 border-b-2 border-200-gray bg-light-gray text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">
                                        Category
                                    </th>
                                    <th
                                        class="px-5 py-3 border-b-2 border-200-gray bg-light-gray text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">
                                        Action
                                    </th>
                                    <th
                                        class="px-5 py-3 border-b-2 border-200-gray bg-light-gray text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($books as $book)
                                    <tr class="border-b border-table-gray">
                                        <td class="px-5 py-5 bg-white text-sm whitespace-nowrap">
                                            {{ $book->name }}
                                        </td>

                                        <td class="px-5 py-5 bg-white text-sm whitespace-nowrap">
                                            {{ $book->author }}
                                        </td>
                                        <td class="px-5 py-5 bg-white text-sm whitespace-nowrap">
                                            {{ $book->category->name }}
                                        </td>
                                        <td class="px-5 py-5 bg-white text-sm whitespace-nowrap">

                                            <a href="{{ route('group.show', $book->id) }}"
                                                class="text-blue-600 hover:underline">Show Groups</a> |
                                            <a href="{{ route('topic.byBook', $book->id) }}"
                                                class="text-blue-600 hover:underline">Show Topics</a>

                                        </td>
                                        <td class="px-5 py-5 bg-white text-sm whitespace-nowrap">
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
