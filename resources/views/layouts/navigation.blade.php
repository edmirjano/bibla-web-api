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
                    <x-nav-link :href="route('category.index')" :active="request()->routeIs('category.index')">
                        {{ __('Category') }}
                    </x-nav-link>
                </div>
                <hr>
                <div class="space-y-8">
                    <x-nav-link :href="route('book.index')" :active="request()->routeIs('book.index')">
                        {{ __('Books') }}
                    </x-nav-link>
                </div>
                <hr>
                <div class="space-y-8">
                    <x-nav-link :href="route('users.index')" :active="request()->routeIs('users.index')">
                        {{ __('Users') }}
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

                <hr>
                @endrole
            </div>

        </div>
    </div>
</nav>
