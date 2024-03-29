<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>403 - Siakad</title>


    <link rel="shortcut icon" href="{{ asset('/compiled/svg/favicon.svg') }}" type="image/x-icon">
    <link rel="stylesheet" href="{{ asset('/compiled/css/app.css') }}">
    <link rel="stylesheet" href="{{ asset('/compiled/css/error.css') }}">

</head>

<body>
    <script src="{{ asset('/static/js/initTheme.js') }}"></script>
    <div id="error">


        <div class="error-page container">
            <div class="col-md-8 col-12 offset-md-2">
                <div class="text-center">
                    <img class="img-error" src="{{ asset('/compiled/svg/error-500.svg') }}" alt="System Error">
                    <h1 class="error-title">Sistem bermasalah</h1>
                    <p class="fs-5 text-gray-600">Situs web saat ini tidak tersedia. Coba lagi nanti atau hubungi pengembang.</p>
                    <a onclick="redirectToHome()" class="btn btn-lg btn-outline-primary mt-3">Go Home</a>
                </div>
            </div>
        </div>


    </div>
    <script>
        function redirectToHome() {
            // Lakukan pengalihan ke halaman home
            window.location.href = "/";
        }
    </script>
</body>

</html>
