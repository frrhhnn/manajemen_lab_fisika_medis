<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use App\Helpers\ImageHelper;

class BiodataPengurus extends Model
{
    use HasFactory;

    protected $table = 'biodatapengurus';
    
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
            // Use the improved fullUrl from Gambar model
            return $gambar->fullUrl;
        }
        // Use ImageHelper for consistent default image handling
        return ImageHelper::getImageUrl(null, 'images/staff/default-staff.svg');
    }

    // Get optimized image URL for better performance
    public function getOptimizedImageUrlAttribute()
    {
        $gambar = $this->fotoPengurus;
        if ($gambar) {
            return $gambar->optimizedUrl;
        }
        return ImageHelper::getImageUrl(null, 'images/staff/default-staff.svg');
    }
}