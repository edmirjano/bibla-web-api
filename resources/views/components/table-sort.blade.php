<th
    class="px-5 py-3 border-b-2 border-200-gray bg-light-gray text-left text-s font-semibold text-gray-700 uppercase tracking-wider cursor-pointer">
    <div class="flex items-center justify-between">
        <!-- Display column name -->
        {{ $slot }}

        <!-- Sorting Arrows -->
        @if ($sortable ?? true)
            <div class="flex gap-2">
                <!-- Ascending Order Arrow -->
                <button type="button" onclick="sortChanged('{{ $name }}', 'asc')" class="focus:outline-none">
                    <svg xmlns="http://www.w3.org/2000/svg"
                        class="w-4 {{ ($sortField ?? '') === $name && ($sortDirection ?? '') === 'asc' ? 'text-white' : 'text-gray-600' }}"
                        viewBox="0 0 24 24" fill="currentColor">
                        <path d="M7 14l5-5 5 5H7z" />
                    </svg>
                </button>

                <!-- Descending Order Arrow -->
                <button type="button" onclick="sortChanged('{{ $name }}', 'desc')" class="focus:outline-none">
                    <svg xmlns="http://www.w3.org/2000/svg"
                        class="w-4 {{ ($sortField ?? '') === $name && ($sortDirection ?? '') === 'desc' ? 'text-white' : 'text-gray-600' }}"
                        viewBox="0 0 24 24" fill="currentColor">
                        <path d="M7 10l5 5 5-5H7z" />
                    </svg>
                </button>
            </div>
        @endif
    </div>
</th>
