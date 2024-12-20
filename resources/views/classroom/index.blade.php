<x-app-layout>
    <x-slot name="header">

    </x-slot>

    <div class="h-screen min-h-screen p-4">
        <div class="mx-auto  h-full">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <div class="sm:px-20 container mx-auto px-4 sm:px-8">
                    <div class="flex justify-between">
                        <div class="mt-8 text-2xl font-semibold leading-tight">
                            Group
                        </div>

                        <div class="mt-6">

                            <x-add-button href="{{ route('classroom.create') }}">
                                {{ '+ ADD' }}
                            </x-add-button>
                        </div>
                    </div>
                    <div class="mt-6 inline-block min-w-full shadow-md rounded-md overflow-hidden">
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
                                        Description
                                    </th>
                                    <th
                                        class="px-5 py-3 border-b-2 border-200-gray bg-light-gray text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">
                                        Actions
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($classrooms as $classroom)
                                    <tr class="border-b border-table-gray">
                                        <td class="px-5 py-5 bg-white text-sm whitespace-nowrap">
                                            {{ $classroom->id }}
                                        </td>
                                        <td class="px-5 py-5 bg-white text-sm whitespace-nowrap">
                                            {{ $classroom->name }}
                                        </td>
                                        <td class="px-5 py-5 bg-white text-sm whitespace-nowrap">
                                            {{ $classroom->description }}
                                        </td>

                                        <td class="px-5 py-5 bg-white text-sm whitespace-nowrap">
                                            <a href="{{ route('classroom.edit', $classroom->id) }}"
                                                class="inline-block">
                                                <img src="{{ asset('icons/edit.svg') }}" alt="Edit">
                                            </a>
                                            <form action="{{ route('classroom.destroy', $classroom->id) }}"
                                                method="POST" class="inline-block">
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
</x-app-layout>
