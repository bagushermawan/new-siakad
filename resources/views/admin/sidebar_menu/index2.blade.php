@extends('admin.layouts.master')
@section('title', 'Sidebar Menu')
@push('page-css')
    <link rel="stylesheet" href="{{ asset('extensions/datatables.net-bs5/css/dataTables.bootstrap5.min.css') }}">


    <link rel="stylesheet" href="{{ asset('compiled/css/table-datatable-jquery.css') }}">
    <link rel="stylesheet" href="{{ asset('/extensions/choices.js/public/assets/styles/choices.css') }}">
    <link rel="stylesheet" href="{{ asset('/extensions/@fortawesome/fontawesome-free/css/all.min.css') }}">
@endpush
{{-- @php
    dd($menus->keys());
@endphp --}}
{{-- @section('content')
    <h1>Sidebar Menus</h1>
    <a href="{{ route('sidebar-menu.create') }}" class="btn btn-primary mb-3">Tambah Menu</a>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Title</th>
                <th>Route Name</th>
                <th>Icon</th>
                <th>Group</th>
                <th>Order</th>
                <th>Is Submenu</th>
                <th>Parent</th>
                <th>Roles</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($menus as $menu)
            <tr>
                <td>{{ $menu->title }}</td>
                <td>{{ $menu->route_name }}</td>
                <td>{{ $menu->icon }}</td>
                <td>{{ $menu->group }}</td>
                <td>{{ $menu->order }}</td>
                <td>{{ $menu->is_submenu ? 'Yes' : 'No' }}</td>
                <td>{{ $menu->parent ? $menu->parent->title : '-' }}</td>
                <td>{{ $menu->roles }}</td>
                <td>
                    <a href="{{ route('sidebar-menu.edit', $menu) }}" class="btn btn-sm btn-warning">Edit</a>

                    <form action="{{ route('sidebar-menu.destroy', $menu) }}" method="POST" style="display:inline-block" onsubmit="return confirm('Hapus menu ini?')">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-sm btn-danger">Hapus</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
@endsection --}}
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
@endpush

