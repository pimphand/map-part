<?php

namespace App\Models\CommandCenter;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;

class DataMap extends Model
{
    protected $fillable = [
        'judul',
        'data',
        'status',
        'gambar',
        'lat',
        'lng',
        'kategori',
        'keterangan'
    ];

    protected $casts = [
        'data' => 'array',
    ];

    /**
     * Handle image upload and convert to WebP
     */
    public function uploadImage($file, $path = 'data-maps')
    {
        if (!$file) {
            return null;
        }

        // Generate unique filename
        $filename = time() . '_' . uniqid() . '.webp';
        $fullPath = $path . '/' . $filename;

        // Convert image to WebP using Intervention Image
        $manager = new ImageManager(new Driver());
        $image = $manager->read($file);

        // Resize if too large (max width 1920px)
        if ($image->width() > 1920) {
            $image->scaleDown(width: 1920);
        }

        // Convert to WebP with 85% quality
        $image->toWebp(85);

        // Store the image
        $imageData = $image->toWebp(85);
        Storage::disk('public')->put($fullPath, $imageData);

        return $fullPath;
    }

    /**
     * Get the full URL for the image
     */
    public function getImageUrlAttribute()
    {
        if (!$this->gambar) {
            return null;
        }

        return asset('storage/' . $this->gambar);
    }

    /**
     * Delete the associated image when model is deleted
     */
    protected static function boot()
    {
        parent::boot();

        static::deleting(function ($dataMap) {
            if ($dataMap->gambar) {
                Storage::disk('public')->delete($dataMap->gambar);
            }
        });
    }
}
