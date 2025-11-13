<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Barangay Complaint System</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen">
    <div class="relative min-h-screen">
        <!-- Background Image -->
        <div class="absolute inset-0">
            <img src="/pobtrinidad.jpg" alt="Background" class="w-full h-full object-cover">
            <div class="absolute inset-0 bg-black/50"></div> <!-- overlay for readability -->
        </div>

        <!-- Centered Content -->
        <div class="relative z-10 flex flex-col items-center justify-center min-h-screen px-4 text-center text-white">
            <h1 class="text-4xl font-bold mb-4 drop-shadow-lg">Barangay Poblacion Complaint System</h1>
            <p class="mb-6 text-lg drop-shadow">Submit complaints and track resolutions easily.</p>

            <div class="flex space-x-4">
                @if (Route::has('login'))
                    <a href="{{ route('login') }}" class="px-4 py-2 bg-blue-600 rounded-lg hover:bg-blue-700">Log in</a>
                    <a href="{{ route('register') }}" class="px-4 py-2 bg-gray-600 rounded-lg hover:bg-gray-700">Register</a>
                @endif
            </div>
        </div>
    </div>
</body>
</html>
