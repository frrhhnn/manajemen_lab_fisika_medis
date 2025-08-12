<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Kunjungan extends Model
{
    use HasFactory;

    protected $table = 'kunjungan';
    
    // Menggunakan custom ID sebagai primary key
    protected $keyType = 'string';
    public $incrementing = false;
    protected $fillable = [
        'namaPengunjung',
        'tujuan',
        'jumlahPengunjung',
        'status',
        'noHp',
        'namaInstansi',
        'suratPengajuan'
    ];

    protected $casts = [
        'jumlahPengunjung' => 'integer',
    ];

    // Generate custom ID dengan prefix KJG- saat create
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
     * Generate custom ID dengan format: KJG-YYYYMMDD-XXXX
     * Contoh: KJG-20231225-0001
     */
    public static function generateCustomId()
    {
        $today = now()->format('Ymd'); // Format: 20231225
        $prefix = 'KJG-' . $today . '-';
        
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

    // Relationships
    public function jadwal()
    {
        return $this->hasOne(Jadwal::class, 'kunjunganId');
    }

    // Scopes
    public function scopePending($query)
    {
        return $query->where('status', 'PENDING');
    }

    public function scopeProcessing($query)
    {
        return $query->where('status', 'PROCESSING');
    }

    public function scopeCompleted($query)
    {
        return $query->where('status', 'COMPLETED');
    }

    public function scopeCancelled($query)
    {
        return $query->where('status', 'CANCELLED');
    }

    // Accessors
    public function getStatusLabelAttribute()
    {
        return match($this->status) {
            'PENDING' => 'Menunggu',
            'PROCESSING' => 'Disetujui',
            'COMPLETED' => 'Selesai',
            'CANCELLED' => 'Dibatalkan',
            default => $this->status
        };
    }

    public function getStatusColorAttribute()
    {
        return match($this->status) {
            'PENDING' => 'warning',
            'PROCESSING' => 'info',
            'COMPLETED' => 'success',
            'CANCELLED' => 'danger',
            default => 'secondary'
        };
    }

    // Methods
    public function canBeCancelled()
    {
        return in_array($this->status, ['PENDING']);
    }

    public function canBeApproved()
    {
        return in_array($this->status, ['PENDING']);
    }

    public function canBeCompleted()
    {
        return in_array($this->status, ['PROCESSING']);
    }
} 