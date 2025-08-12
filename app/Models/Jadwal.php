<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Jadwal extends Model
{
    use HasFactory, HasUuids;

    protected $table = 'jadwal';

    protected $fillable = [
        'kunjunganId',
        'tanggal',
        'waktuKunjungan',
        'isActive'
    ];

    protected $casts = [
        'tanggal' => 'date',
        'waktuKunjungan' => 'string',
        'isActive' => 'boolean'
    ];

    public function kunjungan()
    {
        return $this->belongsTo(Kunjungan::class, 'kunjunganId');
    }

    // Scopes
    public function scopeActive($query)
    {
        return $query->where('isActive', true);
    }

    public function scopeByDate($query, $date)
    {
        return $query->where('tanggal', $date);
    }

    public function scopeByWaktu($query, $waktuKunjungan)
    {
        return $query->where('waktuKunjungan', $waktuKunjungan);
    }

    public function scopeAvailable($query)
    {
        return $query->where('isActive', true)->whereNull('kunjunganId');
    }

    public function scopeWithKunjungan($query)
    {
        return $query->whereNotNull('kunjunganId');
    }

    // Accessors
    public function getTimeLabelAttribute()
    {
        if (!$this->waktuKunjungan) {
            return 'Tidak ditentukan';
        }
        return str_replace('-', ' - ', $this->waktuKunjungan);
    }

    public function getDurationAttribute()
    {
        if (!$this->waktuKunjungan) {
            return 0;
        }
        $times = explode('-', $this->waktuKunjungan);
        if (count($times) !== 2) return 0;
        
        $start = \Carbon\Carbon::createFromFormat('H:i', trim($times[0]));
        $end = \Carbon\Carbon::createFromFormat('H:i', trim($times[1]));
        return $start->diffInHours($end);
    }

    public function getIsBookedAttribute()
    {
        return !is_null($this->kunjunganId);
    }

    public function getKunjunganInfoAttribute()
    {
        if ($this->kunjungan) {
            $status = $this->kunjungan->status === 'COMPLETED' ? '✓' : '';
            return $status . ' ' . $this->kunjungan->namaPengunjung . ' (' . $this->time_label . ')';
        }
        return null;
    }

    // Methods
    public function isAvailable()
    {
        return $this->isActive && is_null($this->kunjunganId);
    }

    public function getEndTime()
    {
        if (!$this->waktuKunjungan) return null;
        $times = explode('-', $this->waktuKunjungan);
        return count($times) === 2 ? trim($times[1]) : null;
    }
    
    public function getStartTime()
    {
        if (!$this->waktuKunjungan) return null;
        $times = explode('-', $this->waktuKunjungan);
        return count($times) === 2 ? trim($times[0]) : null;
    }

    // Static methods for generating default schedule
    public static function getDefaultSlots()
    {
        return [
            '09:00-10:00',
            '10:00-11:00',
            '11:00-12:00',
            '12:00-13:00',
            '13:00-14:00',
            '14:00-15:00',
            '15:00-16:00',
            '16:00-17:00'
        ];
    }

    public static function createDefaultSchedule($tanggal)
    {
        $slots = self::getDefaultSlots();
        $schedules = [];

        foreach ($slots as $waktuKunjungan) {
            $schedule = self::firstOrCreate([
                'tanggal' => $tanggal,
                'waktuKunjungan' => $waktuKunjungan
            ], [
                'isActive' => true,
                'kunjunganId' => null
            ]);
            $schedules[] = $schedule;
        }

        return $schedules;
    }
} 