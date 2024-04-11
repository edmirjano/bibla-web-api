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
                          action="{{ isset($section) ? route('section.update', $section->id) : route('section.store') }}"
                          enctype="multipart/form-data">
                        @csrf
                        @if (isset($section))
                            @method('PUT')
                        @endif                        @csrf
                        <div class="mb-4">

                            <label for="name" class="block text-gray-700">Name:</label>
                            <input type="text" id="name" name="name" required class="border rounded px-3 py-2 w-full" value="{{ isset($section) ? $section->name : old('name') }}">
                        </div>
                        <div class="mb-4">

                            <label for="description" class="block text-gray-700">Description:</label>
                            <textarea id="description" name="description" class="border rounded px-3 py-2 w-full" autofocus>{{ isset($section) ? $section->description : old('description') }}</textarea>
                            @error('description')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <label for="topic_id" class="block font-medium text-sm text-gray-700">Select
                                Topic</label>
                            <select id="topic_id" name="topic_id"
                                    class="block w-full mt-1 rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                    required autofocus>
                                <option value="">Select Topic</option>
                                @if(count($topics)==1)
                                    <option value="{{ $topics[0]->id }}" selected >
                                        {{ $topics[0]->name }}</option>
                                @else
                                @foreach ($topics as $topic)
                                    <option value="{{ $topic->id }}"
                                        {{ isset($section->topic_id) && $section->topic_id == $topic->id ? 'selected' : '' }}>
                                        {{ $topic->name }}</option>
                                @endforeach
                                @endif
                            </select>
                            @error('topic_id')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="flex items-center justify-end mt-4">
                            <button type="submit"
                                    class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-500 active:bg-blue-700 focus:outline-none focus:border-blue-700 focus:ring focus:ring-blue-200 disabled:opacity-25 transition">
                                {{ isset($section) ? 'Update' : 'Create' }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script>
        tinymce.init({
            selector: 'textarea',
            toolbar: 'undo redo | blocks fontfamily fontsize | bold italic underline strikethrough | link image media table mergetags | addcomment showcomments | spellcheckdialog a11ycheck typography | align lineheight | checklist numlist bullist indent outdent | emoticons charmap | removeformat',
            tinycomments_mode: 'embedded',
            tinycomments_author: 'Author name',
            mergetags_list: [
                { value: 'First.Name', title: 'First Name' },
                { value: 'Email', title: 'Email' },
            ],
        });
    </script>
</x-app-layout>
