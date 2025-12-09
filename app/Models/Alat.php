<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use App\Helpers\ImageHelper;

class Alat extends Model
{
    use HasFactory;

    protected $table = 'alat';
    
    // Menggunakan UUID sebagai primary key
    protected $keyType = 'string';
    public $incrementing = false;

    protected $fillable = [
        'nama',
        'kode',
        'deskripsi',
        'image_url',
        'jumlah_tersedia',
        'jumlah_dipinjam',
        'jumlah_rusak',
        'nama_kategori',
        'stok',
        'harga'
    ];

    protected $casts = [
        'harga' => 'double',
        'jumlah_tersedia' => 'integer',
        'jumlah_dipinjam' => 'integer',
        'jumlah_rusak' => 'integer',
        'stok' => 'integer'
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

    // Relasi dengan KategoriAlat
    public function kategoriAlat()
    {
        return $this->belongsTo(KategoriAlat::class, 'nama_kategori', 'nama_kategori');
    }

    // Relasi dengan PeminjamanItem
    public function peminjamanItems()
    {
        return $this->hasMany(PeminjamanItem::class, 'alat_id');
    }

    // Scope untuk alat yang tersedia
    public function scopeTersedia($query)
    {
        return $query->where('jumlah_tersedia', '>', 0);
    }

    // Helper method untuk mengecek ketersediaan
    public function isAvailable($jumlah = 1)
    {
        return $this->jumlah_tersedia >= $jumlah;
    }

    // Get standardized image URL - IMPROVED for hosting compatibility
    public function getImageUrlAttribute($value)
    {
        return ImageHelper::getImageUrl($value, 'images/facilities/default-alat.jpg');
    }

    // Get optimized image URL for better performance
    public function getOptimizedImageUrlAttribute()
    {
        return ImageHelper::getImageUrl($this->attributes['image_url'] ?? null, 'images/facilities/default-alat.jpg');
    }
}
