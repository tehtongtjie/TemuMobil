@extends('layouts.app')

@section('content')
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Data Mobil</h1>
    <a href="{{ url('/mobil/create') }}" class="btn btn-primary btn-sm shadow-sm">
        <i class="fas fa-plus fa-sm text-white-50"></i> Tambah Mobil
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
                        <th>Nama Pemilik</th>
                        <th>Merek</th>
                        <th>Model</th>
                        <th>Tahun</th>
                        <th>Warna Interior</th>
                        <th>Warna Eksterior</th>
                        <th>Transmisi</th>
                        <th>Bahan Bakar</th>
                        <th>Kilometer</th>
                        <th>Jumlah Pemilik</th>
                        <th>Lokasi</th>
                        <th>Harga</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($mobil as $item)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $item->nama_pemilik }}</td>
                        <td>{{ $item->merek }}</td>
                        <td>{{ $item->model }}</td>
                        <td>{{ $item->tahun }}</td>
                        <td>{{ $item->warna_intertior }}</td>
                        <td>{{ $item->warna_eksterior }}</td>
                        <td>{{ ucfirst($item->transmisi) }}</td>
                        <td>{{ ucfirst($item->bahan_bakar) }}</td>
                        <td>{{ number_format($item->kilometer, 0, ',', '.') }} km</td>
                        <td>{{ $item->jumlah_pemilik }}</td>
                        <td>{{ $item->lokasi }}</td>
                        <td>Rp {{ number_format($item->price, 0, ',', '.') }}</td>
                        <td>
                            @if($item->status == 'aktif')
                            <span class="badge badge-success">Aktif</span>
                            @elseif($item->status == 'terjual')
                            <span class="badge badge-danger">Terjual</span>
                            @else
                            <span class="badge badge-secondary">Expired</span>
                            @endif
                        </td>
                        <td>
                            <a href="{{ url('/mobil/'.$item->id) }}" class="btn btn-warning btn-sm me-1" title="Edit">
                                <i class="fas fa-edit"></i>
                            </a>
                            <form action="{{ url('/mobil/'.$item->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin ingin menghapus data ini?')">
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
                        <td colspan="15" class="text-center">Data mobil tidak tersedia.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
