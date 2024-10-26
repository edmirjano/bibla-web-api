<x-app-layout>
    <x-slot name="header">

    </x-slot>

    <div class="p-4">
        <div class=" mx-auto ">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h4>Welcome, {{auth()->user()->name}}! </h4>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>