<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>TOURKIT</title>

        <!-- Fonts -->
        <link rel="icon" href="https://tourkit.vn/wp-content/uploads/2024/06/cropped-favicon-01-32x32.png">
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
        <link rel="stylesheet" href="{{ asset('library/bootstrap-5.3.3-dist/css/bootstrap.min.css') }}">
        <link rel="stylesheet" href="{{ asset('library/datatable/datatables.min.css') }}">
        <link href="{{ asset('library/select2/select2.min.css') }}" rel="stylesheet" />
        <link href="{{ asset('library/toastr/toastr.min.css') }}" rel="stylesheet">
        <script src="{{ asset('library/bootstrap-5.3.3-dist/js/bootstrap.min.js') }}"></script>
        <script src="{{ asset('library/jquery-3.7.1.min.js') }}"></script>
        <script src="{{ asset('library/datatable/datatables.min.js') }}"></script>
        <script src="{{ asset('library/select2/select2.min.js') }}"></script>
        <script src="{{ asset('library/toastr/toastr.min.js') }}"></script>

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased">
        <div class="min-h-screen bg-gray-100">
            @include('layouts.navigation')

            <!-- Page Heading -->
            @isset($header)
                <header class="bg-white shadow">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @endisset

            <!-- Page Content -->
            <main>
                {{ $slot }}
            </main>
        </div>
        @if (session('success'))
            <script>
                toastr.success("{{ session('success') }}", "Success", {
                    closeButton: true,
                    progressBar: true,
                    timeOut: 3000
                });
            </script>
        @endif
    </body>
</html>
