<x-app-layout>

    <div class="py-12 w-full h-full">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <div class="p-6 sm:px-20 bg-white border-b border-gray-200">
                    <form action="{{ isset($user->exists) ? route('users.update', $user->id) : route('users.store') }}" method="POST">
                        @csrf
                        @if(isset($user->exists))
                            @method('PUT')
                        @endif

                        <div class="mt-4">
                            <label for="name" class="uppercase tracking-wide text-black text-xs font-bold mb-2">{{ __('Name') }}</label>
                            <input id="name" class="w-full bg-gray-200 text-black border border-gray-200 rounded py-3 px-4 mb-3" type="text" name="name" value="{{ old('name', $user->name??"") }}" required autofocus />
                            @error('name')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="mt-4">
                            <label for="email" class="uppercase tracking-wide text-black text-xs font-bold mb-2">{{ __('Email') }}</label>
                            <input id="email" class="w-full bg-gray-200 text-black border border-gray-200 rounded py-3 px-4 mb-3" type="email" name="email" value="{{ old('email', $user->email??"") }}" required />
                            @error('email')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="mt-4">
                            <label for="password" class="uppercase tracking-wide text-black text-xs font-bold mb-2">{{ __('Password') }}</label>
                            <input id="password" class="w-full bg-gray-200 text-black border border-gray-200 rounded py-3 px-4 mb-3" type="password" name="password"  {{isset($user->exists) ? '' : 'required' }} autocomplete="new-password" />
                            @error('password')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="mt-4">
                            <label for="password_confirmation" class="uppercase tracking-wide text-black text-xs font-bold mb-2">{{ __('Confirm Password') }}</label>
                            <input id="password_confirmation" class="w-full bg-gray-200 text-black border border-gray-200 rounded py-3 px-4 mb-3" type="password" name="password_confirmation" {{isset($user->exists)? '' : 'required' }} />
                            @error('password_confirmation')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="flex items-center justify-end mt-4">
                            <button type="submit" class="ml-4 inline-flex items-center px-4 py-2 bg-blue-500 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 active:bg-blue-900 focus:outline-none focus:border-blue-900 focus:ring ring-gray-300 disabled:opacity-25 transition ease-in-out duration-150">
                                {{ isset($user->exists) ? __('Update') : __('Create') }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
