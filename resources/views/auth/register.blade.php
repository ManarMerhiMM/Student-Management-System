<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Register</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
</head>

<body class="bg-light d-flex align-items-center justify-content-center" style="height: 100vh;">

    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-5">

                <div class="card shadow-sm">
                    <div class="card-body p-4">
                        <h3 class="card-title mb-4 text-center">Register</h3>

                        <form method="POST" action="{{ route('register') }}">
                            @csrf

                            {{-- Username --}}
                            <div class="mb-3">
                                <label for="username" class="form-label">Username</label>
                                <input type="text" class="form-control @error('username') is-invalid @enderror"
                                    id="username" name="username" value="{{ old('username') }}" autofocus>
                                @error('username')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Email --}}
                            <div class="mb-3">
                                <label for="email" class="form-label">Email address</label>
                                <input class="form-control @error('email') is-invalid @enderror" id="email"
                                    name="email" value="{{ old('email') }}">
                                @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Password --}}
                            <div class="mb-3 position-relative">
                                <label for="password" class="form-label">Password</label>
                                <input type="password" class="form-control @error('password') is-invalid @enderror"
                                    id="password" name="password">

                                <img id="hidepass" src="{{ asset('Images/hidepass.png') }}" alt="Hide password"
                                    onclick="togglePass()"
                                    style="display: block; position: absolute; top: 42%; right: 6%; cursor: pointer; height: 24px;">

                                <img id="showpass" src="{{ asset('Images/showpass.png') }}" alt="Show password"
                                    onclick="togglePass()"
                                    style="display: none; position: absolute; top: 42%; right: 6%; cursor: pointer; height: 24px;">

                                @error('password')
                                    <div id="passError" class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <small class="form-text text-muted">
                                    Minimum 10 characters, must include at least one number.
                                </small>
                            </div>

                            {{-- Confirm Password --}}
                            <div class="mb-3">
                                <label for="password_confirmation" class="form-label">Confirm Password</label>
                                <input type="password" class="form-control" id="password_confirmation"
                                    name="password_confirmation">
                            </div>

                            {{-- Submit --}}
                            <div class="d-grid">
                                <button type="submit" class="btn btn-primary">Register</button>
                            </div>

                        </form>

                        <div class="mt-3 text-center">
                            Already have an account? <a href="{{ route('login') }}">Login here</a>
                        </div>

                    </div>
                </div>

            </div>
        </div>
    </div>
    <script src="{{ asset('JS/register.js') }}"></script>
</body>

</html>
