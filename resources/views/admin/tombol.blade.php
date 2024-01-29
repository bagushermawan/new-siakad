<center>
    <a href='#' data-id="{{ $data->id }}" data-user-type="{{ $data->user_type }}" class="badge bg-primary tombol-edit">Edit</a> |
    <a href='#' data-id="{{ $data->id }}" data-user-type="{{ $data->user_type }}" data-name="{{ $data->name }}" class="badge bg-danger tombol-del">Del</a>
    @if (auth()->user()->hasRole('admin') && in_array(request()->route()->getName(), ['userAjax.index']))
    | <a href='#' data-id="{{ $data->id }}" data-user-type="{{ $data->user_type }}" data-name="{{ $data->name }}" class="badge bg-success tombol-login">Login <i class="bi bi-box-arrow-in-right"></i></a>
    @endif
</center>
