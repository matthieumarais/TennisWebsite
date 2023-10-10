<button {{ $attributes->merge(['type' => 'submit', 'class' => 'text-red-700 hover:text-white border border-red-700 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center mr-2 mb-2']) }}>
    {{ $slot }}
</button>
