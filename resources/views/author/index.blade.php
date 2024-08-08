<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Authors') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <div class="p-6 sm:px-20 bg-white border-b border-gray-200">
                    <div class="flex justify-between items-center">
                        <div class="mt-8 text-2xl">
                            Authors
                        </div>
                        <div>
                            <a href="{{ route('author.create') }}"
                                class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Create
                                Author</a>
                        </div>

                    </div>
                    <div class="mt-6">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Name
                                    </th>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach ($authors as $author)
                                    <tr class="cursor-pointer">
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            {{ $author->name }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap flex justify-end">
                                            <div class="flex items-center space-x-3 align-middle">
                                                <a href="{{ route('author.edit', $author->id) }}"
                                                    class="text-yellow-600 hover:text-yellow-900">
                                                    <!-- Edit icon -->
                                                </a>
                                                <form action="{{ route('author.destroy', $author->id) }}" method="POST"
                                                    class="inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="text-red-600 hover:text-red-900">
                                                        <!-- Delete icon -->
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
