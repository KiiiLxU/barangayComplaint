<button {{ $attributes->merge(['type' => 'submit', 'class' => 'inline-flex items-center px-6 py-3 bg-gradient-to-r from-red-600 to-red-700 border border-transparent rounded-xl font-semibold text-sm text-white uppercase tracking-widest hover:from-red-700 hover:to-red-800 focus:from-red-700 focus:to-red-800 active:from-red-800 active:to-red-900 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 transform hover:scale-105 active:scale-95 transition-all duration-200 ease-out shadow-lg hover:shadow-xl animate-scale-in']) }}>
    {{ $slot }}
</button>
