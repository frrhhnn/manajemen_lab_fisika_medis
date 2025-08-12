<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class BiodataPengurus extends Model
{
    use HasFactory;

    protected $table = 'biodataPengurus';
    
    protected $keyType = 'string';
    public $incrementing = false;

    protected $fillable = [
        'nama',
        'jabatan',
    ];

    protected static function boot()
    {
        parent::boot();
        
        static::creating(function ($model) {
            if (empty($model->id)) {
                $model->id = Str::uuid();
            }
        });
    }

    public function gambar()
    {
        return $this->hasMany(Gambar::class, 'pengurusId');
    }

    public function getFotoPengurusAttribute()
    {
        return $this->gambar()->where('kategori', 'PENGURUS')->first();
    }

    public function getImageUrlAttribute()
    {
        $gambar = $this->fotoPengurus;
        if ($gambar) {
                    // Gunakan fullUrl dari model Gambar untuk konsistensi
        return $gambar->fullUrl;
        }
        return asset('images/pengurus/default-pengurus.png');
    }
}