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
     * Get the full URL for the image or CCTV URL
     */
    public function getImageUrlAttribute()
    {
        if (!$this->gambar) {
            return null;
        }

        // If it's a CCTV type and gambar contains a URL, return it directly
        if ($this->kategori === 'cctv' && (str_starts_with($this->gambar, 'http://') || str_starts_with($this->gambar, 'https://') || str_starts_with($this->gambar, 'rtsp://'))) {
            return $this->gambar;
        }

        // For regular image files, return the asset URL
        return asset('storage/' . $this->gambar);
    }

    /**
     * Delete the associated image when model is deleted (only for file uploads, not URLs)
     */
    protected static function boot()
    {
        parent::boot();

        static::deleting(function ($dataMap) {
            // Only delete files from storage, not URLs
            if (
                $dataMap->gambar &&
                !str_starts_with($dataMap->gambar, 'http://') &&
                !str_starts_with($dataMap->gambar, 'https://') &&
                !str_starts_with($dataMap->gambar, 'rtsp://')
            ) {
                Storage::disk('public')->delete($dataMap->gambar);
            }
        });
    }
}
