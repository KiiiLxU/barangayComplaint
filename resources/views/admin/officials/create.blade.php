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
                        <select name="position" id="position" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required onchange="toggleUserAccountFields()">
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

                    <!-- User Account Fields (only for Kagawad) -->
                    <div id="userAccountFields" class="hidden">
                        <div class="bg-blue-50 border border-blue-200 rounded-lg p-4 mb-4">
                            <h3 class="text-lg font-semibold text-blue-800 mb-3">Create User Account for Kagawad</h3>

                            <div class="mb-4">
                                <label for="email" class="block font-medium text-sm text-gray-700">Email <span class="text-red-500">*</span></label>
                                <input type="email" name="email" id="email" value="{{ old('email') }}"
                                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required>
                                @error('email')
                                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="mb-4">
                                <label for="password" class="block font-medium text-sm text-gray-700">Password <span class="text-red-500">*</span></label>
                                <input type="password" name="password" id="password"
                                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required minlength="6" maxlength="15">
                                <p class="text-sm text-gray-500 mt-1">Password must be 6-15 characters long</p>
                                @error('password')
                                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="mb-4">
                                <label for="password_confirmation" class="block font-medium text-sm text-gray-700">Confirm Password <span class="text-red-500">*</span></label>
                                <input type="password" name="password_confirmation" id="password_confirmation"
                                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required>
                                @error('password_confirmation')
                                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
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

    <script>
        function toggleUserAccountFields() {
            const positionSelect = document.getElementById('position');
            const userAccountFields = document.getElementById('userAccountFields');
            const emailField = document.getElementById('email');
            const passwordField = document.getElementById('password');
            const passwordConfirmationField = document.getElementById('password_confirmation');

            if (positionSelect.value === 'Kagawad') {
                userAccountFields.classList.remove('hidden');
                emailField.setAttribute('required', 'required');
                passwordField.setAttribute('required', 'required');
                passwordConfirmationField.setAttribute('required', 'required');
            } else {
                userAccountFields.classList.add('hidden');
                emailField.removeAttribute('required');
                passwordField.removeAttribute('required');
                passwordConfirmationField.removeAttribute('required');
            }
        }

        // Initialize on page load
        document.addEventListener('DOMContentLoaded', function() {
            toggleUserAccountFields();
        });
    </script>
</x-app-layout>
