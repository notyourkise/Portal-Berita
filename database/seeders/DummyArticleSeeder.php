<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Article;
use App\Models\Category;
use App\Models\Tag;
use App\Models\User;
use Illuminate\Support\Str;

class DummyArticleSeeder extends Seeder
{
    public function run(): void
    {
        // Ambil user untuk author
        $author = User::where('email', 'reporter@portalberita.com')->first();
        if (!$author) {
            $author = User::first();
        }

        // Ambil semua tags
        $tags = Tag::all();

        if ($tags->isEmpty()) {
            $this->command->error('Tidak ada tag! Jalankan TagSeeder dulu.');
            return;
        }

        $this->command->info('Membuat artikel dummy untuk ' . $tags->count() . ' tags...');

        $articleTemplates = [
            [
                'title_prefix' => 'Perkembangan Terbaru',
                'excerpt' => 'Berita terkini mengenai perkembangan yang menarik perhatian publik dalam beberapa hari terakhir.',
                'body' => $this->generateBody('perkembangan', 'Situasi terus berkembang dengan adanya berbagai dinamika yang menarik untuk diamati.'),
            ],
            [
                'title_prefix' => 'Analisis Mendalam',
                'excerpt' => 'Tinjauan komprehensif terhadap situasi terkini yang memberikan perspektif baru bagi pembaca.',
                'body' => $this->generateBody('analisis', 'Para ahli memberikan pandangan yang beragam mengenai situasi ini.'),
            ],
            [
                'title_prefix' => 'Berita Terkini',
                'excerpt' => 'Update terbaru yang perlu Anda ketahui mengenai topik yang sedang hangat diperbincangkan.',
                'body' => $this->generateBody('berita', 'Informasi ini dikonfirmasi dari berbagai sumber terpercaya.'),
            ],
        ];

        $count = 0;
        foreach ($tags as $tag) {
            // Ambil kategori berdasarkan tag
            $category = $this->getCategoryForTag($tag);
            
            if (!$category) {
                $this->command->warn("Skip tag {$tag->name} - kategori tidak ditemukan");
                continue;
            }

            // Buat 2-3 artikel per tag
            $numArticles = rand(2, 3);
            
            for ($i = 0; $i < $numArticles; $i++) {
                $template = $articleTemplates[$i % count($articleTemplates)];
                
                $title = $template['title_prefix'] . ' ' . $tag->name . ' ' . ($i + 1);
                
                $article = Article::create([
                    'category_id' => $category->id,
                    'author_id' => $author->id,
                    'title' => $title,
                    'slug' => Str::slug($title) . '-' . time() . rand(100, 999),
                    'excerpt' => $template['excerpt'],
                    'body' => str_replace('[TAG]', $tag->name, $template['body']),
                    'status' => 'published',
                    'published_at' => now()->subDays(rand(1, 30))->subHours(rand(0, 23)),
                    'views' => rand(50, 500),
                    'is_featured' => false,
                    'allow_comments' => true,
                ]);

                // Attach tag ke artikel
                $article->tags()->attach($tag->id);
                
                // Kadang tambahkan tag lain yang satu kategori
                $relatedTags = Tag::whereHas('articles', function($q) use ($category) {
                    $q->where('category_id', $category->id);
                })->where('id', '!=', $tag->id)->take(2)->pluck('id');
                
                if ($relatedTags->isNotEmpty() && rand(0, 1)) {
                    $article->tags()->attach($relatedTags->random());
                }

                $count++;
            }
        }

        $this->command->info("✓ Berhasil membuat {$count} artikel dummy!");
    }

