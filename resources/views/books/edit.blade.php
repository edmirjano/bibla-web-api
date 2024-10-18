<x-app-layout>
    <x-slot name="header">

    </x-slot>

    <div class="p-4">
        <div class=" mx-auto">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <div class="p-6 sm:px-20 bg-white border-b border-gray-200">
                    <form method="POST"
                        action="{{ isset($book) ? route('book.update', $book->id) : route('book.store') }}"
                        enctype="multipart/form-data">
                        @csrf
                        @if (isset($book))
                            @method('PUT')
                        @endif
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label for="name"
                                    class="uppercase tracking-wide text-black text-xs font-bold mb-2">Book Name</label>
                                <input id="name"
                                    class="w-full bg-gray-200 text-black border border-gray-200 rounded py-3 px-4 mb-3"
                                    type="text" name="name" value="{{ $book->name ?? old('name') }}" required
                                    autofocus oninput="generateSlug(event)" placeholder="Name" />
                                @error('name')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="slug"
                                    class="uppercase tracking-wide text-black text-xs font-bold mb-2">Slug</label>
                                <input id="slug"
                                    class="w-full bg-gray-200 text-black border border-gray-200 rounded py-3 px-4 mb-3"
                                    type="text" name="slug" value="{{ $book->slug ?? old('slug') }}" autofocus />
                                @error('slug')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                            <div>
                                <label for="description"
                                    class="uppercase tracking-wide text-black text-xs font-bold mb-2">Description</label>
                                <textarea id="description" name="description" class="border rounded px-3 py-2 w-full" autofocus>
                                    {{ $book->description ?? old('description') }}</textarea>
                                @error('description')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                            <div>
                                <label for="detailed_info"
                                    class="uppercase tracking-wide text-black text-xs font-bold mb-2">Detailed
                                    Info</label>
                                <textarea id="detailed_info" name="detailed_info" class="border rounded px-3 py-2 w-full" autofocus>
                                   {{ $book->detailed_info ?? old('detailed_info') }}</textarea>
                                @error('detailed_info')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                            <div>
                                <label for="author"
                                    class="uppercase tracking-wide text-black text-xs font-bold mb-2">Author</label>
                                <input id="author"
                                    class="w-full bg-gray-200 text-black border border-gray-200 rounded py-3 px-4 mb-3"
                                    type="text" name="author" value="{{ $book->author ?? old('author') }}"
                                    autofocus />
                                @error('author')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="category_id"
                                    class="uppercase tracking-wide text-black text-xs font-bold mb-2">Category</label>
                                <select id="category_id" name="category_id"
                                    class="w-full bg-gray-200 border border-gray-200 text-black text-xs py-3 px-4 pr-8 mb-3 rounded"
                                    required autofocus value={{ $book->category->id ?? old('category_id') }}>
                                    <option value="">Select Category</option>
                                    @foreach ($categories as $category)
                                        {{ $isSelected = $category->id == isset($book->category->id) ?? old('category_id') }}
                                        <option value="{{ $category->id }}" {{ $isSelected ? 'selected' : '' }}>
                                            {{ $category->name }}</option>
                                    @endforeach
                                </select>
                                @error('category_id')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                            <div>
                                <label for="cover"
                                    class="uppercase tracking-wide text-black text-xs font-bold mb-2">Cover</label>
                                <div id="dropzone"
                                    class="w-full bg-gray-200 text-black border border-gray-200 rounded py-3 px-4 mb-3 flex items-center justify-center cursor-pointer"
                                    ondragover="handleDragOver(event)" ondragleave="handleDragLeave(event)"
                                    ondrop="handleFileDrop(event)">
                                    <span id="dropzoneText">click to select a file</span>
                                    <input id="cover" class="hidden" type="file" name="cover" accept="image/*"
                                        onchange="previewImage(event)" />
                                </div>
                                @error('cover')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                        <div id="imagePreview" class="mt-2"></div>
                        @isset($book->cover)
                            <div class="mt-2 w-48">

                                <img src={{ asset($book->cover) }} alt={{ $book->name }}>
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
        const dropzone = document.getElementById('dropzone');
        const dropzoneText = document.getElementById('dropzoneText');
        const coverInput = document.getElementById('cover');

        // Handle click to simulate file input click
        dropzone.addEventListener('click', function() {
            coverInput.click(); // Simulate file input click
        });

        // Handle drag over event
        function handleDragOver(event) {
            event.preventDefault();
            dropzone.classList.add('bg-blue-200'); // Change background color to indicate drag over
        }

        // Handle drag leave event
        function handleDragLeave(event) {
            dropzone.classList.remove('bg-blue-200'); // Reset background color when drag leaves
        }

        // Handle file drop event
        function handleFileDrop(event) {
            event.preventDefault(); // Prevent default behavior (Stop file from being opened)
            dropzone.classList.remove('bg-blue-200'); // Reset background color after file drop

            const files = event.dataTransfer.files; // Get dropped files

            if (files.length > 0) {
                coverInput.files = files; // Assign dropped files to the hidden file input
                previewImage(); // Call preview function to display the image
            }
        }

        // Preview image before upload
        function previewImage() {
            const file = coverInput.files[0]; // Get the file from the input
            if (file) {
                const reader = new FileReader(); // Create a FileReader object
                reader.onload = function(e) {
                    const output = document.getElementById('imagePreview');
                    output.innerHTML = `<img src="${e.target.result}" class="mt-2 max-w-xs">`; // Display the image
                    dropzoneText.innerHTML = file.name; // Display the file name in the dropzone
                }
                reader.readAsDataURL(file); // Read the file as a Data URL for the preview
            }
        }
    </script>
    <script>
        function toggleAccordion(element) {
            element.nextElementSibling.classList.toggle('hidden');
            const icon = element.querySelector('svg');
            icon.classList.toggle('rotate-180');
        }

        function previewImage(event) {
            const reader = new FileReader();
            reader.onload = function() {
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
            mergetags_list: [{
                    value: 'First.Name',
                    title: 'First Name'
                },
                {
                    value: 'Email',
                    title: 'Email'
                },
            ],
        });
    </script>
    <style>
        #dropzone {
            display: flex;
            align-items: center;
            justify-content: center;
            height: 150px;
            border: 2px dashed #ccc;
            border-radius: 8px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        #dropzone.bg-blue-200 {
            background-color: #ebf8ff;
            /* Light blue background on drag over */
        }

        .max-w-xs {
            max-width: 150px;
        }
    </style>
</x-app-layout>
