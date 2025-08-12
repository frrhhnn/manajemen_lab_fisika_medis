<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

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

    // Get full URL untuk gambar
    public function getFullUrlAttribute()
    {
        // Jika URL sudah berupa full URL (http/https), return as is
        if (str_starts_with($this->url, 'http')) {
            return $this->url;
        }
        
        // Jika URL berupa path relatif, convert ke full URL
        return asset($this->url);
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
} 