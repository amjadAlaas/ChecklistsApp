<!DOCTYPE html>
<html x-data="data" lang="en">

    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
        @vite(['resources/css/bootstrap.min.css', 'resources/js/bootstrap.js'])
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        <!-- Scripts -->
        <script src="{{ asset('js/init-alpine.js') }}"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.0/jquery.min.js" integrity="sha512-3gJwYpMe3QewGELv8k/BX9vcqhryRdzRMxVfq6ngyWXwo03GFEzjsUm8Q7RZcHPHksttq7/GFoxjCVUjkjvPdw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.7.1/chart.js" integrity="sha512-Lii3WMtgA0C0qmmkdCpsG0Gjr6M0ajRyQRQSbTF6BsrVh/nhZdHpVZ76iMIPvQwz1eoXC3DmAg9K51qT5/dEVg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
</head>
<body>
    <div class="flex h-screen bg-gray-50" :class="{ 'overflow-hidden': isSideMenuOpen }">
        <!-- Desktop sidebar -->
        @include('layouts.navigation')
        <!-- Mobile sidebar -->
        <!-- Backdrop -->
        @include('layouts.navigation-mobile')
        <div class="flex flex-col flex-1 w-full">
            @include('layouts.top-menu')
            <main class="h-full overflow-y-auto">
                <div class="container px-6 mx-auto grid">
                    @if (isset($header))
                        <h2 class="my-6 text-2xl font-semibold text-gray-700">
                            {{ $header }}
                        </h2>
                    @endif
                    {{ $slot }}
                </div>
            </main>
        </div>
    </div>
</body>

</html>
