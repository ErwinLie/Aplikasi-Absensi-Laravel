<div class="main-content">
    <section class="section">
        <div class="section-header">
            <div class="section-header-back">
                <a href="{{ url('home/dashboard') }}" class="btn btn-icon"><i class="fas fa-arrow-left"></i></a>
            </div>
            <h1>Data Blok</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="{{ url('home/dashboard') }}">Dashboard</a></div>
                <div class="breadcrumb-item active"><a href="{{ url('home/blok') }}">Data Blok</a></div>
            </div>
        </div>

        <div class="col-lg-7 col-md-12 col-12 col-sm-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <div>
                        <h4>Data Blok</h4>
                    </div>
                    <div>
                        <!-- Button to Open the Modal for Adding Blok -->
                        <button type="button" class="btn btn-success" data-toggle="modal" data-target="#tambahBlokModal">
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
                                    <th scope="col">Nama Blok</th>
                                    <th scope="col">Semester</th>
                                    <th scope="col">Aksi</th>
                                </tr>
                            </thead>
                            <tbody id="tableBody">
                                @php $no = 1; @endphp
                                @foreach($blok as $blk)
                                    <tr>
                                        <td>{{ $no++ }}</td>
                                        <td>{{ $blk->nama_blok }}</td>
                                        <td>{{ $blk->semester }}</td>
                                        <td>
                                            <!-- Edit Button triggers Edit Modal -->
                                            <button type="button" 
                                                    class="btn btn-primary btn-action mr-1" 
                                                    data-toggle="modal" 
                                                    data-target="#editBlokModal" 
                                                    onclick="populateEditModal('{{ $blk->id_blok }}', '{{ $blk->nama_blok }}', '{{ $blk->semester }}')">
                                                <i class="fas fa-pencil-alt"></i>
                                            </button>

                                            <!-- Delete Button -->
                                            <a href="{{ url('home/hapus_blok/'.$blk->id_blok) }}" 
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

<!-- Modal for Adding Blok -->
<div class="modal fade" id="tambahBlokModal" tabindex="-1" role="dialog" aria-labelledby="tambahBlokModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="tambahBlokModalLabel">Tambah Blok</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{ url('home/post_aksi_t_blok') }}" method="POST">
                    @csrf
                    <div class="form-group">
                        <label for="nama_blok">Nama Blok</label>
                        <input type="text" class="form-control" name="nama_blok" id="nama_blok" required>
                    </div>
                    <div class="form-group">
                        <label for="semester">Semester</label>
                        <select class="form-control" name="semester" id="semester" required>
                            <option value="1">1</option>
                            <option value="2">2</option>
                        </select>
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

<!-- Modal for Editing Blok -->
<div class="modal fade" id="editBlokModal" tabindex="-1" role="dialog" aria-labelledby="editBlokModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editBlokModalLabel">Edit Blok</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ url('home/post_aksi_e_blok') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <input type="hidden" name="id" id="editBlokId">
                    <div class="form-group">
                        <label for="editNamaBlok">Nama Blok</label>
                        <input type="text" class="form-control" name="nama_blok" id="editNamaBlok" required>
                    </div>
                    <div class="form-group">
                        <label for="editSemester">Semester</label>
                        <select class="form-control" name="semester" id="editSemester" required>
                            <option value="1">1</option>
                            <option value="2">2</option>
                        </select>
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
    function populateEditModal(id, nama_blok, semester) {
        $('#editBlokId').val(id);
        $('#editNamaBlok').val(nama_blok);
        $('#editSemester').val(semester);
    }
</script>
