<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Complaint') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form method="POST" action="{{ route('complaints.update', $complaint) }}" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <!-- Category -->
                        <div class="mb-4">
                            <x-input-label for="category" :value="__('Category')" />
                            <select name="category" id="category" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" required>
                                <option value="">Select a category</option>
                                <option value="Noise Disturbance" {{ old('category', $complaint->category) == 'Noise Disturbance' ? 'selected' : '' }}>Noise Disturbance</option>
                                <option value="Domestic Dispute" {{ old('category', $complaint->category) == 'Domestic Dispute' ? 'selected' : '' }}>Domestic Dispute</option>
                                <option value="Theft or Property Damage" {{ old('category', $complaint->category) == 'Theft or Property Damage' ? 'selected' : '' }}>Theft or Property Damage</option>
                                <option value="Trespassing" {{ old('category', $complaint->category) == 'Trespassing' ? 'selected' : '' }}>Trespassing</option>
                                <option value="Physical Injury or Assault" {{ old('category', $complaint->category) == 'Physical Injury or Assault' ? 'selected' : '' }}>Physical Injury or Assault</option>
                                <option value="Public Disturbance or Scandal" {{ old('category', $complaint->category) == 'Public Disturbance or Scandal' ? 'selected' : '' }}>Public Disturbance or Scandal</option>
                                <option value="Vandalism" {{ old('category', $complaint->category) == 'Vandalism' ? 'selected' : '' }}>Vandalism</option>
                                <option value="Threat or Harassment" {{ old('category', $complaint->category) == 'Threat or Harassment' ? 'selected' : '' }}>Threat or Harassment</option>
                                <option value="Violation of Barangay Ordinance" {{ old('category', $complaint->category) == 'Violation of Barangay Ordinance' ? 'selected' : '' }}>Violation of Barangay Ordinance</option>
                                <option value="Illegal Gambling" {{ old('category', $complaint->category) == 'Illegal Gambling' ? 'selected' : '' }}>Illegal Gambling</option>
                                <option value="Curfew Violation" {{ old('category', $complaint->category) == 'Curfew Violation' ? 'selected' : '' }}>Curfew Violation</option>
                                <option value="Loud Karaoke or Parties" {{ old('category', $complaint->category) == 'Loud Karaoke or Parties' ? 'selected' : '' }}>Loud Karaoke or Parties</option>
                                <option value="Garbage or Sanitation Complaint" {{ old('category', $complaint->category) == 'Garbage or Sanitation Complaint' ? 'selected' : '' }}>Garbage or Sanitation Complaint</option>
                                <option value="Animal Nuisance (e.g., barking dogs or stray animals)" {{ old('category', $complaint->category) == 'Animal Nuisance (e.g., barking dogs or stray animals)' ? 'selected' : '' }}>Animal Nuisance (e.g., barking dogs or stray animals)</option>
                                <option value="Boundary or Property Dispute" {{ old('category', $complaint->category) == 'Boundary or Property Dispute' ? 'selected' : '' }}>Boundary or Property Dispute</option>
                                <option value="Unpaid Debt or Money Issue" {{ old('category', $complaint->category) == 'Unpaid Debt or Money Issue' ? 'selected' : '' }}>Unpaid Debt or Money Issue</option>
                                <option value="Neighbor Conflict" {{ old('category', $complaint->category) == 'Neighbor Conflict' ? 'selected' : '' }}>Neighbor Conflict</option>
                                <option value="Barangay Staff Misconduct" {{ old('category', $complaint->category) == 'Barangay Staff Misconduct' ? 'selected' : '' }}>Barangay Staff Misconduct</option>
                                <option value="Missing Person Report" {{ old('category', $complaint->category) == 'Missing Person Report' ? 'selected' : '' }}>Missing Person Report</option>
                                <option value="Other" {{ old('category', $complaint->category) == 'Other' ? 'selected' : '' }}>Other</option>
                            </select>
                            <x-input-error :messages="$errors->get('category')" class="mt-2" />
                        </div>

                        <!-- Details -->
                        <div class="mb-4">
                            <x-input-label for="details" :value="__('Details')" />
                            <textarea id="details" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" name="details" required>{{ old('details', $complaint->details) }}</textarea>
                            <x-input-error :messages="$errors->get('details')" class="mt-2" />
                        </div>

                        <!-- Sitio -->
                        <div class="mb-4">
                            <x-input-label for="sitio" :value="__('Sitio')" />
                            <x-text-input id="sitio" class="block mt-1 w-full" type="text" name="sitio" :value="old('sitio', $complaint->sitio)" autocomplete="sitio" />
                            <x-input-error :messages="$errors->get('sitio')" class="mt-2" />
                        </div>

                        <!-- Photo -->
                        <div class="mb-4">
                            <x-input-label for="photo" :value="__('Photo')" />
                            <input id="photo" class="block mt-1 w-full" type="file" name="photo" accept="image/*" />
                            <x-input-error :messages="$errors->get('photo')" class="mt-2" />
                            @if($complaint->photo)
                                <p class="mt-2">Current photo: <img src="{{ asset('storage/' . $complaint->photo) }}" alt="Current Photo" class="w-32 h-32 object-cover rounded"></p>
                            @endif
                        </div>

                        <!-- Status (Admin only) -->
                        @if(Auth::user()->role === 'admin')
                        <div class="mb-4">
                            <x-input-label for="status" :value="__('Status')" />
                            <select id="status" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" name="status">
                                <option value="pending" {{ old('status', $complaint->status) == 'pending' ? 'selected' : '' }}>Pending</option>
                                <option value="in-progress" {{ old('status', $complaint->status) == 'in-progress' ? 'selected' : '' }}>In Progress</option>
                                <option value="resolved" {{ old('status', $complaint->status) == 'resolved' ? 'selected' : '' }}>Resolved</option>
                            </select>
                            <x-input-error :messages="$errors->get('status')" class="mt-2" />
                        </div>
                        @endif

                        <div class="flex items-center justify-end mt-6">
                            <x-primary-button>
                                {{ __('Update Complaint') }}
                            </x-primary-button>
                        </div>
                    </form>

                    <!-- Complaint Details Section -->
                    <div class="mt-8 border-t pt-6">
                        <h3 class="text-lg font-semibold mb-4">Complaint Details</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <strong>Category:</strong> {{ $complaint->category }}
                            </div>
                            <div>
                                <strong>Status:</strong>
                                <span class="px-2 py-1 rounded text-sm
                                    @if($complaint->status == 'pending') bg-yellow-100 text-yellow-800
                                    @elseif($complaint->status == 'in-progress') bg-blue-100 text-blue-800
                                    @else bg-green-100 text-green-800
                                    @endif">
                                    {{ ucfirst(str_replace('-', ' ', $complaint->status)) }}
                                </span>
                            </div>
                            <div>
                                <strong>Sitio:</strong> {{ $complaint->sitio ?: 'N/A' }}
                            </div>
                            <div>
                                <strong>Created:</strong> {{ $complaint->created_at->format('Y-m-d H:i') }}
                            </div>
                            @if($complaint->status_updated_at)
                            <div>
                                <strong>Last Updated:</strong> {{ $complaint->status_updated_at->format('Y-m-d H:i') }}
                            </div>
                            @endif
                        </div>
                        <div class="mt-4">
                            <strong>Details:</strong>
                            <p class="mt-2 p-4 bg-gray-50 rounded">{{ $complaint->details }}</p>
                        </div>
                        @if($complaint->photo)
                        <div class="mt-4">
                            <strong>Photo:</strong>
                            <div class="mt-2">
                                <img src="{{ asset('storage/' . $complaint->photo) }}" alt="Complaint Photo" class="max-w-md rounded shadow">
                            </div>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
