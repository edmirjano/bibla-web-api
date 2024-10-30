<x-app-layout>
    <x-slot name="header">
    </x-slot>

    <div class="p-4">
        <div class="max-w-7xl mx-auto">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <div class="p-6 sm:px-20 bg-white border-b border-gray-200">
                    <form method="POST"
                        action="{{ isset($author) ? route('author.update', $author->id) : route('author.store') }}"
                        enctype="multipart/form-data">
                        @csrf
                        @if (isset($author))
                            @method('PUT')
                        @endif

                        <div class="grid grid-cols-2 gap-4">
                            <div class="self-center">
                                <label for="name" class="block font-medium text-m text-gray-700">Author Name</label>
                                <input id="name"
                                    class="block mt-1 w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                    type="text" name="name" value="{{ $author->name ?? old('name') }}" required
                                    autofocus />
                                @error('name')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="row-span-2">
                                <label for="bio" class="block font-medium text-m text-gray-700">Bio</label>
                                <textarea id="bio" name="bio" class="border rounded py-2 w-full"
                                    autofocus>{{ $author->bio ?? old('bio') }}</textarea>
                                @error('bio')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Cover Image Dropzone -->
                            <div class="justify-self-stretch">
                                <label for="cover" class="block font-medium text-m text-gray-700">Cover</label>
                                <div id="coverDropzone"
                                    class="w-full bg-gray-200 text-black border border-gray-200 rounded py-3 px-4 mb-3 flex items-center justify-center cursor-pointer relative"
                                    ondragover="handleDragOver(event)" ondragleave="handleDragLeave(event)"
                                    ondrop="handleFileDrop(event)">
                                    <span id="coverDropzoneText">Click to select an image or drag and drop</span>
                                    <input id="cover" class="hidden" type="file" name="cover" accept="image/*" required
                                        autofocus onchange="previewImage(event)" />

                                    <!-- Preview for the current image -->
                                    {{-- <div id="imagePreview"
                                        class="absolute inset-0 flex items-center justify-center"></div>--}}
                                </div>
                                @error('cover')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <!-- Current Cover Image -->
                        @isset($author->cover)
                            <div class="mt-2 w-48">
                                <img src="{{ asset($author->cover) }}" alt="{{ $author->name }}" class="mt-2 max-w-xs">
                            </div>
                        @endisset

                        <div class="flex items-center justify-end mt-4">
                            <button type="submit"
                                class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-500 active:bg-blue-700 focus:outline-none focus:border-blue-700 focus:ring focus:ring-blue-200 disabled:opacity-25 transition">
                                {{ isset($author) ? 'Update' : 'Create' }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Drag and Drop functionality for Cover image
        const coverDropzone = document.getElementById('coverDropzone');
        const coverInput = document.getElementById('cover');

        coverDropzone.addEventListener('click', () => coverInput.click());

        function handleDragOver(event) {
            event.preventDefault();
            event.target.classList.add('bg-blue-200');
        }

        function handleDragLeave(event) {
            event.target.classList.remove('bg-blue-200');
        }

        function handleFileDrop(event) {
            event.preventDefault();
            event.target.classList.remove('bg-blue-200');
            const files = event.dataTransfer.files;
            coverInput.files = files;

            // Update text to show the file name
            document.getElementById('coverDropzoneText').innerText = files[0].name;

            previewImage({ target: { files } });
        }

        // Image preview
        function previewImage(event) {
            const reader = new FileReader();
            reader.onload = function () {
                const output = document.getElementById('imagePreview');
                output.innerHTML = `<img src="${reader.result}" class="mt-2 max-w-xs">`;
            }
            reader.readAsDataURL(event.target.files[0]);
        }

        // On page load, check if there's an existing cover image and display it
        document.addEventListener('DOMContentLoaded', function () {
            @isset($author->cover)
                const img = document.createElement('img');
                img.src = "{{ asset($author->cover) }}";
                img.className = 'mt-2 max-w-xs';
                document.getElementById('imagePreview').appendChild(img);
            @endisset
        });

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
        .bg-blue-200 {
            background-color: #ebf8ff;
        }

        #coverDropzone {
            display: flex;
            align-items: center;
            justify-content: center;
            height: 150px;
            border: 2px dashed #ccc;
            border-radius: 8px;
            cursor: pointer;
            transition: background-color 0.3s;
            position: relative;
        }

        .max-h-32 {
            max-height: 120px;
        }

        .max-w-xs {
            max-width: 100%;
        }
    </style>
</x-app-layout>