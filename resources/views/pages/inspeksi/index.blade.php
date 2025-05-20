@extends('layouts.app')

@section('content')
<!-- Page Heading -->
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Data Inspeksi</h1>
    <a href="{{ url('/inspeksi/create') }}" class="btn btn-primary btn-sm shadow-sm">
        <i class="fas fa-plus fa-sm text-white-50"></i> Tambah Inspeksi
    </a>
</div>

{{-- Tabel --}}
<div class="card shadow mb-4">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered table-hover" width="100%" cellspacing="0">
                <thead class="thead-light">
                    <tr>
                        <th>No</th>
                        <th>Mobil ID</th>
                        <th>Inspektor ID</th>
                        <th>Status</th>
                        <th>Laporan</th>
                        <th>Foto</th>
                        <th>Jadwal Inspeksi</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($inspeksi as $item)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $item->mobil_id }}</td>
                        <td>{{ $item->inspektor_id ?? '-' }}</td>
                        <td>
                            @if($item->status == 'pending')
                            <span class="badge badge-secondary">Pending</span>
                            @elseif($item->status == 'berjalan')
                            <span class="badge badge-primary">Berjalan</span>
                            @elseif($item->status == 'selesai')
                            <span class="badge badge-success">Selesai</span>
                            @else
                            <span class="badge badge-danger">Dibatalkan</span>
                            @endif
                        </td>
                        <td>{{ $item->laporan ?? '-' }}</td>
                        <td>
                            @if($item->foto)
                                @foreach(json_decode($item->foto, true) as $foto)
                                    <a href="{{ asset('storage/' . $foto) }}" target="_blank">
                                        <img src="{{ asset('storage/' . $foto) }}" alt="Foto Inspeksi" width="50">
                                    </a>
                                @endforeach
                            @else
                                Tidak ada foto
                            @endif
                        </td>
                        <td>{{ $item->jadwal_inspeksi ? \Carbon\Carbon::parse($item->jadwal_inspeksi)->format('d-m-Y H:i') : '-' }}</td>
                        <td>
                            <a href="{{ url('/inspeksi/'.$item->id) }}" class="btn btn-warning btn-sm me-1" title="Edit">
                                <i class="fas fa-edit"></i>
                            </a>
                            <form action="{{ url('/inspeksi/'.$item->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin ingin menghapus data ini?')">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-danger btn-sm" title="Hapus">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" class="text-center">Data inspeksi tidak tersedia.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection