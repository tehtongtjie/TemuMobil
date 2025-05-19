<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('mobil', function (Blueprint $table) {
            $table->id();
            $table->string('nama_pemilik', 100);
            $table->string('email', 100);
            $table->string('no_hp', 20);
            $table->string('merek', 100);
            $table->string('model', 100);
            $table->string('tipe_body', 20);
            $table->year('tahun');
            $table->string('warna_intertior', 100);
            $table->string('warna_eksterior', 100);
            $table->enum('transmisi', ['manual', 'automatic', 'triptronic']);
            $table->enum('bahan_bakar', ['bensin', 'diesel', 'listrik', 'hybrid', 'plugin hybrid']);
            $table->integer('kilometer');
            $table->enum('jumlah_pemilik', ['1 pemilik', '2 pemilik', '3+ pemilik']);
            $table->string('lokasi');
            $table->decimal('price', 15, 2);
            $table->text('description');
            $table->enum('status', ['aktif', 'terjual', 'expired'])->default('aktif');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mobil');
    }
};
