<?php

namespace App\Http\Controllers;

use App\Models\Mobil;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class MobilController extends Controller
{
    public function index()
    {
        $mobil = Mobil::all();

        return view('pages.mobil.index', [
            'mobil' => $mobil
        ]);
    }


    public function create()
    {
        return view('pages.mobil.create');
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'nama_pemilik' => ['required', 'max:100'],
            'email' => ['required', 'max:100'],
            'no_hp' => ['required', 'max:20'],
            'merek' => ['required', 'max:100'],
            'model' => ['required', 'max:100'],
            'tipe_body' => ['required', 'max:20'],
            'tahun' => ['required'],
            'warna_intertior' => ['required', 'max:100'],
            'warna_eksterior' => ['required', 'max:100'],
            'transmisi' => ['required', Rule::in(['manual', 'automatic', 'triptronic'])],
            'bahan_bakar' => ['required', Rule::in(['bensin', 'diesel', 'listrik', 'hybrid', 'plugin hybrid'])],
            'kilometer' => ['required', 'integer', 'min:0'],
            'jumlah_pemilik' => ['required', Rule::in(['1 pemilik', '2 pemilik', '3+ pemilik'])],
            'lokasi' => ['required'],
            'price' => ['required'],
            'description' => ['required'],
            'status' => ['required'],
        ]);

        Mobil::create($validatedData);

        return redirect('/mobil')->with('success', 'Data Mobil Berhasil Ditambahkan');
    }
    public function edit($id)
    {
        $mobil = Mobil::findOrFail($id);

        return view('pages.mobil.edit', [
            'mobil' => $mobil
        ]);
    }

    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'nama_pemilik' => ['required', 'max:100'],
            'email' => ['required', 'max:200'],
            'no_hp' => ['required', 'max:20'],
            'merek' => ['required', 'max:100'],
            'model' => ['required', 'max:100'],
            'tahun' => ['required'],
            'warna_intertior' => ['required', 'max:100'],
            'warna_eksterior' => ['required', 'max:100'],
            'transmisi' => ['required', Rule::in(['manual', 'automatic', 'triptronic'])],
            'bahan_bakar' => ['required', Rule::in(['bensin', 'diesel', 'listrik', 'hybrid', 'plugin hybrid'])],
            'kilometer' => ['required'],
            'jumlah_pemilik' => ['required', Rule::in(['1 pemilik', '2 pemilik', '3+ pemilik'])],
            'lokasi' => ['required'],
            'price' => ['required'],
            'description' => ['required'],
            'status' => ['required'],
        ]);

        Mobil::findOrFail($id)->update($validatedData);

        return redirect('/mobil')->with('success', 'Data Mobil Berhasil Diubah');
    }

    public function destroy($id)
    {
        $mobil = Mobil::findOrFail($id);
        $mobil->delete();

        return redirect('/mobil')->with('success', 'Data Mobil Berhasil Dihapus');
    }
}
