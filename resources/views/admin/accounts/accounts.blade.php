<x-app-layout>
    <x-slot  name="header">
        <div>
            <h1 class="font-semibold text-xl text-gray-800 leading-tight">
                Accounts
            </h1>
        </div>
    </x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <x-admin.create-user />
            </div>
        </div>
    </div>
    
</x-app-layout>