@extends('admin.layouts.master')
@section('title', 'Users')
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
                    <h3>Data All Users</h3>
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
                    @endif
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped" id="myTable">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Name</th>
                                    <th>Username</th>
                                    <th>Email</th>
                                    <th>Created at</th>
                                    <th>
                                        <center>Status</center>
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
        <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title" id="myModalLabel33">Form Tambah Data User </h4>
                        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round" class="feather feather-x">
                                <line x1="18" y1="6" x2="6" y2="18"></line>
                                <line x1="6" y1="6" x2="18" y2="18"></line>
                            </svg>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="alert alert-danger d-none"></div>
                        {{-- <div class="alert alert-success d-none"></div> --}}
                        <label>Roles<span class="wajib">*</span>: </label>
                        <div class="form-group">
                            <select id="role" name="role" class="form-control">
                                <option value="">Pilih Role</option>
                                @foreach ($roless as $a)
                                    <option value="{{ ucfirst($a->name) }}">{{ ucfirst($a->name) }}</option>
                                @endforeach
                            </select>
                        </div>
                        
                        <label id="nuptk">NUPTK: </label>
                        <div class="form-group">
                            <input id="nuptk" type="text" name="nuptk" class="form-control" autofocus>
                        </div>

                        <label id="nisn">NISN: </label>
                        <div class="form-group">
                            <input id="nisn" type="text" name="nisn" class="form-control" autofocus>
                        </div>

                        <label>Nama<span class="wajib">*</span>: </label>
                        <div class="form-group">
                            <input id="name" type="text" name="name" class="form-control" autofocus>
                        </div>

                        <label id="santri">Santri: </label>
                        <div class="form-group">
                            <select id="santri_id" name="santri_id" class="form-control">
                                <option value="">Pilih Santri</option>
                                @foreach ($santri as $a)
                                    <option value="{{ $a->id }}">{{ $a->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <label>Username<span class="wajib">*</span>: </label>
                        <div class="form-group">
                            <input id="username" type="text" name="username" class="form-control">
                        </div>

                        <label id="kelas">Kelas: </label>
                        <div class="form-group">
                            <select class="form-control" id="kelas_id" name="kelas_id" name="kelas_id" required>
                                {{-- <input type="hidden" id="old_kelas_id" name="old_kelas_id" value="{{ $users->kelas_id }}"> --}}
                                <option value="">Pilih Kelas</option>
                                @foreach ($kelasOptions as $kelas)
                                    <option value="{{ $kelas->id }}">{{ $kelas->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <label>Email<span class="wajib">*</span>: </label>
                        <div class="form-group">
                            <input id="email" type="text" name="email" class="form-control">
                        </div>

                        <label>No HP: </label>
                        <div class="form-group">
                            <input id="nohp" type="text" name="nohp" class="form-control">
                        </div>

                        <label>Password<span class="wajib">*</span>: </label>
                        <div class="form-group">
                            <input id="password" type="password" name="password" class="form-control pw"
                                placeholder="Biarkan kosong jika tidak ingin diganti">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-light-secondary" data-bs-dismiss="modal">
                            <i class="bx bx-x d-block d-sm-none"></i>
                            <span class="d-none d-sm-block">Close</span>
                        </button>
                        <button type="button" class="btn btn-primary ms-1" data-bs-dismiss="modal">
                            <i class="bx bx-check d-block d-sm-none"></i>
                            <span class="d-none d-sm-block tombol-simpan">Save</span>
                        </button>
                    </div>
                </div>
            </div>
        </div>
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

    @include('admin.user.script')
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
        $(document).ready(function() {
            // Ketika terjadi perubahan pada select dengan id 'role'
            $('#role').change(function() {
                // Reset semua elemen yang mungkin disembunyikan sebelumnya
                resetAllElements();

                var selectedRole = $(this).val()
                    .toLowerCase(); // Mengambil nilai peran yang dipilih dan mengonversi ke huruf kecil

                // Sembunyikan elemen-elemen terkait berdasarkan peran yang dipilih
                if (selectedRole === 'wali santri') {
                    hideElements(['#nisn', '#nuptk', '#kelas_id', '#kelas']);
                    showElements(['#santri_id', '#santri']);
                } else if (selectedRole === 'guru') {
                    hideElements(['#nisn', '#kelas_id', '#kelas', '#santri_id', '#santri']);
                    showElements(['#nuptk']);
                } else if (selectedRole === 'wali kelas') {
                    hideElements(['#nisn', '#santri_id', '#santri']);
                    showElements(['#nuptk', '#kelas_id', '#kelas']);
                } else if (selectedRole === 'user') {
                    hideElements(['#nuptk', '#santri_id', '#santri']);
                    showElements(['#nisn']);
                } else if (selectedRole === 'admin') {
                    hideElements(['#nuptk', '#nisn', '#santri_id', '#santri', '#kelas_id', '#kelas']);
                } else {
                    showElements(['#nuptk', '#nisn', '#kelas_id', '#kelas', '#santri_id', '#santri']);
                }
            });

            // Fungsi untuk menyembunyikan elemen-elemen
            function hideElements(elements) {
                $(elements.join(', ')).closest('.form-group').slideUp(500);
                $(elements.join(', ')).slideUp(500);
            }

            // Fungsi untuk menampilkan kembali elemen-elemen
            function showElements(elements) {
                $(elements.join(', ')).closest('.form-group').slideDown(500);
                $(elements.join(', ')).slideDown(500);
            }

            // Fungsi untuk mereset semua elemen yang mungkin disembunyikan sebelumnya
            function resetAllElements() {
                $('#nisn, #nuptk, #kelas_id, #kelas, #santri_id, #santri').closest('.form-group').slideDown(10);
                $('#nisn, #nuptk, #kelas_id, #kelas, #santri_id, #santri').slideDown(10);
            }
        });
    </script>
@endpush
