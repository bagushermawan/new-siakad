<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="2BVl5h2xMHddASyGYQKLAPlCziVv77FjGXoA0muE">
    <title>Siakad MI Darun Najah - Dashboard</title>



    <link rel="shortcut icon" href="{{ asset('compiled/svg/favicon.svg') }}" type="image/x-icon">
    <link rel="shortcut icon"
        href="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAACEAAAAiCAYAAADRcLDBAAAEs2lUWHRYTUw6Y29tLmFkb2JlLnhtcAAAAAAAPD94cGFja2V0IGJlZ2luPSLvu78iIGlkPSJXNU0wTXBDZWhpSHpyZVN6TlRjemtjOWQiPz4KPHg6eG1wbWV0YSB4bWxuczp4PSJhZG9iZTpuczptZXRhLyIgeDp4bXB0az0iWE1QIENvcmUgNS41LjAiPgogPHJkZjpSREYgeG1sbnM6cmRmPSJodHRwOi8vd3d3LnczLm9yZy8xOTk5LzAyLzIyLXJkZi1zeW50YXgtbnMjIj4KICA8cmRmOkRlc2NyaXB0aW9uIHJkZjphYm91dD0iIgogICAgeG1sbnM6ZXhpZj0iaHR0cDovL25zLmFkb2JlLmNvbS9leGlmLzEuMC8iCiAgICB4bWxuczp0aWZmPSJodHRwOi8vbnMuYWRvYmUuY29tL3RpZmYvMS4wLyIKICAgIHhtbG5zOnBob3Rvc2hvcD0iaHR0cDovL25zLmFkb2JlLmNvbS9waG90b3Nob3AvMS4wLyIKICAgIHhtbG5zOnhtcD0iaHR0cDovL25zLmFkb2JlLmNvbS94YXAvMS4wLyIKICAgIHhtbG5zOnhtcE1NPSJodHRwOi8vbnMuYWRvYmUuY29tL3hhcC8xLjAvbW0vIgogICAgeG1sbnM6c3RFdnQ9Imh0dHA6Ly9ucy5hZG9iZS5jb20veGFwLzEuMC9zVHlwZS9SZXNvdXJjZUV2ZW50IyIKICAgZXhpZjpQaXhlbFhEaW1lbnNpb249IjMzIgogICBleGlmOlBpeGVsWURpbWVuc2lvbj0iMzQiCiAgIGV4aWY6Q29sb3JTcGFjZT0iMSIKICAgdGlmZjpJbWFnZVdpZHRoPSIzMyIKICAgdGlmZjpJbWFnZUxlbmd0aD0iMzQiCiAgIHRpZmY6UmVzb2x1dGlvblVuaXQ9IjIiCiAgIHRpZmY6WFJlc29sdXRpb249Ijk2LjAiCiAgIHRpZmY6WVJlc29sdXRpb249Ijk2LjAiCiAgIHBob3Rvc2hvcDpDb2xvck1vZGU9IjMiCiAgIHBob3Rvc2hvcDpJQ0NQcm9maWxlPSJzUkdCIElFQzYxOTY2LTIuMSIKICAgeG1wOk1vZGlmeURhdGU9IjIwMjItMDMtMzFUMTA6NTA6MjMrMDI6MDAiCiAgIHhtcDpNZXRhZGF0YURhdGU9IjIwMjItMDMtMzFUMTA6NTA6MjMrMDI6MDAiPgogICA8eG1wTU06SGlzdG9yeT4KICAgIDxyZGY6U2VxPgogICAgIDxyZGY6bGkKICAgICAgc3RFdnQ6YWN0aW9uPSJwcm9kdWNlZCIKICAgICAgc3RFdnQ6c29mdHdhcmVBZ2VudD0iQWZmaW5pdHkgRGVzaWduZXIgMS4xMC4xIgogICAgICBzdEV2dDp3aGVuPSIyMDIyLTAzLTMxVDEwOjUwOjIzKzAyOjAwIi8+CiAgICA8L3JkZjpTZXE+CiAgIDwveG1wTU06SGlzdG9yeT4KICA8L3JkZjpEZXNjcmlwdGlvbj4KIDwvcmRmOlJERj4KPC94OnhtcG1ldGE+Cjw/eHBhY2tldCBlbmQ9InIiPz5V57uAAAABgmlDQ1BzUkdCIElFQzYxOTY2LTIuMQAAKJF1kc8rRFEUxz9maORHo1hYKC9hISNGTWwsRn4VFmOUX5uZZ36oeTOv954kW2WrKLHxa8FfwFZZK0WkZClrYoOe87ypmWTO7dzzud97z+nec8ETzaiaWd4NWtYyIiNhZWZ2TvE946WZSjqoj6mmPjE1HKWkfdxR5sSbgFOr9Ll/rXoxYapQVik8oOqGJTwqPL5i6Q5vCzeo6dii8KlwpyEXFL519LjLLw6nXP5y2IhGBsFTJ6ykijhexGra0ITl5bRqmWU1fx/nJTWJ7PSUxBbxJkwijBBGYYwhBgnRQ7/MIQIE6ZIVJfK7f/MnyUmuKrPOKgZLpEhj0SnqslRPSEyKnpCRYdXp/9++msneoFu9JgwVT7b91ga+LfjetO3PQ9v+PgLvI1xkC/m5A+h7F32zoLXug38dzi4LWnwHzjeg8UGPGbFfySvuSSbh9QRqZ6H+Gqrm3Z7l9zm+h+iafNUV7O5Bu5z3L/wAdthn7QIme0YAAAAJcEhZcwAADsQAAA7EAZUrDhsAAAJTSURBVFiF7Zi9axRBGIefEw2IdxFBRQsLWUTBaywSK4ubdSGVIY1Y6HZql8ZKCGIqwX/AYLmCgVQKfiDn7jZeEQMWfsSAHAiKqPiB5mIgELWYOW5vzc3O7niHhT/YZvY37/swM/vOzJbIqVq9uQ04CYwCI8AhYAlYAB4Dc7HnrOSJWcoJcBS4ARzQ2F4BZ2LPmTeNuykHwEWgkQGAet9QfiMZjUSt3hwD7psGTWgs9pwH1hC1enMYeA7sKwDxBqjGnvNdZzKZjqmCAKh+U1kmEwi3IEBbIsugnY5avTkEtIAtFhBrQCX2nLVehqyRqFoCAAwBh3WGLAhbgCRIYYinwLolwLqKUwwi9pxV4KUlxKKKUwxC6ZElRCPLYAJxGfhSEOCz6m8HEXvOB2CyIMSk6m8HoXQTmMkJcA2YNTHm3congOvATo3tE3A29pxbpnFzQSiQPcB55IFmFNgFfEQeahaAGZMpsIJIAZWAHcDX2HN+2cT6r39GxmvC9aPNwH5gO1BOPFuBVWAZue0vA9+A12EgjPadnhCuH1WAE8ivYAQ4ohKaagV4gvxi5oG7YSA2vApsCOH60WngKrA3R9IsvQUuhIGY00K4flQG7gHH/mLytB4C42EgfrQb0mV7us8AAMeBS8mGNMR4nwHamtBB7B4QRNdaS0M8GxDEog7iyoAguvJ0QYSBuAOcAt71Kfl7wA8DcTvZ2KtOlJEr+ByyQtqqhTyHTIeB+ONeqi3brh+VgIN0fohUgWGggizZFTplu12yW8iy/YLOGWMpDMTPXnl+Az9vj2HERYqPAAAAAElFTkSuQmCC"
        type="image/png">
    <link rel="stylesheet" href="{{ asset('compiled/css/app.css') }}">
    <link rel="stylesheet" href="{{ asset('compiled/css/app-dark.css') }}">
    <link rel="stylesheet" href="{{ asset('/extensions/sweetalert2/sweetalert2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('/compiled/css/iconly.css') }}">
    <link rel="stylesheet" href="{{ asset('/extensions/@fortawesome/fontawesome-free/css/all.min.css') }}">
    <link rel="stylesheet" href="{{ asset('/extensions/animate/animate.min.css') }}">
    <style>
        .riwayat {
            /* color: red; */
            /* font-size: 70%; */
            display: flex;
            align-items: baseline;
        }

        .buttonsi {
            margin-left: auto;
        }
    </style>
    <style>
        .custom-card--wrapper {
            color: #404b55;
            display: grid;
            gap: 10px;
            grid-template-columns: repeat(3, minmax(0, 1fr));
        }

        .custom-card--wrapper .custom-card {
            border-radius: 4px;
            display: flex;
            height: 118px;
            min-width: 237px;
            overflow: hidden;
            position: relative;
        }

        .custom-card--wrapper .custom-card__img {
            align-self: flex-end;
            margin-bottom: -1px;
            width: 90px;
            z-index: 1;
        }

        .custom-card--wrapper .custom-card__body {
            align-self: center;
            display: flex;
            flex-flow: column;
            padding-left: 28px;
            text-transform: capitalize;
        }



        .custom-card--wrapper .custom-card.bg-skul--gradient__2:before {
            background-color: #ffa87b;
        }

        .custom-card--wrapper .custom-card.bg-skul--gradient__3:before {
            background-color: #71e9d5;
        }

        .custom-card--wrapper .custom-card.bg-skul--gradient__4:before {
            background-color: #72d1ed;
        }

        .custom-card--wrapper .custom-card:before {
            border-radius: 100%;
            bottom: -40px;
            content: "";
            height: 135px;
            left: -30px;
            position: absolute;
            width: 135px;
        }

        .custom-card--wrapper .custom-card__body h5 {
            color: #fff;
            margin-bottom: 0;
        }

        .custom-card--wrapper .custom-card__body h4 {
            color: #fff;
            margin-bottom: 0;
        }

        .bg-skul--gradient__2 {
            background: linear-gradient(260.53deg, #ef6187, #fb8c4e);
        }

        .bg-skul--gradient__3 {
            background: linear-gradient(260.53deg, #64daa1, #5cd7c8);
        }

        .bg-skul--gradient__4 {
            background: linear-gradient(260.53deg, #86d0d5, #66c1e1);
        }

        .stats-icon {
            width: 5rem;
            height: 4rem;
        }

        .stats-icon.transparent {
            background-color: transparent;
        }

        html[data-bs-theme=dark] .stats-icon.transparent {
            background-color: transparent;
        }

        html[data-bs-theme=dark] .stats-icon {
            width: 5rem;
            height: 4rem;
        }
    </style>
</head>

<body>
    <script src="{{ asset('static/js/initTheme.js') }}"></script>
    <div id="app">
        @include('admin.layouts.sidebar')
        <div id="main" class='layout-navbar navbar-fixed'>
            {{-- header --}}
            <div id="main-content">
                <header class="mb-3">
                    <a href="#" class="burger-btn d-block d-xl-none">
                        <i class="bi bi-justify fs-3"></i>
                    </a>
                </header>
                <div class="page-heading">
                    <div class="page-title">
                        <div class="row">
                            <div class="col-12 col-md-6 order-md-1 order-last">
                                <h3>Dashboard</h3>
                                <p class="text-subtitle text-muted">aweaw</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="page-content">
                    <section class="row">
                        <div class="col-12 col-lg-9">
                            <div class="row">
                                <div class="col-6 col-lg-3 col-md-6">
                                    <div class="card">
                                        <div class="card-body px-4 py-4-5">
                                            <div class="row">
                                                <div
                                                    class="col-md-4 col-lg-12 col-xl-12 col-xxl-5 d-flex justify-content-start ">
                                                    <img src="{{ asset('/compiled/svg/siswa.svg') }}"
                                                        class="stats-icon transparent mb-2">
                                                </div>
                                                <div class="col-md-8 col-lg-12 col-xl-12 col-xxl-7">
                                                    <h6 class="text-muted font-semibold">Total Santri</h6>
                                                    <h6 class="font-extrabold mb-0">{{ $total_santri }}</h6>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-6 col-lg-3 col-md-6">
                                    <div class="card">
                                        <div class="card-body px-4 py-4-5">
                                            <div class="row">
                                                <div
                                                    class="col-md-4 col-lg-12 col-xl-12 col-xxl-5 d-flex justify-content-start ">
                                                    <img src="{{ asset('/compiled/svg/guru.svg') }}"
                                                        class="stats-icon transparent mb-2">
                                                </div>
                                                <div class="col-md-8 col-lg-12 col-xl-12 col-xxl-7">
                                                    <h6 class="text-muted font-semibold">Total Guru</h6>
                                                    <h6 class="font-extrabold mb-0">{{ $total_guru }}</h6>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-6 col-lg-3 col-md-6">
                                    <div class="card">
                                        <div class="card-body px-4 py-4-5">
                                            <div class="row">
                                                <div
                                                    class="col-md-4 col-lg-12 col-xl-12 col-xxl-5 d-flex justify-content-start ">
                                                    <img src="{{ asset('/compiled/svg/wali.svg') }}"
                                                        class="stats-icon transparent mb-2">
                                                </div>
                                                <div class="col-md-8 col-lg-12 col-xl-12 col-xxl-7">
                                                    <h6 class="text-muted font-semibold">Orang Tua</h6>
                                                    <h6 class="font-extrabold mb-0">{{ $total_wali }}</h6>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-6 col-lg-3 col-md-6">
                                    <div class="card">
                                        <div class="card-body px-4 py-4-5">
                                            <div class="row">
                                                <div
                                                    class="col-md-4 col-lg-12 col-xl-12 col-xxl-5 d-flex justify-content-start ">
                                                    <div class="stats-icon red mb-2">
                                                        <i class="iconly-boldBookmark"></i>
                                                    </div>
                                                </div>
                                                <div class="col-md-8 col-lg-12 col-xl-12 col-xxl-7">
                                                    <h6 class="text-muted font-semibold">Saved Post</h6>
                                                    <h6 class="font-extrabold mb-0">112</h6>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12 col-xl-4">
                                    <div class="card">
                                        <div class="card-header">
                                            <h4>Total Users <span class="badge bg-info">{{ $total_all }}</span></h4>
                                        </div>
                                        <div class="card-body">
                                            <div id="chart-visitors-profile">
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-12 col-xl-8">
                                    <div class="card" style="max-height: 425px; overflow-y: auto;" id="cardi">
                                        <div class="card-header d-flex justify-content-between align-items-center">
                                            <h4>Riwayat Login</h4>
                                            <div class="buttonsi">
                                                <button class="btn icon" id="minimizeBtn"><i
                                                        class="fas fa-minus"></i></button>
                                                <button class="btn icon" id="closeBtn"><i
                                                        class="fas fa-times"></i></button>
                                            </div>
                                        </div>
                                        <!-- Menampilkan riwayat login dari users -->
                                        @foreach ($data_riwayat_login_users as $riwayat_login)
                                            <div class="card-content pb-4">
                                                <div class="recent-message d-flex px-4 py-3">
                                                    <div class="avatar avatar-xl">
                                                        <img src="{{ asset('/compiled/jpg/1.jpg') }}" alt=""
                                                            srcset="">
                                                        @if ($riwayat_login->status_login == true)
                                                            <span class="avatar-status bg-success"></span>
                                                        @else
                                                            <span class="avatar-status bg-danger"></span>
                                                        @endif
                                                    </div>
                                                    <div class="name ms-4">
                                                        <h5 class="mb-1">{{ $riwayat_login->user->name }}
                                                            <code>({{ $riwayat_login->user->roles->first()->name }})</code>
                                                        </h5>
                                                        <h6 class="text-muted mb-0">{{ $riwayat_login->user->email }}
                                                        </h6>
                                                        @if ($riwayat_login->status_login == false)
                                                            <span class="riwayat"><i class="far fa-clock"></i>&nbsp;
                                                                {{ $riwayat_login->updated_at->diffForHumans() }}</span>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                        <!-- Menampilkan riwayat login dari wali_santris -->
                                        @foreach ($data_riwayat_login_walis as $riwayat_login)
                                            <div class="card-content pb-4">
                                                <div class="recent-message d-flex px-4 py-3">
                                                    <div class="avatar avatar-xl">
                                                        <!-- Gantilah sesuai dengan atribut foto pada wali_santris -->
                                                        <img src="{{ asset('/compiled/jpg/1.jpg') }}" alt=""
                                                            srcset="">
                                                        @if ($riwayat_login->status_login == true)
                                                            <span class="avatar-status bg-success"></span>
                                                        @else
                                                            <span class="avatar-status bg-danger"></span>
                                                        @endif
                                                    </div>
                                                    <div class="name ms-4">
                                                        <h5 class="mb-1">{{ $riwayat_login->waliSantri->name }}
                                                            <code>({{ $riwayat_login->waliSantri->roles->first()->name }})</code>
                                                        </h5>
                                                        <!-- Sesuaikan dengan atribut pada wali_santris yang ingin ditampilkan -->
                                                        <h6 class="text-muted mb-0">
                                                            {{ $riwayat_login->waliSantri->email }}
                                                        </h6>
                                                        @if ($riwayat_login->status_login == true)
                                                            <h6 class="text-muted mb-0"
                                                                style="color:green !important;">
                                                                Online
                                                            </h6>
                                                        @endif
                                                        @if ($riwayat_login->status_login == false)
                                                            <span class="riwayat"><i class="far fa-clock"></i>&nbsp;
                                                                {{ $riwayat_login->updated_at->diffForHumans() }}</span>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>

                        </div>

                        <div class="col-12 col-lg-3">
                            <div class="card">
                                <div class="card-body px-4 py-4-5">
                                    <div class="d-flex align-items-center">
                                        <div class="avatar avatar-xl">
                                            <img src="{{ asset('/compiled/jpg/1.jpg') }}" alt="Face 1">
                                        </div>
                                        <div class="ms-3 name">
                                            <h5 class="font-bold">{{ ucfirst(auth()->user()->name) }}</h5>
                                            <h6 class="text-muted mb-0">{{ ucfirst(implode(', ', $roles->all())) }}
                                            </h6>
                                            <form id="send-verification" method="post"
                                                action="{{ route('verification.send') }}">
                                                @csrf
                                            </form>

                                            @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && !$user->hasVerifiedEmail())
                                                <div>
                                                    <p class="text-sm mt-2 text-gray-800 dark:text-gray-200">
                                                        <code>Email anda belum diverifikasi.</code>
                                                        <button id="send-verification-btn"
                                                            class="btn btn-sm btn-outline-secondary">
                                                            {{ __('Klik disini untuk mengirim email verifikasi.') }}
                                                        </button>
                                                    </p>
                                                    <p
                                                        class="mt-2 font-medium text-sm text-green-600 dark:text-green-400">
                                                        <code id="success-message" style="color:#198754;"></code>
                                                    </p>
                                                </div>
                                            @endif
                                            <form method="POST" action="{{ route('logout') }}">
                                                @csrf
                                                <a href="" class="card-link d-flex justify-content-end"
                                                    onclick="event.preventDefault(); this.closest('form').submit();">Logout</a>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>
                </div>
                @include('admin.layouts.footer')
            </div>
        </div>
        <script src="{{ asset('extensions/jquery/jquery.min.js') }}"></script>
        <script src="{{ asset('static/js/components/dark.js') }}"></script>
        <script src="{{ asset('extensions/perfect-scrollbar/perfect-scrollbar.min.js') }}"></script>
        <script src="{{ asset('compiled/js/app.js') }}"></script>
        <script src="{{ asset('/extensions/sweetalert2/sweetalert2.all.min.js') }}"></script>
        <!-- Include Chart.js -->
        <script src="{{ asset('extensions/apexcharts/apexcharts.min.js') }}"></script>
        {{-- <script src="{{ asset('extensions/chart.js/chartjs-plugin-datalabels.min.js') }}"></script> --}}
        @include('admin.script')
</body>

</html>
