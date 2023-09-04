<button {{ $attributes->merge(['type' => 'submit', 'class' => 'text-white rounded-lg border-box border-double border-1 border-purple-500 w-fit bg-purple-500 ease-in-out duration-200 p-2 my-2']) }}>
    {{ $slot }}
</button>
