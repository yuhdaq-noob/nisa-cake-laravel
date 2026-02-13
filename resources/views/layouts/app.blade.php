<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'Nisa Cake' }} - Nisa Cake</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <!-- Vite Assets (CSS & JS) -->
    @vite(['resources/css/app.css'])

    @yield('styles')
</head>
<body class="bg-light">
    <div class="d-flex flex-column flex-lg-row min-vh-100">
        <!-- Sidebar Navigation -->
        <x-navbar active="{{ $active ?? null }}" />

        <!-- Main Content -->
        <div class="flex-grow-1">
            <div class="container py-4 mb-5">
                @yield('content')
            </div>
        </div>
    </div>

    <!-- Bootstrap JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Page-Specific Scripts -->
    @yield('scripts')
</body>
</html>
