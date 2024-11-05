<main role="main" class="main-content">
<sections class="section">
    <div class="section-header">
        <div class="section-header-back">
            <a href="{{ url ('home/dashboard') }}" class="btn btn-icon"><i class="fas fa-arrow-left"></i></a>
        </div>
        <h1> Pilih </h1>
        <div class="section-header-breadcrumb">
            <div class="breadcrumb-item active"><a href="#">Dashboard</a></div>
            <div class="breadcrumb-item active"><a href="#"> Pilih </a></div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-7 col-md-12 col-12 col-sm-12">
            <div class="card shadow mb-4">
                <div class="card-header">
                    <h4>Pilih Kelas</h4>
                </div>
                <div class="card-body">
                    <!-- Update action URL to a named route in Laravel -->
                    <form action="{{ url('home/absensi') }}" method="POST">
                        <!-- Laravel CSRF token for form security -->
                        @csrf
                        <div class="form-group">
                            <label for="kelas">Kelas</label>
                            <select class="form-control" name="kelas" id="kelas">
                                <option value="">Pilih</option>
                                @foreach ($kelas as $key)
                                    <option value="{{ $key->id_kelas }}">{{ $key->nama_kelas }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="blok">Blok</label>
                            <select class="form-control" name="blok" id="blok">
                                <option value="">Pilih</option>
                                @foreach ($blok as $key)
                                    <option value="{{ $key->id_blok }}">{{ $key->nama_blok }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="mapel">Mapel</label>
                            <select class="form-control" name="mapel" id="mapel">
                                <option value="">Pilih</option>
                                @foreach ($mapel as $key)
                                    <option value="{{ $key->id_mapel }}">{{ $key->nama_mapel }}</option>
                                @endforeach
                            </select>
                        </div>

                        <button type="submit" class="btn btn-primary">Submit</button>
                    </form>
                </div> <!-- /. card-body -->
            </div> <!-- /. card -->
        </div> <!-- /. col -->
    </div> <!-- /. row -->
</sections>
</main>
