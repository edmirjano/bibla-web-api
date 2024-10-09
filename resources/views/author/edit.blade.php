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
                        @if(isset($author))
                            @method('PUT')
                        @endif
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label for="name" class="block font-medium text-sm text-gray-700">Author Name</label>
                                <input id="name"
                                       class="block mt-1 w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                       type="text" name="name" value="{{ $author->name ?? old('name') }}" required autofocus />
                                @error('name')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>


                            <div>
                                <label for="cover" class="block font-medium text-sm text-gray-700">Cover</label>
                                <input id="cover"
                                       class="block mt-1 w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                       type="file" name="cover" onchange="previewImage(event)" />
                                @error('cover')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <div id="imagePreview" class="mt-2"></div>
                        @isset($author->cover)
                            <div class="mt-2 w-48">
                                <img src="{{ asset($author->cover) }}" alt="{{ $author->name }}">
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
        function previewImage(event) {
            const reader = new FileReader();
            reader.onload = function () {
                const output = document.getElementById('imagePreview');
                output.innerHTML = `<img src="${reader.result}" class="mt-2 max-w-xs">`;
            }
            reader.readAsDataURL(event.target.files[0]);
        }
    </script>

</x-app-layout>
