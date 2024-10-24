<x-app-layout>
    <x-slot name="header">
    </x-slot>

    <div class="h-screen min-h-screen p-4">
        <div class="mx-auto  h-full">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg h-96">
                <div class="sm:px-20 bg-white border-b border-gray-200">
                    <div class="flex justify-between items-center">
                        <div class="mt-8 text-2xl">
                            Authors
                        </div>

                        <x-add-button href="{{ route('author.create') }}" class="mt-6">
                            {{ '+ ADD' }}
                        </x-add-button>
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
</x-app-layout>