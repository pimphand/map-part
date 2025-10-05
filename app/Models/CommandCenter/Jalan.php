<?php

namespace App\Models\CommandCenter;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Jalan extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama',
        'keterangan',
        'type',
        'status',
        'gambar',
        'geo_json',
        'kategori'
    ];

    protected $casts = [
        'geo_json' => 'array',
        'created_at' => 'datetime',
        'updated_at' => 'datetime'
    ];

    /**
     * Get the image URL for the road
     */
    public function getImageUrlAttribute()
    {
        if ($this->gambar) {
            return asset('storage/' . $this->gambar);
        }
        return null;
    }

    /**
     * Get the formatted type name
     */
    public function getFormattedTypeAttribute()
    {
        $types = [
            'Bagus' => 'Jalan Bagus',
            'Rusak' => 'Jalan Rusak',
            'Gang' => 'Jalan Gang'
        ];

        return $types[$this->type] ?? $this->type;
    }

    /**
     * Scope to filter by road type
     */
    public function scopeByType($query, $type)
    {
        return $query->where('type', $type);
    }

    /**
     * Scope to filter by status
     */
    public function scopeByStatus($query, $status)
    {
        return $query->where('status', $status);
    }
}
