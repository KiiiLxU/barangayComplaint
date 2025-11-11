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
