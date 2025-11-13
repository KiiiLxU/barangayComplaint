<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 text-gray-900">
                <h1 class="text-2xl font-bold mb-4">Welcome, {{ Auth::user()->name }}!</h1>

                <p class="mb-4">You're logged in to the Barangay Poblacion Complaint System.</p>

                <!-- Profile Information Section -->
                <div class="mb-6 p-4 bg-gray-50 rounded-lg">
                    <h3 class="text-lg font-semibold mb-2">Your Profile Information</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <strong>Email:</strong> {{ Auth::user()->email }}
                        </div>
                        <div>
                            <strong>Contact Number:</strong> {{ Auth::user()->contact_number }}
                        </div>
                        <div>
                            <strong>Purok:</strong> {{ Auth::user()->purok }}
                        </div>
                    </div>
                    <a href="{{ route('profile.edit') }}"
                       class="inline-block mt-2 bg-indigo-600 text-white px-3 py-1 rounded hover:bg-indigo-700 text-sm">
                       Edit Profile
                    </a>
                </div>

                @if(Auth::user()->role === 'admin')
                    <a href="{{ route('admin.dashboard') }}"
                       class="inline-block bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700 mr-4">
                       Admin Dashboard
                    </a>
                    <a href="{{ route('complaints.index') }}"
                       class="inline-block bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                       Manage Complaints
                    </a>
                @else
                    <a href="{{ route('complaints.index') }}"
                       class="inline-block bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                       Go to Complaint System
                    </a>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
