<?php

namespace Database\Seeders;

use App\Models\Tag;
use Illuminate\Database\Seeder;

class TagSeeder extends Seeder
{
    /**
     * Run the database seeders.
     */
    public function run(): void
    {
        $tags = [
            // Politik
            ['name' => 'Nasional', 'description' => 'Berita politik nasional'],
            ['name' => 'Daerah', 'description' => 'Berita politik daerah'],
            ['name' => 'Pemilu', 'description' => 'Berita pemilihan umum'],
            ['name' => 'Pemerintahan', 'description' => 'Berita pemerintahan'],
            
            // Ekonomi
            ['name' => 'Bisnis', 'description' => 'Berita bisnis dan usaha'],
            ['name' => 'Keuangan', 'description' => 'Berita keuangan dan perbankan'],
            ['name' => 'Pasar Modal', 'description' => 'Berita saham dan investasi'],
            ['name' => 'UMKM', 'description' => 'Berita usaha mikro kecil menengah'],
            
            // Teknologi
            ['name' => 'Digital', 'description' => 'Berita teknologi digital'],
            ['name' => 'Gadget', 'description' => 'Review dan berita gadget'],
            ['name' => 'Startup', 'description' => 'Berita startup dan tech company'],
            ['name' => 'Inovasi', 'description' => 'Berita inovasi teknologi'],
            
            // Olahraga
            ['name' => 'Sepakbola', 'description' => 'Berita sepakbola'],
            ['name' => 'Basket', 'description' => 'Berita basket'],
            ['name' => 'Tenis', 'description' => 'Berita tenis'],
            ['name' => 'Bulutangkis', 'description' => 'Berita bulutangkis'],
            ['name' => 'MotoGP', 'description' => 'Berita MotoGP dan balap motor'],
            
            // Hiburan
            ['name' => 'Film', 'description' => 'Review dan berita film'],
            ['name' => 'Musik', 'description' => 'Berita musik dan musisi'],
            ['name' => 'Selebriti', 'description' => 'Berita selebriti'],
            ['name' => 'K-Pop', 'description' => 'Berita K-Pop'],
            
            // Gaya Hidup
            ['name' => 'Fashion', 'description' => 'Berita mode dan fashion'],
            ['name' => 'Kuliner', 'description' => 'Berita kuliner dan resep'],
            ['name' => 'Wisata', 'description' => 'Berita wisata dan travel'],
            ['name' => 'Otomotif', 'description' => 'Berita otomotif'],
            
            // Kesehatan
            ['name' => 'Tips Sehat', 'description' => 'Tips hidup sehat'],
            ['name' => 'Nutrisi', 'description' => 'Berita nutrisi dan diet'],
            ['name' => 'Olahraga', 'description' => 'Tips olahraga dan fitness'],
            ['name' => 'Mental', 'description' => 'Kesehatan mental'],
            
            // Pendidikan
            ['name' => 'Sekolah', 'description' => 'Berita pendidikan sekolah'],
            ['name' => 'Universitas', 'description' => 'Berita pendidikan tinggi'],
            ['name' => 'Beasiswa', 'description' => 'Info beasiswa'],
            ['name' => 'Tips Belajar', 'description' => 'Tips belajar efektif'],
        ];

        foreach ($tags as $tag) {
            Tag::updateOrCreate(
                ['name' => $tag['name']],
                [
                    'slug' => \Str::slug($tag['name']),
                    'description' => $tag['description'],
                ]
            );
        }

        $this->command->info('Tags seeded successfully!');
    }
}
