@extends('admin.layouts.master')
@section('title', 'Role')
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
                    <h3>Data Role</h3>
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
                    <h4 class="card-title">Form Add Role</h4>
                </div>
                <div class="card-content">
                    <div class="card-body">
                        <form action="{{ route('role.store') }}" method="POST" class="form form-vertical">
                            @csrf
                            <div class="form-body">
                                <div class="row">
                                    <div class="col-12">
                                        <div class="form-group has-icon-left">
                                            <label>Nama Role:</label>
                                            <div class="position-relative">
                                                <input type="text" class="form-control" name="name" autofocus>
                                                <div class="form-control-icon">
                                                    <i class="bi bi-person"></i>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="list-group">
                                            <br>
                                            @php
                                                $categoryMappings = [
                                                    'user' => 'User Permission',
                                                    'kelas' => 'Kelas Permission',
                                                    // ... tambahkan mapping lain sesuai kebutuhan
                                                ];

                                                $permissionsByCategory = [];

                                                foreach ($permission as $value) {
                                                    $prefix = explode('-', $value->name)[1]; // Ambil awalan sebagai prefix
                                                    $category = isset($categoryMappings[$prefix]) ? $categoryMappings[$prefix] : $prefix;

                                                    if (!isset($permissionsByCategory[$category])) {
                                                        $permissionsByCategory[$category] = [];
                                                    }

                                                    $permissionsByCategory[$category][] = $value;
                                                }
                                            @endphp

                                            @foreach ($permissionsByCategory as $category => $categoryPermissions)
                                                <div class="row">
                                                    <div class="col-6">
                                                        <div class="list-group-item">
                                                            <h5>{{ $category }}</h5>
                                                            @foreach ($categoryPermissions as $value)
                                                                <label>
                                                                    <input type="checkbox" name="permission[]"
                                                                        value="{{ $value->name }}"
                                                                        class="form-check-input">
                                                                    {{ $value->name }}
                                                                </label>
                                                                <br>
                                                            @endforeach
                                                        </div>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                    <div class="col-12 d-flex justify-content-end">
                                        <a href="{{ route('role.index') }}" class="btn btn-light me-1 mb-1">Back</a>
                                        <button type="reset" class="btn btn-light-secondary me-1 mb-1">Reset</button>
                                        <button type="submit" class="btn btn-primary me-1 mb-1">Submit</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection
