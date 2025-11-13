<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-3xl bg-gradient-to-r from-primary-600 to-secondary-600 bg-clip-text text-transparent leading-tight animate-fade-in">
            {{ __('Dashlboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-8">
            <!-- Welcome Card -->
            <div class="bg-white/80 backdrop-blur-sm overflow-hidden shadow-xl sm:rounded-2xl p-8 text-gray-900 border border-white/20 animate-scale-in">
                <div class="flex items-center space-x-4 mb-6">
                    <div class="w-16 h-16 bg-gradient-to-r from-primary-500 to-secondary-500 rounded-full flex items-center justify-center animate-pulse-slow">
                        <svg class="w-8 h-8 text-white" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"></path>
                        </svg>
                    </div>
                    <div>
                        <h1 class="text-3xl font-bold bg-gradient-to-r from-primary-600 to-secondary-600 bg-clip-text text-transparent">Welcome, {{ Auth::user()->name }}!</h1>
                        <p class="text-gray-600 text-lg">You're logged in to the Barangay Complaint System</p>
                    </div>
                </div>

                <!-- Profile Information Section -->
                <div class="mb-8 p-6 bg-gradient-to-r from-primary-50 to-secondary-50 rounded-xl border border-primary-100 animate-slide-in">
                    <h3 class="text-xl font-semibold mb-4 text-primary-800 flex items-center">
                        <svg class="w-6 h-6 mr-2" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-6-3a2 2 0 11-4 0 2 2 0 014 0zm-2 4a5 5 0 00-4.546 2.916A5.986 5.986 0 0010 16a5.986 5.986 0 004.546-2.084A5 5 0 0010 11z" clip-rule="evenodd"></path>
                        </svg>
                        Your Profile Information
                    </h3>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <div class="bg-white p-4 rounded-lg shadow-sm border border-primary-100">
                            <div class="text-sm text-gray-500 mb-1">Email</div>
                            <div class="font-semibold text-primary-800">{{ Auth::user()->email }}</div>
                        </div>
                        <div class="bg-white p-4 rounded-lg shadow-sm border border-primary-100">
                            <div class="text-sm text-gray-500 mb-1">Contact Number</div>
                            <div class="font-semibold text-primary-800">{{ Auth::user()->contact_number ?: 'Not set' }}</div>
                        </div>
                        <div class="bg-white p-4 rounded-lg shadow-sm border border-primary-100">
                            <div class="text-sm text-gray-500 mb-1">Purok</div>
                            <div class="font-semibold text-primary-800">{{ Auth::user()->purok ?: 'Not set' }}</div>
                        </div>
                    </div>
                    <div class="mt-4">
                        <x-secondary-button href="{{ route('profile.edit') }}" class="animate-scale-in">
                            <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z"></path>
                            </svg>
                            Edit Profile
                        </x-secondary-button>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="flex flex-wrap gap-4 animate-fade-in">
                    @if(Auth::user()->role === 'admin')
                        <x-primary-button href="{{ route('admin.dashboard') }}" class="animate-scale-in">
                            <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M3 4a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm0 4a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm0 4a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1z" clip-rule="evenodd"></path>
                            </svg>
                            Admin Dashboard
                        </x-primary-button>
                        <x-secondary-button href="{{ route('complaints.index') }}" class="animate-scale-in">
                            <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path>
                            </svg>
                            Manage Complaints
                        </x-secondary-button>
                    @else
                        <x-primary-button href="{{ route('complaints.index') }}" class="animate-scale-in">
                            <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" clip-rule="evenodd"></path>
                            </svg>
                            Go to Complaint System
                        </x-primary-button>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
