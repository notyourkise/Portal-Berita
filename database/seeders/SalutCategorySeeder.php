<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;
use App\Models\Tag;
use Illuminate\Support\Str;

class SalutCategorySeeder extends Seeder
{
    public function run(): void
    {
        // Categories untuk SALUT UT Samarinda
        $categories = [
            ['name' => 'Pengumuman', 'order' => 1],
            ['name' => 'Berita', 'order' => 2],
            ['name' => 'Pendidikan', 'order' => 3],
            ['name' => 'Kegiatan Mahasiswa', 'order' => 4],
            ['name' => 'Tutorial', 'order' => 5],
            ['name' => 'Tips & Panduan', 'order' => 6],
            ['name' => 'Informasi Akademik', 'order' => 7],
            ['name' => 'Prestasi', 'order' => 8],
        ];

        foreach ($categories as $category) {
            Category::create([
                'name' => $category['name'],
                'slug' => Str::slug($category['name']),
                'description' => 'Kategori ' . $category['name'] . ' SALUT UT Samarinda',
                'is_active' => true,
                'order' => $category['order'],
            ]);
        }

        // Tags untuk SALUT UT Samarinda
        $tags = [
            // Layanan Akademik
            'Registrasi',
            'Pendaftaran',
            'Admisi',
            'Mata Kuliah',
            'Jadwal Kuliah',
            'Tutorial Online',
            'Ujian',
            'UAS',
            'Tugas',
            'Kalender Akademik',
            
            // Program Studi
            'S1',
            'S2',
            'S3',
            'D3',
            'D4',
            'FKIP',
            'FEB',
            'FST',
            'FHISIP',
            
            // Layanan Mahasiswa
            'Bimbingan Belajar',
            'Konsultasi',
            'Administrasi',
            'Legalisir',
            'Transkrip',
            'Ijazah',
            'KTM',
            'Beasiswa',
            
            // Kegiatan
            'Wisuda',
            'Seminar',
            'Workshop',
            'Pelatihan',
            'Webinar',
            'Sosialisasi',
            
            // Informasi Umum
            'Mahasiswa Baru',
            'Alumni',
            'Biaya Kuliah',
            'Fasilitas',
            'Kampus',
            'Samarinda',
            'Kalimantan Timur',
            
            // Tips
            'Cara Kuliah',
            'Manajemen Waktu',
            'Belajar Online',
            'Motivasi',
            'Karir',
        ];

        foreach ($tags as $tagName) {
            Tag::create([
                'name' => $tagName,
                'slug' => Str::slug($tagName),
            ]);
        }
    }
}
