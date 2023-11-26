@extends('admin.layouts.master')
@section('title', 'Dashboard')
@push('page-css')
    <link rel="stylesheet" href="{{ asset('extensions/datatables.net-bs5/css/dataTables.bootstrap5.min.css') }}">


  <link rel="stylesheet" href="{{ asset('compiled/css/table-datatable-jquery.css') }}">
@endpush
@section('content')
    <div class="page-heading">
        <div class="page-title">
            <div class="row">
                <div class="col-12 col-md-6 order-md-1 order-last">
                    <h3>Data User</h3>
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
                        Simple Datatable
                    </h5>
                </div>
                <div class="card-body">
                    <table class="table table-striped" id="table1">
                        <thead>
                            <tr>
                                <th>
                                    <center>No</center>
                                </th>
                                <th>Nama</th>
                                <th>Username</th>
                                <th>Email</th>
                                <th>Created At</th>
                                @if (auth()->user()->hasRole('admin'))
                                    <th>Status</th>
                                    <th>
                                        <center>Action</center>
                                    </th>
                                @endif
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($daftar_user as $no => $user)
                                <tr role="row" class="even">
                                    <td>
                                        <center>
                                            {{ ++$no }}
                                        </center>
                                    </td>
                                    <td>{{ $user->name }}</td>
                                    <td>{{ $user->username }}</td>
                                    <td>{{ $user->email }}</td>

                                    {{-- <td>{{$user->password}}</td> --}}
                                    <td class="text-right">
                                        {{ $user->created_at->format('d M Y, H:i') }}
                                    </td>
                                    @if (auth()->user()->hasRole('admin'))
                                        <td>{{ ucfirst(implode(', ', $user->roles->pluck('name')->all())) }}</td>
                                    <td>
                                        <center>
                                            <a href="{{ route('admin.user.edit', $user->id) }}" class="badge bg-primary">Edit</a> | 
                                            <a href="{{ route('admin.user.destroy', $user->id) }}" class="badge bg-danger">Delete</a>
                                        </center>
                                    </td>
                                    @endif
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
<script src="{{ asset('static/js/pages/datatables.js') }}"></script>
@endpush
