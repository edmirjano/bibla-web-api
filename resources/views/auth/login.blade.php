<x-guest-layout>
    <x-auth-session-status class="mb-4" :status="session('status')" />

    @if (session('error'))
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
            <span class="block sm:inline">{{ session('error') }}</span>
        </div>
    @endif

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <!-- Email Address -->
        <div>
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required
                autofocus autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('Password')" />

            <x-text-input id="password" class="block mt-1 w-full" type="password" name="password" required
                autocomplete="current-password" />

            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Remember Me -->
        <div class="block mt-4">
            <label for="remember_me" class="inline-flex items-center">
                <input id="remember_me" type="checkbox"
                    class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500" name="remember">
                <span class="ms-2 text-sm text-gray-600">{{ __('Remember me') }}</span>
            </label>
        </div>


        <div class="flex items-center justify-between mt-4">
            @if (Route::has('password.request'))
                <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                    href="{{ route('password.request') }}">
                    {{ __('Forgot your password?') }}
                </a>
            @endif

            <x-primary-button class="ms-3">
                {{ __('Log in') }}
            </x-primary-button>
        </div>
    </form>
    <a href="{{ route('google.redirect') }}"
       class="flex items-center justify-center px-3 py-3 mt-8 text-white bg-blue-600 hover:bg-blue-700 rounded-lg shadow-md transition duration-300">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 48 48">
            <path fill="#EA4335" d="M24 9.5c3.67 0 6.99 1.36 9.61 3.59l7.19-7.19C36.1 2.5 30.4 0 24 0 14.62 0 6.4 5.62 2.61 13.88l8.57 6.69C13.22 14.68 18.19 9.5 24 9.5z"/>
            <path fill="#34A853" d="M46.3 24.5c0-1.34-.12-2.64-.34-3.91H24v7.39h12.6c-.54 2.91-2.13 5.4-4.5 7.04v5.79h7.29C43.35 36.62 46.3 30.94 46.3 24.5z"/>
            <path fill="#4A90E2" d="M12.9 25.99C12.34 24.51 12 22.81 12 21c0-1.81.34-3.51.89-5.01l-8.57-6.7C2.64 14.62 0 21.5 0 24c0 6.62 3.46 12.41 8.61 15.77l7.29-5.79C13.88 31.4 12.9 28.81 12.9 25.99z"/>
            <path fill="#FBBC05" d="M24 48c6.39 0 11.8-2.5 15.59-6.64l-7.29-5.79C30.4 37.8 27.15 39 24 39c-5.8 0-10.76-4.18-12.63-9.82l-7.3 5.79C6.4 42.4 14.61 48 24 48z"/>
        </svg>
        <span>Login with Google</span>
    </a>

</x-guest-layout>