    private function getCategoryForTag($tag)
    {
        $tagCategoryMap = [
            // Politik
            'nasional' => 'Politik',
            'daerah' => 'Politik',
            'pemilu' => 'Politik',
            'pemerintahan' => 'Politik',
            
            // Ekonomi
            'bisnis' => 'Ekonomi',
            'keuangan' => 'Ekonomi',
            'pasar-modal' => 'Ekonomi',
            'umkm' => 'Ekonomi',
            
            // Teknologi
            'digital' => 'Teknologi',
            'gadget' => 'Teknologi',
            'startup' => 'Teknologi',
            'inovasi' => 'Teknologi',
            
            // Olahraga
            'sepakbola' => 'Olahraga',
            'basket' => 'Olahraga',
            'tenis' => 'Olahraga',
            'bulutangkis' => 'Olahraga',
            'motogp' => 'Olahraga',
            
            // Hiburan
            'film' => 'Hiburan',
            'musik' => 'Hiburan',
            'selebriti' => 'Hiburan',
            'k-pop' => 'Hiburan',
            
            // Gaya Hidup
            'fashion' => 'Gaya Hidup',
            'kuliner' => 'Gaya Hidup',
            'wisata' => 'Gaya Hidup',
            'otomotif' => 'Gaya Hidup',
            
            // Kesehatan
            'tips-sehat' => 'Kesehatan',
            'nutrisi' => 'Kesehatan',
            'olahraga-kesehatan' => 'Kesehatan',
            'mental' => 'Kesehatan',
            
            // Pendidikan
            'sekolah' => 'Pendidikan',
            'universitas' => 'Pendidikan',
            'beasiswa' => 'Pendidikan',
            'tips-belajar' => 'Pendidikan',
        ];

        $categoryName = $tagCategoryMap[$tag->slug] ?? null;
        
        if (!$categoryName) {
            return null;
        }

        return Category::where('name', $categoryName)->first();
    }

    private function generateBody($type, $additionalText)
    {
        $paragraphs = [
            "<p><strong>[TAG]</strong> - " . $additionalText . " Berita ini menjadi perhatian utama di berbagai kalangan masyarakat.</p>",
            
            "<p>Dalam perkembangan terkini, berbagai pihak telah memberikan respons yang beragam terhadap situasi ini. Hal ini menunjukkan kompleksitas permasalahan yang ada dan memerlukan perhatian serius dari semua pemangku kepentingan.</p>",
            
            "<p>Menurut sumber yang dapat dipercaya, situasi ini telah berlangsung selama beberapa waktu dan kini mencapai titik krusial. Para ahli menyarankan agar masyarakat tetap mengikuti perkembangan berita ini melalui sumber-sumber informasi yang kredibel.</p>",
            
            "<h2>Latar Belakang</h2>",
            "<p>Kronologi peristiwa ini dimulai beberapa waktu yang lalu dan telah mengalami berbagai dinamika. Pemahaman mengenai konteks historis sangat penting untuk mendapatkan gambaran yang komprehensif mengenai situasi saat ini.</p>",
            
            "<p>Berbagai faktor turut berkontribusi terhadap perkembangan situasi ini, mulai dari aspek sosial, ekonomi, hingga politik. Interaksi antar berbagai faktor tersebut menciptakan kompleksitas yang memerlukan analisis mendalam.</p>",
            
            "<h2>Dampak dan Implikasi</h2>",
            "<p>Dampak dari situasi ini dirasakan oleh berbagai pihak, baik secara langsung maupun tidak langsung. Masyarakat diharapkan untuk tetap waspada dan mengikuti perkembangan informasi terkini.</p>",
            
            "<p>Para pengamat melihat bahwa implikasi jangka panjang dari peristiwa ini akan sangat signifikan. Oleh karena itu, diperlukan langkah-langkah strategis dan terukur dalam merespons situasi yang ada.</p>",
            
            "<h2>Respons dan Tanggapan</h2>",
            "<p>Berbagai pihak telah menyampaikan tanggapan mereka terhadap situasi ini. Keberagaman perspektif tersebut menunjukkan pentingnya dialog dan komunikasi yang konstruktif dalam mencari solusi terbaik.</p>",
            
            "<p>Pemerintah dan pihak terkait telah mengambil beberapa langkah responsif untuk menangani situasi ini. Koordinasi antar lembaga menjadi kunci dalam memastikan penanganan yang efektif dan efisien.</p>",
            
            "<h2>Kesimpulan</h2>",
            "<p>Situasi ini terus berkembang dan memerlukan perhatian berkelanjutan dari semua pihak. Masyarakat diimbau untuk terus mengikuti perkembangan berita melalui media-media terpercaya dan tidak mudah terpengaruh oleh informasi yang belum terverifikasi.</p>",
            
            "<p>Ke depannya, diharapkan akan ada penyelesaian yang komprehensif dan berkelanjutan yang dapat mengakomodasi kepentingan semua pihak yang terlibat. Transparansi dan akuntabilitas menjadi prinsip penting dalam proses tersebut.</p>",
        ];

        return implode("\n\n", $paragraphs);
    }
}
