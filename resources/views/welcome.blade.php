<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Barangay Complaint System</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen flex flex-col">
    <div class="relative flex-1">
        <!-- Background Image -->
        <div class="absolute inset-0">
            <img src="/pobtrinidad.jpg" alt="Background" class="w-full h-full object-cover">
            <div class="absolute inset-0 bg-black/50"></div> <!-- overlay for readability -->
        </div>

        <!-- Centered Content -->
        <div class="relative z-10 flex flex-col items-center justify-center min-h-screen px-4 text-center text-white">
            <img src="/bcs.png" alt="Barangay Complaint System Logo" class="w-24 h-24 mx-auto mb-4 drop-shadow-lg">
            <h1 class="text-4xl font-bold mb-4 drop-shadow-lg">Barangay Poblacion Complaint System</h1>
            <p class="mb-6 text-lg drop-shadow">Submit complaints and track resolutions easily.</p>

            <!-- Login and Register Buttons -->
            <div class="mt-8 flex space-x-4">
                @if (Route::has('login'))
                    <a href="{{ route('login') }}" class="px-6 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 text-lg font-medium">Log in</a>
                    <a href="{{ route('register') }}" class="px-6 py-3 bg-gray-600 text-white rounded-lg hover:bg-gray-700 text-lg font-medium">Register</a>
                @endif
            </div>

            <!-- Emergency Contacts -->
            <div class="mt-8 max-w-4xl mx-auto">
                <h3 class="text-lg font-semibold mb-4 drop-shadow">Emergency Contacts</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 text-left">
                    <div>
                        <h4 class="font-medium mb-2">BFP/FIRE STATION:</h4>
                        <p>0969-112-4936</p>
                    </div>
                    <div>
                        <h4 class="font-medium mb-2">TREAT & MDRRM OFFICE:</h4>
                        <p>0946-239-7377</p>
                        <p>0912-233-3539</p>
                    </div>
                    <div>
                        <h4 class="font-medium mb-2">RHU - HEALTH EMERGENCY:</h4>
                        <p>0956-866-7231</p>
                        <p>0908-596-2294</p>
                    </div>
                    <div>
                        <h4 class="font-medium mb-2">PNP/POLICE:</h4>
                        <p>0998-598-6443</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
