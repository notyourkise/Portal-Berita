<?php

namespace App\Services;

use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;
use Illuminate\Support\Facades\Storage;

class ImageOptimizationService
{
    protected ImageManager $manager;

    public function __construct()
    {
        $this->manager = new ImageManager(new Driver());
    }

    /**
     * Optimize and resize image for article covers
     * 
     * @param string $path Original image path in storage
     * @param array $sizes Array of sizes to generate ['width' => height]
     * @return array Generated image paths
     */
    public function optimizeArticleCover(string $path, array $sizes = []): array
    {
        $defaultSizes = [
            'large' => ['width' => 1200, 'height' => 675],   // Headline
            'medium' => ['width' => 800, 'height' => 450],   // Article cards
            'small' => ['width' => 400, 'height' => 225],    // Mobile
            'thumbnail' => ['width' => 200, 'height' => 113], // Thumbnails
        ];

        $sizes = !empty($sizes) ? $sizes : $defaultSizes;
        $generatedPaths = [];

        $fullPath = Storage::disk('public')->path($path);
        $image = $this->manager->read($fullPath);
        
        // Get original info
        $pathInfo = pathinfo($path);
        $directory = $pathInfo['dirname'];
        $filename = $pathInfo['filename'];
        $extension = $pathInfo['extension'];

        foreach ($sizes as $sizeName => $dimensions) {
            // Create resized version
            $resized = $image->cover(
                $dimensions['width'], 
                $dimensions['height']
            );

            // Encode with quality optimization
            $quality = 85; // Good balance between quality and file size
            if ($sizeName === 'small' || $sizeName === 'thumbnail') {
                $quality = 80; // Lower quality for smaller sizes
            }

            // Generate new filename
            $newFilename = "{$filename}_{$sizeName}.{$extension}";
            $newPath = "{$directory}/{$newFilename}";
            $fullNewPath = Storage::disk('public')->path($newPath);

            // Save optimized image
            if ($extension === 'jpg' || $extension === 'jpeg') {
                $resized->toJpeg($quality)->save($fullNewPath);
            } elseif ($extension === 'png') {
                $resized->toPng()->save($fullNewPath);
            } elseif ($extension === 'webp') {
                $resized->toWebp($quality)->save($fullNewPath);
            }

            $generatedPaths[$sizeName] = $newPath;
        }

        return $generatedPaths;
    }

    /**
     * Convert image to WebP format
     * 
     * @param string $path Original image path
     * @param int $quality Quality (1-100)
     * @return string Path to WebP image
     */
    public function convertToWebp(string $path, int $quality = 85): string
    {
        $fullPath = Storage::disk('public')->path($path);
        $image = $this->manager->read($fullPath);
        
        $pathInfo = pathinfo($path);
        $directory = $pathInfo['dirname'];
        $filename = $pathInfo['filename'];
        
        $webpFilename = "{$filename}.webp";
        $webpPath = "{$directory}/{$webpFilename}";
        $fullWebpPath = Storage::disk('public')->path($webpPath);

        $image->toWebp($quality)->save($fullWebpPath);

        return $webpPath;
    }

    /**
     * Create responsive image srcset
     * 
     * @param array $imagePaths Array of image paths from optimizeArticleCover
     * @param string $originalPath Original image path
     * @return string HTML srcset attribute value
     */
    public function generateSrcset(array $imagePaths, string $originalPath): string
    {
        $srcsetParts = [];
        
        $widths = [
            'thumbnail' => 200,
            'small' => 400,
            'medium' => 800,
            'large' => 1200,
        ];

        foreach ($imagePaths as $size => $path) {
            if (isset($widths[$size])) {
                $url = Storage::disk('public')->url($path);
                $srcsetParts[] = "{$url} {$widths[$size]}w";
            }
        }

        return implode(', ', $srcsetParts);
    }

    /**
     * Delete all optimized versions of an image
     * 
     * @param string $originalPath Original image path
     * @return void
     */
    public function deleteOptimizedVersions(string $originalPath): void
    {
        $pathInfo = pathinfo($originalPath);
        $directory = $pathInfo['dirname'];
        $filename = $pathInfo['filename'];
        
        $sizes = ['large', 'medium', 'small', 'thumbnail'];
        $extensions = ['jpg', 'jpeg', 'png', 'webp'];

        foreach ($sizes as $size) {
            foreach ($extensions as $ext) {
                $path = "{$directory}/{$filename}_{$size}.{$ext}";
                if (Storage::disk('public')->exists($path)) {
                    Storage::disk('public')->delete($path);
                }
            }
            
            // Also check for webp version
            $webpPath = "{$directory}/{$filename}_{$size}.webp";
            if (Storage::disk('public')->exists($webpPath)) {
                Storage::disk('public')->delete($webpPath);
            }
        }
    }
}
