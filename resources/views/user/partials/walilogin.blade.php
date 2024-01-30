<div class="row">
    <div class="col-12 col-lg-5">
        <div class="card">
            <div class="card-header">
                <div class="card-title">
                    <h4>Informasi Data Santri Anda</h4>
                </div>
            </div>
            <div class="d-flex justify-content-center align-items-center flex-column">
                <div class="avatar avatar-xl">
                    @if ($fotoSantri != '')
                        <img src="{{ asset('storage/' . $fotoSantri) }}" alt="Avatar" id="fotoPondok">
                    @else
                        <img src="{{ asset('/compiled/jpg/1.jpg') }}" alt="Avatar">{{ $fotoSantri }}
                    @endif
                </div>
            </div>
            <div class="table-responsive" style="margin-top: 3rem;">
                <table class="table table-borderless table-lg">
                    <tbody>
                        <tr>
                            <td class="col-4">
                                <div class="d-flex align-items-center">
                                    <p class="font-bold h6 mb-0">NISN</p>
                                </div>
                            </td>
                            <td class="col-auto">
                                <p class=" mb-0">
                                    @if ($nisnSantri != null)
                                        <span class="profilepp" style="margin-left: 1rem">
                                            : {{ $nisnSantri }}
                                        </span>
                                    @else
                                        <span class="profilepp2" style="margin-left: 1rem">
                                            : <i>Santri belum input NISN</i>
                                        </span>
                                    @endif
                                </p>
                            </td>
                        </tr>
                        <tr>
                            <td class="col-4">
                                <div class="d-flex align-items-center">
                                    <p class="font-bold h6 mb-0">Nama Santri</p>
                                </div>
                            </td>
                            <td class="col-auto">
                                <p class=" mb-0">
                                    <span class="profilepp" style="margin-left: 1rem">
                                        : {{ $namaSantri }}
                                    </span>
                                </p>
                            </td>
                        </tr>
                        <tr>
                            <td class="col-4">
                                <div class="d-flex align-items-center">
                                    <p class="font-bold h6 mb-0">Username Santri</p>
                                </div>
                            </td>
                            <td class="col-auto">
                                <p class=" mb-0">
                                    <span class="profilepp" style="margin-left: 1rem">
                                        : {{ $usernameSantri }}
                                    </span>
                                </p>
                            </td>
                        </tr>
                        <tr>
                            <td class="col-4">
                                <div class="d-flex align-items-center">
                                    <p class="font-bold h6 mb-0">Kelas Santri</p>
                                </div>
                            </td>
                            <td class="col-auto">
                                <p class=" mb-0">
                                    @if ($kelasSantri != null)
                                        <span class="profilepp" style="margin-left: 1rem">
                                            : {{ $kelasSantri }}
                                        </span>
                                    @else
                                        <span class="profilepp2" style="margin-left: 1rem">
                                            : <i>Santri belum input kelas</i>
                                        </span>
                                    @endif
                                </p>
                            </td>
                        </tr>
                        <tr>
                            <td class="col-4">
                                <div class="d-flex align-items-center">
                                    <p class="font-bold h6 mb-0">Telepon Santri</p>
                                </div>
                            </td>
                            <td class="col-auto">
                                <p class=" mb-0">
                                    @if ($nohpSantri != null)
                                        <span class="profilepp" style="margin-left: 1rem">
                                            : {{ $nohpSantri }}
                                        </span>
                                    @else
                                        <span class="profilepp2" style="margin-left: 1rem">
                                            : <i>Santri belum input nomor HP</i>
                                        </span>
                                    @endif
                                </p>
                            </td>
                        </tr>
                        <tr>
                            <td class="col-4">
                                <div class="d-flex align-items-center">
                                    <p class="font-bold h6 mb-0">Email Santri</p>
                                </div>
                            </td>
                            <td class="col-auto">
                                <p class=" mb-0"><span class="profilepp" style="margin-left: 1rem">:
                                        {{ $emailSantri }}</span>
                                </p>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    {{-- nilai --}}
    <div class="col-12 col-lg-7">
        <div class="card">
            <div class="card-header">
                <button id="generateRaportButton" class="btn btn-primary">Generate Raport</button>
                <div class="card-title">
                    <h6 class="d-flex justify-content-between align-items-center">
                        {{-- <span>Tahun Ajaran: <b>{{ $thaktif->name }}</b></span> --}}
                        <div class="">Tahun Ajaran:
                            <select class="" id="filterAllTahunAjaran">
                                <option value="">Semua</option>
                            </select>
                        </div>
                        <div class="ml-auto">Semester:
                            <select class="" id="filterSemester">
                                <option value="">Semua</option>
                            </select>
                        </div>
                    </h6>

                    <h6 class="d-flex justify-content-between align-items-center">
                        <div class=""></div>
                        <div class="ml-auto">Semester:
                            <select class="" id="filterKelas">
                                <option value="">Semua</option>
                            </select>
                        </div>
                    </h6>
                </div>
            </div>
            <div class="table-responsive" id="tebel">
                <table class="table table-hover" id="myTable">
                    {{-- isi nilai santri --}}
                </table>
                <a onclick="refreshDataTable();"
                    class="btn icon icon-left d-flex justify-content-center align-items-center">
                    <span id="refreshText" style="color: rgb(142, 158, 216)">REFRESH</span>
                    <i id="refreshIcon" class="fas fa-sync fa-spin d-none"></i>
                </a>
            </div>
        </div>
    </div>
</div>
