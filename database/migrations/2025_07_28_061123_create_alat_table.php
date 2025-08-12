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
        Schema::create('alat', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('nama');
            $table->string('kode')->nullable();
            $table->text('deskripsi');
            $table->string('image_url')->nullable();
            $table->integer('jumlah_tersedia')->default(0);
            $table->integer('jumlah_dipinjam')->default(0);
            $table->integer('jumlah_rusak')->default(0);
            $table->string('nama_kategori')->nullable();
            $table->integer('stok');
            $table->double('harga')->nullable();
            $table->timestamps();

            // Foreign key constraint
            $table->foreign('nama_kategori')->references('nama_kategori')->on('kategori_alat');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('alat');
    }
};
