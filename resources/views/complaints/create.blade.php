<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-3xl bg-gradient-to-r from-primary-600 to-secondary-600 bg-clip-text text-transparent leading-tight animate-fade-in">
            {{ __('Submit a Complaint') }}
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white/80 backdrop-blur-sm shadow-xl sm:rounded-2xl p-8 border border-white/20 animate-scale-in">
                <div class="mb-6">
                    <div class="flex items-center space-x-3 mb-4">
                        <div class="w-12 h-12 bg-gradient-to-r from-primary-500 to-secondary-500 rounded-full flex items-center justify-center animate-pulse-slow">
                            <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path>
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-xl font-semibold text-gray-800">File Your Complaint</h3>
                            <p class="text-gray-600">Please provide detailed information about your complaint</p>
                        </div>
                    </div>
                </div>

                <form method="POST" action="{{ route('complaints.store') }}" enctype="multipart/form-data" class="space-y-6">
                    @csrf

                    <div class="animate-slide-in">
                        <label for="category" class="block font-semibold text-sm text-gray-700 mb-2 flex items-center">
                            <svg class="w-4 h-4 mr-2 text-primary-600" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M17.707 9.293a1 1 0 010 1.414l-7 7a1 1 0 01-1.414 0l-7-7A.997.997 0 012 10V5a3 3 0 013-3h5c.256 0 .512.098.707.293l7 7zM5 6a1 1 0 100-2 1 1 0 000 2z" clip-rule="evenodd"></path>
                            </svg>
                            Category <span class="text-red-500">*</span>
                        </label>
                        <select name="category" id="category"
                            class="mt-1 block w-full border-gray-300 rounded-xl shadow-sm focus:border-primary-500 focus:ring-primary-500 transition-all duration-200 bg-white" required>
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
                            <p class="text-red-600 text-sm mt-1 animate-fade-in">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="animate-slide-in">
                        <label for="details" class="block font-semibold text-sm text-gray-700 mb-2 flex items-center">
                            <svg class="w-4 h-4 mr-2 text-primary-600" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M4 4a2 2 0 012-2h4.586A2 2 0 0112 2.586L15.414 6A2 2 0 0116 7.414V16a2 2 0 01-2 2H6a2 2 0 01-2-2V4zm2 6a1 1 0 011-1h6a1 1 0 110 2H7a1 1 0 01-1-1zm1 3a1 1 0 100 2h6a1 1 0 100-2H7z" clip-rule="evenodd"></path>
                            </svg>
                            Details <span class="text-red-500">*</span>
                        </label>
                        <textarea name="details" id="details" rows="4"
                            class="mt-1 block w-full border-gray-300 rounded-xl shadow-sm focus:border-primary-500 focus:ring-primary-500 transition-all duration-200 bg-white resize-none"
                            placeholder="Please provide detailed information about your complaint..." required>{{ old('details') }}</textarea>
                        @error('details')
                            <p class="text-red-600 text-sm mt-1 animate-fade-in">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="animate-slide-in">
                            <label for="sitio" class="block font-semibold text-sm text-gray-700 mb-2 flex items-center">
                                <svg class="w-4 h-4 mr-2 text-primary-600" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd"></path>
                                </svg>
                                Sitio / Purok <span class="text-red-500">*</span>
                            </label>
                            <select name="sitio" id="sitio"
                                class="mt-1 block w-full border-gray-300 rounded-xl shadow-sm focus:border-primary-500 focus:ring-primary-500 transition-all duration-200 bg-white" required>
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
                                <p class="text-red-600 text-sm mt-1 animate-fade-in">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="animate-slide-in">
                            <label for="respondent" class="block font-semibold text-sm text-gray-700 mb-2 flex items-center">
                                <svg class="w-4 h-4 mr-2 text-primary-600" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"></path>
                                </svg>
                                Respondent (Optional)
                            </label>
                            <input type="text" name="respondent" id="respondent" value="{{ old('respondent') }}"
                                class="mt-1 block w-full border-gray-300 rounded-xl shadow-sm focus:border-primary-500 focus:ring-primary-500 transition-all duration-200 bg-white"
                                placeholder="Name of the person involved">
                            @error('respondent')
                                <p class="text-red-600 text-sm mt-1 animate-fade-in">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div class="animate-slide-in">
                        <label for="photo" class="block font-semibold text-sm text-gray-700 mb-2 flex items-center">
                            <svg class="w-4 h-4 mr-2 text-primary-600" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M4 3a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V5a2 2 0 00-2-2H4zm12 12H4l4-8 3 6 2-4 3 6z" clip-rule="evenodd"></path>
                            </svg>
                            Upload Photo (Optional)
                        </label>
                        <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-xl hover:border-primary-400 transition-colors duration-200 bg-gray-50 hover:bg-primary-50">
                            <div class="space-y-1 text-center">
                                <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48" aria-hidden="true">
                                    <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                                </svg>
                                <div class="flex text-sm text-gray-600">
                                    <label for="photo" class="relative cursor-pointer bg-white rounded-md font-medium text-primary-600 hover:text-primary-500 focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-primary-500">
                                        <span>Upload a file</span>
                                        <input id="photo" name="photo" type="file" class="sr-only">
                                    </label>
                                    <p class="pl-1">or drag and drop</p>
                                </div>
                                <p class="text-xs text-gray-500">PNG, JPG, GIF up to 2MB</p>
                            </div>
                        </div>
                    </div>

                    <div class="flex justify-end space-x-4 pt-6 border-t border-gray-200 animate-fade-in">
                        <x-secondary-button href="{{ route('complaints.index') }}" class="animate-scale-in">
                            <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                            </svg>
                            Cancel
                        </x-secondary-button>
                        <x-primary-button type="submit" class="animate-scale-in">
                            <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                            </svg>
                            Submit Complaint
                        </x-primary-button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
