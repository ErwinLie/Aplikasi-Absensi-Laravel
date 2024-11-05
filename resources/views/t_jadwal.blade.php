
<main role="main" class="main-content">
    <div class="pagetitle">
        <h1>Tambah Jadwal</h1>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="card shadow mb-4">
                <div class="card-header">
                    <strong class="card-title">Tambah Jadwal</strong>
                </div>
                <form action="{{ url('home/post_aksi_t_jadwal') }}" method="POST">
                    @csrf
                    <div class="card-body">
                        <div class="form-group">
                            <label for="kelas">Kelas</label>
                            <select class="form-control" name="kelas" id="kelas">
                                <option value="">Pilih</option>
                                @foreach($erwin as $key)
                                    <option value="{{ $key->id_kelas }}">{{ $key->nama_kelas }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="blok">Blok</label>
                            <select class="form-control" name="blok" id="blok">
                                <option value="">Pilih</option>
                                @foreach($yoga as $key)
                                    <option value="{{ $key->id_blok }}">{{ $key->nama_blok }}</option>
                                @endforeach
                            </select>
                        </div>
                        
                        <div class="form-group">
                            <label for="guru">Nama Guru</label>
                            <select class="form-control" name="guru" id="guru" onchange="getMapelByGuru()">
                                <option value="">Pilih</option>
                                @foreach($darren as $key)
                                    <option value="{{ $key->id_user }}">{{ $key->username }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="mapel">Mapel</label>
                            <select class="form-control" name="mapel" id="mapel">
                                <option value="">Pilih</option>
                                @foreach($leo as $key)
                                    <option value="{{ $key->id_mapel }}">{{ $key->nama_mapel }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="sesi">Sesi</label>
                            <select class="form-control" name="sesi" id="sesi">
                                <option value="">Pilih</option>
                                <option value="1">Sesi 1</option>
                                <option value="2">Sesi 2</option>
                                <option value="3">Sesi 3</option>
                                <option value="4">Sesi 4</option>
                                <option value="5">Sesi 5</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="jam_mulai">Jam Mulai</label>
                            <input class="form-control" type="time" name="jam_mulai">
                        </div>
                        <div class="form-group">
                            <label for="jam_selesai">Jam Selesai</label>
                            <input class="form-control" type="time" name="jam_selesai">
                        </div>
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- <script>
        function handleSesiChange() {
            var sesi = document.getElementById("sesi").value;
            var guruSelect = document.getElementById("guru");
            var mapelSelect = document.getElementById("mapel");

            if (sesi == '6' || sesi == '7') {
                guruSelect.innerHTML = '<option value="-">-</option>';
                mapelSelect.innerHTML = '<option value="-">-</option>';
            } else {
                getMapelByGuru();
            }
        }

        function getMapelByGuru() {
            var guruId = document.getElementById("guru").value;
            var mapelSelect = document.getElementById("mapel");
            var sesi = document.getElementById("sesi").value;

            if (sesi == '6' || sesi == '7') {
                return;
            }

            if (guruId) {
                fetch('{{ url('home/get_mapel_by_guru') }}/' + guruId)
                .then(response => response.json())
                .then(data => {
                    let options = '<option value="">Pilih</option>';
                    data.forEach(mapel => {
                        options += `<option value="${mapel.id_mapel}">${mapel.mapel}</option>`;
                    });
                    mapelSelect.innerHTML = options;
                });
            } else {
                mapelSelect.innerHTML = '<option value="">Pilih</option>';
            }
        }
    </script> -->
</main>

