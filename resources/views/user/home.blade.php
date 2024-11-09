<x-app-layout>
    {{-- <x-slot name="header">
        <h1 class="font-semibold text-xl text-gray-800 leading-tight">
            this the user dashboard
        </h1>
    </x-slot> --}}

    <div>
        <div class="">
            <div class="bg-white overflow-hidden ">
                @livewire('user.home.home')
            </div>
        </div>
    </div>
    
</x-app-layout>
