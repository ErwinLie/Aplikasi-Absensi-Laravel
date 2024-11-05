<div class="main-content">
    <section class="section">
        <div class="section-header">
            <div class="section-header-back">
                <a href="{{ url('home/dashboard') }}" class="btn btn-icon"><i class="fas fa-arrow-left"></i></a>
            </div>
            <h1>User</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="{{ url('home/dashboard') }}">Dashboard</a></div>
                <div class="breadcrumb-item active"><a href="{{ url('home/user') }}">User</a></div>
            </div>
        </div>

        <div class="col-lg-7 col-md-12 col-12 col-sm-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <div>
                        <h4>Data User</h4>
                    </div>
                    <div>
                        <!-- Button to Open the Modal for Adding User -->
                        <button type="button" class="btn btn-success" data-toggle="modal" data-target="#tambahUserModal">
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
                                    <th scope="col">Username</th>
                                    <th scope="col">Email</th>
                                    <th scope="col">Level</th>
                                    <th scope="col">Jenis Kelamin</th>
                                    <th scope="col">Aksi</th>
                                </tr>
                            </thead>
                            <tbody id="tableBody">
                                @php $no = 1; @endphp
                                @foreach($erwin as $user)
                                    <tr>
                                        <td>{{ $no++ }}</td>
                                        <td>{{ $user->username }}</td>
                                        <td>{{ $user->email }}</td>
                                        <td>
                                            @switch($user->id_level)
                                                @case(1)
                                                    Admin
                                                    @break
                                                @case(2)
                                                    Kepala Sekolah
                                                    @break
                                                @case(3)
                                                    Wakil
                                                    @break
                                                @case(4)
                                                    Guru
                                                    @break
                                                @case(5)
                                                    Siswa
                                                    @break
                                            @endswitch
                                        </td>
                                        <td>{{ $user->jk == 'L' ? 'Laki-laki' : 'Perempuan' }}</td>
                                        <td>
                                            <!-- Edit Button triggers Edit Modal -->
                                            <button type="button" 
                                                    class="btn btn-primary btn-action mr-1" 
                                                    data-toggle="modal" 
                                                    data-target="#editUserModal" 
                                                    onclick="populateEditModal('{{ $user->id_user }}', '{{ $user->username }}', '{{ $user->email }}', '{{ $user->id_level }}', '{{ $user->jk }}')">
                                                <i class="fas fa-pencil-alt"></i>
                                            </button>

                                            <!-- Delete Button -->
                                            <a href="{{ url('home/hapus_user/'.$user->id_user) }}" 
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

<!-- Modal for Adding User -->
<div class="modal fade" id="tambahUserModal" tabindex="-1" role="dialog" aria-labelledby="tambahUserModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="tambahUserModalLabel">Tambah User</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{ url('home/post_aksi_t_user') }}" method="POST">
                    @csrf
                    <div class="form-group">
                        <label for="username">Username</label>
                        <input type="text" class="form-control" name="username" id="username" required>
                    </div>
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" class="form-control" name="email" id="email" required>
                    </div>
                    <div class="form-group">
                        <label for="id_level">Level</label>
                        <select class="form-control" name="id_level" id="id_level" required>
                            <option value="1">Admin</option>
                            <option value="2">Kepala Sekolah</option>
                            <option value="3">Wakil</option>
                            <option value="4">Guru</option>
                            <option value="5">Siswa</option>
                        </select>
                    </div>
                    <!-- Pilih Kelas Dropdown -->
                    <div class="form-group" id="kelas-group" style="display: none;">
                        <label for="id_kelas">Pilih Kelas</label>
                        <select class="form-control" name="id_kelas" id="id_kelas">
                            <option value="">-- Pilih Kelas --</option>
                            @foreach($kelas as $k)
                                <option value="{{ $k->id_kelas }}">{{ $k->nama_kelas }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="jk">Jenis Kelamin</label>
                        <select class="form-control" name="jk" id="jk" required>
                            <option value="L">Laki-laki</option>
                            <option value="P">Perempuan</option>
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

<!-- Modal for Editing User -->
<div class="modal fade" id="editUserModal" tabindex="-1" role="dialog" aria-labelledby="editUserModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editUserModalLabel">Edit User</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ url('home/post_aksi_e_user') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <input type="hidden" name="id" id="editUserId">
                    <div class="form-group">
                        <label for="editUsername">Username</label>
                        <input type="text" class="form-control" name="username" id="editUsername" required>
                    </div>
                    <div class="form-group">
                        <label for="editEmail">Email</label>
                        <input type="email" class="form-control" name="email" id="editEmail" required>
                    </div>
                    <div class="form-group">
                        <label for="editIdLevel">Level</label>
                        <select class="form-control" name="id_level" id="editIdLevel" required>
                            <option value="1">Admin</option>
                            <option value="2">Kepala Sekolah</option>
                            <option value="3">Wakil</option>
                            <option value="4">Guru</option>
                            <option value="5">Siswa</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="editJk">Jenis Kelamin</label>
                        <select class="form-control" name="jk" id="editJk" required>
                            <option value="L">Laki-laki</option>
                            <option value="P">Perempuan</option>
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

    $(document).ready(function() {
    // Show/hide 'Pilih Kelas' based on the selected level
    $('#id_level').on('change', function() {
            var selectedLevel = $(this).val();
            if (selectedLevel == '5') { // If level is Siswa (5)
                $('#kelas-group').show();
            } else {
                $('#kelas-group').hide();
            }
        });

        // Trigger change event to ensure correct display when modal opens
        $('#id_level').trigger('change');
    });

    // Populate Edit Modal function
    function populateEditModal(id, username, email, id_level, jk) {
        $('#editUserId').val(id);
        $('#editUsername').val(username);
        $('#editEmail').val(email);
        $('#editIdLevel').val(id_level);
        $('#editJk').val(jk);
    }
</script>
