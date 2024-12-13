<nav x-data="{ openBooks: false, openSongs: false }"
    class="bg-button-white h-screen fixed transition-all duration-300 w-64 flex flex-col justify-between">
    <!-- Primary Navigation Menu -->
    <div class="px-4 sm:px-6 lg:px-8">
        <div class="flex flex-col">
            <!-- Logo -->
            <div class="shrink-0 flex items-center mt-5 mb-10 self-center" id="logo-text">
                <a href="{{ route('dashboard') }}">
                    <img src="{{ asset('icons/bwa.png') }}" alt="Bibla.al Logo" class="h-12 w-auto">
                </a>
            </div>

            <!-- Navigation Links -->
            <div class="space-y-8" id="dashboard-text">
                <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')" iconPath="icons/dashboard.svg">
                    {{ __('Dashboard') }}
                </x-nav-link>
            </div>

            @role(['admin', 'teacher'])
                <!-- Books Section -->
                <div id="books-text">
                    <button @click="openBooks = !openBooks" class="flex items-center">
                        <x-nav-link :active="request()->routeIs('classroom.index', 'category.index', 'book.index')
                            ? 'text-blue-600'
                            : ''" iconPath="icons/books.svg">
                            {{ __('Study plans') }}
                        </x-nav-link>
                        <svg x-bind:class="{ 'rotate-180': openBooks }"
                            class="w-4 h-4 transform transition-transform duration-300" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                        </svg>
                    </button>
                    <div x-show="openBooks" class="pl-4 space-y-2">
                        <x-nav-link :href="route('book.index')" :active="request()->routeIs('book.index')" iconPath="icons/books.svg">
                            {{ __('Study plans') }}
                        </x-nav-link>
                        <x-nav-link :href="route('classroom.index')" :active="request()->routeIs('classroom.index')" iconPath="icons/classroom.svg">
                            {{ __('Classrooms') }}
                        </x-nav-link>
                        <x-nav-link :href="route('category.index')" :active="request()->routeIs('category.index')" iconPath="icons/category.svg">
                            {{ __('Category') }}
                        </x-nav-link>
                    </div>
                </div>

                <!-- Songs Section -->
                <div id="songs-text">
                    <button @click="openSongs = !openSongs" class="flex items-center w-full">
                        <x-nav-link :active="request()->routeIs('song.index', 'album.index', 'playlist.index', 'author.index')
                            ? 'text-blue-600'
                            : ''" iconPath="icons/songs.svg">
                            {{ __('Songs') }}
                        </x-nav-link>
                        <svg x-bind:class="{ 'rotate-180': openSongs }"
                            class="w-4 h-4 transform transition-transform duration-300" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                        </svg>
                    </button>
                    <div x-show="openSongs" class="pl-4 space-y-2">
                        <x-nav-link :href="route('song.index')" :active="request()->routeIs('song.index')" iconPath="icons/songs.svg">
                            {{ __('Songs') }}
                        </x-nav-link>
                        <x-nav-link :href="route('author.index')" :active="request()->routeIs('author.index')" iconPath="icons/artist.svg">
                            {{ __('Authors') }}
                        </x-nav-link>
                        <x-nav-link :href="route('playlist.index')" :active="request()->routeIs('playlist.index')" iconPath="icons/playlist.svg">
                            {{ __('Playlist') }}
                        </x-nav-link>
                        <x-nav-link :href="route('album.index')" :active="request()->routeIs('album.index')" iconPath="icons/album.svg">
                            {{ __('Album') }}
                        </x-nav-link>
                    </div>
                </div>
                <div class="space-y-8" id="users-text">
                    <x-nav-link :href="route('users.index')" :active="request()->routeIs('users.index')" iconPath="icons/users.svg">
                        {{ __('Users') }}
                    </x-nav-link>
                </div>
            @endrole
        </div>
    </div>

    <!-- Footer Section -->
    <div class="px-4 py-4 border-t border-gray-200 bg-gray-50" id="end-of-nav">
        <!-- Profile Button -->
        <x-dropdown-link :href="route('profile.edit')"
            class="flex items-center space-x-4 text-sm font-medium text-gray-700 bg-gray-100 hover:bg-gray-200 rounded-lg px-4 py-2 transition-colors">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-500" fill="none" viewBox="0 0 24 24"
                stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M5.121 12.121l1.415-1.415m0 0l7.778-7.778a2 2 0 112.828 2.828l-7.778 7.778m-3.181.02a2 2 0 102.828 2.828M21 21l-6-6">
                </path>
            </svg>
            <span>{{ __('Profile') }}</span>
        </x-dropdown-link>

        <!-- Logout Button -->
        <form method="POST" action="{{ route('logout') }}" class="mt-3">
            @csrf
            <button type="submit"
                class="w-full flex items-center space-x-4 text-sm font-medium text-gray-700 bg-gray-100 hover:bg-red-100 hover:text-red-600 rounded-lg px-4 py-2 transition-colors">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-500" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7">
                    </path>
                </svg>
                <span>{{ __('Log Out') }}</span>
            </button>
        </form>
    </div>

</nav>
