<nav x-data="{ open: false }" class="bg-white border-r border-gray-100 h-screen fixed w-64">
    <!-- Primary Navigation Menu -->
    <div class="px-4 sm:px-6 lg:px-8">
        <div class="flex flex-col h-full">
            <div class="flex flex-col">
                <!-- Logo -->
                <div class="shrink-0 flex items-center mt-5 mb-10">
                    <a href="{{ route('dashboard') }}">
                        {{ __('Bibla.al') }}
                    </a>
                </div>

                <!-- Navigation Links -->
                <div class="space-y-8">
                    <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                        {{ __('Dashboard') }}
                    </x-nav-link>
                </div>
                @role(['admin','teacher'])
                <div class="space-y-8">
                    <x-nav-link :href="route('classroom.index')" :active="request()->routeIs('classroom.index')">
                        {{ __('Class Room') }}
                    </x-nav-link>
                </div>

                <div class="space-y-8">
                    <x-nav-link :href="route('books.index')" :active="request()->routeIs('books.index')">
                        {{ __('Books') }}
                    </x-nav-link>
                </div>
                <div class="space-y-8">
                    <x-nav-link :href="route('categories.index')" :active="request()->routeIs('categories.index')">
                        {{ __('Category') }}
                    </x-nav-link>
                </div>
                <div class="space-y-8">
                    <x-nav-link :href="route('groups.index')" :active="request()->routeIs('groups.index')">
                        {{ __('Groups') }}
                    </x-nav-link>
                </div>
                <div class="space-y-8">
                    <x-nav-link :href="route('topics.index')" :active="request()->routeIs('topics.index')">
                        {{ __('Topics') }}
                    </x-nav-link>
                </div>
                <div class="space-y-8">
                    <x-nav-link :href="route('section.index')" :active="request()->routeIs('section.index')">
                        {{ __('Sections') }}
                    </x-nav-link>
                </div>
                @endrole
            </div>

        </div>
    </div>
</nav>
