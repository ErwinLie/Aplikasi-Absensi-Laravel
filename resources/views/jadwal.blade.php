<main role="main" class="main-content">
    <!-- Section Header -->
    <section class="section">
        <div class="section-header">
            <div class="section-header-back">
                <a href="{{ url ('home/dashboard') }}" class="btn btn-icon"><i class="fas fa-arrow-left"></i></a>
            </div>
            <h1>Jadwal</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="#">Dashboard</a></div>
                <div class="breadcrumb-item active"><a href="#">Jadwal</a></div>
            </div>
        </div>
        <!-- End of Section Header -->

        <div class="row">
            <div class="col-md-12">
                <div class="card shadow mb-4">
                    <div class="card-header">
                        <strong class="card-title">Tampil Jadwal</strong>
                    </div>

                    <div class="card-body">
                        <div class="form-group">
                            <label for="kelas">Kelas</label>
                            <select class="form-control" name="kelas" id="kelas">
                                <option value="">Pilih</option>
                                @foreach($kelas as $key)
                                    <option value="{{ $key->id_kelas }}">{{ $key->nama_kelas }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="blok">Blok</label>
                            <select class="form-control" name="blok" id="blok">
                                <option value="">Pilih</option>
                                @foreach($blok as $key)
                                    <option value="{{ $key->id_blok }}">{{ $key->nama_blok }}</option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Tambahkan tombol hapus jadwal -->
                        <div class="row mt-3">
                            <div class="col-md-12">
                                <button class="btn btn-danger" id="hapusJadwal">Hapus Jadwal</button>
                            </div>
                        </div>

                        <!-- Data jadwal akan dimuat di sini menggunakan AJAX -->
                        <div class="col-md-12 mt-4">
                            <table class="table table-striped" id="table">
                                <thead>
                                    <tr>
                                        <th>Sesi</th>
                                        <th>Nama Guru</th>
                                        <th>Mata Pelajaran</th>
                                        <th>Jam Mulai</th>
                                        <th>Jam Selesai</th>
                                        <!-- <th>Aksi</th> -->
                                    </tr>
                                </thead>
                                <tbody id="jadwalBody">
                                    <!-- Data jadwal akan dimuat di sini -->
                                </tbody>
                            </table>
                        </div>

                    </div> <!-- /. card-body -->
                </div> <!-- /. card -->
            </div> <!-- /. col -->
        </div> <!-- /. row -->
    </section>
</main>

@php
    $userId = session()->get('id');
@endphp

<script>
    // Function to fetch and display schedule data based on selected class and block
    function fetchJadwal() {
        var kelas = document.getElementById('kelas').value;
        var blok = document.getElementById('blok').value;

        if (kelas && blok) {
            fetch('{{ route("jadwal.getjadwal") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({
                    kelas: kelas,
                    blok: blok
                })
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error('Network response was not ok: ' + response.statusText);
                }
                return response.json();
            })
            .then(data => {
                var jadwalBody = document.getElementById('jadwalBody');
                jadwalBody.innerHTML = '';

                if (data.success) {
                    if (data.data.length > 0) {
                        data.data.forEach(item => {
                            var row = `<tr>
                                <td>${item.sesi}</td>
                                <td>${item.username}</td>
                                <td>${item.nama_mapel}</td>
                                <td>${item.jam_mulai}</td>
                                <td>${item.jam_selesai}</td>
                                <td></td> <!-- Removed Absen button -->
                            </tr>`;
                            jadwalBody.innerHTML += row;
                        });
                    } else {
                        jadwalBody.innerHTML = '<tr><td colspan="6" class="text-center">Tidak ada data.</td></tr>';
                    }
                } else {
                    alert(data.message);
                    jadwalBody.innerHTML = '<tr><td colspan="6" class="text-center">Tidak ada data.</td></tr>';
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Terjadi kesalahan saat memuat data.');
            });
        } else {
            document.getElementById('jadwalBody').innerHTML = '<tr><td colspan="6" class="text-center">Silakan pilih kelas dan blok.</td></tr>';
        }
    }

    // Event listeners for dropdown changes
    document.getElementById('kelas').addEventListener('change', fetchJadwal);
    document.getElementById('blok').addEventListener('change', fetchJadwal);

    // Function to delete schedule based on class and block
    var hapusJadwalBtn = document.getElementById('hapusJadwal');
    hapusJadwalBtn.addEventListener('click', function() {
        var kelas = document.getElementById('kelas').value;
        var blok = document.getElementById('blok').value;

        if (kelas && blok) {
            if (confirm(`Apakah Anda yakin ingin menghapus jadwal untuk Kelas: ${kelas} dan Blok: ${blok}?`)) {
                fetch('{{ url("home/post_hapus_jadwal") }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({
                        kelas: kelas,
                        blok: blok
                    })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        alert('Jadwal berhasil dihapus');
                        fetchJadwal(); // Refresh the table after deletion
                    } else {
                        alert('Gagal menghapus jadwal: ' + data.message);
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Terjadi kesalahan saat menghapus jadwal. Silakan coba lagi.');
                });
            }
        } else {
            alert('Silakan pilih kelas dan blok.');
        }
    });
</script>
