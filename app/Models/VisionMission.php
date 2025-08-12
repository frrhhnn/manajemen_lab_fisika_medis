<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VisionMission extends Model
{
    use HasFactory;

    protected $fillable = [
        'vision',
        'mission'
    ];

    /**
     * Get the latest vision and mission
     */
    public static function getLatest()
    {
        return self::latest()->first();
    }
}
