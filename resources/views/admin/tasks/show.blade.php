@extends('layouts.app')

@section('title', 'Task Detail')

@section('content')
<div class="p-6 max-w-4xl mx-auto">
    <nav class="mb-4 text-sm text-gray-500">
        <a href="{{ route('admin.tasks.index') }}" class="hover:text-gray-700">Admin Tasks</a> 
        <span class="mx-2">&rarr;</span> 
        <span>Task #{{ $task->id }}</span>
    </nav>

    <div class="bg-white shadow rounded-lg overflow-hidden">
        <div class="px-6 py-4 border-b flex justify-between items-center">
            <h1 class="text-xl font-semibold text-gray-800">{{ $task->title }}</h1>
            <span class="px-2 py-1 text-xs font-medium rounded-full {{ $task->status === 'completed' ? 'bg-green-100 text-green-800' : ($task->status === 'in_progress' ? 'bg-blue-100 text-blue-800' : 'bg-gray-100 text-gray-800') }}">
                {{ ucfirst($task->status) }}
            </span>
        </div>
        
        <div class="p-6 grid grid-cols-1 md:grid-cols-3 gap-6">
            <div class="md:col-span-2">
                <label class="block text-xs font-medium text-gray-400 uppercase tracking-wider">Description</label>
                <p class="mt-1 text-gray-700 whitespace-pre-wrap">{{ $task->description ?: 'No description provided.' }}</p>
            </div>
            
            <div class="bg-gray-50 p-4 rounded-lg space-y-4">
                <div>
                    <label class="block text-xs font-medium text-gray-400 uppercase tracking-wider">Assigned User</label>
                    <p class="mt-1 font-medium text-gray-900">{{ $task->user->name }}</p>
                    <p class="text-xs text-gray-500">{{ $task->user->email }}</p>
                </div>
                
                <div>
                    <label class="block text-xs font-medium text-gray-400 uppercase tracking-wider">Created At</label>
                    <p class="mt-1 text-sm text-gray-600">{{ $task->created_at->format('M d, Y H:i') }}</p>
                </div>

                <div class="pt-4 border-t">
                    <div class="flex gap-2">
                        <form action="{{ route('admin.tasks.status', $task) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <input type="hidden" name="status" value="completed">
                            <button type="submit" class="text-xs px-3 py-1 bg-green-600 text-white rounded hover:bg-green-700">Mark Complete</button>
                        </form>
                        <form action="{{ route('admin.tasks.delete', $task) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-xs px-3 py-1 bg-red-600 text-white rounded hover:bg-red-700" onclick="return confirm('Are you sure?')">Delete</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection