<div class="col-7">
                        <div class="card">
                            <div class="card-header">
                                <div class="card-title">
                                    <h4>Hubungkan Santri</h4>
                                </div>
                            </div>
                            <div class="d-flex justify-content-center align-items-center flex-column">
                                <div class="avatar avatar-3xl">
                                    <img src="{{ asset('compiled/svg/addsantri.svg') }}" alt="Avatar" id="fotoPondok">
                                </div>
                            </div>
                            <div class="card-body">
                                <form method="post" action="{{ route('search-santri') }}">
                                    @csrf
                                    <h6>Username:</h6>
                                    <div class="form-group position-relative has-icon-left">
                                        <input type="text" class="form-control" name="username"
                                            placeholder="Masukkan Username Santri">
                                        <div class="form-control-icon">
                                            <i class="fas fa-at"></i>
                                        </div>
                                    </div>

                                    <h6>No HP:</h6>
                                    <div class="form-group position-relative has-icon-left">
                                        <input type="number" class="form-control" name="nohp"
                                            placeholder="Masukkan No.HP Santri">
                                        <div class="form-control-icon">
                                            <i class="fas fa-mobile-alt"></i>
                                        </div>
                                    </div>
                                    <code>Pastikan siswa sudah memiliki akun dan terhubung dengan sekolah</code>
                                    @if (session('error'))
                                        <div class="alert alert-danger alert-dismissible fade show">
                                            {{ session('error') }}
                                            <button type="button" class="btn-close" data-bs-dismiss="alert"
                                                aria-label="Close"></button>
                                        </div>
                                    @endif
                                    <div class="form-group position-relative">
                                        <button class="form-control btn btn-primary" type="submit">SEARCH</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
