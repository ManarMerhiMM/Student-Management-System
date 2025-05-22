<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge" />
    <title>@yield('title', 'Student Management System')</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
</head>

<body>

    <header class="bg-primary text-white py-3 mb-4">
        <div class="container">
            <h1 class="mb-0">Student Management System</h1>
            <nav>

            </nav>
        </div>
    </header>

    <main class="container mb-5">
        @yield('content')
    </main>

    <footer class="bg-light text-center py-3">
        <div class="container">
            &copy; {{ date('Y') }} Your Company/Team Name. All rights reserved.
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    @yield('script')
</body>

</html>
