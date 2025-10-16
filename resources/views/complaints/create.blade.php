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
                        <label for="category" class="block font-medium text-sm text-gray-700">Category</label>
                        <input type="text" name="category" id="category" 
                            class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" 
                            value="{{ old('category') }}" required>
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
                        <label for="sitio" class="block font-medium text-sm text-gray-700">Sitio / Street</label>
                        <input type="text" name="sitio" id="sitio"
                            class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" 
                            value="{{ old('sitio') }}">
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
                            Submit Complaint
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
