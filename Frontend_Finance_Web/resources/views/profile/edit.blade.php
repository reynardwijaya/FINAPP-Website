@extends('layouts.app')

@section('title', 'Edit Profile - Finapp')

@section('header', 'Edit Profile')

@section('content')
<div class="max-w-2xl mx-auto">
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-lg p-6">
        <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-6">Profile Information</h2>
        
        <div>
            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Profile Picture</label>
            <div class="flex items-center space-x-4 mb-4">
                <img class="h-24 w-24 rounded-full object-cover" src="{{ auth()->user()->profile_photo_url ?? asset('images/default_profile.png') }}" alt="{{ auth()->user()->username }}" />
                <form action="{{ route('profile.updateProfilePicture') }}" method="POST" enctype="multipart/form-data" class="flex flex-col space-y-2">
                    @csrf
                    <label for="profile_picture" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Upload New Picture</label>
                    <input type="file" name="profile_picture" id="profile_picture" class="block w-full text-sm text-gray-900 dark:text-gray-200 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100 dark:file:bg-blue-900 dark:file:text-blue-300 dark:hover:file:bg-blue-800 cursor-pointer">
                    @error('profile_picture')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                    <div class="flex space-x-2 mt-2">
                        <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">Update Profile Picture</button>
                        @if(auth()->user()->profile_picture)
                            <form id="delete-profile-picture-form" action="{{ route('profile.updateProfilePicture') }}" method="POST" style="display: inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="px-4 py-2 bg-red-600 text-white rounded-md hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2">Delete Picture</button>
                            </form>
                        @endif
                    </div>
                </form>
            </div>
        </div>
        
        <form method="POST" action="{{ route('profile.update') }}" class="space-y-6">
            @csrf
            @method('PUT')
            
            <div>
                <label for="username" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Username</label>
                <input type="text" 
                       name="username" 
                       id="username" 
                       value="{{ auth()->user()->username }}" 
                       class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:text-white"
                       required>
                @error('username')
                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                @enderror
            </div>
            
            <div>
                <label for="email" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Email</label>
                <input type="email" 
                       name="email" 
                       id="email" 
                       value="{{ auth()->user()->email }}" 
                       class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:text-white"
                       required>
                @error('email')
                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                @enderror
            </div>
            
            <div class="flex items-center justify-end space-x-4 mt-8">
                <a href="{{ route('dashboard') }}" 
                   class="px-4 py-2 text-gray-700 dark:text-gray-300 bg-gray-200 dark:bg-gray-700 rounded-md hover:bg-gray-300 dark:hover:bg-gray-600 transition-colors">
                    Cancel
                </a>
                <button type="submit" 
                        class="px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-colors">
                    Update Profile
                </button>
            </div>
        </form>
    </div>
</div>
@endsection 