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
        Schema::create('kunjungan', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('namaPengunjung'); // NAMA ATAU INSTANSI PENGUNJUNG
            $table->text('tujuan');
            $table->integer('jumlahPengunjung')->default(1); // JUMLAH ROMBONGAN YANG DIBAWA
            $table->enum('status', ['PENDING', 'PROCESSING', 'COMPLETED', 'CANCELLED'])->default('PENDING');
            $table->string('noHp');
            $table->string('namaInstansi')->nullable();
            $table->string('suratPengajuan')->nullable(); // File path untuk surat pengajuan
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kunjungan');
    }
}; 