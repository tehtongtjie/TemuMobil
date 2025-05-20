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
        Schema::create('inspeksi', function (Blueprint $table) {
            $table->id();
            $table->foreignId('mobil_id')->constrained('mobil')->onDelete('cascade');
            $table->foreignId('inspektor_id')->nullable()->constrained('users')->onDelete('set null');
            $table->enum('status', ['pending', 'berjalan', 'selesai', 'dibatalkan'])->default('pending');
            $table->text('laporan')->nullable();
            $table->text('foto')->nullable(); // Bisa simpan JSON array path foto
            $table->text('rekomendasi')->nullable();
            $table->timestamp('jadwal_inspeksi')->nullable();
            $table->timestamps();
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('inspeksis');
    }
};
