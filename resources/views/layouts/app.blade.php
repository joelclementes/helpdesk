<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">


    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- Styles -->
    @livewireStyles

    <link rel="stylesheet" href="https://cdn.datatables.net/2.0.8/css/dataTables.dataTables.min.css">
    {{-- (opcional) tema con utilidades tipo Tailwind para DT 2.x --}}
    {{-- <link rel="stylesheet" href="https://cdn.datatables.net/2.0.8/css/dataTables.tailwindcss.css"> --}}

</head>

<body class="font-sans antialiased">
    <x-banner />

    <div class="min-h-screen bg-gray-100">
        @livewire('navigation-menu')

        <!-- Page Heading -->
        @if (isset($header))
            <header class="bg-white shadow">
                <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                    {{ $header }}
                </div>
            </header>
        @endif

        <!-- Page Content -->
        <main>
            {{ $slot }}
        </main>
    </div>

    @stack('modals')

    @livewireScripts

    {{-- @push('scripts') --}}
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.datatables.net/2.0.8/js/dataTables.min.js"></script>
    <script>
        let dt;

        function initDT() {
            const selector = '#tablaAtendidos';
            const table = document.querySelector(selector);
            if (!table) return;

            if (dt) {
                dt.destroy();
                dt = null;
            }

            const wrapper = table.closest('.dt-container');
            if (wrapper) {
                wrapper.replaceWith(table); // devuelve la <table> original al DOM
            }

            if (table.tBodies[0]?.rows.length === 0) return;
            // dt = new DataTable('#tablaAtendidos'); 

            dt = new DataTable(selector, {
                layout: {
                    topEnd: 'search',
                    topStart: 'pageLength',
                    bottomStart: 'info',
                    bottomEnd: 'paging'
                },
                paging: true,
                searching: true,
                info: true,
                lengthChange: true,
                pageLength: 10,
                ordering: true,
                language: {
                    url: 'https://cdn.datatables.net/plug-ins/2.0.8/i18n/es-MX.json'
                },
                pagingType: 'simple_numbers'
            });
        }

        // primer render
        document.addEventListener('livewire:init', initDT);

        // tras cada actualización de Livewire
        document.addEventListener('livewire:update', () => {
            setTimeout(initDT, 0); // o queueMicrotask(initDT)
        });
    </script>

    {{-- @endpush --}}

</body>

</html>
