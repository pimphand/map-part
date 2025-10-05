<?php

namespace App\Models\CommandCenter;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class PajakBumiBangunan extends Model
{
    protected $table = 'pajak_bumi_bangunans';

    protected $fillable = [
        'nama',
        'keterangan',
        'status',
        'gambar',
        'geo_json',
        'properties',
        'kategori',
    ];

    protected $casts = [
        'geo_json' => 'array',
        'properties' => 'array',
    ];

    public function getImageUrlAttribute(): ?string
    {
        if (!$this->gambar) {
            return null;
        }

        // If already a full URL (for future flexibility)
        if (preg_match('/^https?:\\/\\//', $this->gambar) === 1) {
            return $this->gambar;
        }

        return Storage::disk('public')->url($this->gambar);
    }
}
