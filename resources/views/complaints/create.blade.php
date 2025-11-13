<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Submit a Complaint') }}
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-sm sm:rounded-lg p-6">
                <form method="POST" action="{{ route('complaints.store') }}" enctype="multipart/form-data">
                    @csrf

                    <div class="mb-4">
                        <label for="category" class="block font-medium text-sm text-gray-700">Category <span class="text-red-500">*</span></label>
                        <select name="category" id="category"
                            class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required>
                            <option value="">Select a category</option>
                            <option value="Noise Disturbance" {{ old('category') == 'Noise Disturbance' ? 'selected' : '' }}>Noise Disturbance</option>
                            <option value="Domestic Dispute" {{ old('category') == 'Domestic Dispute' ? 'selected' : '' }}>Domestic Dispute</option>
                            <option value="Theft or Property Damage" {{ old('category') == 'Theft or Property Damage' ? 'selected' : '' }}>Theft or Property Damage</option>
                            <option value="Trespassing" {{ old('category') == 'Trespassing' ? 'selected' : '' }}>Trespassing</option>
                            <option value="Physical Injury or Assault" {{ old('category') == 'Physical Injury or Assault' ? 'selected' : '' }}>Physical Injury or Assault</option>
                            <option value="Public Disturbance or Scandal" {{ old('category') == 'Public Disturbance or Scandal' ? 'selected' : '' }}>Public Disturbance or Scandal</option>
                            <option value="Vandalism" {{ old('category') == 'Vandalism' ? 'selected' : '' }}>Vandalism</option>
                            <option value="Threat or Harassment" {{ old('category') == 'Threat or Harassment' ? 'selected' : '' }}>Threat or Harassment</option>
                            <option value="Violation of Barangay Ordinance" {{ old('category') == 'Violation of Barangay Ordinance' ? 'selected' : '' }}>Violation of Barangay Ordinance</option>
                            <option value="Illegal Gambling" {{ old('category') == 'Illegal Gambling' ? 'selected' : '' }}>Illegal Gambling</option>
                            <option value="Curfew Violation" {{ old('category') == 'Curfew Violation' ? 'selected' : '' }}>Curfew Violation</option>
                            <option value="Loud Karaoke or Parties" {{ old('category') == 'Loud Karaoke or Parties' ? 'selected' : '' }}>Loud Karaoke or Parties</option>
                            <option value="Garbage or Sanitation Complaint" {{ old('category') == 'Garbage or Sanitation Complaint' ? 'selected' : '' }}>Garbage or Sanitation Complaint</option>
                            <option value="Animal Nuisance (e.g., barking dogs or stray animals)" {{ old('category') == 'Animal Nuisance (e.g., barking dogs or stray animals)' ? 'selected' : '' }}>Animal Nuisance (e.g., barking dogs or stray animals)</option>
                            <option value="Boundary or Property Dispute" {{ old('category') == 'Boundary or Property Dispute' ? 'selected' : '' }}>Boundary or Property Dispute</option>
                            <option value="Unpaid Debt or Money Issue" {{ old('category') == 'Unpaid Debt or Money Issue' ? 'selected' : '' }}>Unpaid Debt or Money Issue</option>
                            <option value="Neighbor Conflict" {{ old('category') == 'Neighbor Conflict' ? 'selected' : '' }}>Neighbor Conflict</option>
                            <option value="Barangay Staff Misconduct" {{ old('category') == 'Barangay Staff Misconduct' ? 'selected' : '' }}>Barangay Staff Misconduct</option>
                            <option value="Missing Person Report" {{ old('category') == 'Missing Person Report' ? 'selected' : '' }}>Missing Person Report</option>
                            <option value="Other" {{ old('category') == 'Other' ? 'selected' : '' }}>Other</option>
                        </select>
                        @error('category')
                            <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="details" class="block font-medium text-sm text-gray-700">Details</label>
                        <textarea name="details" id="details" rows="4" 
                            class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" 
                            required>{{ old('details') }}</textarea>
                        @error('details') 
                            <p class="text-red-600 text-sm mt-1">{{ $message }}</p> 
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="sitio" class="block font-medium text-sm text-gray-700">Sitio / Purok <span class="text-red-500">*</span></label>
                        <select name="sitio" id="sitio"
                            class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required>
                            <option value="">Select a Purok</option>
                            <option value="Purok 1" {{ old('sitio') == 'Purok 1' ? 'selected' : '' }}>Purok 1</option>
                            <option value="Purok 2" {{ old('sitio') == 'Purok 2' ? 'selected' : '' }}>Purok 2</option>
                            <option value="Purok 3" {{ old('sitio') == 'Purok 3' ? 'selected' : '' }}>Purok 3</option>
                            <option value="Purok 4" {{ old('sitio') == 'Purok 4' ? 'selected' : '' }}>Purok 4</option>
                            <option value="Purok 5" {{ old('sitio') == 'Purok 5' ? 'selected' : '' }}>Purok 5</option>
                            <option value="Purok 6" {{ old('sitio') == 'Purok 6' ? 'selected' : '' }}>Purok 6</option>
                            <option value="Purok 7" {{ old('sitio') == 'Purok 7' ? 'selected' : '' }}>Purok 7</option>
                        </select>
                        @error('sitio')
                            <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="respondent" class="block font-medium text-sm text-gray-700">Respondent</label>
                        <input type="text" name="respondent" id="respondent" value="{{ old('respondent') }}"
                            class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                        @error('respondent')
                            <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="photo" class="block font-medium text-sm text-gray-700">Upload Photo (optional)</label>
                        <input type="file" name="photo" id="photo" 
                            class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                    </div>

                    <div class="flex justify-end">
                        <a href="{{ route('complaints.index') }}" 
                           class="bg-gray-300 text-gray-700 px-4 py-2 rounded mr-2 hover:bg-gray-400">
                            Cancel
                        </a>
                        <button type="submit"
                            class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                            Report
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
