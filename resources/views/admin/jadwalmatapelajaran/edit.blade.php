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
                    <h4 class="card-title">Form Edit Permission</h4>
                </div>
                <div class="card-content">
                    <div class="card-body">
                        <form method="POST" action="{{ route('permission.update', $permission->id) }}">
                            @method('PATCH')
                            @csrf
                            <div class="form-body">
                                <div class="row">
                                    <div class="col-12">
                                        <div class="form-group">
                                            <label for="first-name-vertical">Nama Permission:</label>
                                            <input type="text" class="form-control" name="name"
                                                value="{{ $permission->name }}" autofocus>
                                        </div>
                                    </div>
                                    <div class="col-12 d-flex justify-content-end">
                                        <a href="{{ route('permission.index') }}" class="btn btn-light me-1 mb-1">Back</a>
                                        <button type="reset" class="btn btn-light-secondary me-1 mb-1">Reset</button>
                                        <button type="submit" class="btn btn-success me-1 mb-1">Save</button>
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
