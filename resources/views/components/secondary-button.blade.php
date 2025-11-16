@if(isset($attributes['href']))
    <a {{ $attributes->merge(['class' => 'inline-flex items-center px-6 py-3 bg-gradient-to-r from-gray-100 to-gray-200 border border-gray-300 rounded-xl font-semibold text-sm text-gray-700 uppercase tracking-widest shadow-md hover:from-gray-200 hover:to-gray-300 focus:from-gray-200 focus:to-gray-300 active:from-gray-300 active:to-gray-400 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:ring-offset-2 transform hover:scale-105 active:scale-95 transition-all duration-200 ease-out hover:shadow-lg animate-scale-in no-underline']) }}>
        {{ $slot }}
    </a>
@else
    <button {{ $attributes->merge(['type' => 'button', 'class' => 'inline-flex items-center px-6 py-3 bg-gradient-to-r from-gray-100 to-gray-200 border border-gray-300 rounded-xl font-semibold text-sm text-gray-700 uppercase tracking-widest shadow-md hover:from-gray-200 hover:to-gray-300 focus:from-gray-200 focus:to-gray-300 active:from-gray-300 active:to-gray-400 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:ring-offset-2 transform hover:scale-105 active:scale-95 transition-all duration-200 ease-out hover:shadow-lg animate-scale-in']) }}>
        {{ $slot }}
    </button>
@endif
