{{-- <x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Errors') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    {{ __("$exception") }}
                </div>
            </div>
        </div>
    </div>
</x-app-layout> --}}



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
                    <img class="img-error" src="{{ asset('/compiled/svg/error-403.svg') }}" alt="Forbidden">
                    <h1 class="error-title">Upss</h1>
                    <h4 class="text-gray-600">Maaf, sesi Anda telah berakhir.</h4>
                    <h4 class="text-gray-600">Harap muat ulang dan coba lagi.</h4>
                    <a onclick="goBack()" class="btn btn-lg btn-outline-primary mt-3">Kembali</a>
                </div>
            </div>
        </div>
        <script>
            function goBack() {
                window.location.href = '{{ route('login') }}';
            }
        </script>
</body>

</html>
