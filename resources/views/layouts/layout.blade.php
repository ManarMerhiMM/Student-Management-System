<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge" />
    <title>@yield('title', 'Student Management System')</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">

    <style>
        header {
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        footer {
            border-top: 1px solid #e2e8f0;
        }

        .nav-link {
            color: white;
            margin-right: 1rem;
            text-decoration: none;
            transition: font-size 0.4s ease;
        }

        .nav-link:hover {
            font-size: 1.1em;
        }

        footer {
            position: fixed;
            bottom: 0%;
            width: 100%;
            background-color: rgb(101, 145, 228);
            color: rgb(218, 218, 218);
        }

        main {
            flex: 1;
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: 60vh;

        }
    </style>
</head>

<body class="bg-light">

    <header class="bg-primary text-white py-3 mb-4">
        <div class="container d-flex justify-content-between align-items-center">
            @auth
                <h2 class="mb-0">
                    <i class="bi bi-person-circle d-inline"></i>
                    Welcome {{ Auth::user()->username }}
                </h2>
            @else
                <h2 class="mb-0">Student Management</h2>
            @endauth

            <nav class="d-flex">
                <a class="nav-link d-inline" href="{{ route('home') }}">
                    <i class="bi bi-house-door-fill"></i> Home
                </a>

                @auth
                    <a class="nav-link d-inline" href="{{ route('dashboard') }}">
                        <i class="bi bi-speedometer2"></i> Dashboard
                    </a>
                    <a class="nav-link d-inline" href="{{ route('logout') }}"
                        onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                        <i class="bi bi-box-arrow-right"></i> Logout
                    </a>
                @else
                    <a class="nav-link d-inline" href="{{ route('login') }}">
                        <i class="bi bi-box-arrow-in-right"></i> Login
                    </a>
                    <a class="nav-link d-inline" href="{{ route('register') }}">
                        <i class="bi bi-person-plus"></i> Register
                    </a>
                @endauth
                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                    @csrf
                </form>
            </nav>

        </div>
    </header>

    <main class="container mb-5">
        @yield('content')
    </main>

    <footer class="text-center py-3">
        <div class="container">
            &copy; {{ date('Y') }} Manar Merhi. All rights reserved.
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    @yield('script')
</body>

</html>
