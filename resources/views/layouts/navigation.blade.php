<nav id="sidebar" class="bg-white border-r border-gray-100 h-screen fixed transition-all duration-300 w-64">
    <!-- Primary Navigation Menu -->
    <div class="px-4 sm:px-6 lg:px-8">
        <div class="flex flex-col h-full">
            <div class="flex flex-col">
                <!-- Logo -->
                <div class="shrink-0 flex items-center mt-5 mb-10 self-end">
                    <a href="{{ route('dashboard') }}">
                        <img src="{{ asset('icons/bwa.png') }}" alt="Bibla.al Logo" class="h-12 w-auto">
                    </a>
                </div>

                <!-- Navigation Links -->
                <div class="space-y-8">
                    <a href="{{ route('dashboard') }}"
                        class="flex items-center space-x-3 p-2 rounded-lg hover:bg-gray-200">
                        <img src="{{ asset('icons/dashboard.svg') }}" alt="Dashboard Icon" class="h-6 w-6">
                        <span class="text-sm font-medium" id="dashboard-text">{{ __('Dashboard') }}</span>
                    </a>
                </div>

                @role(['admin', 'teacher'])
                    <!-- Books Section -->
                    <div>
                        <button class="flex items-center w-full space-x-3 p-2 hover:bg-gray-200 rounded-lg"
                            onclick="toggleDropdown('books-dropdown')">
                            <img src="{{ asset('icons/books.svg') }}" alt="Books Icon" class="h-6 w-6">
                            <span class="text-sm font-medium" id="books-text">{{ __('Study plans') }}</span>
                            <svg id="books-arrow" class="h-4 w-4 ml-auto transform transition-transform"
                                xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                            </svg>
                        </button>
                        <div id="books-dropdown" class="hidden pl-8 space-y-2">
                            <a href="{{ route('classroom.index') }}"
                                class="block text-sm hover:text-gray-600">{{ __('Group') }}</a>
                            <a href="{{ route('category.index') }}"
                                class="block text-sm hover:text-gray-600">{{ __('Category') }}</a>
                            <a href="{{ route('book.index') }}"
                                class="block text-sm hover:text-gray-600">{{ __('Study plans') }}</a>
                        </div>
                    </div>

                    <!-- Songs Section -->
                    <div>
                        <button class="flex items-center w-full space-x-3 p-2 hover:bg-gray-200 rounded-lg"
                            onclick="toggleDropdown('songs-dropdown')">
                            <img src="{{ asset('icons/songs.svg') }}" alt="Songs Icon" class="h-6 w-6">
                            <span class="text-sm font-medium" id="songs-text">{{ __('Songs') }}</span>
                            <svg id="songs-arrow" class="h-4 w-4 ml-auto transform transition-transform"
                                xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                            </svg>
                        </button>
                        <div id="songs-dropdown" class="hidden pl-8 space-y-2">
                            <a href="{{ route('song.index') }}"
                                class="block text-sm hover:text-gray-600">{{ __('Songs') }}</a>
                            <a href="{{ route('author.index') }}"
                                class="block text-sm hover:text-gray-600">{{ __('Authors') }}</a>
                            <a href="{{ route('playlist.index') }}"
                                class="block text-sm hover:text-gray-600">{{ __('Playlist') }}</a>
                        </div>
                    </div>
                @endrole
            </div>
        </div>
    </div>
</nav>

<!-- Sidebar Toggle Button -->
<button id="toggleSidebarBtn" class="absolute top-4 left-4 bg-gray-200 p-2 rounded-md">
    <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7" />
    </svg>
</button>

<script>
    // Function to toggle the sidebar
    const sidebar = document.getElementById('sidebar');
    const toggleSidebarBtn = document.getElementById('toggleSidebarBtn');

    toggleSidebarBtn.addEventListener('click', () => {
        const isOpen = sidebar.classList.contains('w-64');
        sidebar.classList.toggle('w-64', !isOpen);
        sidebar.classList.toggle('w-16', isOpen);

        // Toggle visibility of text inside sidebar
        const sidebarTexts = sidebar.querySelectorAll('span[id$="-text"]');
        sidebarTexts.forEach(text => {
            text.classList.toggle('hidden', isOpen);
        });
    });

    // Function to toggle dropdown menus
    function toggleDropdown(dropdownId) {
        const dropdown = document.getElementById(dropdownId);
        const arrow = document.getElementById(`${dropdownId.replace('-dropdown', '-arrow')}`);
        const isHidden = dropdown.classList.contains('hidden');

        dropdown.classList.toggle('hidden', !isHidden);
        dropdown.classList.toggle('block', isHidden);

        // Rotate arrow icon
        arrow.classList.toggle('rotate-180', isHidden);
    }
</script>
