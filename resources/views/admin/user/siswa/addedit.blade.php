<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="myModalLabel33">Form Tambah Data User </h4>
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
                <label>NISN<span class="wajib">*</span>: </label>
                <div class="form-group">
                    <input id="nisn" type="text" name="nisn" class="form-control" autofocus>
                </div>
                <label>NIS<span class="wajib">*</span>: </label>
                <div class="form-group">
                    <input id="nis" type="text" name="nis" class="form-control" autofocus>
                </div>
                <label>Nama<span class="wajib">*</span>: </label>
                <div class="form-group">
                    <input id="name" type="text" name="name" class="form-control" autofocus>
                </div>
                <label>Username<span class="wajib">*</span>: </label>
                <div class="form-group">
                    <input id="username" type="text" name="username" class="form-control"
                        placeholder="Username default sama dengan nama">
                </div>
                <label>No Handphone<span class=""></span>: </label>
                <div class="form-group">
                    <input id="nohp" type="number" name="nohp" class="form-control"
                        placeholder="08xxx">
                </div>
                <label>Tanggal Lahir<span class="wajib">*</span>: </label>
                <div class="form-group">
                    <input id="tanggal_lahir" type="date" name="tanggal_lahir" class="form-control">
                </div>
                <label>Kelas: </label>
                <div class="form-group">
                    <select class="form-control" id="kelas_id" name="kelas_id" required>
                        {{-- <input type="hidden" id="old_kelas_id" name="old_kelas_id" value="{{ $users->kelas_id }}"> --}}
                        <option value="">Pilih Kelas</option>
                        @foreach ($kelasOptions as $kelas)
                            <option value="{{ $kelas->id }}">{{ $kelas->name }}</option>
                        @endforeach
                    </select>
                </div>
                <label>Status<span class="wajib">*</span>: </label>
                <div class="form-group">
                    <select class="form-control" id="status_siswa" name="status_siswa" required>
                        {{-- <input type="hidden" id="old_kelas_id" name="old_kelas_id" value="{{ $users->kelas_id }}"> --}}
                        <option value="">Pilih Status</option>
                        <option value="aktif">Aktif</option>
                        <option value="tidak aktif">Tidak Aktif</option>
                        <option value="lulus">Lulus</option>
                        <option value="pindahan">Pindahan</option>
                    </select>
                </div>
                <label>Email<span class="wajib">*</span>: </label>
                <div class="form-group">
                    <input id="email" type="text" name="email" class="form-control">
                </div>
                {{-- <label>No HP: </label>
                <div class="form-group">
                    <input id="nohp" type="text" name="nohp" class="form-control">
                </div> --}}
                <label>Roles: </label>
                <div class="form-group">
                    <select id="role" name="role" class="form-control">
                        {{-- <option value="">Pilih Role</option> --}}
                        @if (count($roless) >= 2)
                            <option value="{{ $roless[3]->name }}" selected>{{ ucfirst($roless[3]->name) }}
                            </option>
                        @endif
                    </select>
                </div>

                <label>Password: </label>
                <div class="form-group">
                    <input id="password" type="password" name="password" class="form-control"
                        placeholder="Password default sama dengan Username">
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
