<button 
    {{ $attributes->merge([
        'type' => 'submit',
        'class' => 'inline-flex items-center justify-center rounded-lg 
                    bg-gradient-to-r from-indigo-600 to-purple-600 
                    px-4 py-2 text-sm font-medium text-white shadow-md 
                    hover:from-indigo-500 hover:to-purple-500 
                    focus:outline-none focus:ring-2 focus:ring-indigo-400 focus:ring-offset-1 
                    transition ease-in-out duration-150'
    ]) }}
>
    {{ $slot }}
</button>
