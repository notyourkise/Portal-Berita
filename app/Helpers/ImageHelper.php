<?php

if (!function_exists('optimized_image')) {
    /**
     * Generate optimized image HTML with responsive srcset
     * 
     * @param string|null $imagePath Path to the original image
     * @param string $alt Alt text for the image
     * @param string $size Default size (large|medium|small|thumbnail)
     * @param string $class CSS classes
     * @return string HTML img tag with srcset
     */
    function optimized_image(?string $imagePath, string $alt = '', string $size = 'medium', string $class = ''): string
    {
        if (!$imagePath) {
            // Return placeholder image
            return '<img src="/images/placeholder.jpg" alt="' . htmlspecialchars($alt) . '" class="' . htmlspecialchars($class) . '">';
        }

        $storage = Storage::disk('public');
        $pathInfo = pathinfo($imagePath);
        $directory = $pathInfo['dirname'];
        $filename = $pathInfo['filename'];
        $extension = $pathInfo['extension'];

        // Check if optimized versions exist
        $sizes = ['large', 'medium', 'small', 'thumbnail'];
        $srcsetParts = [];
        $widths = [
            'thumbnail' => 200,
            'small' => 400,
            'medium' => 800,
            'large' => 1200,
        ];

        $defaultSrc = $storage->url($imagePath);
        $hasOptimized = false;

        foreach ($sizes as $sizeName) {
            $optimizedPath = "{$directory}/{$filename}_{$sizeName}.{$extension}";
            if ($storage->exists($optimizedPath)) {
                $url = $storage->url($optimizedPath);
                $srcsetParts[] = "{$url} {$widths[$sizeName]}w";
                
                // Use optimized version as default src
                if ($sizeName === $size && !$hasOptimized) {
                    $defaultSrc = $url;
                    $hasOptimized = true;
                }
            }
        }

        $srcset = !empty($srcsetParts) ? 'srcset="' . implode(', ', $srcsetParts) . '"' : '';
        $sizes = !empty($srcsetParts) ? 'sizes="(max-width: 576px) 100vw, (max-width: 992px) 50vw, 33vw"' : '';

        return sprintf(
            '<img src="%s" %s %s alt="%s" class="%s" loading="lazy">',
            htmlspecialchars($defaultSrc),
            $srcset,
            $sizes,
            htmlspecialchars($alt),
            htmlspecialchars($class)
        );
    }
}

if (!function_exists('article_cover')) {
    /**
     * Get article cover image with optimization
     * 
     * @param \App\Models\Article $article
     * @param string $size Size variant (large|medium|small|thumbnail)
     * @param string $class CSS classes
     * @return string HTML img tag
     */
    function article_cover($article, string $size = 'medium', string $class = ''): string
    {
        return optimized_image(
            $article->cover_image,
            $article->title,
            $size,
            $class
        );
    }
}

if (!function_exists('webp_image')) {
    /**
     * Generate picture element with WebP support and fallback
     * 
     * @param string|null $imagePath Path to the original image
     * @param string $alt Alt text
     * @param string $size Size variant
     * @param string $class CSS classes
     * @return string HTML picture element
     */
    function webp_image(?string $imagePath, string $alt = '', string $size = 'medium', string $class = ''): string
    {
        if (!$imagePath) {
            return '<img src="/images/placeholder.jpg" alt="' . htmlspecialchars($alt) . '" class="' . htmlspecialchars($class) . '">';
        }

        $storage = Storage::disk('public');
        $pathInfo = pathinfo($imagePath);
        $directory = $pathInfo['dirname'];
        $filename = $pathInfo['filename'];
        $extension = $pathInfo['extension'];

        // Check for WebP version
        $webpPath = "{$directory}/{$filename}_{$size}.webp";
        $originalOptimized = "{$directory}/{$filename}_{$size}.{$extension}";

        $hasWebp = $storage->exists($webpPath);
        $hasOptimized = $storage->exists($originalOptimized);

        $webpUrl = $hasWebp ? $storage->url($webpPath) : '';
        $fallbackUrl = $hasOptimized ? $storage->url($originalOptimized) : $storage->url($imagePath);

        if ($hasWebp) {
            return sprintf(
                '<picture>
                    <source srcset="%s" type="image/webp">
                    <img src="%s" alt="%s" class="%s" loading="lazy">
                </picture>',
                htmlspecialchars($webpUrl),
                htmlspecialchars($fallbackUrl),
                htmlspecialchars($alt),
                htmlspecialchars($class)
            );
        }

        return sprintf(
            '<img src="%s" alt="%s" class="%s" loading="lazy">',
            htmlspecialchars($fallbackUrl),
            htmlspecialchars($alt),
            htmlspecialchars($class)
        );
    }
}
