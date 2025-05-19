@extends('layouts.app')

@section('content')
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Ubah Data Mobil</h1>
    </div>

    <div class="card shadow mb-4">
        <div class="card-body">
            <form action="/mobil/{{ $mobil->id }}" method="POST">
                @csrf
                @method('PUT')

                <div class="form-group">
                    <label for="nama_pemilik">Nama Pemilik</label>
                    <input type="text" name="nama_pemilik" class="form-control"
                        value="{{ old('nama_pemilik', $mobil->nama_pemilik) }}" required>
                </div>

                <div class="form-group">
                    <label for="email">Email Pemilik</label>
                    <input type="email" name="email" class="form-control" value="{{ old('email', $mobil->email) }}"
                        required>
                </div>

                <div class="form-group">
                    <label for="no_hp">No HP</label>
                    <input type="text" name="no_hp" class="form-control" value="{{ old('no_hp', $mobil->no_hp) }}"
                        required>
                </div>

                <div class="form-group">
                    <label for="merek">Merek</label>
                    <input type="text" name="merek" class="form-control" value="{{ old('merek', $mobil->merek) }}"
                        required>
                </div>

                <div class="form-group">
                    <label for="model">Model</label>
                    <input type="text" name="model" class="form-control" value="{{ old('model', $mobil->model) }}"
                        required>
                </div>

                <div class="form-group">
                    <label for="tipe_body">Tipe Body</label>
                    <input type="text" name="tipe_body" class="form-control"
                        value="{{ old('tipe_body', $mobil->tipe_body) }}" required>
                </div>

                <div class="form-group">
                    <label for="tahun">Tahun</label>
                    <input type="number" name="tahun" class="form-control" value="{{ old('tahun', $mobil->tahun) }}"
                        required>
                </div>

                <div class="form-group">
                    <label for="warna_intertior">Warna Interior</label>
                    <input type="text" name="warna_intertior" class="form-control"
                        value="{{ old('warna_intertior', $mobil->warna_intertior) }}" required>
                </div>

                <div class="form-group">
                    <label for="warna_eksterior">Warna Eksterior</label>
                    <input type="text" name="warna_eksterior" class="form-control"
                        value="{{ old('warna_eksterior', $mobil->warna_eksterior) }}" required>
                </div>

                <div class="form-group">
                    <label for="transmisi">Transmisi</label>
                    <select name="transmisi" class="form-control" required>
                        <option value="">-- Pilih Transmisi --</option>
                        @foreach (['manual', 'automatic', 'triptronic'] as $val)
                            <option value="{{ $val }}"
                                {{ old('transmisi', $mobil->transmisi) == $val ? 'selected' : '' }}>{{ ucfirst($val) }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group">
                    <label for="bahan_bakar">Bahan Bakar</label>
                    <select name="bahan_bakar" class="form-control" required>
                        <option value="">-- Pilih Bahan Bakar --</option>
                        @foreach (['bensin', 'diesel', 'listrik', 'hybrid', 'plugin hybrid'] as $val)
                            <option value="{{ $val }}"
                                {{ old('bahan_bakar', $mobil->bahan_bakar) == $val ? 'selected' : '' }}>
                                {{ ucfirst($val) }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group">
                    <label for="kilometer">Kilometer</label>
                    <input type="number" name="kilometer" class="form-control"
                        value="{{ old('kilometer', $mobil->kilometer) }}" required>
                </div>

                <div class="form-group">
                    <label for="jumlah_pemilik">Jumlah Pemilik</label>
                    <select name="jumlah_pemilik" class="form-control" required>
                        @foreach (['1 pemilik', '2 pemilik', '3+ pemilik'] as $val)
                            <option value="{{ $val }}"
                                {{ old('jumlah_pemilik', $mobil->jumlah_pemilik) == $val ? 'selected' : '' }}>
                                {{ $val }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group">
                    <label for="lokasi">Lokasi</label>
                    <input type="text" name="lokasi" class="form-control" value="{{ old('lokasi', $mobil->lokasi) }}"
                        required>
                </div>

                <div class="form-group">
                    <label for="price">Harga (Rp)</label>
                    <input type="number" name="price" class="form-control" value="{{ old('price', $mobil->price) }}"
                        required>
                </div>

                <div class="form-group">
                    <label for="description">Deskripsi</label>
                    <textarea name="description" class="form-control" rows="4" required>{{ old('description', $mobil->description) }}</textarea>
                </div>

                <div class="form-group">
                    <label for="status">Status</label>
                    <select name="status" class="form-control" required>
                        @foreach (['aktif', 'terjual', 'expired'] as $val)
                            <option value="{{ $val }}"
                                {{ old('status', $mobil->status) == $val ? 'selected' : '' }}>{{ ucfirst($val) }}</option>
                        @endforeach
                    </select>
                </div>

                <button type="submit" class="btn btn-warning">Simpan Perubahan</button>
                <a href="{{ url('/mobil') }}" class="btn btn-secondary">Batal</a>
            </form>
        </div>
    </div>
@endsection
