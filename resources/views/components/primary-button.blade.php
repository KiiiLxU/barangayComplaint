@if(isset($attributes['href']))
    <a {{ $attributes->merge(['class' => 'inline-flex items-center px-6 py-3 bg-gradient-to-r from-primary-600 to-primary-700 border border-transparent rounded-xl font-semibold text-sm text-white uppercase tracking-widest hover:from-primary-700 hover:to-primary-800 focus:from-primary-700 focus:to-primary-800 active:from-primary-800 active:to-primary-900 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:ring-offset-2 transform hover:scale-105 active:scale-95 transition-all duration-200 ease-out shadow-lg hover:shadow-xl animate-scale-in no-underline']) }}>
        {{ $slot }}
    </a>
@else
    <button {{ $attributes->merge(['type' => 'submit', 'class' => 'inline-flex items-center px-6 py-3 bg-gradient-to-r from-primary-600 to-primary-700 border border-transparent rounded-xl font-semibold text-sm text-white uppercase tracking-widest hover:from-primary-700 hover:to-primary-800 focus:from-primary-700 focus:to-primary-800 active:from-primary-800 active:to-primary-900 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:ring-offset-2 transform hover:scale-105 active:scale-95 transition-all duration-200 ease-out shadow-lg hover:shadow-xl animate-scale-in']) }}>
        {{ $slot }}
    </button>
@endif
