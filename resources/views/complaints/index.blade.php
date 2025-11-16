<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Complaints') }}
        </h2>
    </x-slot>

    <script src="{{ asset('js/complaint-search.js') }}"></script>

    <!-- Modal for Image Viewing -->
    <div id="imageModal" class="fixed inset-0 bg-black bg-opacity-50 hidden flex items-center justify-center z-50">
        <div class="relative max-w-4xl max-h-full p-4">
            <img id="modalImage" src="" alt="Complaint Photo" class="max-w-full max-h-full object-contain">
            <button onclick="closeModal()" class="absolute top-2 right-2 text-white text-2xl font-bold bg-black bg-opacity-50 rounded-full w-10 h-10 flex items-center justify-center">&times;</button>
        </div>
    </div>

    <!-- Modal for Viewing Messages -->
    <div id="messagesModal" class="fixed inset-0 bg-black bg-opacity-50 hidden flex items-center justify-center z-50">
       <div class="relative bg-white rounded-lg w-full max-w-4xl max-h-[90vh] p-10 overflow-y-auto">

            <div class="flex justify-between items-center mb-8">
                <h3 class="text-3xl font-semibold">Official Messages</h3>
                <button onclick="closeMessagesModal()" class="text-gray-500 hover:text-gray-700 text-4xl font-bold">&times;</button>
            </div>
            <div id="messagesContent" class="text-gray-700">
                <!-- Messages will be loaded here -->
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

        function viewMessages(complaintId) {
            // Fetch messages via AJAX
            fetch(`/complaints/${complaintId}/messages`)
                .then(response => response.json())
                .then(data => {
                    let messagesHtml = '';
                    if (data.length === 0) {
                        messagesHtml = '<p>No messages yet.</p>';
                    } else {
                        data.forEach(message => {
                                    messagesHtml += `
                                <div class="mb-6 p-4 bg-gray-50 rounded">
                                    <div class="flex justify-between items-center mb-3">
                                        <strong>${message.sender.name}</strong>
                                        <small class="text-gray-500">${new Date(message.created_at).toLocaleString()}</small>
                                    </div>
                                    <textarea class="w-full p-4 border border-gray-300 rounded bg-white text-gray-700" rows="4" readonly style="min-height: 120px;">${message.message}</textarea>
                                </div>
                            `;
                        });
                    }
                    document.getElementById('messagesContent').innerHTML = messagesHtml;
                    document.getElementById('messagesModal').classList.remove('hidden');
                })
                .catch(error => {
                    console.error('Error fetching messages:', error);
                    alert('Error loading messages. Please try again.');
                });
        }

        function closeMessagesModal() {
            document.getElementById('messagesModal').classList.add('hidden');
        }

        // Close modal when clicking outside the image
        document.getElementById('imageModal').addEventListener('click', function(event) {
            if (event.target === this) {
                closeModal();
            }
        });

        // Close messages modal when clicking outside
        document.getElementById('messagesModal').addEventListener('click', function(event) {
            if (event.target === this) {
                closeMessagesModal();
            }
        });
    </script>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h3 class="text-lg font-semibold mb-4">
                        @if(Auth::user()->role === 'admin')
                            All Complaints
                        @else
                            Your Complaints
                        @endif
                    </h3>

                    @if(Auth::user()->role !== 'admin')
                        <a href="{{ route('complaints.create') }}"
                           class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 mb-4 inline-block">
                            + New Report
                        </a>
                    @endif

                    <!-- Search and Filter (only for admins, kapitan, kagawad) -->
                    @if(Auth::user()->role === 'admin' || Auth::user()->role === 'kapitan' || Auth::user()->role === 'kagawad')
                    <div class="mb-4 flex flex-wrap gap-4 justify-between items-center">
                        <form method="GET" action="{{ route('complaints.index') }}" class="flex gap-2">
                            <input type="text" name="search" value="{{ request('search') }}" placeholder="Search by category, details, or sitio" class="border border-gray-300 rounded px-3 py-2 flex-1">
                            <select name="status" class="border border-gray-300 rounded px-3 py-2">
                                <option value="">All Statuses</option>
                                <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                                <option value="in-progress" {{ request('status') == 'in-progress' ? 'selected' : '' }}>In Progress</option>
                                <option value="resolved" {{ request('status') == 'resolved' ? 'selected' : '' }}>Resolved</option>
                            </select>
                            <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Filter</button>
                        </form>
                    </div>
                    @endif

                    @if($complaints->isEmpty())
                        <p>No complaints submitted yet.</p>
                    @else

                        <div class="overflow-x-auto">
                            <table class="w-full border border-gray-300 table-fixed">
                                <thead>
                                    <tr class="bg-gray-100">
                                        <th class="px-4 py-2 border">Category</th>
                                        <th class="px-4 py-2 border w-2/5">Details</th>
                                        <th class="px-4 py-2 border">Photo</th>
                                        <th class="px-4 py-2 border">Status</th>
                                        <th class="px-4 py-2 border">Assigned Official</th>
                                        <th class="px-4 py-2 border">Date</th>
                                        <th class="px-4 py-2 border">Actions</th>
                                    </tr>
                                </thead>
                                <tbody id="complaints-table">
                                    @foreach($complaints as $complaint)
                                        <tr>
                                            <td class="px-4 py-2 border">{{ $complaint->category }}</td>
                                            <td class="px-4 py-2 border">
                                                <div class="truncate" title="{{ $complaint->details }}">
                                                    {{ Str::limit($complaint->details, 30) }}
                                                </div>
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
                                            <td class="px-4 py-2 border">
                                                @if($complaint->assigned_official_id)
                                                    {{ $complaint->assignedOfficial->name }}<br>
                                                    <small class="text-gray-600">({{ $complaint->assignedOfficial->position }})</small>
                                                @else
                                                    Not Assigned
                                                @endif
                                            </td>
                                            <td class="px-4 py-2 border">{{ $complaint->created_at->format('Y-m-d') }}</td>
                                            <td class="px-4 py-2 border">
                                                <div class="flex flex-wrap gap-1">
                                                    @if(Auth::user()->role !== 'admin')
                                                        <a href="{{ route('complaints.edit', $complaint) }}" class="bg-blue-500 text-white px-2 py-1 rounded text-xs hover:bg-blue-600">Edit</a>
                                                        @if($complaint->messages->count() > 0)
                                                            <button onclick="viewMessages({{ $complaint->id }})" class="bg-green-500 text-white px-2 py-1 rounded text-xs hover:bg-green-600">Messages ({{ $complaint->messages->count() }})</button>
                                                        @endif
                                                    @endif
                                                    @if(Auth::user()->role === 'admin')
                                                        @if($complaint->status === 'pending')
                                                            <form action="{{ route('complaints.update', $complaint) }}" method="POST" class="inline">
                                                                @csrf
                                                                @method('PUT')
                                                                <input type="hidden" name="status" value="in-progress">
                                                                <button type="submit" class="bg-green-500 text-white px-2 py-1 rounded text-xs hover:bg-green-600">In Progress</button>
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
