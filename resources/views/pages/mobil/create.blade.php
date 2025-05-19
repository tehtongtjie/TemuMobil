@extends('layouts.app')

@section('content')
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Tambah Data Mobil</h1>
    </div>

    <div class="card shadow mb-4">
        <div class="card-body">
            <form action="{{ url('/mobil') }}" method="POST">
                @csrf

                <div class="form-group">
                    <label for="nama_pemilik">Nama Pemilik</label>
                    <input type="text" name="nama_pemilik" class="form-control" value="{{ old('nama_pemilik') }}" required>
                </div>

                <div class="form-group">
                    <label for="email">Email Pemilik</label>
                    <input type="email" name="email" class="form-control" value="{{ old('email') }}" required>
                </div>

                <div class="form-group">
                    <label for="no_hp">No HP</label>
                    <input type="text" name="no_hp" class="form-control" value="{{ old('no_hp') }}" required>
                </div>

                <div class="form-group">
                    <label for="merek">Merek</label>
                    <input type="text" name="merek" class="form-control" value="{{ old('merek') }}" required>
                </div>

                <div class="form-group">
                    <label for="model">Model</label>
                    <input type="text" name="model" class="form-control" value="{{ old('model') }}" required>
                </div>

                <div class="form-group">
                    <label for="tipe_body">Tipe Body</label>
                    <input type="text" name="tipe_body" class="form-control" value="{{ old('tipe_body') }}" required>
                </div>

                <div class="form-group">
                    <label for="tahun">Tahun</label>
                    <input type="year" name="tahun" class="form-control" value="{{ old('tahun') }}" required>
                </div>

                <div class="form-group">
                    <label for="warna_intertior">Warna Interior</label>
                    <input type="text" name="warna_intertior" class="form-control" value="{{ old('warna_intertior') }}"
                        required>
                </div>

                <div class="form-group">
                    <label for="warna_eksterior">Warna Eksterior</label>
                    <input type="text" name="warna_eksterior" class="form-control" value="{{ old('warna_eksterior') }}"
                        required>
                </div>

                <div class="form-group">
                    <label for="transmisi">Transmisi</label>
                    <select name="transmisi" class="form-control" required>
                        <option value="">-- Pilih Transmisi --</option>
                        <option value="manual">Manual</option>
                        <option value="automatic">Automatic</option>
                        <option value="triptronic">Triptronic</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="bahan_bakar">Bahan Bakar</label>
                    <select name="bahan_bakar" class="form-control" required>
                        <option value="">-- Pilih Bahan Bakar --</option>
                        <option value="bensin">Bensin</option>
                        <option value="diesel">Diesel</option>
                        <option value="listrik">Listrik</option>
                        <option value="hybrid">Hybrid</option>
                        <option value="plugin hybrid">Plug-in Hybrid</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="kilometer">Kilometer</label>
                    <input type="number" name="kilometer" class="form-control" value="{{ old('kilometer') }}" required>
                </div>

                <div class="form-group">
                    <label for="jumlah_pemilik">Jumlah Pemilik</label>
                    <select name="jumlah_pemilik" class="form-control" required>
                        <option value="">-- Pilih Jumlah Pemilik --</option>
                        <option value="1 pemilik">1 Pemilik</option>
                        <option value="2 pemilik">2 Pemilik</option>
                        <option value="3+ pemilik">3+ Pemilik</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="lokasi">Lokasi</label>
                    <input type="text" name="lokasi" class="form-control" value="{{ old('lokasi') }}" required>
                </div>

                <div class="form-group">
                    <label for="price">Harga (Rp)</label>
                    <input type="number" name="price" class="form-control" value="{{ old('price') }}" required>
                </div>

                <div class="form-group">
                    <label for="description">Deskripsi</label>
                    <textarea name="description" class="form-control" rows="4" required>{{ old('description') }}</textarea>
                </div>

                <div class="form-group">
                    <label for="status">Status</label>
                    <select name="status" class="form-control" required>
                        <option value="aktif">Aktif</option>
                        <option value="terjual">Terjual</option>
                        <option value="expired">Expired</option>
                    </select>
                </div>

                <button type="submit" class="btn btn-primary">Simpan</button>
                <a href="{{ url('/mobil') }}" class="btn btn-secondary">Batal</a>
            </form>
        </div>
    </div>
@endsection
