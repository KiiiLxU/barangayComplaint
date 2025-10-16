@extends('layouts.app')

@section('content')
<div class="container mx-auto p-4">
    <h1 class="text-2xl font-bold mb-4">Edit Complaint</h1>

    @if ($errors->any())
        <div class="bg-red-100 text-red-700 p-2 rounded mb-4">
            <ul class="list-disc list-inside">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('complaints.update', $complaint->id) }}" method="POST" enctype="multipart/form-data" class="space-y-4">
        @csrf
        @method('PUT')

        <div>
            <label class="block font-semibold">Category</label>
            <input type="text" name="category" value="{{ $complaint->category }}" class="w-full border p-2 rounded" required>
        </div>

        <div>
            <label class="block font-semibold">Details</label>
            <textarea name="details" rows="4" class="w-full border p-2 rounded" required>{{ $complaint->details }}</textarea>
        </div>

        <div>
            <label class="block font-semibold">Sitio</label>
            <input type="text" name="sitio" value="{{ $complaint->sitio }}" class="w-full border p-2 rounded">
        </div>

        <div>
            <label class="block font-semibold">Status</label>
            <select name="status" class="w-full border p-2 rounded">
                <option value="pending" {{ $complaint->status == 'pending' ? 'selected' : '' }}>Pending</option>
                <option value="in review" {{ $complaint->status == 'in review' ? 'selected' : '' }}>In Review</option>
                <option value="resolved" {{ $complaint->status == 'resolved' ? 'selected' : '' }}>Resolved</option>
            </select>
        </div>

        <div>
            <label class="block font-semibold">Replace Photo (optional)</label>
            <input type="file" name="photo" accept="image/*" class="w-full border p-2 rounded">
            @if($complaint->photo)
                <div class="mt-2">
                    <img src="{{ asset('storage/'.$complaint->photo) }}" alt="Photo" class="w-20 h-20 object-cover">
                </div>
            @endif
        </div>

        <div>
            <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">
                Update Complaint
            </button>
        </div>
    </form>
</div>
@endsection
