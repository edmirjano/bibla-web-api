<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Create Classroom') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <div class="p-6 sm:px-20 bg-white border-b border-gray-200">
                    <form action="{{ route('classroom.store') }}" method="POST">
                        @csrf
                        <div class="mt-4">
                            <label for="name" class="uppercase tracking-wide text-black text-xs font-bold mb-2">Name:</label>
                            <input type="text" name="name" id="name" class="w-full bg-gray-200 text-black border border-gray-200 rounded py-3 px-4 mb-3" />
                        </div>

                        <div class="mt-4">
                            <label for="description" class="uppercase tracking-wide text-black text-xs font-bold mb-2">Description:</label>
                            <textarea name="description" id="description" class="w-full bg-gray-200 text-black border border-gray-200 rounded py-3 px-4 mb-3" ></textarea>
                        </div>

                        <div class="flex items-center justify-end mt-4">
                            <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                                Create Classroom
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
