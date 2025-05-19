<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Mobil extends Model
{
    use HasFactory;

    protected $table = 'mobil';

    // Jika kamu ingin mengizinkan mass assignment
    protected $fillable = [
        'nama_pemilik',
        'email',
        'no_hp',
        'merek',
        'model',
        'tipe_body',
        'tahun',
        'warna_intertior',
        'warna_eksterior',
        'transmisi',
        'bahan_bakar',
        'kilometer',
        'jumlah_pemilik',
        'lokasi',
        'price',
        'description',
        'status',
    ];

    // Jika kamu ingin mencegah Laravel dari menambah kolom created_at dan updated_at
    // public $timestamps = false;

    // Contoh relasi jika ada: Mobil memiliki banyak inspeksi
    public function inspeksi()
    {
        return $this->hasMany(Inspeksi::class);
    }

    // Contoh relasi: Mobil dimiliki oleh User (jika ada user_id di tabel mobil)
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
