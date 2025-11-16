<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - Barangay Complaint System</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen">

    <div class="relative min-h-screen">
        <!-- Background Image -->
        <div class="absolute inset-0">
            <img src="/pobtrinidad.jpg" alt="Background" class="w-full h-full object-cover">
            <div class="absolute inset-0 bg-black/50"></div> <!-- overlay for readability -->
        </div>

        <!-- Centered Register Form -->
        <div class="relative z-10 flex flex-col items-center justify-center min-h-screen px-4 text-center text-white">
            <img src="/bcs.png" alt="Barangay Complaint System Logo" class="w-24 h-24 mx-auto mb-4 drop-shadow-lg">
            <h1 class="text-4xl font-bold mb-6 drop-shadow-lg">Register</h1>

            <form method="POST" action="{{ route('register') }}" class="w-full max-w-md bg-white/20 p-8 rounded-lg backdrop-blur-sm">
                @csrf

                <!-- First Name -->
                <div class="mb-4 text-left">
                    <label for="first_name" class="block mb-1">First Name</label>
                    <input id="first_name" type="text" name="first_name" :value="old('first_name')" required autofocus autocomplete="given-name"
                           class="w-full px-4 py-2 rounded-lg text-black shadow-sm focus:ring-2 focus:ring-blue-400">
                    @error('first_name')
                        <p class="text-red-300 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Last Name -->
                <div class="mb-4 text-left">
                    <label for="last_name" class="block mb-1">Last Name</label>
                    <input id="last_name" type="text" name="last_name" :value="old('last_name')" required autocomplete="family-name"
                           class="w-full px-4 py-2 rounded-lg text-black shadow-sm focus:ring-2 focus:ring-blue-400">
                    @error('last_name')
                        <p class="text-red-300 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Email -->
                <div class="mb-4 text-left">
                    <label for="email" class="block mb-1">Email</label>
                    <input id="email" type="email" name="email" :value="old('email')" required autocomplete="username"
                           class="w-full px-4 py-2 rounded-lg text-black shadow-sm focus:ring-2 focus:ring-blue-400">
                    @error('email')
                        <p class="text-red-300 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Contact Number -->
                <div class="mb-4 text-left">
                    <label for="contact_number" class="block mb-1">Contact Number</label>
                    <input id="contact_number" type="tel" name="contact_number" :value="old('contact_number')" required autocomplete="tel" pattern="[0-9]{11}" maxlength="11"
                           class="w-full px-4 py-2 rounded-lg text-black shadow-sm focus:ring-2 focus:ring-blue-400">
                    @error('contact_number')
                        <p class="text-red-300 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Password -->
                <div class="mb-4 text-left">
                    <label for="password" class="block mb-1">Password</label>
                    <input id="password" type="password" name="password" required autocomplete="new-password" minlength="6" maxlength="15"
                           class="w-full px-4 py-2 rounded-lg text-black shadow-sm focus:ring-2 focus:ring-blue-400">
                    @error('password')
                        <p class="text-red-300 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Confirm Password -->
                <div class="mb-4 text-left">
                    <label for="password_confirmation" class="block mb-1">Confirm Password</label>
                    <input id="password_confirmation" type="password" name="password_confirmation" required autocomplete="new-password" minlength="6" maxlength="15"
                           class="w-full px-4 py-2 rounded-lg text-black shadow-sm focus:ring-2 focus:ring-blue-400">
                    @error('password_confirmation')
                        <p class="text-red-300 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Purok -->
                <div class="mb-4 text-left">
                    <label for="purok" class="block mb-1">Purok</label>
                    <select id="purok" name="purok" class="w-full px-4 py-2 rounded-lg text-black shadow-sm focus:ring-2 focus:ring-blue-400" required>
                        <option value="">Select Purok</option>
                        @for ($i = 1; $i <= 7; $i++)
                            <option value="Purok {{ $i }}" {{ old('purok') == 'Purok ' . $i ? 'selected' : '' }}>Purok {{ $i }}</option>
                        @endfor
                    </select>
                    @error('purok')
                        <p class="text-red-300 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <button type="submit" class="w-full bg-blue-600 py-2 rounded-lg hover:bg-blue-700 transition duration-200">
                    Register
                </button>

                <p class="mt-4 text-white">
                    Already have an account?
                    <a href="{{ route('login') }}" class="underline hover:text-gray-200">Login</a>
                </p>
            </form>
        </div>
    </div>

</body>
</html>
