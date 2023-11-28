@extends('admin.layouts.master')
@section('title', 'Permission')
@push('page-css')
    <link rel="stylesheet" href="{{ asset('extensions/datatables.net-bs5/css/dataTables.bootstrap5.min.css') }}">


    <link rel="stylesheet" href="{{ asset('compiled/css/table-datatable-jquery.css') }}">
    <script></script>
@endpush
@section('content')
    <div class="page-heading">
        <div class="page-title">
            <div class="row">
                <div class="col-12 col-md-6 order-md-1 order-last">
                    <h3>Data Permission</h3>
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
                        Tabel Permission
                    </h5>
                    @if (auth()->user()->hasRole('admin'))
                        <h6>
                            <a href="{{ route('permission.create') }}"
                                class="btn icon icon-left btn-success tombol-tambah"><svg xmlns="http://www.w3.org/2000/svg"
                                    width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                    class="feather feather-edit">
                                    <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path>
                                    <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path>
                                </svg> Tambah Data</a>
                        </h6>
                    @endif
                </div>
                <div class="card-body">
                    <table class="table table-striped" id="myTable">
                        <thead>
                            <tr>
                                <th class="col-md-1">
                                    <center>No</center>
                                </th>
                                <th class="col-md-8">Name</th>
                                <th>
                                    <center>Created at</center>
                                </th>
                                <th>
                                    <center>Action</center>
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($daftar_permission as $a)
                                <tr>
                                    <td>
                                        <center>
                                            {{ $loop->iteration }}
                                        </center>
                                    </td>
                                    <td>{{ $a->name }}</td>
                                    <td>
                                        <center>{{ date('Y-m-d h:i A', strtotime($a->created_at)) }}</center>
                                    </td>
                                    <td>
                                        <center>
                                            <a
                                                href='{{ route('permission.edit', ['permission' => $a->id]) }}'class="badge bg-primary tombol-edit">Edit</a>
                                            |
                                            <a href="{{ route('permission.destroy', ['permission' => $a->id]) }}"
                                                class="badge bg-danger tombol-del"
                                                onclick="event.preventDefault(); document.getElementById('delete-form-{{ $a->id }}').submit();">
                                                Delete
                                            </a>
                                            <form id="delete-form-{{ $a->id }}"
                                                action="{{ route('permission.destroy', ['permission' => $a->id]) }}"
                                                method="POST" style="display: none;">
                                                @csrf
                                                @method('DELETE')
                                            </form>
                                        </center>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </section>
    </div>
@endsection
@push('page-script')
    <script src="{{ asset('extensions/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('extensions/datatables.net/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('extensions/datatables.net-bs5/js/dataTables.bootstrap5.min.js') }}"></script>
    @include('admin.permission.script')
@endpush
