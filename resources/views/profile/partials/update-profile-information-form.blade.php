<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900">
            {{ __('Profile Information') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600">
            {{ __("Update your account's profile information and email address.") }}
        </p>
    </header>

    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    <form method="post" action="{{ route('profile.update') }}" class="mt-6 space-y-6">
        @csrf
        @method('patch')

        <div>
            <x-input-label for="name" :value="__('Name')" />
            <x-text-input id="name" name="name" type="text" class="mt-1 block w-full" :value="old('name', $user->name)" required autofocus autocomplete="name" />
            <x-input-error class="mt-2" :messages="$errors->get('name')" />
        </div>

        <div>
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" name="email" type="email" class="mt-1 block w-full" :value="old('email', $user->email)" required autocomplete="username" />
            <x-input-error class="mt-2" :messages="$errors->get('email')" />

            @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                <div>
                    <p class="text-sm mt-2 text-gray-800">
                        {{ __('Your email address is unverified.') }}

                        <button form="send-verification" class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            {{ __('Click here to re-send the verification email.') }}
                        </button>
                    </p>

                    @if (session('status') === 'verification-link-sent')
                        <p class="mt-2 font-medium text-sm text-green-600">
                            {{ __('A new verification link has been sent to your email address.') }}
                        </p>
                    @endif
                </div>
            @endif
        </div>

        <div>
            <x-input-label for="contact_number" :value="__('Contact Number')" />
            <x-text-input id="contact_number" name="contact_number" type="tel" class="mt-1 block w-full" :value="old('contact_number', $user->contact_number)" required autocomplete="tel" pattern="[0-9]{11}" maxlength="11" />
            <x-input-error class="mt-2" :messages="$errors->get('contact_number')" />
        </div>

        <div>
            <x-input-label for="purok" :value="__('Purok')" />
            <select id="purok" name="purok" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" required>
                <option value="">Select Purok</option>
                <option value="Purok 1" {{ old('purok', $user->purok) == 'Purok 1' ? 'selected' : '' }}>Purok 1</option>
                <option value="Purok 2" {{ old('purok', $user->purok) == 'Purok 2' ? 'selected' : '' }}>Purok 2</option>
                <option value="Purok 3" {{ old('purok', $user->purok) == 'Purok 3' ? 'selected' : '' }}>Purok 3</option>
                <option value="Purok 4" {{ old('purok', $user->purok) == 'Purok 4' ? 'selected' : '' }}>Purok 4</option>
                <option value="Purok 5" {{ old('purok', $user->purok) == 'Purok 5' ? 'selected' : '' }}>Purok 5</option>
                <option value="Purok 6" {{ old('purok', $user->purok) == 'Purok 6' ? 'selected' : '' }}>Purok 6</option>
                <option value="Purok 7" {{ old('purok', $user->purok) == 'Purok 7' ? 'selected' : '' }}>Purok 7</option>
            </select>
            <x-input-error class="mt-2" :messages="$errors->get('purok')" />
        </div>

        <div class="flex items-center gap-4">
            <x-primary-button>{{ __('Save') }}</x-primary-button>

            @if (session('status') === 'profile-updated')
                <p
                    x-data="{ show: true }"
                    x-show="show"
                    x-transition
                    x-init="setTimeout(() => show = false, 2000)"
                    class="text-sm text-gray-600"
                >{{ __('Saved.') }}</p>
            @endif
        </div>
    </form>
</section>
