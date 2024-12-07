<x-app-layout>
    <x-slot name="header">
        <form method="GET" action="{{ route('song.index') }}" class="flex">
            <input type="text" name="search" value="{{ old('search', $query ?? '') }}" placeholder="Search songs..."
                   class="border rounded px-4 py-2">
            <button type="submit" class="ml-2 bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                Search
            </button>
        </form>
    </x-slot>

    <div class="h-screen min-h-screen p-4">
        <div class="mx-auto h-full">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <div class="sm:px-20 container mx-auto px-4 sm:px-8">
                    <div class="flex justify-between">
                        <div class="mt-8 text-2xl font-semibold leading-tight">
                            Songs
                        </div>
                        <div class="flex space-x-4 mt-6">
                            <x-add-button href="{{ route('song.create') }}">
                                {{ '+ ADD' }}
                            </x-add-button>
                            <x-add-button href="{{ route('song.index') }}">
                                {{ 'Index' }}
                            </x-add-button>
                            <button id="saveOrder" class="ml-2 bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">
                                Save Order
                            </button>
                        </div>
                    </div>
                    <div class="mt-6 inline-block w-full shadow-md rounded-md sm:overflow-x-visible overflow-x-auto">
                        <table id="sortableTable" class="min-w-full leading-normal">
                            <thead>
                            <tr>
                                <th
                                    class="px-5 py-3 border-b-2 border-200-gray bg-light-gray text-left text-s font-semibold text-gray-700 uppercase tracking-wider">
                                    Title
                                </th>
                                <th
                                    class="px-5 py-3 border-b-2 border-200-gray bg-light-gray text-left text-s font-semibold text-gray-700 uppercase tracking-wider">
                                    Author
                                </th>
                                <th
                                    class="px-5 py-3 border-b-2 border-200-gray bg-light-gray text-left text-s font-semibold text-gray-700 uppercase tracking-wider">
                                    Action
                                </th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach ($songs as $song)
                                <tr data-id="{{ $song->id }}" class="border-b border-table-gray cursor-move">
                                    <td class="px-5 py-5 bg-white text-sm whitespace-nowrap">
                                        <img src="{{ asset($song->cover) }}" alt="{{ $song->name }}"
                                             class="w-8 h-8 mr-1 rounded-full inline-block"
                                             onerror="this.onerror=null;this.src='{{ asset('icons/song.png') }}';">
                                        {{ $song->title }}
                                    </td>
                                    <td class="px-5 py-5 bg-white text-sm whitespace-nowrap">
                                        @if ($song->authors->isNotEmpty())
                                            <ul>
                                                @foreach ($song->authors as $author)
                                                    <li>
                                                        <img src="{{ asset($author->cover) }}"
                                                             alt="{{ $author->name }}"
                                                             class="w-8 h-8 mr-1 mb-1 rounded-full inline-block"
                                                             onerror="this.onerror=null;this.src='{{ asset('icons/profile_icon.png') }}';">
                                                        {{ $author->name }}
                                                    </li>
                                                @endforeach
                                            </ul>
                                        @endif
                                    </td>
                                    <td class=" bg-white text-sm whitespace-nowrap">
                                        <div class="flex space-x-3 align-middle">
                                            <img src="{{ asset('icons/burger.svg') }}" alt="Drag">
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Include Sortable.js -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Sortable/1.14.0/Sortable.min.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Initialize Sortable.js on the table body
            var sortable = new Sortable(document.querySelector('#sortableTable tbody'), {
                animation: 150,
                ghostClass: 'bg-blue-100',
                handle: 'img', // Restrict dragging to the burger icon
            });

            // Save button click handler
            document.getElementById('saveOrder').addEventListener('click', function () {
                // Collect the order of IDs
                var order = [];
                document.querySelectorAll('#sortableTable tbody tr').forEach(row => {
                    order.push(row.getAttribute('data-id'));
                });

                // Send the order to the server via AJAX
                fetch('{{ route('song.saveOrder') }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({ order: order })
                })
                    .then(response => response.json())
                    .then(data => {
                        alert(data.message || 'Order saved successfully!');
                    })
                    .catch(error => {
                        console.error('Error saving order:', error);
                        alert('An error occurred while saving the order.');
                    });
            });
        });
    </script>
</x-app-layout>
