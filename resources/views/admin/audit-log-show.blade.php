@extends('layouts.app')

@section('title', 'Audit Log Detail')

@section('content')
<div class="p-6 max-w-4xl mx-auto">
    <nav class="mb-4 text-sm text-gray-500">
        <a href="{{ route('admin.audit-logs.index') }}" class="hover:text-gray-700">Audit Logs</a> 
        <span class="mx-2">&rarr;</span> 
        <span>Log #{{ $auditLog->id }}</span>
    </nav>

    <div class="bg-white shadow rounded-lg overflow-hidden">
        <div class="px-6 py-4 border-b flex justify-between items-center">
            <h1 class="text-xl font-semibold text-gray-800">Audit Entry: {{ ucfirst(str_replace('_', ' ', $auditLog->action)) }}</h1>
            <span class="text-xs text-gray-500">{{ $auditLog->created_at->format('M d, Y H:i:s') }}</span>
        </div>
        
        <div class="p-6 grid grid-cols-1 md:grid-cols-3 gap-6">
            <div class="md:col-span-2">
                <label class="block text-xs font-medium text-gray-400 uppercase tracking-wider">Changes</label>
                <div class="mt-2 overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200 text-sm">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-4 py-2 text-left font-medium text-gray-500">Field</th>
                                <th class="px-4 py-2 text-left font-medium text-gray-500">Before</th>
                                <th class="px-4 py-2 text-left font-medium text-gray-500">After</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            @php
                                $before = $auditLog->changes['before'] ?? [];
                                $after = $auditLog->changes['after'] ?? [];
                                $allFields = array_unique(array_merge(array_keys($before), array_keys($after)));
                            @endphp
                            @foreach($allFields as $field)
                                <tr>
                                    <td class="px-4 py-2 font-medium text-gray-700">{{ ucfirst($field) }}</td>
                                    <td class="px-4 py-2 text-gray-600">{{ $before[$field] ?? 'N/A' }}</td>
                                    <td class="px-4 py-2 text-gray-800 font-semibold">{{ $after[$field] ?? 'N/A' }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            
            <div class="bg-gray-50 p-4 rounded-lg space-y-4">
                <div class="mb-4">
                    <label class="block text-xs font-medium text-gray-400 uppercase tracking-wider">Admin Actor</label>
                    <p class="mt-1 font-medium text-gray-900">{{ $auditLog->admin->name }}</p>
                    <p class="text-xs text-gray-500">{{ $auditLog->admin->email }}</p>
                </div>
                
                <div class="mb-4">
                    <label class="block text-xs font-medium text-gray-400 uppercase tracking-wider">Target Model</label>
                    <p class="mt-1 text-sm text-gray-700">{{ $auditLog->model_type }} (ID: {{ $auditLog->model_id }})</p>
                </div>

                <div class="mb-4">
                    <label class="block text-xs font-medium text-gray-400 uppercase tracking-wider">Network Context</label>
                    <p class="mt-1 text-xs text-gray-600 truncate">{{ $auditLog->ip_address }}</p>
                    <p class="mt-1 text-xs text-gray-500 italic">{{ $auditLog->user_agent }}</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection