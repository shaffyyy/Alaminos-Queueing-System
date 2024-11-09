@extends('layouts.admin')

@section('content')
    <div class="container mx-auto">
        <h1 class="text-2xl font-bold mb-4">Services List</h1>

        <!-- Success Message -->
        @if (session('success'))
            <div class="bg-green-100 text-green-800 p-3 rounded-md mb-4">
                {{ session('success') }}
            </div>
        @endif

        <a href="{{ route('admin-add-services') }}" class="bg-blue-500 text-white px-4 py-2 rounded-md mb-4">Add New Service</a>

        <table class="min-w-full bg-white border">
            <thead>
                <tr>
                    <th class="py-2 px-4 border">Name</th>
                    <th class="py-2 px-4 border">Description</th>
                    <th class="py-2 px-4 border">Status</th>
                    <th class="py-2 px-4 border">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($services as $service)
                    <tr>
                        <td class="py-2 px-4 border">{{ $service->name }}</td>
                        <td class="py-2 px-4 border">{{ $service->description }}</td>
                        <td class="py-2 px-4 border">
                            {{ $service->status ? 'Active' : 'Inactive' }}
                        </td>
                        <td class="py-2 px-4 border">
                            <a href="{{ route('admin-edit-service', $service->id) }}" class="text-blue-500">Edit</a> |
                            <form action="{{ route('admin-delete-service', $service->id) }}" method="POST" class="inline-block">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-500">Delete</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
