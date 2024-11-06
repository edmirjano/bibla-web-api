<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <div class="p-6 sm:px-20 bg-white border-b border-gray-200">
                    <form method="POST"
                        action="{{ isset($song) ? route('song.update', $song->id) : route('song.store') }}"
                        enctype="multipart/form-data">
                        @csrf
                        @if (isset($song))
                            @method('PUT')
                        @endif

                        <!-- Song Title -->
                        <div class="mt-4">
                            <label for="title" :value="__('Title')"
                                class="block font-medium text-m text-gray-700">Title</label>
                            <input id="title" class="block mt-1 w-full" type="text" name="title"
                                value="{{ $song->title ?? old('title') }}" required autofocus />
                        </div>

                        <!-- Author Selection -->
                        <div class="mt-4">
                            <label for="author_id" :value="__('Author')"
                                class="block font-medium text-m text-gray-700">Author</label>
                            <select id="author_id" name="author_id" class="block mt-1 w-full">
                                <option value="">Select Author</option>
                                @foreach ($authors as $author)
                                    <option value="{{ $author->id }}"
                                        {{ isset($song) && $song->author_id == $author->id ? 'selected' : '' }}>
                                        {{ $author->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mt-4">
                            <label for="release_year" :value="__('Release Year')"
                                class="block font-medium text-m text-gray-700">Release Year</label>
                            <input id="release_year" class="block mt-1 w-full" type="number" name="release_year"
                                value="{{ $song->release_year ?? old('release_year') }}" required autofocus />
                        </div>

                        <div class="mt-4">
                            <label for="playlists" class="block font-medium text-m text-gray-700">Playlists</label>
                            <select id="playlists" name="playlists[]" class="block mt-1 w-full" multiple>
                                @foreach ($playlists as $playlist)
                                    <option value="{{ $playlist->id }}"
                                        {{ isset($song) && $song->playlists->contains($playlist->id) ? 'selected' : '' }}>
                                        {{ $playlist->title }}
                                    </option>
                                @endforeach
                            </select>
                            <p class="text-xs">Press Control + Left Mouse Click to remove</pcla>
                        </div>

                        <div class="mt-4">
                            <label for="yt_link" :value="__('Youtube Link')"
                                class="block font-medium text-m text-gray-700">Youtube Link</label>
                            <input id="yt_link" class="block mt-1 w-full" type="text" name="yt_link"
                                value="{{ $song->yt_link ?? old('yt_link') }}" />
                        </div>

                        <div class="mt-4">
                            <label for="spotify_link" :value="__('Spotify Link')"
                                class="block font-medium text-m text-gray-700">Spotify Link</label>
                            <input id="spotify_link" class="block mt-1 w-full" type="text" name="spotify_link"
                                value="{{ $song->spotify_link ?? old('spotify_)link') }}" />
                        </div>

                        <!-- Music File Dropzone -->
                        <div class="mt-4">
                            <label for="mp3link" class="block font-medium text-m text-gray-700">Music</label>
                            <div id="musicDropzone"
                                class="w-full bg-gray-200 text-black border border-gray-200 rounded py-3 px-4 mb-3 flex items-center justify-center cursor-pointer"
                                ondragover="handleDragOver(event)" ondragleave="handleDragLeave(event)"
                                ondrop="handleFileDrop(event, 'mp3link')">
                                <span id="musicDropzoneText">
                                    {{ isset($song->mp3link) ? basename($song->mp3link) : 'Click to select a file or drag and drop' }}
                                </span>
                                <input id="mp3link" class="hidden" type="file" name="mp3link" accept="audio/*"
                                    onchange="updateDropzoneText(this, 'musicDropzoneText')" required />
                            </div>
                            @error('mp3link')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                            @if (isset($song) && $song->mp3link)
                                <p class="mt-2">Current MP3: <a href="{{ asset($song->mp3link) }}"
                                        target="_blank">Listen</a></p>
                            @endif
                        </div>

                        <!-- Cover Image Dropzone -->
                        <div class="mt-4">
                            <label for="cover" class="block font-medium text-m text-gray-700">Cover</label>
                            <div id="coverDropzone"
                                class="w-full bg-gray-200 text-black border border-gray-200 rounded py-3 px-4 mb-3 flex items-center justify-center cursor-pointer"
                                ondragover="handleDragOver(event)" ondragleave="handleDragLeave(event)"
                                ondrop="handleFileDrop(event, 'cover')">
                                <span id="coverDropzoneText">Click to select an image or drag and drop</span>
                                <input id="cover" class="hidden" type="file" name="cover" accept="image/*"
                                    autofocus onchange="previewImage(event, 'imagePreview')" />
                            </div>
                            @error('cover')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>



                        <!-- Image Preview -->
                        <div id="imagePreview" class="mt-2"></div>
                        @isset($song->cover)
                            <div class="mt-2 w-48">
                                <img src="{{ asset($song->cover) }}" alt="{{ $song->title }}">
                            </div>
                        @endisset

                        <div>
                            <label for="lyrics" class="block font-medium text-m text-gray-700">Lyrics</label>
                            <textarea id="lyrics" name="lyrics" class="border rounded px-3 py-2 w-full" autofocus>{{ $song->lyrics ?? old('lyrics') }}</textarea>
                            @error('lyrics')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>



                        <!-- Submit Button -->
                        <div class="flex items-center justify-end mt-4">
                            <button type="submit"
                                class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-500 active:bg-blue-700 focus:outline-none focus:border-blue-700 focus:ring focus:ring-blue-200 disabled:opacity-25 transition">
                                {{ isset($song) ? 'Update' : 'Create' }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Dropzone click simulation for Music and Cover file inputs
        const musicDropzone = document.getElementById('musicDropzone');
        const coverDropzone = document.getElementById('coverDropzone');
        const musicInput = document.getElementById('mp3link');
        const coverInput = document.getElementById('cover');

        musicDropzone.addEventListener('click', () => musicInput.click());
        coverDropzone.addEventListener('click', () => coverInput.click());

        // Drag and Drop functionality
        function handleDragOver(event) {
            event.preventDefault();
            event.target.classList.add('bg-blue-200');
        }

        function handleDragLeave(event) {
            event.target.classList.remove('bg-blue-200');
        }

        function handleFileDrop(event, inputId) {
            event.preventDefault();
            event.target.classList.remove('bg-blue-200');
            const files = event.dataTransfer.files;
            document.getElementById(inputId).files = files;

            // Update text to show the file name
            const dropzoneText = inputId === 'mp3link' ? 'musicDropzoneText' : 'coverDropzoneText';
            document.getElementById(dropzoneText).innerText = files[0].name;

            if (inputId === 'cover') previewImage({
                target: {
                    files
                }
            }, 'imagePreview');
        }

        // Image preview
        function previewImage(event, previewId) {
            const file = event.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    const output = document.getElementById(previewId);
                    output.innerHTML = `<img src="${e.target.result}" class="mt-2 max-w-xs">`;
                }
                reader.readAsDataURL(file);
            }
        }

        function updateDropzoneText(inputElement, dropzoneTextId) {
            const fileName = inputElement.files[0].name;
            document.getElementById(dropzoneTextId).textContent = fileName;
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
        .bg-blue-200 {
            background-color: #ebf8ff;
        }

        #musicDropzone,
        #coverDropzone {
            display: flex;
            align-items: center;
            justify-content: center;
            height: 150px;
            border: 2px dashed #ccc;
            border-radius: 8px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        .max-w-xs {
            max-width: 150px;
        }
    </style>
</x-app-layout>
