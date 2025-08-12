<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class PeminjamanItem extends Model
{
    use HasFactory;

    protected $table = 'peminjaman_item';
    
    // Menggunakan UUID sebagai primary key
    protected $keyType = 'string';
    public $incrementing = false;

    protected $fillable = [
        'peminjamanId',
        'alat_id',
        'jumlah'
    ];

    protected $casts = [
        'jumlah' => 'integer'
    ];

    // Generate UUID saat create
    protected static function boot()
    {
        parent::boot();
        
        static::creating(function ($model) {
            if (empty($model->id)) {
                $model->id = Str::uuid();
            }
        });
    }

    // Relasi dengan Peminjaman
    public function peminjaman()
    {
        return $this->belongsTo(Peminjaman::class, 'peminjamanId');
    }

    // Relasi dengan Alat
    public function alat()
    {
        return $this->belongsTo(Alat::class, 'alat_id');
    }

    // Helper method untuk subtotal (jika ada harga)
    public function getSubtotalAttribute()
    {
        return $this->jumlah * ($this->alat->harga ?? 0);
    }
}
