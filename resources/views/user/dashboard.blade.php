@extends('user.layouts.master')
@section('title', 'Dashboard')
@push('user-css')
    <style>
        html[data-bs-theme=dark] .text-sm {
            font-size: .775rem;
        }

        .profilepp {
            user-select: none;
            font-size: 1.5rem;
            margin-top: 0;
            margin-bottom: 0.5rem;
            font-weight: 700;
            line-height: 1.2;
            color: var(--bs-heading-color);
        }
    </style>
@endpush
@section('content')
    <div class="content-wrapper container">
        <div class="page-title">
            <div class="row">
                <div class="col-12 col-md-6 order-md-1 order-last">
                    <h3>Dashboard {{ ucfirst(implode(', ', $roles->all())) }}</h3>
                    {{-- <p class="text-subtitle text-muted">#</p> --}}
                </div>
            </div>
        </div>
        <div class="page-content">
            <div class="row">
                @if ($waliSantri && $waliSantri->santri_id === null)
                    {{-- <h1>Tidak ada santri ID</h1> --}}
                    <div class="card col-6">
                        <div class="card-header">
                            <div class="card-title">
                                <h4>Tidak ada santri ID</h4>
                            </div>
                        </div>
                    </div>
                @else
                    <div class="card col-8">
                        <div class="card-header">
                            <div class="card-title">
                                <h4>Informasi Data Santri Anda</h4>
                            </div>
                        </div>
                        <div class="d-flex justify-content-center align-items-center flex-column">
                            <div class="avatar avatar-3xl">
                                <img src="{{ asset('storage/' . $fotoSantri) }}" alt="Avatar" id="fotoPondok">
                            </div>
                        </div>
                        <div class="table-responsive" style="margin-top: 3rem;">
                            <table class="table table-borderless table-lg">
                                <tbody>
                                    <tr>
                                        <td class="col-5">
                                            <div class="d-flex align-items-center">
                                                <p class="font-bold h6 mb-0">NISN</p>
                                            </div>
                                        </td>
                                        <td class="col-auto">
                                            <p class=" mb-0"><span class="profilepp" style="margin-left: 1rem">
                                                    : {{ $nisnSantri }}
                                                </span>
                                            </p>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="col-5">
                                            <div class="d-flex align-items-center">
                                                <p class="font-bold h6 mb-0">Nama Santri</p>
                                            </div>
                                        </td>
                                        <td class="col-auto">
                                            <p class=" mb-0">
                                                <span class="profilepp" style="margin-left: 1rem">
                                                    : {{ $namaSantri }}
                                                </span>
                                            </p>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="col-5">
                                            <div class="d-flex align-items-center">
                                                <p class="font-bold h6 mb-0">Username Santri</p>
                                            </div>
                                        </td>
                                        <td class="col-auto">
                                            <p class=" mb-0">
                                                <span class="profilepp" style="margin-left: 1rem">
                                                    : {{ $usernameSantri }}
                                                </span>
                                            </p>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="col-5">
                                            <div class="d-flex align-items-center">
                                                <p class="font-bold h6 mb-0">Telepon Santri</p>
                                            </div>
                                        </td>
                                        <td class="col-auto">
                                            <p class=" mb-0"><span class="profilepp" style="margin-left: 1rem">:
                                                    {{ $nohpSantri }}</span>
                                            </p>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="col-5">
                                            <div class="d-flex align-items-center">
                                                <p class="font-bold h6 mb-0">Email Santri</p>
                                            </div>
                                        </td>
                                        <td class="col-auto">
                                            <p class=" mb-0"><span class="profilepp" style="margin-left: 1rem">:
                                                    {{ $emailSantri }}</span>
                                            </p>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                @endif

            </div>
            <section class="row">
                <div class="col-12 col-lg-3">
                    <div class="card" style="max-height: 425px; overflow-y: auto;" id="cardi">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <h4>Riwayat Login</h4>
                            <div class="buttonsi">
                                <button class="btn icon" id="minimizeBtn"><i class="fas fa-minus"></i></button>
                                <button class="btn icon" id="closeBtn"><i class="fas fa-times"></i></button>
                            </div>
                        </div>
                        <!-- Menampilkan riwayat login dari users -->
                        @foreach ($data_riwayat_login_users as $riwayat_login)
                            <div class="card-content pb-4">
                                <div class="recent-message d-flex px-4 py-3">
                                    <div class="avatar avatar-xl">
                                        <img src="{{ asset('/compiled/jpg/1.jpg') }}" alt="" srcset="">
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
                                        <h6 class="text-muted mb-0">{{ $riwayat_login->user->email }}</h6>
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
                                        <img src="{{ asset('/compiled/jpg/1.jpg') }}" alt="" srcset="">
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
                                        <h6 class="text-muted mb-0">{{ $riwayat_login->waliSantri->email }}
                                        </h6>
                                        @if ($riwayat_login->status_login == true)
                                            <h6 class="text-muted mb-0" style="color:green !important;">Online
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
            </section>
        </div>
    </div>
@endsection
@push('user-script')
    <!-- Include Chart.js -->
    <script src="{{ asset('extensions/chart.js/chart.umd.min.js') }}"></script>
    <script src="{{ asset('extensions/chart.js/chartjs-plugin-datalabels.min.js') }}"></script>
    <script src="{{ asset('extensions/apexcharts/apexcharts.min.js') }}"></script>
    @include('user.script')
@endpush
