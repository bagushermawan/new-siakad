<div class="modal fade" id="statusModal" tabindex="-1" aria-labelledby="statusModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="myModalLabel33">Form Edit Status User </h4>
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
                <div style="display:none;">
                <label>NISN<span class="wajib">*</span>: </label>
                <div class="form-group">
                    <input id="nisnn" type="text" name="nisn" class="form-control" disabled>
                </div>
                <label>NIS<span class="wajib">*</span>: </label>
                <div class="form-group">
                    <input id="niss" type="text" name="nis" class="form-control" disabled>
                </div>
                <label>Tanggal Lahir<span class="wajib">*</span>: </label>
                <div class="form-group">
                    <input id="tanggal_lahirr" type="date" name="tanggal_lahir" class="form-control" disabled>
                </div>
                <label>Kelas: </label>
                <div class="form-group">
                    <select class="form-control" id="kelas_idd" name="kelas_id" disabled>
                        {{-- <input type="hidden" id="old_kelas_id" name="old_kelas_id" value="{{ $users->kelas_id }}"> --}}
                        <option value="">Pilih Kelas</option>
                        @foreach ($kelasOptions as $kelas)
                            <option value="{{ $kelas->id }}">{{ $kelas->name }}</option>
                        @endforeach
                    </select>
                </div>
                <label>Email<span class="wajib">*</span>: </label>
                <div class="form-group">
                    <input id="emaill" type="text" name="email" class="form-control" disabled>
                </div>
                <label>Roles: </label>
                <div class="form-group">
                    <select id="rolee" name="role" class="form-control" disabled>
                        {{-- <option value="">Pilih Role</option> --}}
                            <option value="user" selected>user</option>
                    </select>
                </div>
                <label>Password: </label>
                <div class="form-group">
                    <input id="passwordd" type="password" name="password" class="form-control"
                        placeholder="Password default sama dengan Username">
                </div>
                </div>
                <label>Nama<span class="wajib">*</span>: </label>
                <div class="form-group">
                    <input id="namee" type="text" name="name" class="form-control" disabled>
                </div>
                <label>Username<span class="wajib">*</span>: </label>
                <div class="form-group">
                    <input id="usernamee" type="text" name="username" class="form-control"
                        placeholder="Username default sama dengan nama" disabled>
                </div>
                <label>Status<span class="wajib">*</span>: </label>
                <div class="form-group">
                    <select class="form-control" id="status_siswaa" name="status_siswa" required>
                        {{-- <input type="hidden" id="old_kelas_id" name="old_kelas_id" value="{{ $users->kelas_id }}"> --}}
                        <option value="">Pilih Status</option>
                        <option value="aktif">Aktif</option>
                        <option value="tidak aktif">Tidak Aktif</option>
                        <option value="lulus">Lulus</option>
                        <option value="pindahan">Pindahan</option>
                    </select>
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
