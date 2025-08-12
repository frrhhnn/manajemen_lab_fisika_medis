<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Peminjaman extends Model
{
    use HasFactory;

    protected $table = 'peminjaman';
    
    // Menggunakan UUID sebagai primary key
    protected $keyType = 'string';
    public $incrementing = false;

    protected $fillable = [
        'namaPeminjam',
        'is_mahasiswa_usk',
        'npm_nim',
        'noHp',
        'tujuanPeminjaman',
        'tanggal_pinjam',
        'tanggal_pengembalian',
        'kondisi_pengembalian',
        'status'
    ];

    protected $casts = [
        'tanggal_pinjam' => 'datetime',
        'tanggal_pengembalian' => 'datetime',
        'is_mahasiswa_usk' => 'boolean'
    ];

    // Generate custom ID dengan prefix PJM- saat create
    protected static function boot()
    {
        parent::boot();
        
        static::creating(function ($model) {
            if (empty($model->id)) {
                $model->id = self::generateCustomId();
            }
        });
    }
    
    /**
     * Generate custom ID dengan format: PJM-YYYYMMDD-XXXX
     * Contoh: PJM-20231225-0001
     */
    public static function generateCustomId()
    {
        $today = now()->format('Ymd'); // Format: 20231225
        $prefix = 'PJM-' . $today . '-';
        
        // Cari ID terakhir untuk hari ini
        $lastRecord = self::where('id', 'like', $prefix . '%')
                          ->orderBy('id', 'desc')
                          ->first();
        
        if ($lastRecord) {
            // Ambil nomor urut terakhir dan tambah 1
            $lastNumber = (int) substr($lastRecord->id, -4);
            $nextNumber = $lastNumber + 1;
        } else {
            // Jika belum ada untuk hari ini, mulai dari 1
            $nextNumber = 1;
        }
        
        // Format nomor urut menjadi 4 digit dengan leading zero
        $formattedNumber = str_pad($nextNumber, 4, '0', STR_PAD_LEFT);
        
        return $prefix . $formattedNumber;
    }

    // Relasi dengan PeminjamanItem
    public function peminjamanItems()
    {
        return $this->hasMany(PeminjamanItem::class, 'peminjamanId');
    }

    // Scope untuk status tertentu
    public function scopeByStatus($query, $status)
    {
        return $query->where('status', $status);
    }

    // Scope untuk peminjaman yang sedang berjalan
    public function scopeAktif($query)
    {
        return $query->whereIn('status', ['Menunggu', 'Disetujui', 'Dipinjam']);
    }

    // Helper method untuk total item yang dipinjam
    public function getTotalItemsAttribute()
    {
        return $this->peminjamanItems->sum('jumlah');
    }
}
