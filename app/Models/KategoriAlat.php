<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class KategoriAlat extends Model
{
    use HasFactory;

    protected $table = 'kategori_alat';
    
    // Menggunakan UUID sebagai primary key
    protected $keyType = 'string';
    public $incrementing = false;

    protected $fillable = [
        'nama_kategori'
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

    // Relasi dengan Alat
    public function alat()
    {
        return $this->hasMany(Alat::class, 'nama_kategori', 'nama_kategori');
    }
}
