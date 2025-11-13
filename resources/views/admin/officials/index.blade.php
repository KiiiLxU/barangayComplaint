<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Barangay Officials Management') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <div class="flex justify-between items-center mb-6">
                        <h3 class="text-lg font-semibold">Barangay Officials</h3>
                        <a href="{{ route('admin.officials.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                            Add Official
                        </a>
                    </div>

                    @if($officials->isEmpty())
                        <p class="text-gray-500">No barangay officials added yet.</p>
                    @else
                        <div class="overflow-x-auto">
                            <table class="min-w-full border border-gray-300">
                                <thead>
                                    <tr class="bg-gray-100">
                                        <th class="px-4 py-2 border">Photo</th>
                                        <th class="px-4 py-2 border">Name</th>
                                        <th class="px-4 py-2 border">Position</th>
                                        <th class="px-4 py-2 border">Contact Number</th>
                                        <th class="px-4 py-2 border">Purok Assigned</th>
                                        <th class="px-4 py-2 border">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($officials as $official)
                                        <tr>
                                            <td class="px-4 py-2 border">
                                                @if($official->photo)
                                                    <img src="{{ asset('storage/' . $official->photo) }}" alt="Official Photo" class="w-8 h-8 object-cover rounded cursor-pointer" onclick="openModal('{{ asset('storage/' . $official->photo) }}', '{{ $official->name }}')">
                                                @else
                                                    <div class="w-8 h-8 bg-gray-200 rounded flex items-center justify-center">
                                                        <span class="text-gray-500 text-xs">No Photo</span>
                                                    </div>
                                                @endif
                                            </td>
                                            <td class="px-4 py-2 border">{{ $official->name }}</td>
                                            <td class="px-4 py-2 border">{{ $official->position }}</td>
                                            <td class="px-4 py-2 border">{{ $official->contact_no ?: 'N/A' }}</td>
                                            <td class="px-4 py-2 border">{{ $official->purok_assigned ? 'Purok ' . $official->purok_assigned : 'N/A' }}</td>
                                            <td class="px-4 py-2 border">
                                                <a href="{{ route('admin.officials.edit', $official) }}" class="text-blue-600 hover:text-blue-800 mr-2">Edit</a>
                                                <form action="{{ route('admin.officials.destroy', $official) }}" method="POST" class="inline" onsubmit="return confirm('Are you sure you want to delete this official?')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="text-red-600 hover:text-red-800">Delete</button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <!-- Pagination -->
                        <div class="mt-4">
                            {{ $officials->links() }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Modal for image preview -->
    <div id="imageModal" class="fixed inset-0 bg-black bg-opacity-50 hidden z-50 flex items-center justify-center">
        <div class="bg-white p-4 rounded-lg max-w-3xl max-h-3xl">
            <div class="flex justify-between items-center mb-4">
                <h3 id="modalTitle" class="text-lg font-semibold"></h3>
                <button onclick="closeModal()" class="text-gray-500 hover:text-gray-700 text-2xl">&times;</button>
            </div>
            <img id="modalImage" src="" alt="Official Photo" class="max-w-full max-h-96 object-contain">
        </div>
    </div>

    <script>
        function openModal(imageSrc, name) {
            document.getElementById('modalImage').src = imageSrc;
            document.getElementById('modalTitle').textContent = name;
            document.getElementById('imageModal').classList.remove('hidden');
        }

        function closeModal() {
            document.getElementById('imageModal').classList.add('hidden');
        }

        // Close modal when clicking outside
        document.getElementById('imageModal').addEventListener('click', function(e) {
            if (e.target === this) {
                closeModal();
            }
        });
    </script>
</x-app-layout>
