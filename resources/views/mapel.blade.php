<div class="main-content">
    <section class="section">
        <div class="section-header">
            <div class="section-header-back">
                <a href="{{ url('home/dashboard') }}" class="btn btn-icon"><i class="fas fa-arrow-left"></i></a>
            </div>
            <h1>Mata Pelajaran</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="{{ url('home/dashboard') }}">Dashboard</a></div>
                <div class="breadcrumb-item active"><a href="{{ url('home/mapel') }}">Mata Pelajaran</a></div>
            </div>
        </div>

        <div class="col-lg-7 col-md-12 col-12 col-sm-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <div>
                        <h4>Data Mata Pelajaran</h4>
                    </div>
                    <div>
                        <!-- Button to Open the Modal for Adding Mapel -->
                        <button type="button" class="btn btn-success" data-toggle="modal" data-target="#tambahMapelModal">
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
                                    <th scope="col">Nama Mata Pelajaran</th>
                                    <th scope="col">Aksi</th>
                                </tr>
                            </thead>
                            <tbody id="tableBody">
                                @php $no = 1; @endphp
                                @foreach($mapels as $mapel)
                                    <tr>
                                        <td>{{ $no++ }}</td>
                                        <td>{{ $mapel->nama_mapel }}</td>
                                        <td>
                                            <!-- Edit Button triggers Edit Modal -->
                                            <button type="button" 
                                                    class="btn btn-primary btn-action mr-1" 
                                                    data-toggle="modal" 
                                                    data-target="#editMapelModal" 
                                                    onclick="populateEditModal('{{ $mapel->id_mapel }}', '{{ $mapel->nama_mapel }}')">
                                                <i class="fas fa-pencil-alt"></i>
                                            </button>

                                            <!-- Delete Button -->
                                            <a href="{{ url('home/hapus_mapel/'.$mapel->id_mapel) }}" 
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

<!-- Modal for Adding Mapel -->
<div class="modal fade" id="tambahMapelModal" tabindex="-1" role="dialog" aria-labelledby="tambahMapelModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="tambahMapelModalLabel">Tambah Mata Pelajaran</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{ url('home/post_aksi_t_mapel') }}" method="POST">
                    @csrf
                    <div class="form-group">
                        <label for="nama_mapel">Nama Mata Pelajaran</label>
                        <input type="text" class="form-control" name="nama_mapel" id="nama_mapel" required>
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

<!-- Modal for Editing Mapel -->
<div class="modal fade" id="editMapelModal" tabindex="-1" role="dialog" aria-labelledby="editMapelModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editMapelModalLabel">Edit Mata Pelajaran</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ url('home/post_aksi_e_mapel') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <input type="hidden" name="id" id="editMapelId">
                    <div class="form-group">
                        <label for="editNamaMapel">Nama Mata Pelajaran</label>
                        <input type="text" class="form-control" name="nama_mapel" id="editNamaMapel" required>
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

<!-- Script for table search filter and populating edit modal -->
<script>
    $(document).ready(function() {
        // Filter table function
        $('#searchInput').on('keyup', function() {
            var filter = $(this).val().toLowerCase();
            $('#tableBody tr').filter(function() {
                $(this).toggle($(this).text().toLowerCase().indexOf(filter) > -1);
            });
        });
    });

    // Populate Edit Modal function
    function populateEditModal(id, nama_mapel) {
        $('#editMapelId').val(id);
        $('#editNamaMapel').val(nama_mapel);
    }
</script>
