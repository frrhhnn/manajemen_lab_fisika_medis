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
        Schema::create('peminjaman', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('namaPeminjam');
            $table->boolean('is_mahasiswa_usk')->nullable();
            $table->string('npm_nim')->nullable();
            $table->string('noHp');
            $table->string('tujuanPeminjaman')->nullable();
            $table->datetime('tanggal_pinjam');
            $table->datetime('tanggal_pengembalian');
            $table->string('kondisi_pengembalian')->nullable();
            $table->enum('status', ['Menunggu', 'Disetujui', 'Dipinjam', 'Selesai', 'Ditolak', 'Terlambat'])->default('Menunggu');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('peminjaman');
    }
};