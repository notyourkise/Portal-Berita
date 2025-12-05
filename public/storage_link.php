<?php
/**
 * Script untuk membuat symlink storage di hosting yang tidak support exec()
 * Jalankan sekali: https://domain.com/storage_link.php
 * Hapus file ini setelah berhasil!
 */

$target = $_SERVER['DOCUMENT_ROOT'] . '/../storage/app/public';
$link = $_SERVER['DOCUMENT_ROOT'] . '/storage';

// Cek apakah symlink sudah ada
if (file_exists($link)) {
    echo "Symlink sudah ada di: " . $link;
    exit;
}

// Buat symlink
if (symlink($target, $link)) {
    echo "✅ Symlink berhasil dibuat!<br>";
    echo "Target: " . $target . "<br>";
    echo "Link: " . $link . "<br>";
    echo "<br><strong style='color:red;'>⚠️ HAPUS FILE INI SEKARANG untuk keamanan!</strong>";
} else {
    echo "❌ Gagal membuat symlink.<br>";
    echo "Coba buat manual via File Manager Hostinger:<br>";
    echo "1. Buka File Manager<br>";
    echo "2. Buat folder 'storage' di public_html<br>";
    echo "3. Copy isi dari storage/app/public ke public_html/storage<br>";
}
