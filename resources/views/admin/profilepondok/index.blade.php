@extends('admin.layouts.master')
@section('title', 'Prestasi')
@push('page-css')
    <link rel="stylesheet" href="{{ asset('extensions/datatables.net-bs5/css/dataTables.bootstrap5.min.css') }}">

    <link rel="stylesheet" href="{{ asset('compiled/css/table-datatable-jquery.css') }}">
    <link rel="stylesheet" href="{{ asset('/extensions/@fortawesome/fontawesome-free/css/all.min.css') }}">
    <link rel="stylesheet" href="{{ asset('/extensions/filepond/filepond.css') }}">
    <link rel="stylesheet" href="{{ asset('/extensions/filepond-plugin-image-preview/filepond-plugin-image-preview.css') }}">
    <style>
        .profilepp {
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
    <div class="page-heading">
        <div class="page-title">
            <div class="row">
                <div class="col-12 col-md-6 order-md-1 order-last">
                    <h3>Profile Pondok Pesantren</h3>
                    <p class="text-subtitle text-muted">Informasi profile Pondok Pesantren.</p>
                </div>
                <div class="col-12 col-md-6 order-md-2 order-first">
                    <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="index.html">Dashboard</a></li>
                            <li class="breadcrumb-item" aria-current="page">User
                            </li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
        <section class="section">
            <div class="row">
                <div class="col-12 col-lg-5">
                    <div class="card">
                        <div class="card-body">
                            <form class="form" data-parsley-validate="" novalidate="" id="profileForm">
                                <input type="hidden" name="id" value="{{ $a->first()->id }}">
                                <div class="row">
                                    <div class="form-group mandatory">
                                        <label for="nama_pondok" class="form-label">Nama Pondok Pesantren</label>
                                        <input type="text" id="nama_pondok" class="form-control" name="nama_pondok"
                                            value="{{ $a->first()->nama_pondok }}" data-parsley-required="true">
                                    </div>
                                    <div class="form-group mandatory">
                                        <label for="kepala_pondok" class="form-label">Kepala Pondok Pesantren</label>
                                        <input type="text" id="kepala_pondok" class="form-control" name="kepala_pondok"
                                            value="{{ $a->first()->kepala_pondok }}" data-parsley-required="true">
                                    </div>
                                    <div class="form-group">
                                        <label for="alamat" class="form-label">Alamat</label>
                                        <input type="text" id="alamat" class="form-control" name="alamat"
                                            value="{{ $a->first()->alamat }}">
                                    </div>
                                    <div class="form-group">
                                        <label for="telepon" class="form-label">Telepon</label>
                                        <input type="number" id="telepon" class="form-control" name="telepon"
                                            value="{{ $a->first()->telepon }}">
                                    </div>
                                    <div class="form-group">
                                        <label for="email" class="form-label">Email</label>
                                        <input type="email" id="email" class="form-control" name="email"
                                            value="{{ $a->first()->email }}">
                                    </div>
                                    <div class="form-group">
                                        <label for="deskripsi" class="form-label">Deskripsi</label>
                                        <input type="text" id="deskripsi" class="form-control" name="deskripsi"
                                            value="{{ $a->first()->deskripsi }}">
                                    </div>
                                    <div class="form-group">
                                        <label for="visi_misi" class="form-label">Visi Misi</label>
                                        <input type="text" id="visi_misi" class="form-control" name="visi_misi"
                                            value="{{ $a->first()->visi_misi }}">
                                    </div>
                                    <br><br><br><br>
                                    <div class="form-groupp">
                                        <p class="card-text">Foto/Logo Pondok Pesantren.
                                        </p>
                                        <input type="file" class="image-exif-filepond" name="foto_pondok">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-12">
                                        <div class="form-check mandatory">
                                            <input type="checkbox" id="checkbox5" class="form-check-input"
                                                checked="" data-parsley-required="true"
                                                data-parsley-error-message="You have to accept our terms and conditions to proceed."
                                                data-parsley-multiple="checkbox5">
                                            <label for="checkbox5" class="form-check-label form-label">Perbarui profile
                                                Pondok Pesantren.</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-12 d-flex justify-content-end">
                                        <button type="submit" class="btn btn-primary me-1 mb-1">
                                            Submit
                                        </button>
                                        <button type="reset" class="btn btn-light-secondary me-1 mb-1">
                                            Reset
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-lg-7">
                    <div class="card">
                        <div class="card-header">
                            <h2 class="card-title">Profile Pondok Pesantren</h2>
                        </div>
                        <div class="card-body">
                            <div class="d-flex justify-content-center align-items-center flex-column">
                                <div class="avatar avatar-3xl">
                                    <img src="{{ asset('storage/' .$a->first()->foto_pondok) }}" alt="Avatar" id="fotoPondok">
                                </div>

                            </div>
                            <div class="table-responsive" style="margin-top: 3rem;">
                                <table class="table table-borderless table-lg">
                                    <tbody>
                                        <tr>
                                            <td class="col-5">
                                                <div class="d-flex align-items-center">
                                                    <p class="font-bold h6 mb-0">Nama Pondok Pesantren</p>
                                                </div>
                                            </td>
                                            <td class="col-auto">
                                                <p class=" mb-0"><span class="profilepp" id="namaPondok"
                                                        style="margin-left: 1rem">: {{ $a->first()->nama_pondok }}</span>
                                                </p>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="col-5">
                                                <div class="d-flex align-items-center">
                                                    <p class="font-bold h6 mb-0">Kepala Pondok Pesantren</p>
                                                </div>
                                            </td>
                                            <td class="col-auto">
                                                <p class=" mb-0"><span class="profilepp" id="kepalaPondok"
                                                        style="margin-left: 1rem">:
                                                        {{ $a->first()->kepala_pondok }}</span>
                                                </p>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="col-5">
                                                <div class="d-flex align-items-center">
                                                    <p class="font-bold h6 mb-0">Alamat</p>
                                                </div>
                                            </td>
                                            <td class="col-auto">
                                                <p class=" mb-0"><span class="profilepp" id="alamatPondok"
                                                        style="margin-left: 1rem">: {{ $a->first()->alamat }}</span>
                                                </p>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="col-5">
                                                <div class="d-flex align-items-center">
                                                    <p class="font-bold h6 mb-0">Telepon</p>
                                                </div>
                                            </td>
                                            <td class="col-auto">
                                                <p class=" mb-0"><span class="profilepp" id="teleponPondok"
                                                        style="margin-left: 1rem">: {{ $a->first()->telepon }}</span>
                                                </p>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="col-5">
                                                <div class="d-flex align-items-center">
                                                    <p class="font-bold h6 mb-0">Email</p>
                                                </div>
                                            </td>
                                            <td class="col-auto">
                                                <p class=" mb-0"><span class="profilepp" id="emailPondok"
                                                        style="margin-left: 1rem">: {{ $a->first()->email }}</span>
                                                </p>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="col-5">
                                                <div class="d-flex align-items-center">
                                                    <p class="font-bold h6 mb-0">Deskripsi</p>
                                                </div>
                                            </td>
                                            <td class="col-auto">
                                                <p class=" mb-0"><span class="profilepp" id="deskripsiPondok"
                                                        style="margin-left: 1rem">: {{ $a->first()->deskripsi }}</span>
                                                </p>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="col-5">
                                                <div class="d-flex align-items-center">
                                                    <p class="font-bold h6 mb-0">Visi Misi</p>
                                                </div>
                                            </td>
                                            <td class="col-auto">
                                                <p class=" mb-0"><span class="profilepp" id="visi_misiPondok"
                                                        style="margin-left: 1rem">: {{ $a->first()->visi_misi }}</span>
                                                </p>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
    </div>
    </section>
    </div>
@endsection
@push('page-script')
    <script src="{{ asset('extensions/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('extensions/parsleyjs/parsley.min.js') }}"></script>
    <script src="{{ asset('static/js/pages/parsley.js') }}"></script>

    <script src="{{ asset('/extensions/filepond-plugin-file-validate-size/filepond-plugin-file-validate-size.min.js') }}">
    </script>
    <script src="{{ asset('/extensions/filepond-plugin-file-validate-type/filepond-plugin-file-validate-type.min.js') }}">
    </script>
    <script src="{{ asset('/extensions/filepond-plugin-image-crop/filepond-plugin-image-crop.min.js') }}"></script>
    <script
        src="{{ asset('/extensions/filepond-plugin-image-exif-orientation/filepond-plugin-image-exif-orientation.min.js') }}">
    </script>
    <script src="{{ asset('/extensions/filepond-plugin-image-filter/filepond-plugin-image-filter.min.js') }}"></script>
    <script src="{{ asset('/extensions/filepond-plugin-image-preview/filepond-plugin-image-preview.min.js') }}"></script>
    <script src="{{ asset('/extensions/filepond-plugin-image-resize/filepond-plugin-image-resize.min.js') }}"></script>
    <script src="{{ asset('/extensions/filepond/filepond.js') }}"></script>
    {{-- <script src="{{ asset('/extensions/toastify-js/src/toastify.js') }}"></script> --}}
    <script src="{{ asset('/static/js/pages/filepond.js') }}"></script>
    @include('admin.profilepondok.script')
@endpush
