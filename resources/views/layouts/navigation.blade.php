<nav x-data="{ open: false }" class="bg-white border-r border-gray-100 h-screen fixed w-64">
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
                @role(['admin','teacher'])
                <div class="space-y-8">
                    <x-nav-link :href="route('classroom.index')" :active="request()->routeIs('classroom.index')" iconPath="icons/classroom.svg">
                        {{ __('Class Room') }}
                    </x-nav-link>
                </div>
                <div class="space-y-8">
                    <x-nav-link :href="route('category.index')" :active="request()->routeIs('category.index')" iconPath="icons/category.svg">
                        {{ __('Category') }}
                    </x-nav-link>
                </div>

                <div class="space-y-8">
                    <x-nav-link :href="route('book.index')" :active="request()->routeIs('book.index')" iconPath="icons/books.svg">
                        {{ __('Books') }}
                    </x-nav-link>
                </div>

                <div class="space-y-8">
                    <x-nav-link :href="route('song.index')" :active="request()->routeIs('song.index')" iconPath="icons/songs.svg">
                        {{ __('Songs') }}
                    </x-nav-link>
                </div>
                <div class="space-y-8">
                    <x-nav-link :href="route('author.index')" :active="request()->routeIs('author.index')" iconPath="icons/artist.svg">
                        {{ __('Authors') }}
                    </x-nav-link>
                </div>
                <div class="space-y-8">
                    <x-nav-link :href="route('playlist.index')" :active="request()->routeIs('playlist.index')" iconPath="icons/playlist.svg">
                        {{ __('Playlist') }}
                    </x-nav-link>
                </div>
{{--                <div class="space-y-8">--}}
{{--                    <x-nav-link :href="route('group.index')" :active="request()->routeIs('group.index')">--}}
{{--                        {{ __('Groups') }}--}}
{{--                    </x-nav-link>--}}
{{--                </div>--}}
{{--                <div class="space-y-8">--}}
{{--                    <x-nav-link :href="route('topic.index')" :active="request()->routeIs('topic.index')">--}}
{{--                        {{ __('Topics') }}--}}
{{--                    </x-nav-link>--}}
{{--                </div>--}}
{{--                <div class="space-y-8">--}}
{{--                    <x-nav-link :href="route('section.index')" :active="request()->routeIs('section.index')">--}}
{{--                        {{ __('Sections') }}--}}
{{--                    </x-nav-link>--}}
{{--                </div>--}}
{{--                <div class="space-y-8">--}}
{{--                    <x-nav-link :href="route('question.index')" :active="request()->routeIs('question.index')">--}}
{{--                        {{ __('Questions') }}--}}
{{--                    </x-nav-link>--}}
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
