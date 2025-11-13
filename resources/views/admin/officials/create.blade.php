<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Add Barangay Official') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-sm sm:rounded-lg p-6">
                <form method="POST" action="{{ route('admin.officials.store') }}" enctype="multipart/form-data">
                    @csrf

                    <div class="mb-4">
                        <label for="name" class="block font-medium text-sm text-gray-700">Name <span class="text-red-500">*</span></label>
                        <input type="text" name="name" id="name" value="{{ old('name') }}"
                            class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required>
                        @error('name')
                            <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="position" class="block font-medium text-sm text-gray-700">Position <span class="text-red-500">*</span></label>
                        <select name="position" id="position" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required>
                            <option value="">Select Position</option>
                            <option value="Kapitan" {{ old('position') == 'Kapitan' ? 'selected' : '' }}>Kapitan</option>
                            <option value="Treasurer" {{ old('position') == 'Treasurer' ? 'selected' : '' }}>Treasurer</option>
                            <option value="Secretary" {{ old('position') == 'Secretary' ? 'selected' : '' }}>Secretary</option>
                            <option value="Kagawad" {{ old('position') == 'Kagawad' ? 'selected' : '' }}>Kagawad</option>
                        </select>
                        @error('position')
                            <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="contact_no" class="block font-medium text-sm text-gray-700">Contact Number</label>
                        <input type="text" name="contact_no" id="contact_no" value="{{ old('contact_no') }}"
                            class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" pattern="[0-9]{11}" maxlength="11">
                        @error('contact_no')
                            <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="purok_assigned" class="block font-medium text-sm text-gray-700">Purok Assigned</label>
                        <select name="purok_assigned" id="purok_assigned" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                            <option value="">Select Purok</option>
                            @for($i = 1; $i <= 7; $i++)
                                <option value="{{ $i }}" {{ old('purok_assigned') == $i ? 'selected' : '' }}>Purok {{ $i }}</option>
                            @endfor
                        </select>
                        @error('purok_assigned')
                            <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="photo" class="block font-medium text-sm text-gray-700">Photo</label>
                        <input type="file" name="photo" id="photo"
                            class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" accept="image/*">
                        @error('photo')
                            <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="flex justify-end">
                        <a href="{{ route('admin.officials.index') }}"
                           class="bg-gray-300 text-gray-700 px-4 py-2 rounded mr-2 hover:bg-gray-400">
                            Cancel
                        </a>
                        <button type="submit"
                            class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                            Add Official
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
