<?php

namespace App\Http\Controllers;

use App\Models\Inspeksi;
use App\Models\User;
use App\Models\Mobil;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class InspeksiController extends Controller
{
    public function index()
    {
        $inspeksi = Inspeksi::all();

        return view('pages.inspeksi.index', [
            'inspeksi' => $inspeksi
        ]);
    }

    public function create()
    {
        $mobils = Mobil::all();
        $inspektors = User::all();

        return view('pages.inspeksi.create', compact('mobils', 'inspektors'));
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'mobil_id' => ['required'],
            'inspektor_id' => ['nullable'],
            'status' => ['required', Rule::in(['pending', 'berjalan', 'selesai', 'dibatalkan'])],
            'laporan' => ['nullable'],
            'foto.*' => ['nullable', 'image', 'mimes:jpg,jpeg,png', 'max:2048'],
            'rekomendasi' => ['nullable'],
            'jadwal_inspeksi' => ['nullable'],

        ]);

        Inspeksi::create($validatedData);

        return redirect('/inspeksi')->with('success', 'Data Inspeksi Berhasil Ditambahkan');
    }

    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'mobil_id' => ['required'],
            'inspektor_id' => ['nullable'],
            'status' => ['required', Rule::in(['pending', 'berjalan', 'selesai', 'dibatalkan'])],
            'laporan' => ['nullable'],
            'foto' => ['nullable'],
            'rekomendasi' => ['nullable'],
            'jadwal_inspeksi' => ['nullable'],

        ]);

        Inspeksi::findOrFail($id)->update($validatedData);

        return redirect('/inspeksi')->with('success', 'Data Inspeksi Berhasil Diubah');
    }


    public function edit($id)
    {
        $inspeksi = Inspeksi::findOrFail($id);

        return view('pages.inspeksi.edit', [
            'inspeksi' => $inspeksi
        ]);
    }

    public function destroy($id)
    {
        $inspeksi = Inspeksi::findOrFail($id);
        $inspeksi->delete();

        return redirect('/inspeksi')->with('success', 'Data Inspeksi Berhasil Dihapus');
    }
}
