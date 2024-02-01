@extends('admin.layouts.master')
@section('title', 'Kelas')
@push('page-css')
    <link rel="stylesheet" href="{{ asset('extensions/datatables.net-bs5/css/dataTables.bootstrap5.min.css') }}">


    <link rel="stylesheet" href="{{ asset('compiled/css/table-datatable-jquery.css') }}">
    <link rel="stylesheet" href="{{ asset('/extensions/choices.js/public/assets/styles/choices.css') }}">
    <link rel="stylesheet" href="{{ asset('/extensions/@fortawesome/fontawesome-free/css/all.min.css') }}">
@endpush
@section('content')
    <div class="page-heading">
        <div class="page-title">
            <div class="row">
                <div class="col-12 col-md-6 order-md-1 order-last">
                    <h3>Data Kelas</h3>
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
                        <h6 style="float: left;">
                            <a href="#" class="btn icon icon-left btn-success tombol-tambah"><svg
                                    xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                    fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                    stroke-linejoin="round" class="feather feather-edit">
                                    <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path>
                                    <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path>
                                </svg> Tambah Data</a>
                        </h6>
                        <div id="totalKelas" data-total="{{ $total_kelas }}"></div>
                    @endif
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped" id="myTable">
                            <thead>
                                <tr>
                                    <th class="col-md-1">
                                        <center>No</center>
                                    </th>
                                    <th class="col-md-1">Nama Kelas</th>
                                    <th class="col-md-3">Wali Kelas</th>
                                    <th class="col-md-3">Event/Pengumuman</th>
                                    <th class="col-md-1">
                                        <center>Jumlah</center>
                                    </th>
                                    <th>Created at</th>
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
                        <h4 class="modal-title" id="myModalLabel33">Form Tambah Data Kelas </h4>
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
                        <label>Nama Kelas: </label>
                        <div class="form-group">
                            <input id="name" type="text" name="name" class="form-control" autofocus>
                        </div>

                        <label>Wali Kelas: </label>
                        <div class="form-group">
                            <select id="walikelas_id" name="walikelas_id" class="form-control">
                                <option value="">Pilih Wali Kelas</option>
                                @foreach ($walikelas as $a)
                                    <option value="{{ $a->id }}">{{ $a->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <label>Event/Pengumuman: </label>
                        <div class="form-group">
                            <input id="event" type="text" name="event" class="form-control">
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
        <div class="modal fade" id="santriModal" tabindex="-1" aria-labelledby="santriModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header bg-primary">
                        <h4 class="modal-title white" id="myModalLabel33">Informasi Data Santri </h4>
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
                        <div class="row">
                            <div class="col-8">
                                <div id="santriInfoContent"></div>
                            </div>
                            <div class="col-4">
                                <div class="avatar avatar-2xl" style="display: block;">
                                    <img id="santriPhoto" src="" alt="Foto Santri">
                                </div>
                            </div>
                        </div>
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

    @include('admin.kelas.script')
    <script src="{{ asset('/extensions/choices.js/public/assets/scripts/choices.min.js') }}"></script>
    <script>
    var scrollPosition;
    var baseUrl = "{{ asset('storage/') }}";
    $(document).on('click', '.guru-link', function() {
        // Simpan posisi scroll sebelum membuka modal
        scrollPosition = $(window).scrollTop();
        var guruId = $(this).data('guru-id');

        $.ajax({
            url: '/getWaliKelasInfo/' + guruId, // Correct the URL to match the server-side route
            method: 'GET',
            dataType: 'json',
            success: function(guruInfo) { // Correct the variable name to guruInfo
                // Menampilkan informasi guru di dalam modal
                $('#santriInfoContent').html(
                    'NUPTK: ' + guruInfo.nuptk +
                    '<br>Nama: ' + guruInfo.name +
                    '<br>Username: ' + guruInfo.username +
                    '<br>Email: ' + guruInfo.email +
                    '<br>No HP: ' + guruInfo.nohp
                );
                // Set nilai foto_user
                var fotoUser = guruInfo.foto_user ? baseUrl + '/' + guruInfo.foto_user : '{{ asset('compiled/jpg/1.jpg') }}';
                $('#santriPhoto').attr('src', fotoUser);
                $('#santriModal').modal('show');
            },
            error: function(xhr, status, error) {
                console.error('Error fetching guru info:', error);
            }
        });
    });
    $('#santriModal').on('hidden.bs.modal', function() {
        // Kembalikan posisi scroll setelah menutup modal
        $(window).scrollTop(scrollPosition);
    });
</script>
@endpush
