<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;

class ImageHelper
{
    /**
     * Get standardized image URL for hosting compatibility
     * 
     * @param string|null $imagePath
     * @param string $defaultImage
     * @return string
     */
    public static function getImageUrl($imagePath, $defaultImage = 'images/default/placeholder.png')
    {
        // If no image path provided, return default
        if (empty($imagePath)) {
            return self::getDefaultImageUrl($defaultImage);
        }

        // If already a full URL (http/https), return as is
        if (self::isFullUrl($imagePath)) {
            return $imagePath;
        }

        // Handle different path formats for hosting compatibility
        $cleanPath = self::cleanImagePath($imagePath);

        // Check if file exists in storage or public directory
        if (self::imageExists($cleanPath)) {
            return self::buildImageUrl($cleanPath);
        }

        // If image doesn't exist, return default
        return self::getDefaultImageUrl($defaultImage);
    }

    /**
     * Clean and normalize image path
     */
    private static function cleanImagePath($imagePath)
    {
        // Remove leading slash
        $cleanPath = ltrim($imagePath, '/');
        
        // Remove 'public/' prefix if exists (from storage)
        $cleanPath = preg_replace('/^public\//', '', $cleanPath);
        
        // Ensure forward slashes for web compatibility
        $cleanPath = str_replace('\\', '/', $cleanPath);
        
        return $cleanPath;
    }

    /**
     * Check if image file exists in storage or public directory
     */
    private static function imageExists($imagePath)
    {
        // Check in storage/app/public
        if (Storage::disk('public')->exists($imagePath)) {
            return true;
        }

        // Check in public directory directly
        $publicPath = public_path($imagePath);
        if (File::exists($publicPath)) {
            return true;
        }

        return false;
    }

    /**
     * Build proper image URL for production hosting
     */
    private static function buildImageUrl($imagePath)
    {
        // For production hosting, we want to use asset() for proper URL generation
        // This will handle the base URL correctly when deployed
        
        // If file is in storage (accessed via symlink)
        if (Storage::disk('public')->exists($imagePath)) {
            return asset('storage/' . $imagePath);
        }

        // If file is in public directory
        return asset($imagePath);
    }

    /**
     * Get default image URL
     */
    private static function getDefaultImageUrl($defaultImage)
    {
        // Ensure default image exists, otherwise use a safe fallback
        $safeFallback = 'data:image/svg+xml;base64,' . base64_encode(
            '<svg xmlns="http://www.w3.org/2000/svg" width="300" height="200" viewBox="0 0 300 200" fill="#f3f4f6">
                <rect width="300" height="200" fill="#e5e7eb"/>
                <text x="150" y="100" text-anchor="middle" fill="#9ca3af" font-family="Arial" font-size="14">No Image</text>
            </svg>'
        );

        if (self::imageExists($defaultImage)) {
            return asset($defaultImage);
        }

        return $safeFallback;
    }

    /**
     * Check if URL is already a full URL
     */
    private static function isFullUrl($url)
    {
        return preg_match('/^https?:\/\//', $url) || str_starts_with($url, 'data:');
    }

    /**
     * Store uploaded image with proper naming and structure
     * 
     * @param \Illuminate\Http\UploadedFile $file
     * @param string $directory (staff, articles, gallery, equipment)
     * @param string $prefix
     * @return string Storage path
     */
    public static function storeImage($file, $directory, $prefix = '')
    {
        // Generate unique filename
        $extension = $file->getClientOriginalExtension();
        $filename = $prefix . '_' . time() . '_' . uniqid() . '.' . $extension;
        
        // Store in storage/app/public/{directory}
        $path = $file->storeAs($directory, $filename, 'public');
        
        return $path;
    }

    /**
     * Delete image from storage
     * 
     * @param string $imagePath
     * @return bool
     */
    public static function deleteImage($imagePath)
    {
        if (empty($imagePath)) {
            return false;
        }

        $cleanPath = self::cleanImagePath($imagePath);

        // Try to delete from storage
        if (Storage::disk('public')->exists($cleanPath)) {
            return Storage::disk('public')->delete($cleanPath);
        }

        return false;
    }

    /**
     * Get image size and info
     * 
     * @param string $imagePath
     * @return array|null
     */
    public static function getImageInfo($imagePath)
    {
        $cleanPath = self::cleanImagePath($imagePath);

        if (Storage::disk('public')->exists($cleanPath)) {
            $fullPath = Storage::disk('public')->path($cleanPath);
            $info = getimagesize($fullPath);
            
            if ($info) {
                return [
                    'width' => $info[0],
                    'height' => $info[1],
                    'type' => $info[2],
                    'mime' => $info['mime'],
                    'size' => Storage::disk('public')->size($cleanPath)
                ];
            }
        }

        return null;
    }

    /**
     * Generate responsive image sizes (for future use)
     * 
     * @param string $imagePath
     * @param array $sizes
     * @return array
     */
    public static function generateResponsiveSizes($imagePath, $sizes = [300, 600, 900, 1200])
    {
        // This is a placeholder for future implementation
        // Could be implemented with intervention/image package
        return [
            'original' => self::getImageUrl($imagePath),
            'sizes' => []
        ];
    }
}
