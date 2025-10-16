<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Barangay Complaint System</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-100 dark:bg-gray-900 text-gray-900 dark:text-gray-100">
    <div class="flex flex-col items-center justify-center min-h-screen px-4">
        <h1 class="text-4xl font-bold mb-4">Barangay Poblacion Complaint System</h1>
        <p class="mb-6 text-center text-lg">Submit complaints and track resolutions easily.</p>

        <div class="flex space-x-4">
            @if (Route::has('login'))
                <a href="{{ route('login') }}" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">Log in</a>
                <a href="{{ route('register') }}" class="px-4 py-2 bg-gray-600 text-white rounded-lg hover:bg-gray-700">Register</a>
            @endif
        </div>
    </div>
</body>
</html>
