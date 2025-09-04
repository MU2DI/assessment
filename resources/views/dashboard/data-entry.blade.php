@extends('layouts.admin')

@section('title', 'Data Entry Dashboard')

@section('content')
<div class="bg-white rounded-lg shadow p-6">
    <div class="text-center py-8">
        <i class="fas fa-clipboard-check text-blue-400 text-6xl mb-4"></i>
        <h2 class="text-2xl font-semibold text-gray-700 mb-2">Data Entry Dashboard</h2>
        <p class="text-gray-600 mb-6">Welcome to the marks entry system</p>
        
        <div class="bg-blue-50 rounded-lg p-6 max-w-md mx-auto">
            <div class="flex items-center justify-center mb-4">
                <i class="fas fa-tasks text-blue-600 text-3xl"></i>
            </div>
            <h3 class="text-lg font-medium text-blue-900 mb-2">Pending Tasks</h3>
            <p class="text-3xl font-bold text-blue-600">{{ $pending_marks }} marks to enter</p>
            <a href="{{ route('data.marks.create') }}" class="mt-4 inline-block bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700 transition">
                Enter Marks Now
            </a>
        </div>
    </div>
</div>

<!-- Recent Activity -->
<div class="mt-8 bg-white rounded-lg shadow">
    <div class="px-6 py-4 border-b border-gray-200">
        <h3 class="text-lg font-medium text-gray-900">Quick Access</h3>
    </div>
    <div class="p-6 grid grid-cols-1 md:grid-cols-2 gap-4">
        <a href="{{ route('data.marks.create') }}" class="flex items-center p-4 border border-gray-200 rounded-lg hover:bg-gray-50 transition">
            <i class="fas fa-pen-alt text-green-600 text-2xl mr-4"></i>
            <div>
                <h4 class="font-medium text-gray-900">Enter New Marks</h4>
                <p class="text-sm text-gray-500">Add examination results</p>
            </div>
        </a>
        
        <a href="{{ route('data.marks.index') }}" class="flex items-center p-4 border border-gray-200 rounded-lg hover:bg-gray-50 transition">
            <i class="fas fa-list text-blue-600 text-2xl mr-4"></i>
            <div>
                <h4 class="font-medium text-gray-900">View Entered Marks</h4>
                <p class="text-sm text-gray-500">Review previous entries</p>
            </div>
        </a>
    </div>
</div>
@endsection