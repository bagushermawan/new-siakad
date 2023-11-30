<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forgot Password - Siakad</title>



    <link rel="shortcut icon" href="{{ asset('/compiled/svg/favicon.svg') }}" type="image/x-icon">
    <link rel="stylesheet" href="{{ asset('/compiled/css/app.css') }}">
    <link rel="stylesheet" href="{{ asset('/compiled/css/app-dark.css') }}">
    <link rel="stylesheet" href="{{ asset('/compiled/css/auth.css') }}">
</head>

<body>
    <script src="{{ asset('/static/js/initTheme.js') }}"></script>
    <div id="auth">
        <!-- Session Status -->

        <div class="row h-100">
            <div class="col-lg-5 col-12">
                <div id="auth-left">
                    <div class="auth-logo">
                        <a href="index.html"><img src="{{ asset('/compiled/svg/logo.svg') }}" alt="Logo"></a>
                    </div>
                    <h1 class="auth-title">Reset Password</h1>
                    {{-- <p class="auth-subtitle mb-5">No problem. Just let us know your email address and we will email you
                        a password reset link that will allow you to choose a new one.</p> --}}

                    <form method="POST" action="{{ route('password.store') }}">
                        @csrf

                        <!-- Password Reset Token -->
                        <input type="hidden" name="token" value="{{ $request->route('token') }}">

                        <div class="form-group position-relative has-icon-left mb-4">
                            <input type="password" class="form-control form-control-xl" id="password" name="password"
                                autocomplete="new-password" value="{{ old('email', $request->email) }}">
                            <div class="form-control-icon">
                                <i class="bi bi-envelope"></i>
                            </div>
                            @foreach ($errors->get('email') as $message)
                                <div style="color:#F8719D;">{{ $message }}</div>
                            @endforeach
                        </div>


                        <div class="form-group position-relative has-icon-left mb-4">
                            <input type="email" class="form-control form-control-xl" id="email" name="email"
                                placeholder="New Password" autofocus>
                            <div class="form-control-icon">
                                <i class="bi bi-envelope"></i>
                            </div>
                            @foreach ($errors->get('password') as $message)
                                <div style="color:#F8719D;">{{ $message }}</div>
                            @endforeach
                        </div>

                        <div class="form-group position-relative has-icon-left mb-4">
                            <input type="password" class="form-control form-control-xl" id="password_confirmation"
                                name="password_confirmation" placeholder="Password Confirmation">
                            <div class="form-control-icon">
                                <i class="bi bi-envelope"></i>
                            </div>
                            @foreach ($errors->get('password_confirmation') as $message)
                                <div style="color:#F8719D;">{{ $message }}</div>
                            @endforeach
                        </div>

                        <button type="submit" class="btn btn-primary btn-block btn-lg shadow-lg mt-5">Reset
                            Password</button>
                    </form>
                </div>
            </div>
            <div class="col-lg-7 d-none d-lg-block">
                <div id="auth-right">

                </div>
            </div>
        </div>

    </div>
</body>

</html>
