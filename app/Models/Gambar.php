<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use App\Helpers\ImageHelper;

class Gambar extends Model
{
    use HasFactory;

    protected $table = 'gambar';
    
    // Menggunakan UUID sebagai primary key
    protected $keyType = 'string';
    public $incrementing = false;

    protected $fillable = [
        'pengurusId',
        'acaraId',
        'url',
        'kategori',
        'judul',
        'deskripsi',
        'isVisible'
    ];

    protected $casts = [
        'kategori' => 'string',
        'isVisible' => 'boolean'
    ];

    // Generate UUID saat create
    protected static function boot()
    {
        parent::boot();
        
        static::creating(function ($model) {
            if (empty($model->id)) {
                $model->id = Str::uuid();
            }
            // Default isVisible to true
            if (!isset($model->isVisible)) {
                $model->isVisible = true;
            }
        });
    }

    // Relasi dengan Artikel
    public function artikel()
    {
        return $this->belongsTo(Artikel::class, 'acaraId');
    }

    // Relasi dengan BiodataPengurus (for PENGURUS category)
    public function biodataPengurus()
    {
        return $this->belongsTo(BiodataPengurus::class, 'pengurusId');
    }

    // Scope untuk gambar pengurus
    public function scopePengurus($query)
    {
        return $query->where('kategori', 'PENGURUS');
    }

    // Scope untuk gambar acara
    public function scopeAcara($query)
    {
        return $query->where('kategori', 'ACARA');
    }

    // Scope untuk gambar fasilitas
    public function scopeFasilitas($query)
    {
        return $query->where('kategori', 'FASILITAS');
    }

    // Scope untuk gambar yang visible
    public function scopeVisible($query)
    {
        return $query->where('isVisible', true);
    }

    // Scope untuk gambar yang tidak visible
    public function scopeHidden($query)
    {
        return $query->where('isVisible', false);
    }

    // Get full URL untuk gambar - IMPROVED for hosting compatibility
    public function getFullUrlAttribute()
    {
        $defaultImage = $this->getDefaultImageByCategory();
        return ImageHelper::getImageUrl($this->url, $defaultImage);
    }

    // Get default image based on category
    private function getDefaultImageByCategory()
    {
        $defaults = [
            'PENGURUS' => 'images/staff/default-staff.svg',
            'ACARA' => 'images/gallery/default-event.svg',
            'FASILITAS' => 'images/equipment/default-equipment.svg'
        ];

        return $defaults[$this->kategori] ?? 'images/default/placeholder.svg';
    }

    // Get optimized image URL for different sizes
    public function getOptimizedUrlAttribute()
    {
        return ImageHelper::getImageUrl($this->url);
    }

    // Get kategori label
    public function getKategoriLabelAttribute()
    {
        $labels = [
            'PENGURUS' => 'Pengurus',
            'ACARA' => 'Acara',
            'FASILITAS' => 'Fasilitas'
        ];
        
        return $labels[$this->kategori] ?? $this->kategori;
    }

    // Get image info
    public function getImageInfoAttribute()
    {
        return ImageHelper::getImageInfo($this->url);
    }
} 