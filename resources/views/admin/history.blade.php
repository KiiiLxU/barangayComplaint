<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Resolved Complaints History') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="flex justify-between items-center mb-6">
                        <h3 class="text-lg font-semibold">All Resolved Complaints</h3>
                        <a href="{{ route('kapitan.dashboard') }}" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                            Back to Dashboard
                        </a>
                    </div>

                    @if($resolvedComplaints->isEmpty())
                        <p>No resolved complaints yet.</p>
                    @else
                        <div class="overflow-x-auto">
                            <table class="min-w-full border border-gray-300">
                                <thead>
                                    <tr class="bg-gray-100">
                                        <th class="px-4 py-2 border">Category</th>
                                        <th class="px-4 py-2 border">Details</th>
                                        <th class="px-4 py-2 border">Photo</th>
                                        <th class="px-4 py-2 border">User</th>
                                        <th class="px-4 py-2 border">Resolved Date</th>
                                        <th class="px-4 py-2 border">Assigned Admin</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($resolvedComplaints as $complaint)
                                        <tr>
                                            <td class="px-4 py-2 border">{{ $complaint->category }}</td>
                                            <td class="px-4 py-2 border">{{ Str::limit($complaint->details, 50) }}
                                                @if(strlen($complaint->details) > 50)
                                                    <br><button onclick="showFullDetails({{ $complaint->id }})" class="text-blue-600 hover:text-blue-800 text-xs mt-1">See More Details</button>
                                                @endif
                                            </td>
                                            <td class="px-4 py-2 border">
                                                @if($complaint->photo)
                                                    <img src="{{ asset('storage/' . $complaint->photo) }}" alt="Complaint Photo" class="w-20 h-20 object-cover rounded cursor-pointer" onclick="openModal('{{ asset('storage/' . $complaint->photo) }}')">
                                                @else
                                                    No Image
                                                @endif
                                            </td>
                                            <td class="px-4 py-2 border">{{ $complaint->user->name }}</td>
                                            <td class="px-4 py-2 border">{{ $complaint->status_updated_at ? \Carbon\Carbon::parse($complaint->status_updated_at)->format('Y-m-d H:i') : 'N/A' }}</td>
                                            <td class="px-4 py-2 border">{{ $complaint->assignedAdmin ? $complaint->assignedAdmin->name : 'N/A' }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <!-- Pagination -->
                        <div class="mt-4">
                            {{ $resolvedComplaints->links() }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Modal for Image Preview -->
    <div id="imageModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full hidden z-50" onclick="closeModal()">
        <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
            <div class="mt-3 text-center">
                <img id="modalImage" src="" alt="Complaint Photo" class="w-full h-auto max-h-96 object-contain">
                <button onclick="closeModal()" class="mt-4 bg-red-500 text-white px-4 py-2 rounded hover:bg-red-700">Close</button>
            </div>
        </div>
    </div>

    <!-- Modal for Full Details -->
    <div id="detailsModal" class="fixed inset-0 bg-black bg-opacity-50 hidden flex items-center justify-center z-50">
        <div class="relative bg-white rounded-lg max-w-2xl max-h-full p-6 overflow-y-auto">
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-lg font-semibold">Complaint Details</h3>
                <button onclick="closeDetailsModal()" class="text-gray-500 hover:text-gray-700 text-2xl font-bold">&times;</button>
            </div>
            <div id="complaintDetails" class="text-gray-700">
                <!-- Details will be loaded here -->
            </div>
        </div>
    </div>

    <script>
        function openModal(imageSrc) {
            document.getElementById('modalImage').src = imageSrc;
            document.getElementById('imageModal').classList.remove('hidden');
        }

        function closeModal() {
            document.getElementById('imageModal').classList.add('hidden');
        }

        function showFullDetails(complaintId) {
            // Fetch complaint details via AJAX
            fetch(`/admin/complaints/${complaintId}/details`)
                .then(response => response.json())
                .then(data => {
                    document.getElementById('complaintDetails').innerHTML = `
                        <div class="space-y-4">
                            <div><strong>Category:</strong> ${data.category}</div>
                            <div><strong>Reported By:</strong> ${data.reported_by}</div>
                            <div><strong>Purok:</strong> ${data.purok || 'N/A'}</div>
                            <div><strong>Status:</strong> ${data.status}</div>
                            <div><strong>Date:</strong> ${data.date}</div>
                            <div><strong>Details:</strong></div>
                            <textarea class="w-full p-3 border border-gray-300 rounded bg-gray-50" rows="4" readonly>${data.details}</textarea>
                            ${data.photo ? `<div><strong>Photo:</strong><br><img src="${data.photo}" alt="Complaint Photo" class="max-w-full h-auto mt-2 rounded"></div>` : ''}
                        </div>
                    `;
                    document.getElementById('detailsModal').classList.remove('hidden');
                })
                .catch(error => {
                    console.error('Error fetching complaint details:', error);
                    alert('Error loading complaint details. Please try again.');
                });
        }

        function closeDetailsModal() {
            document.getElementById('detailsModal').classList.add('hidden');
        }

        // Close details modal when clicking outside
        document.getElementById('detailsModal').addEventListener('click', function(event) {
            if (event.target === this) {
                closeDetailsModal();
            }
        });

        function toggleDetails(element) {
            const truncatedText = element.querySelector('.truncated-text');
            const fullText = element.querySelector('.full-text');

            if (fullText.classList.contains('hidden')) {
                truncatedText.classList.add('hidden');
                fullText.classList.remove('hidden');
            } else {
                fullText.classList.add('hidden');
                truncatedText.classList.remove('hidden');
            }
        }
    </script>
</x-app-layout>
