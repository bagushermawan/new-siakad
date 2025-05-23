@extends('admin.layouts.master')
@section('title', 'Siswa')
@push('page-css')
    <link rel="stylesheet" href="{{ asset('extensions/datatables.net-bs5/css/dataTables.bootstrap5.min.css') }}">


    <link rel="stylesheet" href="{{ asset('compiled/css/table-datatable-jquery.css') }}">
    <link rel="stylesheet" href="{{ asset('/extensions/choices.js/public/assets/styles/choices.css') }}">
    <link rel="stylesheet" href="{{ asset('/extensions/@fortawesome/fontawesome-free/css/all.min.css') }}">
    <style>
        .wajib {
            color: #dc3545;
        }

        .form-control.pw::placeholder {
            color: #495057 !important;
        }
    </style>
@endpush
@section('content')
    <div class="page-heading">
        <div class="page-title">
            <div class="row">
                <div class="col-12 col-md-6 order-md-1 order-last">
                    <h3>Data Siswa</h3>
                    <p class="text-subtitle text-muted">A sortable, searchable, paginated table without dependencies thanks
                        to simple-datatables.</p>
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
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title">
                        Ajax CRUD Datatables
                    </h5>
                    @if (auth()->user()->hasRole('admin'))
                        <h6>
                            <a href="#" class="btn icon icon-left btn-success tombol-tambah"><svg
                                    xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                    fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                    stroke-linejoin="round" class="feather feather-edit">
                                    <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path>
                                    <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path>
                                </svg> Tambah Data</a>
                        </h6>
                        <div id="totalSantri" data-total="{{ $totalSantri }}"></div>
                    @endif
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped" id="myTable">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    {{-- <th>id</th> --}}
                                    <th>NISN</th>
                                    <th>NIS</th>
                                    <th>Name</th>
                                    <th>Username</th>
                                    <th>No HP</th>
                                    <th>Tanggal Lahir</th>
                                    <th>Kelas</th>
                                    <th>Status</th>
                                    <th>
                                        <center>Roles</center>
                                    </th>
                                    <th>
                                        Foto User
                                    </th>
                                    <th>
                                        <center>Action</center>
                                    </th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </section>
        {{-- Add/Edit Modal --}}
        @include('admin.user.siswa.addedit')
        {{-- No Status Modal --}}
        @include('admin.user.siswa.nostatus')
        {{-- No Status Modal --}}
        @include('admin.user.siswa.xnohp')
    </div>
@endsection
@push('page-script')
    <script src="{{ asset('extensions/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('extensions/datatables.net/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('extensions/datatables.net-bs5/js/dataTables.bootstrap5.min.js') }}"></script>
    <script src="{{ asset('extensions/datatables.net/js/dataTables.buttons.min.js') }}"></script>
    <script src="{{ asset('extensions/datatables.net/js/jszip.min.js') }}"></script>
    <script src="{{ asset('extensions/datatables.net/js/pdfmake.min.js') }}"></script>
    <script src="{{ asset('extensions/datatables.net/js/vfs_fonts.js') }}"></script>
    <script src="{{ asset('extensions/datatables.net/js/buttons.html5.min.js') }}"></script>
    <script src="{{ asset('extensions/datatables.net/js/buttons.print.min.js') }}"></script>

    @include('admin.user.siswa.script')
    <script src="{{ asset('/extensions/choices.js/public/assets/scripts/choices.min.js') }}"></script>
    <script>
        // Inisialisasi objek Choices.js baru
        var roleSelect = new Choices('#role', {
            searchEnabled: false,
            itemSelectText: '',
            allowHTML: true,
        });
    </script>
    <script>
        document.getElementById("name").addEventListener("input", function() {
            var nameValue = this.value.trim().toLowerCase();
            var usernameInput = document.getElementById("username");
            var cleanedName = nameValue.replace(/\W+/g, '');
            var nameParts = cleanedName.split(' ');
            var usernameValue = nameParts[0];
            if (nameParts.length > 1) {
                usernameValue += nameParts[1];
            }
            usernameInput.value = usernameValue;
        });
    </script>
@endpush
