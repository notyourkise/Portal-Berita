<?php
/**
 * Storage File Server
 * 
 * This script serves files from storage/app/public when symlink is not working.
 * Only use this as a fallback when PHP symlink is not available.
 */

// Get the requested path
$requestUri = $_SERVER['REQUEST_URI'];

// Remove query string if present
$path = parse_url($requestUri, PHP_URL_PATH);

// Remove /storage/ prefix to get the actual file path
$storagePath = preg_replace('#^/storage/#', '', $path);

if (empty($storagePath)) {
    http_response_code(404);
    exit('File not found');
}

// Build the actual file path
$filePath = __DIR__ . '/../storage/app/public/' . $storagePath;

// Security: Prevent directory traversal
$realPath = realpath($filePath);
$basePath = realpath(__DIR__ . '/../storage/app/public');

if ($realPath === false || strpos($realPath, $basePath) !== 0) {
    http_response_code(404);
    exit('File not found');
}

if (!file_exists($realPath) || is_dir($realPath)) {
    http_response_code(404);
    exit('File not found');
}

// Get file info
$finfo = finfo_open(FILEINFO_MIME_TYPE);
$mimeType = finfo_file($finfo, $realPath);
finfo_close($finfo);

// Set cache headers (1 week)
$maxAge = 604800;
header('Cache-Control: public, max-age=' . $maxAge);
header('Expires: ' . gmdate('D, d M Y H:i:s', time() + $maxAge) . ' GMT');
header('Last-Modified: ' . gmdate('D, d M Y H:i:s', filemtime($realPath)) . ' GMT');

// Output file
header('Content-Type: ' . $mimeType);
header('Content-Length: ' . filesize($realPath));
readfile($realPath);
exit;
