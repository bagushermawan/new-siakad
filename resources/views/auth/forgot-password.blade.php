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
                    <h1 class="auth-title">Lupa kata sandi?</h1>
                    <p class="auth-subtitle mb-5">Tidak masalah. Cukup beri tahu kami alamat email Anda dan kami akan mengirimkan email berisi tautan pengaturan ulang kata sandi yang memungkinkan Anda memilih yang baru.</p>

                    <form method="POST" action="{{ route('password.email') }}">
                        @csrf
                        <div class="form-group position-relative has-icon-left mb-4">
                            <input type="email" class="form-control form-control-xl" placeholder="Email"
                                id="email" name="email" :value="old('email')" autofocus>
                            <div class="form-control-icon">
                                <i class="bi bi-envelope"></i>
                            </div>
                            @error('email')
                                <div class="auth-subtitle mb-5" style="color:#F8719D;">{{ $message }}</div>
                            @enderror
                        </div>
                        @if (session('status'))
                            <div class="auth-subtitle mb-5" style="color:#198754;">
                                {{ session('status') }}
                            </div>
                        @endif
                        <button class="btn btn-primary btn-block btn-lg shadow-lg mt-5">Kirim</button>
                    </form>
                    <div class="text-center mt-5 text-lg fs-4">
                        <p class='text-gray-600'>Remember your account? <a href="{{ route('login') }}" class="font-bold">Log
                                in</a>.
                        </p>
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
