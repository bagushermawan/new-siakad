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
                    <img class="img-error" src="{{ asset('/compiled/svg/error-404.svg') }}" alt="Not Found">
                    <h1 class="error-title">Not Found</h1>
                    <p class='fs-5 text-gray-600'>The page you are looking not found.</p>
                    <a onclick="goBack()" class="btn btn-lg btn-outline-primary mt-3">Go Back</a>
                </div>
            </div>
        </div>


    </div>
    <script>
        function goBack() {
            window.history.back();
        }
    </script>
</body>

</html>
