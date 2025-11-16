<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Kagawad Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            <!-- Assigned Complaints Statistics -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 text-center">
                    <h3 class="text-lg font-medium">My Assigned Complaints</h3>
                    <p class="text-3xl font-bold text-blue-600 mt-2">{{ $assignedComplaints->count() }}</p>
                </div>

                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 text-center">
                    <h3 class="text-lg font-medium">In Progress</h3>
                    <p class="text-3xl font-bold text-orange-500 mt-2">{{ $inProgressCount }}</p>
                </div>

                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 text-center">
                    <h3 class="text-lg font-medium">Resolved</h3>
                    <p class="text-3xl font-bold text-green-500 mt-2">{{ $resolvedCount }}</p>
                </div>
            </div>

            <!-- Assigned Complaints Management -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h3 class="text-lg font-semibold mb-4">My Assigned Complaints</h3>

                    @if($assignedComplaints->isEmpty())
                        <p class="text-gray-500">No complaints assigned to you yet.</p>
                    @else
                        <div class="overflow-x-auto">
                            <table class="min-w-full border border-gray-300">
                                <thead>
                                    <tr class="bg-gray-100">
                                        <th class="px-4 py-2 border">Category</th>
                                        <th class="px-4 py-2 border">Reported By</th>
                                        <th class="px-4 py-2 border">Purok</th>
                                        <th class="px-4 py-2 border">Details</th>
                                        <th class="px-4 py-2 border">Photo</th>
                                        <th class="px-4 py-2 border">Status</th>
                                        <th class="px-4 py-2 border">Date</th>
                                        <th class="px-4 py-2 border">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($assignedComplaints as $complaint)
                                        <tr>
                                            <td class="px-4 py-2 border">{{ $complaint->category }}</td>
                                            <td class="px-4 py-2 border">{{ $complaint->user->name }}</td>
                                            <td class="px-4 py-2 border">{{ $complaint->sitio ?: 'N/A' }}</td>
                                            <td class="px-4 py-2 border">{{ Str::limit($complaint->details, 50) }}
                                                @if(strlen($complaint->details) > 50)
                                                    <br><button onclick="showFullDetails({{ $complaint->id }})" class="text-blue-600 hover:text-blue-800 text-xs mt-1">See More Details</button>
                                                @endif
                                            </td>
                                            <td class="px-4 py-2 border">
                                                @if($complaint->photo)
                                                    <img src="{{ asset('storage/' . $complaint->photo) }}" alt="Complaint Photo" class="w-16 h-16 object-cover rounded cursor-pointer" onclick="openModal('{{ asset('storage/' . $complaint->photo) }}')">
                                                @else
                                                    No Image
                                                @endif
                                            </td>
                                            <td class="px-4 py-2 border">
                                                <span class="px-2 py-1 rounded text-sm
                                                    @if($complaint->status == 'pending') bg-yellow-100 text-yellow-800
                                                    @elseif($complaint->status == 'in-progress') bg-blue-100 text-blue-800
                                                    @else bg-green-100 text-green-800
                                                    @endif">
                                                    {{ ucfirst(str_replace('-', ' ', $complaint->status)) }}
                                                </span>
                                            </td>
                                            <td class="px-4 py-2 border">{{ $complaint->created_at->format('Y-m-d') }}</td>
                                            <td class="px-4 py-2 border">
                                                <div class="flex flex-wrap gap-1">
                                                    @if($complaint->status === 'in-progress')
                                                        <form action="{{ route('complaints.update', $complaint) }}" method="POST" class="inline">
                                                            @csrf
                                                            @method('PUT')
                                                            <input type="hidden" name="status" value="resolved">
                                                            <button type="submit" class="bg-blue-500 text-white px-2 py-1 rounded text-xs hover:bg-blue-600">Resolved</button>
                                                        </form>
                                                        <button onclick="sendOfficialMessage({{ $complaint->id }})" class="bg-green-500 text-white px-2 py-1 rounded text-xs hover:bg-green-600">Message</button>
                                                    @elseif($complaint->status === 'resolved')
                                                        <form action="{{ route('complaints.update', $complaint) }}" method="POST" class="inline">
                                                            @csrf
                                                            @method('PUT')
                                                            <input type="hidden" name="status" value="in-progress">
                                                            <button type="submit" class="bg-yellow-500 text-white px-2 py-1 rounded text-xs hover:bg-yellow-600">In Progress</button>
                                                        </form>
                                                    @endif
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <!-- Pagination -->
                        <div class="mt-4">
                            {{ $assignedComplaints->links() }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Modal for Image Viewing -->
    <div id="imageModal" class="fixed inset-0 bg-black bg-opacity-50 hidden flex items-center justify-center z-50">
        <div class="relative max-w-4xl max-h-full p-4">
            <img id="modalImage" src="" alt="Complaint Photo" class="max-w-full max-h-full object-contain">
            <button onclick="closeModal()" class="absolute top-2 right-2 text-white text-2xl font-bold bg-black bg-opacity-50 rounded-full w-10 h-10 flex items-center justify-center">&times;</button>
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

    <!-- Modal for Sending Official Message -->
    <div id="messageModal" class="fixed inset-0 bg-black bg-opacity-50 hidden flex items-center justify-center z-50">
        <div class="relative bg-white rounded-lg w-full max-w-4xl max-h-[90vh] p-10 overflow-y-auto">

            <div class="flex justify-between items-center mb-6">
                <h3 class="text-2xl font-semibold">Send Official Message</h3>
                <button onclick="closeMessageModal()" class="text-gray-500 hover:text-gray-700 text-3xl font-bold">&times;</button>
            </div>
            <form id="messageForm" method="POST">
                @csrf
                <div class="mb-6">
                    <label for="message" class="block font-medium text-lg text-gray-700 mb-3">Message</label>
                    <textarea name="message" id="message" rows="12" class="mt-1 block w-full border-gray-300 rounded-lg shadow-sm focus:border-blue-500 focus:ring-blue-500 text-lg p-6" placeholder="Type your official message here..." required></textarea>
                </div>
                <div class="flex justify-end space-x-4">
                    <button type="button" onclick="closeMessageModal()" class="bg-gray-300 text-gray-700 px-8 py-4 rounded-lg hover:bg-gray-400 transition-colors text-lg">Cancel</button>
                    <button type="submit" class="bg-blue-600 text-white px-8 py-4 rounded-lg hover:bg-blue-700 transition-colors text-lg">Send Message</button>
                </div>
            </form>
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

        function sendOfficialMessage(complaintId) {
            document.getElementById('messageForm').action = `/complaints/${complaintId}/send-message`;
            document.getElementById('messageModal').classList.remove('hidden');
        }

        function closeMessageModal() {
            document.getElementById('messageModal').classList.add('hidden');
            document.getElementById('messageForm').reset();
        }

        // Close modal when clicking outside the image
        document.getElementById('imageModal').addEventListener('click', function(event) {
            if (event.target === this) {
                closeModal();
            }
        });

        // Close details modal when clicking outside
        document.getElementById('detailsModal').addEventListener('click', function(event) {
            if (event.target === this) {
                closeDetailsModal();
            }
        });

        // Close message modal when clicking outside
        document.getElementById('messageModal').addEventListener('click', function(event) {
            if (event.target === this) {
                closeMessageModal();
            }
        });
    </script>
</x-app-layout>
