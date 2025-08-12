<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Artikel extends Model
{
    use HasFactory;

    protected $table = 'artikel';
    
    // Menggunakan UUID sebagai primary key
    protected $keyType = 'string';
    public $incrementing = false;

    protected $fillable = [
        'namaAcara',
        'deskripsi',
        'penulis',
        'tanggalAcara'
    ];

    protected $casts = [
        'tanggalAcara' => 'datetime'
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

    // Route model binding untuk UUID
    public function getRouteKeyName()
    {
        return 'id';
    }

    // Relasi dengan Gambar
    public function gambar()
    {
        return $this->hasMany(Gambar::class, 'acaraId');
    }

    // Get featured image
    public function getFeaturedImageAttribute()
    {
        $firstImage = $this->gambar->first();
        return $firstImage ? $firstImage->fullUrl : asset('images/facilities/default-alat.jpg');
    }

    // Get formatted date
    public function getFormattedDateAttribute()
    {
        return $this->tanggalAcara->format('d F Y');
    }

    // Get excerpt from description
    public function getExcerptAttribute()
    {
        return Str::limit(strip_tags($this->deskripsi), 150);
    }

    // Scope for latest articles
    public function scopeLatest($query)
    {
        return $query->orderBy('tanggalAcara', 'desc');
    }

    // Scope for published articles (you might want to add a status field later)
    public function scopePublished($query)
    {
        // For now, show all articles since we don't have a status field
        // You can add a status field later if needed
        return $query;
    }
}