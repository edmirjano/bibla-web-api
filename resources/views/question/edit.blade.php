<x-app-layout>
    <x-slot name="header">
    </x-slot>

    <div class="p-4">
        <div class="mx-auto">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <div class="sm:px-20 bg-white border-b border-gray-200">
                    <form method="POST"
                          action="{{ isset($question) ? route('question.update', $question->id) : route('question.store') }}"
                          enctype="multipart/form-data">
                        @csrf
                        @if (isset($question))
                            @method('PUT')
                        @endif

                        <div class="mb-4">
                            <label for="description" class="uppercase tracking-wide text-black text-xs font-bold mb-2">Description:</label>
                            <textarea id="description" name="description" class="w-full bg-gray-200 text-black border border-gray-200 rounded py-3 px-4 mb-3"  autofocus>{{ isset($question) ? $question->description : old('description') }}</textarea>
                        </div>
                        <div class="mb-4">
                            <label for="index" class="uppercase tracking-wide text-black text-xs font-bold mb-2">Index for sort:</label>
                            <input id="index" type="number" name="index" class="w-full bg-gray-200 text-black border border-gray-200 rounded py-3 px-4 mb-3" autofocus value="{{ isset($question) ? $question->index : old('index') }}">
                        </div>

                        <div>
                            <label for="section_id" class="block font-medium text-sm text-gray-700">Select
                                Section</label>
                            <select id="section_id" name="section_id"
                                    class="w-full bg-gray-200 border border-gray-200 text-black text-xs py-3 px-4 pr-8 mb-3 rounded"
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
