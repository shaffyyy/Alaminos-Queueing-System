<x-app-layout>
    <x-slot  name="header">
        <div>
            <h1 class="font-semibold text-xl text-gray-800 leading-tight">
                Queue Request
            </h1>
        </div>
    </x-slot>
    <div class="py-12">
        <div class="">
            <div class="">
                @livewire('admin.queue.queue')
            </div>
        </div>
    </div>
    
</x-app-layout>