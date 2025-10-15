@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-4xl mx-auto">
        <h1 class="text-2xl font-bold text-gray-900 dark:text-white mb-8">Settings</h1>

        @if(session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                <span class="block sm:inline">{{ session('success') }}</span>
            </div>
        @endif

        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-lg overflow-hidden">
            <!-- Settings Navigation -->
            <div class="border-b border-gray-200 dark:border-gray-700">
                <nav class="flex -mb-px" aria-label="Settings Navigation">
                    <button class="settings-tab active px-6 py-4 text-sm font-medium text-blue-600 dark:text-blue-400 border-b-2 border-blue-600 dark:border-blue-400" data-tab="profile">
                        Profile
                    </button>
                    <button class="settings-tab px-6 py-4 text-sm font-medium text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-300 border-b-2 border-transparent" data-tab="preferences">
                        Preferences
                    </button>
                    <button class="settings-tab px-6 py-4 text-sm font-medium text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-300 border-b-2 border-transparent" data-tab="security">
                        Security
                    </button>
                    <button class="settings-tab px-6 py-4 text-sm font-medium text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-300 border-b-2 border-transparent" data-tab="notifications">
                        Notifications
                    </button>
                    <button class="settings-tab px-6 py-4 text-sm font-medium text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-300 border-b-2 border-transparent" data-tab="categories">
                        Categories
                    </button>
                </nav>
            </div>

            <!-- Profile Settings -->
            <div class="settings-content active p-6" id="profile">
                <form action="{{ route('settings.updateProfile') }}" method="POST" class="space-y-6">
                    @csrf
                    @method('PUT')

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="username" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Username</label>
                            <input type="text" name="username" id="username" value="{{ old('username', $user->username) }}" 
                                class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-white shadow-sm focus:border-blue-500 focus:ring-blue-500">
                            @error('username')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="email" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Email</label>
                            <input type="email" name="email" id="email" value="{{ old('email', $user->email) }}"
                                class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-white shadow-sm focus:border-blue-500 focus:ring-blue-500">
                            @error('email')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="currency" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Currency</label>
                            <select name="currency" id="currency" 
                                class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-white shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                <option value="USD" {{ old('currency', $user->currency) == 'USD' ? 'selected' : '' }}>USD ($)</option>
                                <option value="EUR" {{ old('currency', $user->currency) == 'EUR' ? 'selected' : '' }}>EUR (€)</option>
                                <option value="GBP" {{ old('currency', $user->currency) == 'GBP' ? 'selected' : '' }}>GBP (£)</option>
                                <option value="IDR" {{ old('currency', $user->currency) == 'IDR' ? 'selected' : '' }}>IDR (Rp)</option>
                            </select>
                            @error('currency')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="language" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Language</label>
                            <select name="language" id="language"
                                class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-white shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                <option value="en" {{ old('language', $user->language) == 'en' ? 'selected' : '' }}>English</option>
                                <option value="id" {{ old('language', $user->language) == 'id' ? 'selected' : '' }}>Bahasa Indonesia</option>
                            </select>
                            @error('language')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="timezone" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Timezone</label>
                            <select name="timezone" id="timezone"
                                class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-white shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                <option value="UTC" {{ old('timezone', $user->timezone) == 'UTC' ? 'selected' : '' }}>UTC</option>
                                <option value="Asia/Jakarta" {{ old('timezone', $user->timezone) == 'Asia/Jakarta' ? 'selected' : '' }}>Asia/Jakarta (WIB)</option>
                                <option value="Asia/Makassar" {{ old('timezone', $user->timezone) == 'Asia/Makassar' ? 'selected' : '' }}>Asia/Makassar (WITA)</option>
                                <option value="Asia/Jayapura" {{ old('timezone', $user->timezone) == 'Asia/Jayapura' ? 'selected' : '' }}>Asia/Jayapura (WIT)</option>
                            </select>
                            @error('timezone')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="date_format" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Date Format</label>
                            <select name="date_format" id="date_format"
                                class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-white shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                <option value="Y-m-d" {{ old('date_format', $user->date_format) == 'Y-m-d' ? 'selected' : '' }}>YYYY-MM-DD</option>
                                <option value="d/m/Y" {{ old('date_format', $user->date_format) == 'd/m/Y' ? 'selected' : '' }}>DD/MM/YYYY</option>
                                <option value="m/d/Y" {{ old('date_format', $user->date_format) == 'm/d/Y' ? 'selected' : '' }}>MM/DD/YYYY</option>
                            </select>
                            @error('date_format')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div class="flex justify-end">
                        <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                            Save Profile Settings
                        </button>
                    </div>
                </form>

                <!-- Change Password Form -->
                <div class="mt-8 pt-8 border-t border-gray-200 dark:border-gray-700">
                    <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-4">Change Password</h3>
                    <form action="{{ route('settings.updatePassword') }}" method="POST" class="space-y-6">
                        @csrf
                        @method('PUT')

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label for="current_password" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Current Password</label>
                                <input type="password" name="current_password" id="current_password" required
                                    class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-white shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                @error('current_password')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="password" class="block text-sm font-medium text-gray-700 dark:text-gray-300">New Password</label>
                                <input type="password" name="password" id="password" required
                                    class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-white shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                @error('password')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="password_confirmation" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Confirm New Password</label>
                                <input type="password" name="password_confirmation" id="password_confirmation" required
                                    class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-white shadow-sm focus:border-blue-500 focus:ring-blue-500">
                            </div>
                        </div>

                        <div class="flex justify-end">
                            <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                                Update Password
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Preferences Settings -->
            <div class="settings-content hidden p-6" id="preferences">
                <form action="{{ route('settings.updatePreferences') }}" method="POST" class="space-y-6">
                    @csrf
                    @method('PUT')

                    <div class="space-y-4">
                        <div>
                            <label for="theme" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Theme</label>
                            <select name="theme" id="theme"
                                class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-white shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                <option value="light" {{ old('theme', $user->preferences->theme ?? 'system') == 'light' ? 'selected' : '' }}>Light</option>
                                <option value="dark" {{ old('theme', $user->preferences->theme ?? 'system') == 'dark' ? 'selected' : '' }}>Dark</option>
                                <option value="system" {{ old('theme', $user->preferences->theme ?? 'system') == 'system' ? 'selected' : '' }}>System</option>
                            </select>
                        </div>

                        <div>
                            <label for="default_view" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Default View</label>
                            <select name="default_view" id="default_view"
                                class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-white shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                <option value="dashboard" {{ old('default_view', $user->preferences->default_view ?? 'dashboard') == 'dashboard' ? 'selected' : '' }}>Dashboard</option>
                                <option value="transactions" {{ old('default_view', $user->preferences->default_view ?? 'dashboard') == 'transactions' ? 'selected' : '' }}>Transactions</option>
                                <option value="reports" {{ old('default_view', $user->preferences->default_view ?? 'dashboard') == 'reports' ? 'selected' : '' }}>Reports</option>
                            </select>
                        </div>

                        <div class="space-y-4">
                            <div class="flex items-center">
                                <input type="checkbox" name="transaction_reminders" id="transaction_reminders" value="1"
                                    {{ old('transaction_reminders', $user->preferences->transaction_reminders ?? false) ? 'checked' : '' }}
                                    class="h-4 w-4 rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                                <label for="transaction_reminders" class="ml-2 block text-sm text-gray-700 dark:text-gray-300">
                                    Enable Transaction Reminders
                                </label>
                            </div>

                            <div class="flex items-center">
                                <input type="checkbox" name="monthly_report" id="monthly_report" value="1"
                                    {{ old('monthly_report', $user->preferences->monthly_report ?? false) ? 'checked' : '' }}
                                    class="h-4 w-4 rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                                <label for="monthly_report" class="ml-2 block text-sm text-gray-700 dark:text-gray-300">
                                    Receive Monthly Financial Reports
                                </label>
                            </div>
                        </div>
                    </div>

                    <div class="flex justify-end">
                        <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                            Save Preferences
                        </button>
                    </div>
                </form>
            </div>

            <!-- Security Settings -->
            <div class="settings-content hidden p-6" id="security">
                <form action="{{ route('settings.updateSecurity') }}" method="POST" class="space-y-6">
                    @csrf
                    @method('PUT')

                    <div class="space-y-4">
                        <div class="flex items-center">
                            <input type="checkbox" name="two_factor_enabled" id="two_factor_enabled" value="1"
                                {{ old('two_factor_enabled', $user->security_settings->two_factor_enabled ?? false) ? 'checked' : '' }}
                                class="h-4 w-4 rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                            <label for="two_factor_enabled" class="ml-2 block text-sm text-gray-700 dark:text-gray-300">
                                Enable Two-Factor Authentication
                            </label>
                        </div>

                        <div class="flex items-center">
                            <input type="checkbox" name="login_notifications" id="login_notifications" value="1"
                                {{ old('login_notifications', $user->security_settings->login_notifications ?? false) ? 'checked' : '' }}
                                class="h-4 w-4 rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                            <label for="login_notifications" class="ml-2 block text-sm text-gray-700 dark:text-gray-300">
                                Receive Login Notifications
                            </label>
                        </div>

                        <div>
                            <label for="session_timeout" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Session Timeout (minutes)</label>
                            <input type="number" name="session_timeout" id="session_timeout" 
                                value="{{ old('session_timeout', $user->security_settings->session_timeout ?? 30) }}"
                                min="5" max="120"
                                class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-white shadow-sm focus:border-blue-500 focus:ring-blue-500">
                        </div>
                    </div>

                    <div class="flex justify-end">
                        <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                            Save Security Settings
                        </button>
                    </div>
                </form>
            </div>

            <!-- Notification Settings -->
            <div class="settings-content hidden p-6" id="notifications">
                <form action="{{ route('settings.updatePreferences') }}" method="POST" class="space-y-6">
                    @csrf
                    @method('PUT')

                    <div class="space-y-4">
                        <div class="flex items-center">
                            <input type="checkbox" name="notifications" id="notifications" value="1"
                                {{ old('notifications', $user->preferences->notifications ?? true) ? 'checked' : '' }}
                                class="h-4 w-4 rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                            <label for="notifications" class="ml-2 block text-sm text-gray-700 dark:text-gray-300">
                                Enable Browser Notifications
                            </label>
                        </div>

                        <div class="flex items-center">
                            <input type="checkbox" name="email_notifications" id="email_notifications" value="1"
                                {{ old('email_notifications', $user->preferences->email_notifications ?? true) ? 'checked' : '' }}
                                class="h-4 w-4 rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                            <label for="email_notifications" class="ml-2 block text-sm text-gray-700 dark:text-gray-300">
                                Enable Email Notifications
                            </label>
                        </div>
                    </div>

                    <div class="flex justify-end">
                        <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                            Save Notification Settings
                        </button>
                    </div>
                </form>
            </div>

            <!-- Categories Settings -->
            <div class="settings-content hidden p-6" id="categories">
                <div class="flex justify-between items-center mb-6">
                    <h3 class="text-lg font-medium text-gray-900 dark:text-white">Manage Transaction Categories</h3>
                    <a href="{{ route('categories.index') }}" class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                        <svg class="h-5 w-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                        </svg>
                        Manage Categories
                    </a>
                </div>

                <div class="bg-gray-50 dark:bg-gray-900 rounded-lg p-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Income Categories -->
                        <div>
                            <h4 class="text-md font-medium text-gray-900 dark:text-white mb-4">Income Categories</h4>
                            <div class="space-y-2">
                                @forelse($user->categories()->where('type', 'income')->get() as $category)
                                    <div class="flex items-center justify-between p-3 bg-white dark:bg-gray-800 rounded-lg shadow">
                                        <div class="flex items-center space-x-3">
                                            <div class="w-8 h-8 rounded-full flex items-center justify-center" style="background-color: {{ $category->color }}">
                                                <i class="{{ $category->icon }} text-white"></i>
                                            </div>
                                            <span class="text-sm font-medium text-gray-900 dark:text-white">{{ $category->name }}</span>
                                            @if($category->is_default)
                                                <span class="px-2 py-1 text-xs font-medium text-blue-800 bg-blue-100 dark:bg-blue-900 dark:text-blue-200 rounded-full">Default</span>
                                            @endif
                                        </div>
                                    </div>
                                @empty
                                    <p class="text-sm text-gray-500 dark:text-gray-400">No income categories found. Add one from the "Manage Categories" page.</p>
                                @endforelse
                            </div>
                        </div>

                        <!-- Expense Categories -->
                        <div>
                            <h4 class="text-md font-medium text-gray-900 dark:text-white mb-4">Expense Categories</h4>
                            <div class="space-y-2">
                                @forelse($user->categories()->where('type', 'expense')->get() as $category)
                                    <div class="flex items-center justify-between p-3 bg-white dark:bg-gray-800 rounded-lg shadow">
                                        <div class="flex items-center space-x-3">
                                            <div class="w-8 h-8 rounded-full flex items-center justify-center" style="background-color: {{ $category->color }}">
                                                <i class="{{ $category->icon }} text-white"></i>
                                            </div>
                                            <span class="text-sm font-medium text-gray-900 dark:text-white">{{ $category->name }}</span>
                                            @if($category->is_default)
                                                <span class="px-2 py-1 text-xs font-medium text-blue-800 bg-blue-100 dark:bg-blue-900 dark:text-blue-200 rounded-full">Default</span>
                                            @endif
                                        </div>
                                    </div>
                                @empty
                                    <p class="text-sm text-gray-500 dark:text-gray-400">No expense categories found. Add one from the "Manage Categories" page.</p>
                                @endforelse
                            </div>
                        </div>
                    </div>

                    <div class="mt-6 text-sm text-gray-500 dark:text-gray-400">
                        <p>• Click "Manage Categories" to add, edit, or delete categories</p>
                        <p>• Default categories cannot be modified or deleted</p>
                        <p>• Categories with existing transactions cannot be deleted</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Tab switching functionality
    const tabs = document.querySelectorAll('.settings-tab');
    const contents = document.querySelectorAll('.settings-content');

    tabs.forEach(tab => {
        tab.addEventListener('click', () => {
            // Remove active class from all tabs and contents
            tabs.forEach(t => t.classList.remove('active', 'text-blue-600', 'border-blue-600', 'dark:text-blue-400', 'dark:border-blue-400'));
            tabs.forEach(t => t.classList.add('text-gray-500', 'dark:text-gray-400'));
            contents.forEach(c => c.classList.add('hidden'));

            // Add active class to clicked tab and corresponding content
            tab.classList.remove('text-gray-500', 'dark:text-gray-400');
            tab.classList.add('active', 'text-blue-600', 'border-blue-600', 'dark:text-blue-400', 'dark:border-blue-400');
            document.getElementById(tab.dataset.tab).classList.remove('hidden');
        });
    });

    // Theme change handler
    const themeSelect = document.getElementById('theme');
    if (themeSelect) {
        themeSelect.addEventListener('change', function() {
            const theme = this.value;
            if (theme === 'system') {
                // Remove both classes and let the system preference take over
                document.documentElement.classList.remove('dark', 'light');
            } else {
                document.documentElement.classList.remove('light', 'dark');
                document.documentElement.classList.add(theme);
            }
            // Dispatch theme change event
            document.dispatchEvent(new Event('themeChanged'));
        });
    }
});
</script>
@endpush

@push('styles')
<style>
.settings-tab.active {
    @apply text-blue-600 dark:text-blue-400 border-blue-600 dark:border-blue-400;
}

.settings-tab:not(.active) {
    @apply text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-300;
}

.settings-content {
    @apply transition-all duration-200 ease-in-out;
}
</style>
@endpush
@endsection 