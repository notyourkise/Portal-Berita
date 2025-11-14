<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Tag;
use App\Models\Article;
use App\Models\Page;
use App\Models\User;
use Illuminate\Database\Seeder;

class PortalBeritaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->command->info('🌱 Seeding Portal Berita data...');

        // Create additional users (Reporter & Redaktur)
        $admin = User::where('email', 'admin@admin.com')->first();
        
        $redaktur = User::firstOrCreate(
            ['email' => 'redaktur@admin.com'],
            [
                'name' => 'Redaktur',
                'password' => bcrypt('password'),
                'email_verified_at' => now(),
            ]
        );

        $reporter = User::firstOrCreate(
            ['email' => 'reporter@admin.com'],
            [
                'name' => 'Reporter',
                'password' => bcrypt('password'),
                'email_verified_at' => now(),
            ]
        );

        $this->command->info('✅ Users created');

        // Create Categories
        $categories = [
            [
                'name' => 'Politik',
                'slug' => 'politik',
                'description' => 'Berita seputar politik nasional dan internasional',
                'meta_title' => 'Berita Politik Terkini',
                'meta_description' => 'Kumpulan berita politik terbaru dan terkini',
                'is_active' => true,
                'order' => 1,
            ],
            [
                'name' => 'Ekonomi',
                'slug' => 'ekonomi',
                'description' => 'Berita ekonomi, bisnis, dan keuangan',
                'meta_title' => 'Berita Ekonomi Terkini',
                'meta_description' => 'Informasi ekonomi dan bisnis terbaru',
                'is_active' => true,
                'order' => 2,
            ],
            [
                'name' => 'Teknologi',
                'slug' => 'teknologi',
                'description' => 'Berita teknologi, gadget, dan inovasi',
                'meta_title' => 'Berita Teknologi Terkini',
                'meta_description' => 'Update teknologi dan gadget terbaru',
                'is_active' => true,
                'order' => 3,
            ],
            [
                'name' => 'Olahraga',
                'slug' => 'olahraga',
                'description' => 'Berita olahraga nasional dan internasional',
                'meta_title' => 'Berita Olahraga Terkini',
                'meta_description' => 'Informasi olahraga dan pertandingan terbaru',
                'is_active' => true,
                'order' => 4,
            ],
            [
                'name' => 'Entertainment',
                'slug' => 'entertainment',
                'description' => 'Berita hiburan, selebriti, dan musik',
                'meta_title' => 'Berita Entertainment Terkini',
                'meta_description' => 'Kabar terbaru dunia hiburan dan selebriti',
                'is_active' => true,
                'order' => 5,
            ],
        ];

        foreach ($categories as $category) {
            Category::create($category);
        }

        $this->command->info('✅ Categories created');

        // Create Tags
        $tags = [
            ['name' => 'Breaking News', 'slug' => 'breaking-news'],
            ['name' => 'Trending', 'slug' => 'trending'],
            ['name' => 'Viral', 'slug' => 'viral'],
            ['name' => 'Investigasi', 'slug' => 'investigasi'],
            ['name' => 'Opini', 'slug' => 'opini'],
            ['name' => 'Analisis', 'slug' => 'analisis'],
            ['name' => 'Internasional', 'slug' => 'internasional'],
            ['name' => 'Nasional', 'slug' => 'nasional'],
        ];

        foreach ($tags as $tag) {
            Tag::create($tag);
        }

        $this->command->info('✅ Tags created');

        // Create Sample Articles
        $politik = Category::where('slug', 'politik')->first();
        $teknologi = Category::where('slug', 'teknologi')->first();
        $olahraga = Category::where('slug', 'olahraga')->first();

        $articles = [
            [
                'category_id' => $politik->id,
                'author_id' => $reporter->id,
                'editor_id' => $redaktur->id,
                'title' => 'Sidang Paripurna DPR Membahas RUU Kesehatan',
                'slug' => 'sidang-paripurna-dpr-membahas-ruu-kesehatan',
                'excerpt' => 'DPR RI menggelar sidang paripurna untuk membahas Rancangan Undang-Undang tentang Kesehatan.',
                'body' => '<p>Jakarta - Dewan Perwakilan Rakyat Republik Indonesia (DPR RI) menggelar sidang paripurna pada hari ini untuk membahas Rancangan Undang-Undang (RUU) tentang Kesehatan. Sidang dipimpin oleh Ketua DPR dan dihadiri oleh seluruh anggota dewan.</p><p>Dalam sidang tersebut, berbagai fraksi menyampaikan pandangan mereka terkait RUU Kesehatan. Pembahasan difokuskan pada peningkatan kualitas layanan kesehatan masyarakat dan aksesibilitas terhadap fasilitas kesehatan.</p>',
                'meta_title' => 'Sidang Paripurna DPR Membahas RUU Kesehatan',
                'meta_description' => 'DPR RI gelar sidang paripurna bahas RUU Kesehatan untuk tingkatkan kualitas layanan masyarakat',
                'status' => 'published',
                'published_at' => now()->subDays(1),
                'is_featured' => true,
                'views' => 1250,
            ],
            [
                'category_id' => $teknologi->id,
                'author_id' => $reporter->id,
                'editor_id' => $redaktur->id,
                'title' => 'Peluncuran Smartphone Flagship Terbaru dengan AI Canggih',
                'slug' => 'peluncuran-smartphone-flagship-terbaru-dengan-ai-canggih',
                'excerpt' => 'Produsen smartphone ternama meluncurkan flagship terbarunya dengan fitur AI yang revolusioner.',
                'body' => '<p>Industri teknologi kembali dihebohkan dengan peluncuran smartphone flagship terbaru yang mengintegrasikan kecerdasan buatan (AI) tingkat lanjut. Smartphone ini diklaim mampu memberikan pengalaman pengguna yang lebih personal dan efisien.</p><p>Fitur unggulan meliputi kamera dengan AI photography, battery management cerdas, dan asisten virtual yang lebih responsif. Harga dibanderol mulai dari Rp 15 juta.</p>',
                'meta_title' => 'Smartphone Flagship Terbaru dengan AI Canggih',
                'meta_description' => 'Peluncuran smartphone flagship dengan fitur AI revolusioner untuk pengalaman pengguna terbaik',
                'status' => 'published',
                'published_at' => now()->subHours(12),
                'is_featured' => true,
                'views' => 890,
            ],
            [
                'category_id' => $olahraga->id,
                'author_id' => $reporter->id,
                'editor_id' => null,
                'title' => 'Tim Nasional Indonesia Raih Kemenangan di Kualifikasi',
                'slug' => 'tim-nasional-indonesia-raih-kemenangan-di-kualifikasi',
                'excerpt' => 'Timnas Indonesia berhasil meraih kemenangan penting dalam laga kualifikasi.',
                'body' => '<p>Tim Nasional Indonesia menunjukkan performa impresif dengan meraih kemenangan 3-1 dalam pertandingan kualifikasi. Gol-gol kemenangan dicetak oleh pemain-pemain muda berbakat.</p><p>Kemenangan ini semakin memperkuat posisi Indonesia di klasemen dan membuka peluang besar untuk lolos ke babak selanjutnya.</p>',
                'meta_title' => 'Timnas Indonesia Menang di Kualifikasi',
                'meta_description' => 'Timnas Indonesia raih kemenangan penting 3-1 di laga kualifikasi',
                'status' => 'published',
                'published_at' => now()->subHours(3),
                'is_featured' => false,
                'views' => 567,
            ],
            [
                'category_id' => $teknologi->id,
                'author_id' => $reporter->id,
                'editor_id' => null,
                'title' => 'Draft: Inovasi Terbaru dalam Teknologi Energi Terbarukan',
                'slug' => 'draft-inovasi-terbaru-dalam-teknologi-energi-terbarukan',
                'excerpt' => 'Peneliti mengembangkan teknologi panel surya generasi baru dengan efisiensi tinggi.',
                'body' => '<p>Tim peneliti berhasil mengembangkan teknologi panel surya generasi baru yang diklaim memiliki efisiensi konversi energi hingga 40%.</p>',
                'meta_title' => 'Inovasi Teknologi Energi Terbarukan',
                'meta_description' => 'Panel surya generasi baru dengan efisiensi tinggi',
                'status' => 'draft',
                'published_at' => null,
                'is_featured' => false,
                'views' => 0,
            ],
        ];

        foreach ($articles as $articleData) {
            $article = Article::create($articleData);
            
            // Attach random tags
            $randomTags = Tag::inRandomOrder()->limit(rand(2, 4))->pluck('id');
            $article->tags()->attach($randomTags);
        }

        $this->command->info('✅ Articles created');

        // Create Pages
        $pages = [
            [
                'title' => 'Tentang Kami',
                'slug' => 'tentang-kami',
                'content' => '<h2>Tentang Portal Berita</h2><p>Portal Berita adalah platform media digital yang menyajikan informasi terkini, akurat, dan terpercaya untuk masyarakat Indonesia.</p><p>Kami berkomitmen untuk memberikan berita berkualitas dengan standar jurnalistik profesional.</p>',
                'meta_title' => 'Tentang Kami - Portal Berita',
                'meta_description' => 'Informasi tentang Portal Berita sebagai platform media digital terpercaya',
                'is_active' => true,
                'order' => 1,
            ],
            [
                'title' => 'Kontak',
                'slug' => 'kontak',
                'content' => '<h2>Hubungi Kami</h2><p>Email: redaksi@portalberita.com</p><p>Telepon: +62 21 1234567</p><p>Alamat: Jl. Media No. 123, Jakarta Pusat</p>',
                'meta_title' => 'Kontak Kami - Portal Berita',
                'meta_description' => 'Hubungi redaksi Portal Berita untuk informasi lebih lanjut',
                'is_active' => true,
                'order' => 2,
            ],
            [
                'title' => 'Kebijakan Privasi',
                'slug' => 'kebijakan-privasi',
                'content' => '<h2>Kebijakan Privasi</h2><p>Portal Berita menghormati privasi pengunjung website kami...</p>',
                'meta_title' => 'Kebijakan Privasi - Portal Berita',
                'meta_description' => 'Kebijakan privasi Portal Berita dalam melindungi data pengunjung',
                'is_active' => true,
                'order' => 3,
            ],
        ];

        foreach ($pages as $page) {
            Page::create($page);
        }

        $this->command->info('✅ Pages created');

        $this->command->newLine();
        $this->command->info('🎉 Portal Berita seeding completed successfully!');
        $this->command->newLine();
        $this->command->table(
            ['Role', 'Email', 'Password'],
            [
                ['Admin', 'admin@admin.com', 'password'],
                ['Redaktur', 'redaktur@admin.com', 'password'],
                ['Reporter', 'reporter@admin.com', 'password'],
            ]
        );
    }
}
