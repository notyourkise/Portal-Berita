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

        // Create Categories untuk SALUT UT Samarinda
        $categories = [
            [
                'name' => 'Pengumuman',
                'slug' => 'pengumuman',
                'description' => 'Pengumuman resmi SALUT UT Samarinda',
                'meta_title' => 'Pengumuman SALUT UT Samarinda',
                'meta_description' => 'Pengumuman terbaru dari SALUT UT Samarinda',
                'is_active' => true,
                'order' => 1,
            ],
            [
                'name' => 'Berita',
                'slug' => 'berita',
                'description' => 'Berita seputar SALUT UT Samarinda',
                'meta_title' => 'Berita SALUT UT Samarinda',
                'meta_description' => 'Berita terbaru dari SALUT UT Samarinda',
                'is_active' => true,
                'order' => 2,
            ],
            [
                'name' => 'Pendidikan',
                'slug' => 'pendidikan',
                'description' => 'Informasi pendidikan dan akademik',
                'meta_title' => 'Berita Pendidikan Terkini',
                'meta_description' => 'Informasi pendidikan dan akademik terbaru',
                'is_active' => true,
                'order' => 3,
            ],
            [
                'name' => 'Kegiatan Mahasiswa',
                'slug' => 'kegiatan-mahasiswa',
                'description' => 'Kegiatan mahasiswa Universitas Terbuka',
                'meta_title' => 'Kegiatan Mahasiswa UT Samarinda',
                'meta_description' => 'Kegiatan mahasiswa Universitas Terbuka Samarinda',
                'is_active' => true,
                'order' => 4,
            ],
            [
                'name' => 'Tutorial',
                'slug' => 'tutorial',
                'description' => 'Tutorial dan panduan untuk mahasiswa',
                'meta_title' => 'Tutorial Mahasiswa UT',
                'meta_description' => 'Panduan dan tutorial untuk mahasiswa Universitas Terbuka',
                'is_active' => true,
                'order' => 5,
            ],
            [
                'name' => 'Tips & Panduan',
                'slug' => 'tips-panduan',
                'description' => 'Tips dan panduan belajar',
                'meta_title' => 'Tips & Panduan Belajar',
                'meta_description' => 'Tips dan panduan belajar untuk mahasiswa UT',
                'is_active' => true,
                'order' => 6,
            ],
            [
                'name' => 'Informasi Akademik',
                'slug' => 'informasi-akademik',
                'description' => 'Informasi akademik Universitas Terbuka',
                'meta_title' => 'Informasi Akademik UT',
                'meta_description' => 'Informasi akademik Universitas Terbuka terbaru',
                'is_active' => true,
                'order' => 7,
            ],
            [
                'name' => 'Prestasi',
                'slug' => 'prestasi',
                'description' => 'Prestasi mahasiswa dan alumni UT',
                'meta_title' => 'Prestasi Mahasiswa UT',
                'meta_description' => 'Prestasi mahasiswa dan alumni Universitas Terbuka',
                'is_active' => true,
                'order' => 8,
            ],
        ];

        foreach ($categories as $category) {
            Category::create($category);
        }

        $this->command->info('✅ Categories created');

        // Create Tags untuk SALUT UT Samarinda
        $tags = [
            ['name' => 'Registrasi', 'slug' => 'registrasi'],
            ['name' => 'Pendaftaran', 'slug' => 'pendaftaran'],
            ['name' => 'Tutorial Online', 'slug' => 'tutorial-online'],
            ['name' => 'Ujian', 'slug' => 'ujian'],
            ['name' => 'Wisuda', 'slug' => 'wisuda'],
            ['name' => 'Beasiswa', 'slug' => 'beasiswa'],
            ['name' => 'Mahasiswa Baru', 'slug' => 'mahasiswa-baru'],
            ['name' => 'Alumni', 'slug' => 'alumni'],
        ];

        foreach ($tags as $tag) {
            Tag::create($tag);
        }

        $this->command->info('✅ Tags created');

        // Create Sample Articles untuk SALUT
        $pendidikan = Category::where('slug', 'pendidikan')->first();
        $pengumuman = Category::where('slug', 'pengumuman')->first();
        $kegiatanMahasiswa = Category::where('slug', 'kegiatan-mahasiswa')->first();

        $articles = [
            [
                'category_id' => $pengumuman->id,
                'author_id' => $reporter->id,
                'editor_id' => $redaktur->id,
                'title' => 'Pembukaan Pendaftaran Mahasiswa Baru UT Samarinda',
                'slug' => 'pembukaan-pendaftaran-mahasiswa-baru-ut-samarinda',
                'excerpt' => 'SALUT UT Samarinda membuka pendaftaran mahasiswa baru untuk semester mendatang.',
                'body' => '<p>Samarinda - Sentra Layanan Universitas Terbuka (SALUT) Samarinda mengumumkan pembukaan pendaftaran mahasiswa baru untuk semester mendatang. Pendaftaran dapat dilakukan secara online maupun langsung di kantor SALUT UT Samarinda.</p><p>Calon mahasiswa dapat memilih berbagai program studi yang tersedia mulai dari jenjang D3, S1, hingga S2. Untuk informasi lebih lanjut, silakan kunjungi kantor SALUT UT Samarinda atau hubungi nomor layanan yang tersedia.</p>',
                'meta_title' => 'Pembukaan Pendaftaran Mahasiswa Baru UT Samarinda',
                'meta_description' => 'Informasi pendaftaran mahasiswa baru Universitas Terbuka Samarinda',
                'status' => 'published',
                'published_at' => now()->subDays(2),
                'is_featured' => true,
                'is_headline' => true,
                'views' => 1250,
            ],
            [
                'category_id' => $pendidikan->id,
                'author_id' => $reporter->id,
                'editor_id' => $redaktur->id,
                'title' => 'Panduan Lengkap Registrasi Online Mahasiswa',
                'slug' => 'panduan-lengkap-registrasi-online-mahasiswa',
                'excerpt' => 'Panduan langkah demi langkah untuk melakukan registrasi online di Universitas Terbuka.',
                'body' => '<p>Registrasi online di Universitas Terbuka kini semakin mudah. Mahasiswa dapat melakukan registrasi kapan saja dan dimana saja melalui portal sia.ut.ac.id.</p><p>Berikut adalah langkah-langkah registrasi online:</p><ol><li>Login ke portal sia.ut.ac.id</li><li>Pilih menu Registrasi</li><li>Pilih mata kuliah yang akan diambil</li><li>Lakukan pembayaran</li><li>Cetak kartu registrasi</li></ol>',
                'meta_title' => 'Panduan Registrasi Online Mahasiswa UT',
                'meta_description' => 'Panduan lengkap cara registrasi online di Universitas Terbuka',
                'status' => 'published',
                'published_at' => now()->subDays(5),
                'is_featured' => true,
                'is_headline' => false,
                'views' => 890,
            ],
            [
                'category_id' => $kegiatanMahasiswa->id,
                'author_id' => $reporter->id,
                'editor_id' => null,
                'title' => 'Mahasiswa Juara Lomba 1',
                'slug' => 'mahasiswa-juara-lomba-1',
                'excerpt' => 'Mahasiswa UT Samarinda berhasil meraih juara dalam kompetisi.',
                'body' => '<p>Mahasiswa Universitas Terbuka Samarinda kembali mengharumkan nama almamater dengan meraih prestasi gemilang dalam kompetisi tingkat regional.</p><p>Prestasi ini membuktikan bahwa mahasiswa pendidikan jarak jauh juga mampu bersaing dengan mahasiswa perguruan tinggi konvensional.</p>',
                'meta_title' => 'Prestasi Mahasiswa UT Samarinda',
                'meta_description' => 'Mahasiswa UT Samarinda raih juara dalam kompetisi',
                'status' => 'published',
                'published_at' => now()->subHours(13),
                'is_featured' => true,
                'is_headline' => true,
                'views' => 567,
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
