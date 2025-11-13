<div class="relative min-h-screen">
    <!-- Background Image -->
    <div class="absolute inset-0">
        <img src="/pobtrinidad.jpg" alt="Background" class="w-full h-full object-cover">
        <div class="absolute inset-0 bg-black/50"></div> <!-- overlay for readability -->
    </div>

    <!-- Foreground content -->
    <div class="relative z-10 flex items-center justify-center min-h-screen">
        <x-guest-layout>
       

            <form method="POST" action="{{ route('register') }}" class="bg-white/90 p-8 rounded-lg shadow-lg w-full max-w-md">
                @csrf

                <!-- First Name -->
                <div>
                    <x-input-label for="first_name" :value="__('First Name')" />
                    <x-text-input id="first_name" class="block mt-1 w-full" type="text" name="first_name" :value="old('first_name')" required autofocus autocomplete="given-name" />
                    <x-input-error :messages="$errors->get('first_name')" class="mt-2" />
                </div>

                <!-- Last Name -->
                <div class="mt-4">
                    <x-input-label for="last_name" :value="__('Last Name')" />
                    <x-text-input id="last_name" class="block mt-1 w-full" type="text" name="last_name" :value="old('last_name')" required autocomplete="family-name" />
                    <x-input-error :messages="$errors->get('last_name')" class="mt-2" />
                </div>

                <!-- Email -->
                <div class="mt-4">
                    <x-input-label for="email" :value="__('Email')" />
                    <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autocomplete="username" />
                    <x-input-error :messages="$errors->get('email')" class="mt-2" />
                </div>

                <!-- Contact Number -->
                <div class="mt-4">
                    <x-input-label for="contact_number" :value="__('Contact Number')" />
                    <x-text-input id="contact_number" class="block mt-1 w-full" type="tel" name="contact_number" :value="old('contact_number')" required autocomplete="tel" pattern="[0-9]{11}" maxlength="11" />
                    <x-input-error :messages="$errors->get('contact_number')" class="mt-2" />
                </div>

                <!-- Password -->
                <div class="mt-4">
                    <x-input-label for="password" :value="__('Password')" />
                    <x-text-input id="password" class="block mt-1 w-full" type="password" name="password" required autocomplete="new-password" minlength="6" maxlength="15" />
                    <x-input-error :messages="$errors->get('password')" class="mt-2" />
                </div>

                <!-- Confirm Password -->
                <div class="mt-4">
                    <x-input-label for="password_confirmation" :value="__('Confirm Password')" />
                    <x-text-input id="password_confirmation" class="block mt-1 w-full" type="password" name="password_confirmation" required autocomplete="new-password" minlength="6" maxlength="15" />
                    <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
                </div>

                <!-- Purok -->
                <div class="mt-4">
                    <x-input-label for="purok" :value="__('Purok')" />
                    <select id="purok" name="purok" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" required>
                        <option value="">Select Purok</option>
                        @for ($i = 1; $i <= 7; $i++)
                            <option value="Purok {{ $i }}" {{ old('purok') == 'Purok ' . $i ? 'selected' : '' }}>Purok {{ $i }}</option>
                        @endfor
                    </select>
                    <x-input-error :messages="$errors->get('purok')" class="mt-2" />
                </div>

                <div class="flex items-center justify-end mt-4">
                    <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" href="{{ route('login') }}">
                        {{ __('Already registered?') }}
                    </a>

                    <x-primary-button class="ms-4">
                        {{ __('Register') }}
                    </x-primary-button>
                </div>
            </form>
        </x-guest-layout>
    </div>
</div>
