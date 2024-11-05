<div class="main-content">
    <section class="section">
        <div class="section-header">
            <div class="section-header-back">
                <a href="{{ url('home/dashboard') }}" class="btn btn-icon"><i class="fas fa-arrow-left"></i></a>
            </div>
            <h1>Absensi</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="{{ url('home/dashboard') }}">Dashboard</a></div>
                <div class="breadcrumb-item active"><a href="{{ url('home/absensi') }}">Absensi</a></div>
            </div>
        </div>

        <div class="col-lg-12 col-md-12 col-12 col-sm-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <div>
                        <h4>Absensi</h4>
                    </div>
                    <div>
                        <!-- Button to Open the Modal for Adding Absensi -->
                        <button type="button" class="btn btn-success" data-toggle="modal" data-target="#tambahAbsensiModal">
                            <i class="fas fa-plus"></i> Tambah
                        </button>
                    </div>
                    <div class="ml-auto">
                        <form class="form-inline">
                            <input id="searchInput" class="form-control mr-sm-2" type="search" placeholder="Search" aria-label="Search">
                        </form>
                    </div>
                </div>

                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-striped mb-0">
                            <thead>
                                <tr>
                                    <th scope="col">No</th>
                                    <th scope="col">Siswa</th>
                                    <th scope="col">Tanggal</th>
                                    <th scope="col">Status Absensi</th>
                                    <th scope="col">Pokok Bahasan</th>
                                    <th scope="col">Metode Pengajaran</th>
                                    <th scope="col">Aksi</th>
                                </tr>
                            </thead>
                            <tbody id="tableBody">
                                @php $no = 1; @endphp
                                @foreach($absensi as $abs)
                                    <tr>
                                        <td>{{ $no++ }}</td>
                                        <td>{{ $abs->username }}</td>
                                        <td>{{ $abs->tanggal }}</td> <!-- Asumsikan Anda menghubungkan id_siswa dengan nama siswa -->
                                        <td>{{ $abs->status_absensi }}</td>
                                        <td>{{ $abs->pokok_bahasan }}</td>
                                        <td>{{ $abs->metode_pengajaran }}</td>
                                        <td>
                                            <!-- Edit Button triggers Edit Modal -->
                                            <button type="button" 
                                                    class="btn btn-primary btn-action mr-1" 
                                                    data-toggle="modal" 
                                                    data-target="#editAbsensiModal" 
                                                    onclick="populateEditModal('{{ $abs->id_absensi }}', '{{ $abs->tanggal }}', '{{ $abs->id_siswa }}', '{{ $abs->status_absensi }}', '{{ $abs->pokok_bahasan }}', '{{ $abs->metode_pengajaran }}')">
                                                <i class="fas fa-pencil-alt"></i>
                                            </button>

                                            <!-- Delete Button -->
                                            <a href="{{ url('home/hapus_absensi/'.$abs->id_absensi) }}" 
                                                class="btn btn-danger btn-action" 
                                                data-toggle="tooltip" 
                                                title="Delete">
                                                <i class="fas fa-trash"></i>
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

<!-- Modal for Adding Absensi -->
<div class="modal fade" id="tambahAbsensiModal" tabindex="-1" role="dialog" aria-labelledby="tambahAbsensiModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="tambahAbsensiModalLabel">Tambah Absensi</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{ url('home/post_aksi_t_absensi') }}" method="POST">
                    @csrf
                    <div class="form-group">
                        <label for="tanggal">Tanggal</label>
                        <input type="date" class="form-control" name="tanggal" id="tanggal" required>
                    </div>
                    <div class="form-group">
                        <label for="id_siswa">Siswa</label>
                        <select class="form-control" name="id_siswa" id="id_siswa" required>
                            @foreach($siswa as $s)
                                <option value="{{ $s->id_user }}">{{ $s->username }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="status_absensi">Status Absensi</label>
                        <select class="form-control" name="status_absensi" id="status_absensi" required>
                            <option value="Hadir">Hadir</option>
                            <option value="Sakit">Sakit</option>
                            <option value="Izin">Izin</option>
                            <option value="Alpha">Alpha</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="pokok_bahasan">Pokok Bahasan</label>
                        <input type="text" class="form-control" name="pokok_bahasan" id="pokok_bahasan" required>
                    </div>
                    <div class="form-group">
                        <label for="metode_pengajaran">Metode Pengajaran</label>
                        <input type="text" class="form-control" name="metode_pengajaran" id="metode_pengajaran" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Submit</button>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal for Editing Absensi -->
<div class="modal fade" id="editAbsensiModal" tabindex="-1" role="dialog" aria-labelledby="editAbsensiModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editAbsensiModalLabel">Edit Absensi</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ url('home/post_aksi_e_absensi') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <input type="hidden" name="id" id="editAbsensiId">
                    <div class="form-group">
                        <label for="editTanggal">Tanggal</label>
                        <input type="date" class="form-control" name="tanggal" id="editTanggal" required>
                    </div>
                    <div class="form-group">
                        <label for="editIdSiswa">Siswa</label>
                        <select class="form-control" name="id_siswa" id="editIdSiswa" required>
                            @foreach($siswa as $s)
                                <option value="{{ $s->id_user }}">{{ $s->username }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="editStatusAbsensi">Status Absensi</label>
                        <select class="form-control" name="status_absensi" id="editStatusAbsensi" required>
                            <option value="Hadir">Hadir</option>
                            <option value="Sakit">Sakit</option>
                            <option value="Izin">Izin</option>
                            <option value="Alpha">Alpha</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="editPokokBahasan">Pokok Bahasan</label>
                        <input type="text" class="form-control" name="pokok_bahasan" id="editPokokBahasan" required>
                    </div>
                    <div class="form-group">
                        <label for="editMetodePengajaran">Metode Pengajaran</label>
                        <input type="text" class="form-control" name="metode_pengajaran" id="editMetodePengajaran" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Submit</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Script for populating edit modal -->
<script>
    function populateEditModal(id, tanggal, id_siswa, status_absensi, pokok_bahasan, metode_pengajaran) {
        $('#editAbsensiId').val(id);
        $('#editTanggal').val(tanggal);
        $('#editIdSiswa').val(id_siswa);
        $('#editStatusAbsensi').val(status_absensi);
        $('#editPokokBahasan').val(pokok_bahasan);
        $('#editMetodePengajaran').val(metode_pengajaran);
    }
</script>