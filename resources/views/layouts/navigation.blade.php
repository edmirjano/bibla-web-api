<nav x-data="{ openBooks: false, openSongs: false }"
    class="bg-button-white h-screen fixed transition-all duration-300 w-64">
    <!-- Primary Navigation Menu -->
    <div class="px-4 sm:px-6 lg:px-8">
        <div class="flex flex-col h-full">
            <div class="flex flex-col">
                <!-- Logo -->
                <div class="shrink-0 flex items-center mt-5 mb-10 self-center" id="logo-text">
                    <a href="{{ route('dashboard') }}">
                        <img src="{{ asset('icons/bwa.png') }}" alt="Bibla.al Logo" class="h-12 w-auto">
                    </a>
                </div>

                <!-- Navigation Links -->
                <div class="space-y-8 " id="dashboard-text">
                    <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')"
                        iconPath="icons/dashboard.svg">
                        {{ __('Dashboard') }}
                    </x-nav-link>
                </div>

                @role(['admin', 'teacher'])
                <!-- Books Section -->
                <div id="books-text">
                    <button @click="openBooks = !openBooks" class="flex items-center">
                        <x-nav-link :active="request()->routeIs('book.index')" iconPath="icons/books.svg">
                            {{ __('Study plans') }}
                        </x-nav-link>
                        <svg x-bind:class="{ 'rotate-180': openBooks }"
                            class="w-4 h-4 transform transition-transform duration-300" fill="none"
                            stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7">
                            </path>
                        </svg>
                    </button>
                    <div x-show="openBooks" class="pl-4 space-y-2">
                        <x-nav-link :href="route('classroom.index')" :active="request()->routeIs('classroom.index')"
                            iconPath="icons/classroom.svg">
                            {{ __('Group') }}
                        </x-nav-link>
                        <x-nav-link :href="route('category.index')" :active="request()->routeIs('category.index')"
                            iconPath="icons/category.svg">
                            {{ __('Category') }}
                        </x-nav-link>
                        <x-nav-link :href="route('book.index')" :active="request()->routeIs('book.index')"
                            iconPath="icons/books.svg">
                            {{ __('Study plans') }}
                        </x-nav-link>
                    </div>
                </div>

                <!-- Songs Section -->
                <div id="songs-text">
                    <button @click="openSongs = !openSongs" class="flex items-center w-full">
                        <x-nav-link :active="request()->routeIs('song.index')" iconPath="icons/songs.svg">
                            {{ __('Songs') }}
                        </x-nav-link>
                        <svg x-bind:class="{ 'rotate-180': openSongs }"
                            class="w-4 h-4 transform transition-transform duration-300" fill="none"
                            stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7">
                            </path>
                        </svg>
                    </button>
                    <div x-show="openSongs" class="pl-4 space-y-2">
                        <x-nav-link :href="route('song.index')" :active="request()->routeIs('song.index')"
                            iconPath="icons/songs.svg">
                            {{ __('Songs') }}
                        </x-nav-link>
                        <x-nav-link :href="route('author.index')" :active="request()->routeIs('author.index')"
                            iconPath="icons/artist.svg">
                            {{ __('Authors') }}
                        </x-nav-link>
                        <x-nav-link :href="route('playlist.index')" :active="request()->routeIs('playlist.index')"
                            iconPath="icons/playlist.svg">
                            {{ __('Playlist') }}
                        </x-nav-link>
                        <x-nav-link :href="route('album.index')" :active="request()->routeIs('album.index')"
                            iconPath="icons/album.svg">
                            {{ __('Album') }}
                        </x-nav-link>
                    </div>
                </div>
                <div class="space-y-8" id="users-text">
                    <x-nav-link :href="route('users.index')" :active="request()->routeIs('users.index')"
                        iconPath="icons/users.svg">
                        {{ __('Users') }}
                    </x-nav-link>
                </div>
                @endrole
            </div>
        </div>
    </div>
    <div class="py-2.5 pr-4 justify-items-end mt-96 relative">
        <x-dropdown width="48">
            <!-- Dropdown Trigger -->
            <x-slot name="trigger">
                <button
                    class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:text-gray-700 focus:outline-none transition ease-in-out duration-150">
                    <div>{{ Auth::user()->name }}</div>
                    <div class="ms-1">
                        <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                            <path fill-rule="evenodd"
                                d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a 1 1 0 111.414 1.414l-4 4a 1 1 0 01-1.414 0l-4-4a 1 1 0 010-1.414z"
                                clip-rule="evenodd" />
                        </svg>
                    </div>
                </button>
            </x-slot>

            <!-- Dropdown Content -->
            <x-slot name="content">
                <x-dropdown-link :href="route('profile.edit')">
                    {{ __('Profile') }}
                </x-dropdown-link>
                <form method="POST" action="{{ route('logout') }}" class="border-t-2 border-table-gray">
                    @csrf
                    <x-dropdown-link :href="route('logout')"
                        onclick="event.preventDefault(); this.closest('form').submit();">
                        {{ __('Log Out') }}
                    </x-dropdown-link>
                </form>
            </x-slot>
        </x-dropdown>
    </div>

</nav>