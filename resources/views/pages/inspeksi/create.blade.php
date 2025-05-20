@extends('layouts.app')

@section('content')
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Tambah Data Inspeksi</h1>
    </div>
    
    <!-- Tabel -->
    <div class="card shadow mb-4">
    <div class="card-body">
        <form action="{{ url('/inspeksi') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="form-group">
                <label for="mobil_id">Mobil</label>
                <select name="mobil_id" class="form-control" required>
                    <option value="">-- Pilih Mobil --</option>
                    @foreach ($mobils as $mobil)
                        <option value="{{ $mobil->id }}">{{ $mobil->merek }} {{ $mobil->model }}</option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label for="inspektor_id">Inspektor</label>
                <select name="inspektor_id" class="form-control">
                    <option value="">-- Pilih Inspektor --</option>
                    @foreach ($inspektors as $inspektor)
                        <option value="{{ $inspektor->id }}">{{ $inspektor->name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label for="status">Status</label>
                <select name="status" class="form-control" required>
                    <option value="pending">Pending</option>
                    <option value="berjalan">Berjalan</option>
                    <option value="selesai">Selesai</option>
                    <option value="dibatalkan">Dibatalkan</option>
                </select>
            </div>

            <div class="form-group">
                <label for="laporan">Laporan</label>
                <textarea name="laporan" class="form-control" rows="4">{{ old('laporan') }}</textarea>
            </div>

            <div class="form-group">
                <label for="foto">Foto Inspeksi</label>
                <input type="file" name="foto[]" class="form-control-file" multiple>
                <small class="form-text text-muted">Bisa upload lebih dari satu foto.</small>
            </div>

            <div class="form-group">
                <label for="rekomendasi">Rekomendasi</label>
                <textarea name="rekomendasi" class="form-control" rows="3">{{ old('rekomendasi') }}</textarea>
            </div>

            <div class="form-group">
                <label for="jadwal_inspeksi">Jadwal Inspeksi</label>
                <input type="datetime-local" name="jadwal_inspeksi" class="form-control" value="{{ old('jadwal_inspeksi') }}">
            </div>

            <button type="submit" class="btn btn-primary">Simpan</button>
            <a href="{{ url('/inspeksi') }}" class="btn btn-secondary">Batal</a>
        </form>
    </div>
@endsection