<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Barangay Complaint System</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen">

    <div class="relative min-h-screen">
        <!-- Background Image -->
        <div class="absolute inset-0">
            <img src="/pobtrinidad.jpg" alt="Background" class="w-full h-full object-cover">
            <div class="absolute inset-0 bg-black/50"></div> <!-- overlay for readability -->
        </div>

        <!-- Centered Login Form -->
        <div class="relative z-10 flex flex-col items-center justify-center min-h-screen px-4 text-center text-white">
            <h1 class="text-4xl font-bold mb-6 drop-shadow-lg">Login</h1>

            <form method="POST" action="{{ route('login') }}" class="w-full max-w-md bg-white/20 p-8 rounded-lg backdrop-blur-sm">
                @csrf

                <div class="mb-4 text-left">
                    <label for="email" class="block mb-1">Email</label>
                    <input id="email" type="email" name="email" required autofocus
                           class="w-full px-4 py-2 rounded-lg text-black shadow-sm focus:ring-2 focus:ring-blue-400">
                </div>

                <div class="mb-4 text-left">
                    <label for="password" class="block mb-1">Password</label>
                    <input id="password" type="password" name="password" required
                           class="w-full px-4 py-2 rounded-lg text-black shadow-sm focus:ring-2 focus:ring-blue-400">
                </div>

                <button type="submit" class="w-full bg-blue-600 py-2 rounded-lg hover:bg-blue-700 transition duration-200">
                    Login
                </button>

                <p class="mt-2 text-sm text-gray-200">
                    <a href="{{ route('password.request') }}" class="underline hover:text-white">Forgot your password?</a>
                </p>

                <p class="mt-4 text-white">
                    Don't have an account? 
                    <a href="{{ route('register') }}" class="underline hover:text-gray-200">Register</a>
                </p>
            </form>
        </div>
    </div>

</body>
</html>
