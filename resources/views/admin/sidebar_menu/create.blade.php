@extends('admin.layouts.master')
@section('title', 'Sidebar Menu')
@push('page-css')
    <link rel="stylesheet" href="{{ asset('extensions/datatables.net-bs5/css/dataTables.bootstrap5.min.css') }}">


    <link rel="stylesheet" href="{{ asset('compiled/css/table-datatable-jquery.css') }}">
    <link rel="stylesheet" href="{{ asset('/extensions/choices.js/public/assets/styles/choices.css') }}">
    <link rel="stylesheet" href="{{ asset('/extensions/@fortawesome/fontawesome-free/css/all.min.css') }}">
@endpush
@section('content')
    <h1>Tambah Sidebar Menu</h1>

    <form action="{{ route('sidebarmenu.store') }}" method="POST">
        @csrf

        <div class="mb-3">
            <label>Title <span class="text-danger">*</span></label>
            <input type="text" name="title" class="form-control" required value="{{ old('title') }}">
        </div>

        <div class="mb-3">
            <label>Route Name</label>
            <input type="text" name="route_name" class="form-control" value="{{ old('route_name') }}">
            <small class="text-muted">Bisa kosong jika menu induk atau hanya header</small>
        </div>

        <div class="mb-3">
            <label>Icon</label>
            <input type="text" name="icon" class="form-control" value="{{ old('icon') }}">
            <small class="text-muted">Contoh: bi bi-grid-fill</small>
        </div>

        <div class="mb-3">
            <label>Group (Menu Section)</label>
            <input type="text" name="group" class="form-control" value="{{ old('group') }}">
            <small class="text-muted">Contoh: Menu, Pages, Administrator</small>
        </div>

        <div class="mb-3">
            <label>Order <span class="text-danger">*</span></label>
            <input type="number" name="order" class="form-control" required value="{{ old('order', 0) }}">
        </div>

        <div class="mb-3 form-check">
            <input type="checkbox" name="is_submenu" class="form-check-input" id="is_submenu" value="1" {{ old('is_submenu') ? 'checked' : '' }}>
            <label class="form-check-label" for="is_submenu">Ini submenu</label>
        </div>

        <div class="mb-3">
            <label>Parent Menu</label>
            <select name="parent_id" class="form-control">
                <option value="">-- Pilih Parent --</option>
                @foreach($parents as $parent)
                    <option value="{{ $parent->id }}" {{ old('parent_id') == $parent->id ? 'selected' : '' }}>
                        {{ $parent->title }}
                    </option>
                @endforeach
            </select>
            <small class="text-muted">Pilih jika ini submenu</small>
        </div>

        <div class="mb-3">
            <label>Roles (Pisahkan dengan koma)</label>
            <input type="text" name="roles" class="form-control" value="{{ old('roles') }}">
            <small class="text-muted">Contoh: admin,guru</small>
        </div>

        <button type="submit" class="btn btn-primary">Simpan</button>
        <a href="{{ route('sidebarmenu.index') }}" class="btn btn-secondary">Batal</a>
    </form>
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
@endpush

