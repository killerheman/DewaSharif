<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Reset Password - HostLok</title>

    <!-- AdminLTE -->
    <link rel="stylesheet" href="{{ asset('admin/assets/css/adminlte.css') }}">

    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">


    <style>
        :root {
            --hostlok: #22c55e;
            --hostlok-dark: #16a34a;
        }

        .card-outline.card-success {
            border-top: 4px solid var(--hostlok);
        }

        .btn-success {
            background: var(--hostlok);
            border-color: var(--hostlok);
        }

        .btn-success:hover {
            background: var(--hostlok-dark);
            border-color: var(--hostlok-dark);
        }

        .text-success {
            color: var(--hostlok) !important;
        }

        .login-page {
            background: #f4f6f9;
        }

        .login-link {
            color: var(--hostlok);
            text-decoration: none;
            font-weight: 600;
        }

        .login-link:hover {
            color: var(--hostlok-dark);
        }
    </style>

</head>


<body class="login-page">


    <main class="login-box">


        <div class="card card-outline card-success">


            <div class="card-header text-center">

                <h2 class="fw-bold text-success">
                    HostLok
                </h2>

            </div>



            <div class="card-body login-card-body">


                <p class="login-box-msg">
                    Reset your Password
                </p>



                {{-- Validation Errors --}}
                @if ($errors->any())

                    <div class="alert alert-danger">

                        <ul class="mb-0">

                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach

                        </ul>

                    </div>

                @endif




                <form action="{{ route('reset.password.store') }}" method="POST">

                    @csrf



                    {{-- Token Hidden --}}
                    <input type="hidden" name="token" value="{{ $token }}">



                    {{-- Email --}}
                    <div class="input-group mb-3">

                        <div class="form-floating">

                            <input type="email" name="email" id="email" class="form-control"
                                value="{{ $email }}" placeholder="" >

                            <label for="email">
                                Email Address
                            </label>

                        </div>


                        <div class="input-group-text">

                            <i class="bi bi-envelope"></i>

                        </div>

                    </div>





                    {{-- New Password --}}
                    <div class="input-group mb-3">
                        <div class="form-floating">
                            <input type="password" name="password" id="password" class="form-control" placeholder=""
                                required>
                            <label for="password">
                                New Password
                            </label>
                        </div>
                        <button class="btn btn-outline-secondary toggle-password-btn" type="button" data-target="password" title="Show / Hide Password" aria-label="Toggle password visibility">
                            <i class="bi bi-eye"></i>
                        </button>
                        <div class="input-group-text">
                            <i class="bi bi-lock-fill"></i>
                        </div>
                    </div>

                    {{-- Confirm Password --}}
                    <div class="input-group mb-3">
                        <div class="form-floating">
                            <input type="password" name="password_confirmation" id="password_confirmation"
                                class="form-control" placeholder="" required>
                            <label for="password_confirmation">
                                Confirm Password
                            </label>
                        </div>
                        <button class="btn btn-outline-secondary toggle-password-btn" type="button" data-target="password_confirmation" title="Show / Hide Password" aria-label="Toggle password visibility">
                            <i class="bi bi-eye"></i>
                        </button>
                        <div class="input-group-text">
                            <i class="bi bi-shield-lock"></i>
                        </div>
                    </div>





                    {{-- Submit Button --}}
                    <div class="d-grid mb-3">


                        <button type="submit" class="btn btn-success btn-lg">


                            <i class="bi bi-key-fill"></i>

                            Reset Password


                        </button>


                    </div>





                    <hr>



                    <p class="text-center mb-0">


                        Remember your password?


                        <a href="{{ route('login') }}" class="login-link">

                            Login

                        </a>


                    </p>



                </form>


            </div>


        </div>


    </main>





    <script src="{{ asset('admin/assets/js/adminlte.js') }}"></script>


</body>

</html>
