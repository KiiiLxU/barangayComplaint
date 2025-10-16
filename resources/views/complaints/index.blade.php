<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Complaints') }}
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h3 class="text-lg font-semibold mb-4">Your Complaints</h3>

                    <a href="{{ route('complaints.create') }}" 
                       class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 mb-4 inline-block">
                        + New Complaint
                    </a>

                    @if($complaints->isEmpty())
                        <p>No complaints submitted yet.</p>
                    @else
                        <table class="min-w-full border border-gray-300">
                            <thead>
                                <tr class="bg-gray-100">
                                    <th class="px-4 py-2 border">Category</th>
                                    <th class="px-4 py-2 border">Details</th>
                                    <th class="px-4 py-2 border">Status</th>
                                    <th class="px-4 py-2 border">Date</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($complaints as $complaint)
                                    <tr>
                                        <td class="px-4 py-2 border">{{ $complaint->category }}</td>
                                        <td class="px-4 py-2 border">{{ $complaint->details }}</td>
                                        <td class="px-4 py-2 border">{{ $complaint->status }}</td>
                                        <td class="px-4 py-2 border">{{ $complaint->created_at->format('Y-m-d') }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
