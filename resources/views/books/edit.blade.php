<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ isset($book) ? __('Edit') : __('Create') }} {{ __('Book') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <div class="p-6 sm:px-20 bg-white border-b border-gray-200">
                    <form method="POST"
                          action="{{ isset($book) ? route('book.update', $book->id) : route('book.store') }}"
                          enctype="multipart/form-data">
                        @csrf
                        @if(isset($book))
                            @method('PUT')

                        @endif
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label for="name" class="block font-medium text-sm text-gray-700">Book Name</label>
                                <input id="name"
                                       class="block mt-1 w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                       type="text" name="name" value="{{ $book->name ?? old('name') }}" required
                                       autofocus oninput="generateSlug(event)"/>
                                @error('name')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="slug" class="block font-medium text-sm text-gray-700">Slug</label>
                                <input id="slug"
                                       class="block mt-1 w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                       type="text" name="slug" value="{{ $book->slug ?? old('slug') }}"
                                       autofocus/>
                                @error('slug')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                            <div>
                                <label for="description"
                                       class="block font-medium text-sm text-gray-700">Description</label>
                                <textarea id="description" name="description" class="border rounded px-3 py-2 w-full"  autofocus>
                                    {{$book->description ?? old('description')}}</textarea>
                                @error('description')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                            <div>
                                <label for="detailed_info" class="block font-medium text-sm text-gray-700">Detailed
                                    Info</label>
                                <textarea id="detailed_info" name="detailed_info" class="border rounded px-3 py-2 w-full"  autofocus>
                                   {{ $book->detailed_info ?? old('detailed_info') }}</textarea>
                                @error('detailed_info')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                            <div>
                                <label for="author" class="block font-medium text-sm text-gray-700">Author</label>
                                <input id="author"
                                       class="block mt-1 w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                       type="text" name="author" value="{{ $book->author ?? old('author') }}"
                                       autofocus/>
                                @error('author')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="category_id"
                                       class="block font-medium text-sm text-gray-700">Category</label>
                                <select id="category_id" name="category_id"
                                        class="block w-full mt-1 rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                        required autofocus value={{ $book->category->id ?? old('category_id') }}>
                                    <option value="">Select Category</option>
                                    @foreach ($categories as $category)
                                        {{ $isSelected = $category->id == isset($book->category->id) ?? old('category_id') }}
                                        <option
                                            value="{{ $category->id }}" {{ $isSelected ? 'selected' : '' }}>{{ $category->name }}</option>
                                    @endforeach
                                </select>
                                @error('category_id')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                            <div>
                                <label for="cover" class="block font-medium text-sm text-gray-700">Cover</label>
                                <input id="cover"
                                       class="block mt-1 w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                       type="file" name="cover" value="{{ $book->cover ?? old('cover') }}"
                                       autofocus onchange="previewImage(event)"/> @error('cover')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                        <div id="imagePreview" class="mt-2"></div>
                        @isset($book)
                        <div  class="mt-2 w-48">

                            <img src={{asset($book->cover)}} alt={{$book->name}}>
                        </div>
                        @endisset
                        <div class="flex items-center justify-end mt-4">
                            <button type="submit"
                                    class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-500 active:bg-blue-700 focus:outline-none focus:border-blue-700 focus:ring focus:ring-blue-200 disabled:opacity-25 transition">
                                {{ isset($book) ? 'Update' : 'Create' }}
                            </button>
                        </div>
                    </form>
                </div>

            </div>
    </div>
    </div>

    <script>

        function toggleAccordion(element) {
            element.nextElementSibling.classList.toggle('hidden');
            const icon = element.querySelector('svg');
            icon.classList.toggle('rotate-180');
        }
        function previewImage(event) {
            const reader = new FileReader();
            reader.onload = function () {
                const output = document.getElementById('imagePreview');
                output.innerHTML = `<img src="${reader.result}" class="mt-2 max-w-xs">`;
            }
            reader.readAsDataURL(event.target.files[0]);
        }

        function generateSlug(event) {
            var slug = event.target.value.toLowerCase().replace(/[^a-z0-9]+/g, '-');
            document.getElementById('slug').value = slug;
        }
        tinymce.init({
            selector: 'textarea',
            toolbar: 'undo redo | blocks fontfamily fontsize | bold italic underline strikethrough | link image media table mergetags | addcomment showcomments | spellcheckdialog a11ycheck typography | align lineheight | checklist numlist bullist indent outdent | emoticons charmap | removeformat',
            tinycomments_author: 'Emanuel Gjoni',
            mergetags_list: [
                { value: 'First.Name', title: 'First Name' },
                { value: 'Email', title: 'Email' },
            ],
        });
    </script>

</x-app-layout>
