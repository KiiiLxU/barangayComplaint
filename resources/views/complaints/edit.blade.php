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
                            <x-text-input id="category" class="block mt-1 w-full" type="text" name="category" :value="old('category', $complaint->category)" required autofocus autocomplete="category" />
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
