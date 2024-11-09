<x-app-layout>
    {{-- <x-slot name="header">
        <h1 class="font-semibold text-xl text-gray-800 leading-tight">
            this the user dashboard history bila
        </h1>
    </x-slot> --}}
    <div>
        @livewire('user.queue-history.queue-history')
    </div>
    
</x-app-layout>