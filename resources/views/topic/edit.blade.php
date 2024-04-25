<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ isset($topic) ? __('Edit Topic') : __('Create Topic') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <div class="p-6 sm:px-20 bg-white border-b border-gray-200">
                    <form method="POST"
                        action="{{ isset($topic) ? route('topic.update', $topic->id) : route('topic.store') }}"
                        enctype="multipart/form-data">
                        @csrf
                        @if (isset($topic))
                            @method('PUT')
                        @endif
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label for="name" class="block font-medium text-sm text-gray-700">Name</label>
                                <input id="name"
                                    class="block mt-1 w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                    type="text" name="name"
                                    value="{{ isset($topic) ? $topic->name : old('name') }}" required autofocus />
                                @error('name')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="group_id" class="block font-medium text-sm text-gray-700">Select Group</label>
                                <select id="group_id" name="group_id"
                                        class="block w-full mt-1 rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                        required autofocus>
                                    @if(isset($groupId))
                                        <option value="{{ $groupId }}" selected>{{ $groups->where('id', $groupId)->first()->name }}</option>
                                    @else
                                        <option value="">Select Group</option>
                                        @foreach($groups as $group)
                                            <option value="{{ $group->id }}" {{ isset($topic) && $topic->group_id == $group->id ? 'selected' : '' }}>
                                                {{ $group->name }}
                                            </option>
                                        @endforeach
                                    @endif
                                </select>
                                @error('group_id')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>



                            <div class="w-full">
                                <label for="description" class="block font-medium text-sm text-gray-700">Description</label>
                                <textarea id="description" name="description" class="border rounded px-3 py-2 w-full" autofocus>
                                        {{ isset($topic) ? $topic->description : old('description') }} </textarea>
                                @error('description')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <div class="flex items-center justify-end mt-4">
                            <button type="submit"
                                class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-500 active:bg-blue-700 focus:outline-none focus:border-blue-700 focus:ring focus:ring-blue-200 disabled:opacity-25 transition">
                                {{ isset($topic) ? 'Update' : 'Create' }}
                            </button>
                        </div>

                        @if (isset($topic))
                            <input type="hidden" name="topic_id" value="{{ $topic->id }}">
                        @endif
                    </form>
                </div>

                @isset($topic)
                <div class="section px-4">
                    <div class="py-5">
                        @foreach($topic->sections as $section)
                            <div class="my-2 bg-gray-300 rounded-sm">
                                <div class="flex justify-between items-center cursor-pointer border-b border-gray-300 py-4 " onclick="toggleAccordion(this)">
                                    <div class="flex items-center">
                                        <svg class="w-6 h-6 mr-3 text-gray-800" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                        </svg>
                                        <div>
                                            <div class="font-semibold text-sm text-gray-800">Section Name: {{$section->name}}</div>
                                            <p class="text-sm text-gray-600">{!!$section->description!!}</p>
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
                                            @foreach($section->questions()->orderBy('index')->get() as $question)
                                                <div class="my-4 p-2 flex justify-between border-gray-300 bg-gray-400">
                                                    <div class="text-gray-800 flex flex-row">
                                                        <div style="widht: 20px; "> {{$loop->iteration}}.</div>
                                                        <div class="pl-2">{!!$question->description!!}</div>
                                                    </div>
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
            @endisset
            </div>

        </div>
    </div>
    <script>
        function toggleAccordion(element) {
            element.nextElementSibling.classList.toggle('hidden');
            const icon = element.querySelector('svg');
            icon.classList.toggle('rotate-180');
        }
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
