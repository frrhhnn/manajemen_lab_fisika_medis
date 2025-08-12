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
        Schema::create('gambar', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('pengurusId')->nullable();
            $table->uuid('acaraId')->nullable();
            $table->string('url');
            $table->enum('kategori', ['PENGURUS', 'ACARA', 'FASILITAS']);
            $table->string('judul')->nullable();
            $table->text('deskripsi')->nullable();
            $table->boolean('isVisible')->default(true);
            $table->timestamps();
            
            // Foreign key constraints
            $table->foreign('pengurusId')->references('id')->on('biodataPengurus')->onDelete('cascade');
            $table->foreign('acaraId')->references('id')->on('artikel')->onDelete('cascade');
        });
    }
    
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('gambar');
    }
};