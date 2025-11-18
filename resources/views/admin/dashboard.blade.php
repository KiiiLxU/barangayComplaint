<x-app-layout>

    <script src="{{ asset('js/complaint-search.js') }}"></script>

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
                            <div><strong>Respondent:</strong> ${data.respondent || 'N/A'}</div>
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
    </script>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            <!-- Complaint Statistics -->
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
                <a href="{{ route('kapitan.dashboard') }}" class="bg-gradient-to-r from-blue-500 to-blue-600 text-white overflow-hidden shadow-sm sm:rounded-lg p-6 text-center hover:from-blue-600 hover:to-blue-700 transition-all cursor-pointer">
                    <h3 class="text-lg font-medium">Total Complaints</h3>
                    <p class="text-3xl font-bold mt-2">{{ $totalComplaints }}</p>
                </a>

                <a href="{{ route('kapitan.dashboard', ['status' => 'pending']) }}" class="bg-gradient-to-r from-yellow-500 to-yellow-600 text-white overflow-hidden shadow-sm sm:rounded-lg p-6 text-center hover:from-yellow-600 hover:to-yellow-700 transition-all cursor-pointer">
                    <h3 class="text-lg font-medium">Pending</h3>
                    <p class="text-3xl font-bold mt-2">{{ $pendingComplaints }}</p>
                </a>

                <a href="{{ route('kapitan.dashboard', ['status' => 'in-progress']) }}" class="bg-gradient-to-r from-orange-500 to-orange-600 text-white overflow-hidden shadow-sm sm:rounded-lg p-6 text-center hover:from-orange-600 hover:to-orange-700 transition-all cursor-pointer">
                    <h3 class="text-lg font-medium">In Progress</h3>
                    <p class="text-3xl font-bold mt-2">{{ $inProgressComplaints }}</p>
                </a>

                <a href="{{ route('kapitan.dashboard', ['status' => 'resolved']) }}" class="bg-gradient-to-r from-green-500 to-green-600 text-white overflow-hidden shadow-sm sm:rounded-lg p-6 text-center hover:from-green-600 hover:to-green-700 transition-all cursor-pointer">
                    <h3 class="text-lg font-medium">Resolved</h3>
                    <p class="text-3xl font-bold mt-2">{{ $resolvedComplaints }}</p>
                </a>
            </div>

            <!-- Complaints Management -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h3 class="text-lg font-semibold mb-4">Manage Complaints</h3>

                    <!-- Search and Filter -->
                    <div class="mb-4 flex flex-wrap gap-4 justify-between items-center">
                        <form method="GET" action="{{ route('kapitan.dashboard') }}" class="flex gap-2">
                            <select name="search" class="border border-gray-300 rounded px-3 py-2 flex-1">
                                <option value="">Search by category</option>
                                <option value="Noise Disturbance" {{ request('search') == 'Noise Disturbance' ? 'selected' : '' }}>Noise Disturbance</option>
                                <option value="Domestic Dispute" {{ request('search') == 'Domestic Dispute' ? 'selected' : '' }}>Domestic Dispute</option>
                                <option value="Theft or Property Damage" {{ request('search') == 'Theft or Property Damage' ? 'selected' : '' }}>Theft or Property Damage</option>
                                <option value="Trespassing" {{ request('search') == 'Trespassing' ? 'selected' : '' }}>Trespassing</option>
                                <option value="Physical Injury or Assault" {{ request('search') == 'Physical Injury or Assault' ? 'selected' : '' }}>Physical Injury or Assault</option>
                                <option value="Public Disturbance or Scandal" {{ request('search') == 'Public Disturbance or Scandal' ? 'selected' : '' }}>Public Disturbance or Scandal</option>
                                <option value="Vandalism" {{ request('search') == 'Vandalism' ? 'selected' : '' }}>Vandalism</option>
                                <option value="Threat or Harassment" {{ request('search') == 'Threat or Harassment' ? 'selected' : '' }}>Threat or Harassment</option>
                                <option value="Violation of Barangay Ordinance" {{ request('search') == 'Violation of Barangay Ordinance' ? 'selected' : '' }}>Violation of Barangay Ordinance</option>
                                <option value="Illegal Gambling" {{ request('search') == 'Illegal Gambling' ? 'selected' : '' }}>Illegal Gambling</option>
                                <option value="Curfew Violation" {{ request('search') == 'Curfew Violation' ? 'selected' : '' }}>Curfew Violation</option>
                                <option value="Loud Karaoke or Parties" {{ request('search') == 'Loud Karaoke or Parties' ? 'selected' : '' }}>Loud Karaoke or Parties</option>
                                <option value="Garbage or Sanitation Complaint" {{ request('search') == 'Garbage or Sanitation Complaint' ? 'selected' : '' }}>Garbage or Sanitation Complaint</option>
                                <option value="Animal Nuisance (e.g., barking dogs or stray animals)" {{ request('search') == 'Animal Nuisance (e.g., barking dogs or stray animals)' ? 'selected' : '' }}>Animal Nuisance (e.g., barking dogs or stray animals)</option>
                                <option value="Boundary or Property Dispute" {{ request('search') == 'Boundary or Property Dispute' ? 'selected' : '' }}>Boundary or Property Dispute</option>
                                <option value="Unpaid Debt or Money Issue" {{ request('search') == 'Unpaid Debt or Money Issue' ? 'selected' : '' }}>Unpaid Debt or Money Issue</option>
                                <option value="Neighbor Conflict" {{ request('search') == 'Neighbor Conflict' ? 'selected' : '' }}>Neighbor Conflict</option>
                                <option value="Barangay Staff Misconduct" {{ request('search') == 'Barangay Staff Misconduct' ? 'selected' : '' }}>Barangay Staff Misconduct</option>
                                <option value="Missing Person Report" {{ request('search') == 'Missing Person Report' ? 'selected' : '' }}>Missing Person Report</option>
                                <option value="Other" {{ request('search') == 'Other' ? 'selected' : '' }}>Other</option>
                            </select>
                            <select name="status" class="border border-gray-300 rounded px-3 py-2">
                                <option value="">All Statuses</option>
                                <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                                <option value="in-progress" {{ request('status') == 'in-progress' ? 'selected' : '' }}>In Progress</option>
                                <option value="resolved" {{ request('status') == 'resolved' ? 'selected' : '' }}>Resolved</option>
                            </select>
                            <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Filter</button>
                        </form>
                        <a href="{{ route('kapitan.history') }}" class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700">
                            Case History
                        </a>
                    </div>

                    @if($complaints->isEmpty())
                        <p>No complaints submitted yet.</p>
                    @else
                        <div class="overflow-x-auto">
                            <table class="min-w-full border border-gray-300">
                                <thead>
                                    <tr class="bg-gray-100">
                                        <th class="px-4 py-2 border">Category</th>
                                        <th class="px-4 py-2 border">Reported By</th>
                                        <th class="px-4 py-2 border">Respondent</th>
                                        <th class="px-4 py-2 border">Purok</th>
                                        <th class="px-4 py-2 border">Details</th>
                                        <th class="px-4 py-2 border">Photo</th>
                                        <th class="px-4 py-2 border">Status</th>
                                        <th class="px-4 py-2 border">Date</th>
                                        <th class="px-4 py-2 border">Actions</th>
                                    </tr>
                                </thead>
                                <tbody id="complaints-table">
                                    @foreach($complaints as $complaint)
                                        <tr>
                                            <td class="px-4 py-2 border">{{ $complaint->category }}</td>
                                            <td class="px-4 py-2 border">{{ $complaint->user->name }}</td>
                                            <td class="px-4 py-2 border">{{ $complaint->respondent ?: 'N/A' }}</td>
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
                                                @if($complaint->assigned_official_id)
                                                    <br><small class="text-gray-600">Assigned: {{ $complaint->assignedOfficial->name }}</small>
                                                @endif
                                            </td>
                                            <td class="px-4 py-2 border">{{ $complaint->created_at->format('Y-m-d') }}</td>
                                            <td class="px-4 py-2 border">
                                                <div class="flex flex-wrap gap-1">
                                                    @if(Auth::user()->role === 'kapitan')
                                                        @if($complaint->status === 'pending')
                                                            <form action="{{ route('complaints.assign', $complaint) }}" method="POST" class="inline mb-1">
                                                                @csrf
                                                                <select name="assigned_official_id" class="text-xs border border-gray-300 rounded px-2 py-1">
                                                                    <option value="">Assign to Kagawad</option>
                                                                    @foreach(\App\Models\BrgyOfficial::where('position', 'Kagawad')->get() as $official)
                                                                        <option value="{{ $official->id }}">{{ $official->name }} (Purok {{ $official->purok_assigned }})</option>
                                                                    @endforeach
                                                                </select>
                                                                <button type="submit" class="bg-purple-500 text-white px-2 py-1 rounded text-xs hover:bg-purple-600">Assign</button>
                                                            </form>
                                                            <br>
                                                            <form action="{{ route('complaints.update', $complaint) }}" method="POST" class="inline">
                                                                @csrf
                                                                @method('PUT')
                                                                <input type="hidden" name="status" value="in-progress">
                                                                <button type="submit" class="bg-green-500 text-white px-2 py-1 rounded text-xs hover:bg-green-600">In Progress</button>
                                                            </form>
                                                            <form action="{{ route('complaints.update', $complaint) }}" method="POST" class="inline">
                                                                @csrf
                                                                @method('PUT')
                                                                <input type="hidden" name="status" value="resolved">
                                                                <button type="submit" class="bg-blue-500 text-white px-2 py-1 rounded text-xs hover:bg-blue-600">Resolved</button>
                                                            </form>
                                                        @elseif($complaint->status === 'in-progress')
                                                            <form action="{{ route('complaints.update', $complaint) }}" method="POST" class="inline">
                                                                @csrf
                                                                @method('PUT')
                                                                <input type="hidden" name="status" value="resolved">
                                                                <button type="submit" class="bg-blue-500 text-white px-2 py-1 rounded text-xs hover:bg-blue-600">Resolved</button>
                                                            </form>
                                                        @elseif($complaint->status === 'resolved')
                                                            <form action="{{ route('complaints.update', $complaint) }}" method="POST" class="inline">
                                                                @csrf
                                                                @method('PUT')
                                                                <input type="hidden" name="status" value="pending">
                                                                <button type="submit" class="bg-yellow-500 text-white px-2 py-1 rounded text-xs hover:bg-yellow-600">Pending</button>
                                                            </form>
                                                        @endif
                                                    @else
                                                        @if($complaint->status === 'pending')
                                                            <form action="{{ route('complaints.update', $complaint) }}" method="POST" class="inline">
                                                                @csrf
                                                                @method('PUT')
                                                                <input type="hidden" name="status" value="in-progress">
                                                                <button type="submit" class="bg-green-500 text-white px-2 py-1 rounded text-xs hover:bg-green-600">In Progress</button>
                                                            </form>
                                                            <form action="{{ route('complaints.update', $complaint) }}" method="POST" class="inline">
                                                                @csrf
                                                                @method('PUT')
                                                                <input type="hidden" name="status" value="resolved">
                                                                <button type="submit" class="bg-blue-500 text-white px-2 py-1 rounded text-xs hover:bg-blue-600">Resolved</button>
                                                            </form>
                                                        @elseif($complaint->status === 'in-progress')
                                                            <form action="{{ route('complaints.update', $complaint) }}" method="POST" class="inline">
                                                                @csrf
                                                                @method('PUT')
                                                                <input type="hidden" name="status" value="resolved">
                                                                <button type="submit" class="bg-blue-500 text-white px-2 py-1 rounded text-xs hover:bg-blue-600">Resolved</button>
                                                            </form>
                                                        @elseif($complaint->status === 'resolved')
                                                            <form action="{{ route('complaints.update', $complaint) }}" method="POST" class="inline">
                                                                @csrf
                                                                @method('PUT')
                                                                <input type="hidden" name="status" value="pending">
                                                                <button type="submit" class="bg-yellow-500 text-white px-2 py-1 rounded text-xs hover:bg-yellow-600">Pending</button>
                                                            </form>
                                                        @endif
                                                    @endif
                                                    <form action="{{ route('complaints.destroy', $complaint) }}" method="POST" class="inline" onsubmit="return confirm('Are you sure you want to delete this complaint?')">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="bg-red-500 text-white px-2 py-1 rounded text-xs hover:bg-red-600">Delete</button>
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <!-- Pagination -->
                        <div class="mt-4">
                            {{ $complaints->links() }}
                        </div>
                    @endif
                </div>
            </div>



        </div>
    </div>
</x-app-layout>
