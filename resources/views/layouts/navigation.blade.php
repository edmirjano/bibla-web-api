<nav x-data="{ openBooks: false, openSongs: false }" class="bg-white border-r border-gray-100 h-screen fixed w-64">
    <!-- Primary Navigation Menu -->
    <div class="px-4 sm:px-6 lg:px-8">
        <div class="flex flex-col h-full">
            <div class="flex flex-col">
                <!-- Logo -->
                <div class="shrink-0 flex items-center mt-5 mb-10">
                    <a href="{{ route('dashboard') }}">
                        <img src="{{ asset('icons/bwa.png') }}" alt="Bibla.al Logo" class="h-12 w-auto">
                    </a>
                </div>

                <!-- Navigation Links -->
                <div class="space-y-8">
                    <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')" iconPath="icons/dashboard.svg">
                        {{ __('Dashboard') }}
                    </x-nav-link>
                </div>

                @role(['admin', 'teacher'])
                    <div class="space-y-2">
                        <button @click="openBooks = !openBooks" class="flex items-center w-full">
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
                            <x-nav-link :href="route('classroom.index')" :active="request()->routeIs('classroom.index')" iconPath="icons/classroom.svg">
                                {{ __('Group') }}
                            </x-nav-link>
                            <x-nav-link :href="route('category.index')" :active="request()->routeIs('category.index')" iconPath="icons/category.svg">
                                {{ __('Category') }}
                            </x-nav-link>
                            <x-nav-link :href="route('book.index')" :active="request()->routeIs('book.index')" iconPath="icons/books.svg">
                                {{ __('Study plans') }}
                            </x-nav-link>
                        </div>
                    </div>

                    <div class="space-y-2">
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
                            <x-nav-link :href="route('song.index')" :active="request()->routeIs('song.index')" iconPath="icons/songs.svg">
                                {{ __('Songs') }}
                            </x-nav-link>
                            <x-nav-link :href="route('author.index')" :active="request()->routeIs('author.index')" iconPath="icons/artist.svg">
                                {{ __('Authors') }}
                            </x-nav-link>
                            <x-nav-link :href="route('playlist.index')" :active="request()->routeIs('playlist.index')" iconPath="icons/playlist.svg">
                                {{ __('Playlist') }}
                            </x-nav-link>
                        </div>
                    </div>

                    <div class="space-y-8">
                        <x-nav-link :href="route('users.index')" :active="request()->routeIs('users.index')" iconPath="icons/users.svg">
                            {{ __('Users') }}
                        </x-nav-link>
                    </div>
                @endrole
            </div>
        </div>
    </div>
</nav>
