@extends('admin.layouts.master')
@section('title', 'Sidebar Menus')
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
        @keyframes rainbow {

            0%,
            100% {
                background-color: rgba(255, 0, 0, 0.1);
            }

            8% {
                background-color: rgba(255, 127, 0, 0.1);
            }

            16% {
                background-color: rgba(255, 255, 0, 0.1);
            }

            25% {
                background-color: rgba(127, 255, 0, 0.1);
            }

            33% {
                background-color: rgba(0, 255, 0, 0.1);
            }

            41% {
                background-color: rgba(0, 255, 127, 0.1);
            }

            50% {
                background-color: rgba(0, 255, 255, 0.1);
            }

            58% {
                background-color: rgba(0, 127, 255, 0.1);
            }

            66% {
                background-color: rgba(0, 0, 255, 0.1);
            }

            75% {
                background-color: rgba(127, 0, 255, 0.1);
            }

            83% {
                background-color: rgba(255, 0, 255, 0.1);
            }

            91% {
                background-color: rgba(255, 0, 127, 0.1);
            }
        }        .swal2-container.swal2-center.swal2-backdrop-show {
            background-size: 200% 200%, cover, auto;
            animation: rainbow 3s linear infinite;
            background-blend-mode: screen, normal, overlay;
        }
    </style>
@endpush
@section('content')
    <div class="page-heading">
        <div class="page-title">
            <div class="row">
                <div class="col-12 col-md-6 order-md-1 order-last">
                    <h3>Sidebar Menus</h3>
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
                        <div id="totalSidebarMenu" data-total="{{ $total_SidebarMenu }}"></div>
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
                                    <th>Title</th>
                                    <th>Route Name</th>
                                    <th>Icon</th>
                                    <th>Group</th>
                                    <th>Order</th>
                                    <th>Is Submenu</th>
                                    <th>Parent</th>
                                    <th>Roles</th>
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
                        <h4 class="modal-title" id="myModalLabel33">Form Tambah Data Prestasi </h4>
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
                        <label>Title<span class="wajib">*</span>: </label>
                        <div class="form-group">
                            <input id="title" type="text" name="title" class="form-control" autofocus>
                        </div>
                        <label>Route Name: </label>
                        <div class="form-group">
                            <input id="route_name" type="text" name="route_name" class="form-control" autofocus>
                        </div>
                        <label>Icon: </label>
                        <div class="form-group">
                            <input id="icon" type="text" name="icon" class="form-control"
                                placeholder="Contoh: fas fa-stream" autofocus>
                        </div>
                        {{-- <label>Group (Menu Section): </label>
                        <div class="form-group">
                            <input id="group" type="text" name="group" class="form-control" placeholder="Contoh: Menu, Pages, Administrator" autofocus>
                        </div> --}}
                        <div class="mb-3">
                            <label>Group (Menu Section): </label>
                            <select class="form-control" name="group" id="group">
                                <option value="">-- Pilih Menu --</option>
                                @foreach ($list_menu as $menu)
                                    <option value="{{ $menu->title }}">{{ $menu->title }}</option>
                                @endforeach
                            </select>
                            <small class="text-muted">Pilih jika ini submenu</small>
                        </div>
                        <label>Order: </label>
                        <div class="form-group">
                            <input id="order" type="number" name="order" class="form-control" autofocus>
                        </div>
                        <div class="mb-3">
                            <input type="hidden" name="is_submenu" id="is_submenu_hidden" value="0">
                            <input type="checkbox" name="is_submenu" class="form-check-input" id="is_submenu_checkbox"
                                value="1" {{ old('is_submenu') ? 'checked' : '' }}>
                            <label class="form-check-label" for="is_submenu_checkbox">Ini submenu</label>
                        </div>
                        <div class="mb-3">
                            <label>Parent Menu</label>
                            <select class="form-control" name="parent_id" id="parent_id">
                                <option value="">-- Pilih Parent --</option>
                                @foreach ($parents as $parent)
                                    <option value="{{ $parent->id }}">{{ $parent->title }}</option>
                                @endforeach
                            </select>
                            <small class="text-muted">Pilih jika ini submenu</small>
                        </div>
                        <div class="mb-3">
                            <label for="roles">Roles</label>
                            <select name="roles[]" id="roles" class="form-control" multiple>
                                <option value="">-- Pilih Roles --</option>
                                @foreach ($listroles as $role)
                                    <option value="{{ $role }}">{{ $role }}</option>
                                @endforeach
                            </select>
                            <small class="text-muted">Pilih satu atau lebih role</small>
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

    <script src="{{ asset('/extensions/choices.js/public/assets/scripts/choices.min.js') }}"></script>
    @include('admin.sidebar_menu.script')
    {{-- <script>
        // Inisialisasi objek Choices.js baru
        var parent_idSelect = new Choices('#parent_id', {
            searchEnabled: false,
            itemSelectText: '',
            allowHTML: true,
            });
        </script> --}}
    {{-- location.reload(); --}}
@endpush
