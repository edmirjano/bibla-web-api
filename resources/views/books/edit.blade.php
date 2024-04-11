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
                                       type="text" name="slug" value="{{ $book->slug ?? old('slug') }}" required
                                       autofocus/>
                                @error('slug')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                            <div>
                                <label for="description"
                                       class="block font-medium text-sm text-gray-700">Description</label>
                                <textarea id="description" name="description" class="border rounded px-3 py-2 w-full" required autofocus>
                                    {{$book->description ?? old('description')}}</textarea>
                                @error('description')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                            <div>
                                <label for="detailed_info" class="block font-medium text-sm text-gray-700">Detailed
                                    Info</label>
                                <input id="detailed_info"
                                       class="block mt-1 w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                       type="text" name="detailed_info"
                                       value="{{ $book->detailed_info ?? old('detailed_info') }}" required autofocus
                                       rows="10"/>
                                @error('detailed_info')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                            <div>
                                <label for="author" class="block font-medium text-sm text-gray-700">Author</label>
                                <input id="author"
                                       class="block mt-1 w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                       type="text" name="author" value="{{ $book->author ?? old('author') }}" required
                                       autofocus/>
                                @error('author')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                            <div>
                                <label for="rating" class="block font-medium text-sm text-gray-700">Rating</label>
                                <input id="rating"
                                       class="block mt-1 w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                       type="number" name="rating" value="{{ $book->rating ?? old('rating') }}"
                                       step="0.1" required autofocus/>
                                @error('rating')
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
                @if(isset($book))
                    <div class="container mx-auto">
                        @foreach($book->groups as $group)
                            <div class="group bg-gray-100 p-4 rounded-sm m-4">
                                <div class="flex justify-between items-center cursor-pointer" onclick="toggleAccordion(this)">
                                    <div class="flex items-center mb-4">
                                        <svg class="w-6 h-6 mr-3 text-gray-800" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                        </svg>
                                        <div class="flex flex-row text-pretty">
                                            <h3 class="text-lg font-semibold text-gray-800">Group Name</h3>
                                            <h3 class="text-lg  text-gray-600 pl-2">{{$group->name}}</h3>
                                        </div>
                                    </div>
                                    <div class="flex px-2">
                                        <a href="{{route('group.edit',$group->id)}}" class="text-yellow-600 hover:text-yellow-900 px-4">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16"
                                                 height="16" fill="currentColor" class="bi bi-pencil"
                                                 viewBox="0 0 16 16">
                                                <path
                                                    d="M12.146.146a.5.5 0 0 1 .708 0l3 3a.5.5 0 0 1 0 .708l-10 10a.5.5 0 0 1-.168.11l-5 2a.5.5 0 0 1-.65-.65l2-5a.5.5 0 0 1 .11-.168zM11.207 2.5 13.5 4.793 14.793 3.5 12.5 1.207zm1.586 3L10.5 3.207 4 9.707V10h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.293zm-9.761 5.175-.106.106-1.528 3.821 3.821-1.528.106-.106A.5.5 0 0 1 5 12.5V12h-.5a.5.5 0 0 1-.5-.5V11h-.5a.5.5 0 0 1-.468-.325" />
                                            </svg>
                                        </a>
                                        <form action="{{ route('group.destroy', $group->id) }}" method="POST"
                                              class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-600 hover:text-red-900">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="16"
                                                     height="16" fill="currentColor" class="bi bi-trash"
                                                     viewBox="0 0 16 16">
                                                    <path
                                                        d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5m2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5m3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0z" />
                                                    <path
                                                        d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4zM2.5 3h11V2h-11z" />
                                                </svg>
                                            </button>
                                        </form>
                                    </div>
                                </div>
                                <div class="bi-tropical-storm">
                                    <div class="py-5">
                                    @foreach($group->topics as $topic)
                                        <div class="my-4 bg-gray-200 rounded-sm">
                                            <div class="flex justify-between items-center cursor-pointer border-b border-gray-300 py-4" onclick="toggleAccordion(this)">
                                                <div class="flex items-center">
                                                    <svg class="w-6 h-6 mr-3 text-gray-800" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                                    </svg>
                                                    <div>
                                                        <h2 class="text-lg font-semibold text-gray-800">Topic Name: {{$topic->name}}</h2>
                                                        <p class="text-gray-600">{{$topic->description}}</p>
                                                    </div>
                                                </div>
                                                <div class="flex px-2">

                                                    <a href="{{route('topic.edit',$topic->id)}}" class="text-yellow-600 hover:text-yellow-900 px-4">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="16"
                                                             height="16" fill="currentColor" class="bi bi-pencil"
                                                             viewBox="0 0 16 16">
                                                            <path
                                                                d="M12.146.146a.5.5 0 0 1 .708 0l3 3a.5.5 0 0 1 0 .708l-10 10a.5.5 0 0 1-.168.11l-5 2a.5.5 0 0 1-.65-.65l2-5a.5.5 0 0 1 .11-.168zM11.207 2.5 13.5 4.793 14.793 3.5 12.5 1.207zm1.586 3L10.5 3.207 4 9.707V10h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.293zm-9.761 5.175-.106.106-1.528 3.821 3.821-1.528.106-.106A.5.5 0 0 1 5 12.5V12h-.5a.5.5 0 0 1-.5-.5V11h-.5a.5.5 0 0 1-.468-.325" />
                                                        </svg>
                                                    </a>
                                                    <form action="{{ route('topic.destroy', $topic->id) }}" method="POST"
                                                          class="inline">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="text-red-600 hover:text-red-900">
                                                            <svg xmlns="http://www.w3.org/2000/svg" width="16"
                                                                 height="16" fill="currentColor" class="bi bi-trash"
                                                                 viewBox="0 0 16 16">
                                                                <path
                                                                    d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5m2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5m3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0z" />
                                                                <path
                                                                    d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4zM2.5 3h11V2h-11z" />
                                                            </svg>
                                                        </button>
                                                    </form>
                                                </div>
                                            </div>
                                            <div class="section">
                                                <div class="py-5">
                                                @foreach($topic->sections as $section)
                                                    <div class="my-2 bg-gray-300 rounded-sm">
                                                        <div class="flex justify-between items-center cursor-pointer border-b border-gray-300 py-4" onclick="toggleAccordion(this)">
                                                            <div class="flex items-center">
                                                                <svg class="w-6 h-6 mr-3 text-gray-800" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                                                </svg>
                                                                <div>
                                                                    <div class="font-semibold text-sm text-gray-800">Section Name: {{$section->name}}</div>
                                                                    <p class="text-sm text-gray-600">{{$section->description}}</p>
                                                                </div>
                                                            </div>
                                                            <div class="flex px-2">

                                                                <a href="{{route('section.edit',$section->id)}}" class="text-yellow-600 hover:text-yellow-900 px-4">
                                                                    <svg xmlns="http://www.w3.org/2000/svg" width="16"
                                                                         height="16" fill="currentColor" class="bi bi-pencil"
                                                                         viewBox="0 0 16 16">
                                                                        <path
                                                                            d="M12.146.146a.5.5 0 0 1 .708 0l3 3a.5.5 0 0 1 0 .708l-10 10a.5.5 0 0 1-.168.11l-5 2a.5.5 0 0 1-.65-.65l2-5a.5.5 0 0 1 .11-.168zM11.207 2.5 13.5 4.793 14.793 3.5 12.5 1.207zm1.586 3L10.5 3.207 4 9.707V10h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.293zm-9.761 5.175-.106.106-1.528 3.821 3.821-1.528.106-.106A.5.5 0 0 1 5 12.5V12h-.5a.5.5 0 0 1-.5-.5V11h-.5a.5.5 0 0 1-.468-.325" />
                                                                    </svg>
                                                                </a>
                                                                <form action="{{ route('section.destroy', $section->id) }}" method="POST"
                                                                      class="inline">
                                                                    @csrf
                                                                    @method('DELETE')
                                                                    <button type="submit" class="text-red-600 hover:text-red-900">
                                                                        <svg xmlns="http://www.w3.org/2000/svg" width="16"
                                                                             height="16" fill="currentColor" class="bi bi-trash"
                                                                             viewBox="0 0 16 16">
                                                                            <path
                                                                                d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5m2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5m3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0z" />
                                                                            <path
                                                                                d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4zM2.5 3h11V2h-11z" />
                                                                        </svg>
                                                                    </button>
                                                                </form>
                                                            </div>
                                                        </div>
                                                        <div class="ml-4">
                                                            <div class="py-5">
                                                            @foreach($section->questions as $question)
                                                                <div class="my-4 p-2 flex justify-between border-gray-300 bg-gray-400">
                                                                    <p class="text-gray-800">{{$loop->iteration}}. {{$question->description}}</p>
                                                                    <div class="flex px-2">
                                                                        <a href="{{route('question.edit',$question->id)}}" class="text-yellow-600 hover:text-yellow-900 px-4">
                                                                            <svg xmlns="http://www.w3.org/2000/svg" width="16"
                                                                                 height="16" fill="currentColor" class="bi bi-pencil"
                                                                                 viewBox="0 0 16 16">
                                                                                <path
                                                                                    d="M12.146.146a.5.5 0 0 1 .708 0l3 3a.5.5 0 0 1 0 .708l-10 10a.5.5 0 0 1-.168.11l-5 2a.5.5 0 0 1-.65-.65l2-5a.5.5 0 0 1 .11-.168zM11.207 2.5 13.5 4.793 14.793 3.5 12.5 1.207zm1.586 3L10.5 3.207 4 9.707V10h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.293zm-9.761 5.175-.106.106-1.528 3.821 3.821-1.528.106-.106A.5.5 0 0 1 5 12.5V12h-.5a.5.5 0 0 1-.5-.5V11h-.5a.5.5 0 0 1-.468-.325" />
                                                                            </svg>
                                                                        </a>
                                                                        <form action="{{ route('question.destroy', $question->id) }}" method="POST"
                                                                              class="inline">
                                                                            @csrf
                                                                            @method('DELETE')
                                                                            <button type="submit" class="text-red-600 hover:text-red-900">
                                                                                <svg xmlns="http://www.w3.org/2000/svg" width="16"
                                                                                     height="16" fill="currentColor" class="bi bi-trash"
                                                                                     viewBox="0 0 16 16">
                                                                                    <path
                                                                                        d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5m2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5m3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0z" />
                                                                                    <path
                                                                                        d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4zM2.5 3h11V2h-11z" />
                                                                                </svg>
                                                                            </button>
                                                                        </form>
                                                                    </div>
                                                                </div>
                                                            @endforeach

                                                                <a href="{{ route('question.create',['section_id'=>$section->id]) }}"
                                                                   class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Create Question</a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endforeach
                                                    <a href="{{ route('section.create',['topic_id'=>$topic->id]) }}"
                                                       class="bg-blue-500 hover:bg-blue-700 text-white font-bold  m-2 p-2 rounded">Create Section</a>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                        <a href="{{ route('topic.create', ['book_id' => $book->id,'group_id'=>$group->id]) }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Create Topic</a>

                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                <div class="flex justify-between">
                    <a href="{{route('group.create',['book_id'=>$book->id])}}" class="btn-blue m-4">Create Group</a>
                </div>
                @endif
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
