<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta name="csrf-token" content="{{ csrf_token() }}" />

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Bootstrap CSS (CDN only) -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light d-flex align-items-center min-vh-100">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-12 col-sm-10 col-md-8 col-lg-5 col-xl-4">
                <header class="text-center mb-4">
                    <a href="{{ url('/') }}"
                        class="d-inline-flex align-items-center justify-content-center text-decoration-none">
                        <x-application-logo style="width:56px;height:56px;" />
                    </a>
                    <div class="mt-2 h5 mb-0">{{ config('app.name', 'Laravel') }}</div>
                </header>

                <div class="card border-0 shadow-sm">
                    <div class="card-body p-4">
                        {{ $slot }}
                    </div>
                </div>

                <footer class="text-center mt-3 small text-muted">
                    &copy; {{ date('Y') }} {{ config('app.name') }}
                </footer>
            </div>
        </div>
    </div>

    <!-- Bootstrap Bundle JS (includes Popper) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
