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
        Schema::create('jadwal', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('kunjunganId')->nullable();
            $table->date('tanggal');
            $table->string('waktuKunjungan')->comment('Format: HH:MM-HH:MM (09:00-10:00)');
            $table->boolean('isActive')->default(true);
            $table->timestamps();

            $table->foreign('kunjunganId')->references('id')->on('kunjungan')->onDelete('cascade');
            $table->unique(['tanggal', 'waktuKunjungan']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('jadwal');
    }
};