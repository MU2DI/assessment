@extends('layouts.app')

@section('title', 'Admin Dashboard')

@section('content')
<div class="grid grid-cols-1 md:grid-cols-3 gap-6">
    <!-- Schools Card -->
    <div class="bg-white rounded-lg shadow p-6">
        <div class="flex items-center">
            <div class="p-3 bg-blue-100 rounded-full">
                <i class="fas fa-school text-blue-600 text-xl"></i>
            </div>
            <div class="ml-4">
                <h3 class="text-sm font-medium text-gray-600">Total Schools</h3>
                <p class="text-2xl font-bold text-gray-900">{{ $stats['total_schools'] }}</p>
            </div>
        </div>
        <a href="{{ route('admin.schools.index') }}" class="block mt-4 text-blue-600 hover:text-blue-800 text-sm">
            Manage schools →
        </a>
    </div>

    <!-- Users Card -->
    <div class="bg-white rounded-lg shadow p-6">
        <div class="flex items-center">
            <div class="p-3 bg-green-100 rounded-full">
                <i class="fas fa-users text-green-600 text-xl"></i>
            </div>
            <div class="ml-4">
                <h3 class="text-sm font-medium text-gray-600">Total Users</h3>
                <p class="text-2xl font-bold text-gray-900">{{ $stats['total_users'] }}</p>
            </div>
        </div>
        <a href="{{ route('admin.users.index') }}" class="block mt-4 text-green-600 hover:text-green-800 text-sm">
            Manage users →
        </a>
    </div>

    <!-- Active Schools Card -->
    <div class="bg-white rounded-lg shadow p-6">
        <div class="flex items-center">
            <div class="p-3 bg-purple-100 rounded-full">
                <i class="fas fa-check-circle text-purple-600 text-xl"></i>
            </div>
            <div class="ml-4">
                <h3 class="text-sm font-medium text-gray-600">Active Schools</h3>
                <p class="text-2xl font-bold text-gray-900">{{ $stats['active_schools'] }}</p>
            </div>
        </div>
        <span class="block mt-4 text-sm text-gray-500">Currently active</span>
    </div>
</div>

<!-- Quick Actions -->
<div class="mt-8 bg-white rounded-lg shadow">
    <div class="px-6 py-4 border-b border-gray-200">
        <h3 class="text-lg font-medium text-gray-900">Quick Actions</h3>
    </div>
    <div class="p-6 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
        <a href="{{ route('admin.schools.create') }}" class="flex flex-col items-center p-4 border border-gray-200 rounded-lg hover:bg-gray-50 transition">
            <i class="fas fa-plus-circle text-blue-600 text-2xl mb-2"></i>
            <span class="text-sm font-medium text-gray-700">Add School</span>
        </a>
        
        <a href="{{ route('admin.users.create') }}" class="flex flex-col items-center p-4 border border-gray-200 rounded-lg hover:bg-gray-50 transition">
            <i class="fas fa-user-plus text-green-600 text-2xl mb-2"></i>
            <span class="text-sm font-medium text-gray-700">Add User</span>
        </a>
        
        <a href="{{ route('reports.school-performance') }}" class="flex flex-col items-center p-4 border border-gray-200 rounded-lg hover:bg-gray-50 transition">
            <i class="fas fa-chart-line text-purple-600 text-2xl mb-2"></i>
            <span class="text-sm font-medium text-gray-700">Performance Reports</span>
        </a>
        
        <a href="{{ route('reports.rankings') }}" class="flex flex-col items-center p-4 border border-gray-200 rounded-lg hover:bg-gray-50 transition">
            <i class="fas fa-trophy text-orange-600 text-2xl mb-2"></i>
            <span class="text-sm font-medium text-gray-700">View Rankings</span>
        </a>
    </div>
</div>
@endsection