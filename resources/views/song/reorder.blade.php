
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Reorder Songs') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">
                <ul id="sortable" class="list-disc pl-5">
                    @foreach ($songs as $song)
                        <li class="mb-2 cursor-move" data-id="{{ $song->id }}">
                            {{ $song->title }}
                        </li>
                    @endforeach
                </ul>
                <button id="saveOrder" class="mt-4 bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                    Save Order
                </button>
            </div>
        </div>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/Sortable/1.14.0/Sortable.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            var sortable = new Sortable(document.getElementById('sortable'), {
                animation: 150,
                ghostClass: 'bg-blue-100'
            });

            document.getElementById('saveOrder').addEventListener('click', function () {
                var order = sortable.toArray();
                fetch('{{ route('song.saveOrder') }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({ order: order })
                }).then(response => response.json())
                  .then(data => {
                      if (data.success) {
                          alert('Order saved successfully!');
                      } else {
                          alert('Failed to save order.');
                      }
                  });
            });
        });
    </script>
</x-app-layout>
