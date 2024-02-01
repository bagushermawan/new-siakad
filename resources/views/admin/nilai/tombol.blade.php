<div class="btn-group mb-1">
    <div class="dropdown">
        <div class="btn-group">
            <button class="btn btn-primary btn-sm dropdown-toggle me-1" type="button" id="dropdownMenuButtonIcon"
                data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <i class="bi bi-error-circle me-50"></i> Action
            </button>
            <div class="dropdown-menu" aria-labelledby="dropdownMenuButtonIcon" style="">
                <a class="dropdown-item tombol-edit" href="#" data-id="{{ $data->id }}">Edit</a>
                <a class="dropdown-item tombol-del" href="#" data-id="{{ $data->id }}" data-name="{{ $data->name }}">Delete</a>
            </div>
        </div>
    </div>
</div>
