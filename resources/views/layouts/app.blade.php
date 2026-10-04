<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'ShopEase') - {{ config('app.name') }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .product-img { height: 200px; object-fit: cover; }
        .carousel-item img { height: 380px; object-fit: cover; }
        .brand-img { height: 70px; object-fit: cover; }
    </style>
</head>
<body class="bg-light">
    @include('partials.navbar')

    <main class="container py-4">
        @include('partials.alerts')
        @yield('content')
    </main>

    <footer class="text-center text-muted py-4 border-top">&copy; {{ date('Y') }} ShopEase. Demo store.</footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
