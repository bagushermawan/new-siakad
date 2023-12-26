<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Siakad</title>



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
                        <a href="/"><img src="{{ asset('/compiled/svg/logo.svg') }}" alt="Logo"></a>
                    </div>
                    <h1 class="auth-title">Log in.</h1>
                    <p class="auth-subtitle mb-5">Log in with your data that you entered during registration.</p>
                    @if (session('status'))
                        <div class="auth-subtitle mb-5" style="color:#198754;">
                            {{ session('status') }}
                        </div>
                    @endif

                    <form method="POST" action="{{ route('login') }}">
                        @csrf
                        <div class="form-group position-relative has-icon-left mb-4">
                            <input type="text" class="form-control form-control-xl" id="id_user"
                                placeholder="Username or Email" name="id_user" value="{{ old('email') }}{{ old('username') }}" required
                                autofocus autocomplete="id_user">
                            <div class="form-control-icon">
                                <i class="bi bi-person"></i>
                            </div>
                            @error('id_user')
                                <div style="color:#F8719D;">{{ $message }}</div>
                            @enderror
                        </div>


                        <div class="form-group position-relative has-icon-left mb-4">
                            <input type="password" id="password" class="form-control form-control-xl"
                                placeholder="Password" name="password" required autocomplete="current-password">
                            <div class="form-control-icon">
                                <i class="bi bi-shield-lock"></i>
                            </div>
                            @error('password')
                                <div style="color:#F8719D;">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-check form-check-lg d-flex align-items-end">
                            <input id="remember_me" class="form-check-input me-2" type="checkbox" name="remember"
                                value="">
                            <label class="form-check-label text-gray-600" for="remember_me">
                                Remember me
                            </label>
                        </div>
                        <button type="submit" class="btn btn-primary btn-block btn-lg shadow-lg mt-5">Log in</button>
                    </form>
                    <div class="text-center mt-5 text-lg fs-4">
                        <p class="text-gray-600">Don't have an account? <a href="{{ route('register') }}"
                                class="font-bold">Sign
                                up</a>.</p>
                        <p><a class="font-bold" href="{{ route('password.request') }}">Forgot password?</a>.</p>
                    </div>
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
