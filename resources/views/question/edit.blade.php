<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Section') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <div class="p-6 sm:px-20 bg-white border-b border-gray-200">
                    <form method="POST"
                          action="{{ isset($question) ? route('question.update', $question->id) : route('question.store') }}"
                          enctype="multipart/form-data">
                        @csrf
                        @if (isset($question))
                            @method('PUT')
                        @endif
                        <div class="mb-4">

                            <label for="description" class="block text-gray-700">Description:</label>
                            <input type="text" id="description" name="description"
                                   class="border rounded px-3 py-2 w-full"  value="{{ isset($question) ? $question->description : old('name') }}" required autofocus>
                        </div>
                        <div>
                            <label for="section_id" class="block font-medium text-sm text-gray-700">Select
                                Section</label>
                            <select id="section_id" name="section_id"
                                    class="block w-full mt-1 rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                    required autofocus>
                                <option value="">Select Section </option>
                                @if(count($sections)==1)
                                    <option value="{{ $sections[0]->id }}" selected >
                                        {{ $sections[0]->name }}</option>
                                @else

                                @foreach ($sections as $section)
                                    <option value="{{ $section->id }}"
                                        {{ isset($question->section_id) && $question->section_id == $section->id ? 'selected' : '' }}>
                                        {{ $section->name }}</option>
                                @endforeach
                                @endif
                            </select>
                            @error('section_id')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="flex items-center justify-end mt-4">
                            <button type="submit"
                                    class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-500 active:bg-blue-700 focus:outline-none focus:border-blue-700 focus:ring focus:ring-blue-200 disabled:opacity-25 transition">
                                {{ isset($question) ? 'Update' : 'Create' }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

</x-app-layout>
