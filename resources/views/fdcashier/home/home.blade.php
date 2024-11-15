<x-app-layout>
    <x-slot  name="header">
        <div>
            <h1 class="font-semibold text-xl text-gray-800 leading-tight">
                Dashboard
            </h1>
        </div>
    </x-slot>
    <div class="py-12">
        <div class="">
            <div class="">
                @livewire('admin.home.home')
            </div>
        </div>
    </div>
    
</x-app-layout>