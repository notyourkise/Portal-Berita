<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Page;

class PageSeeder extends Seeder
{
    public function run(): void
    {
        $pages = [
            [
                'title' => 'Visi dan Misi',
                'slug' => 'visi-misi',
                'content' => '<h2>SALUT KOTA SAMARINDA</h2>
<p><em>Salut Kota Samarinda Pintu Terdekat Menuju Kampus Terbuka.</em></p>

<h2>Visi</h2>
<p>Menjadi pusat layanan pendidikan tinggi terbuka dan jarak jauh yang unggul, mudah diakses, serta terpercaya di Kota Samarinda, untuk mendukung terwujudnya masyarakat berdaya saing melalui perluasan akses pendidikan sepanjang masa.</p>

<h2>Misi</h2>
<ol>
<li>Menyelenggarakan layanan administrasi dan akademik yang cepat, tepat, transparan, dan berorientasi pada kepuasan mahasiswa melalui pemanfaatan teknologi dan peningkatan kualitas layanan.</li>
<li>Memfasilitasi kegiatan akademik, bimbingan belajar, serta kegiatan pengembangan mahasiswa guna mendukung keberhasilan studi dan peningkatan kualitas lulusan Universitas Terbuka.</li>
<li>Melakukan sosialisasi, promosi, dan edukasi tentang sistem pendidikan terbuka dan jarak jauh kepada masyarakat Samarinda dan sekitarnya untuk meningkatkan pemahaman dan kepercayaan terhadap Universitas Terbuka.</li>
<li>Melaksanakan kegiatan perekrutan calon mahasiswa secara aktif, inklusif, dan berkelanjutan demi memperluas akses pendidikan tinggi dan meningkatkan angka partisipasi mahasiswa UT.</li>
<li>Membangun kemitraan strategis dengan instansi pemerintah, lembaga pendidikan, dunia usaha, dan komunitas lokal untuk mendukung pengembangan layanan, kegiatan akademik, dan pemberdayaan masyarakat.</li>
<li>Menjamin kenyamanan, aksesibilitas, dan kedekatan layanan bagi seluruh pemangku kepentingan sehingga SALUT menjadi pusat rujukan layanan UT yang mudah dijangkau dan responsif.</li>
</ol>',
                'is_active' => true,
                'order' => 1,
            ],
            [
                'title' => 'Struktur Organisasi',
                'slug' => 'struktur-organisasi',
                'content' => '<h2>Struktur Organisasi SALUT UT Samarinda</h2>
<p>SALUT UT Samarinda merupakan unit layanan yang terstruktur dengan pembagian tugas yang jelas untuk memberikan pelayanan terbaik kepada mahasiswa.</p>

<h3>Koordinator SALUT</h3>
<p>Bertanggung jawab atas keseluruhan operasional dan manajemen SALUT UT Samarinda.</p>

<h3>Staf Akademik</h3>
<p>Menangani layanan administrasi akademik, registrasi, dan konsultasi akademik mahasiswa.</p>

<h3>Staf Tutorial</h3>
<p>Mengkoordinir pelaksanaan tutorial tatap muka dan online untuk mendukung pembelajaran mahasiswa.</p>

<h3>Staf Administrasi</h3>
<p>Mengelola administrasi umum, keuangan, dan dokumentasi SALUT.</p>',
                'is_active' => true,
                'order' => 2,
            ],
            [
                'title' => 'Sejarah',
                'slug' => 'sejarah',
                'content' => '<h2>Sejarah SALUT UT Samarinda</h2>
<p>Sentra Layanan Universitas Terbuka (SALUT) Samarinda didirikan untuk memberikan kemudahan akses pendidikan tinggi bagi masyarakat Kalimantan Timur khususnya wilayah Samarinda dan sekitarnya.</p>

<p>Sebagai bagian dari sistem Universitas Terbuka, SALUT Samarinda berkomitmen untuk menyediakan layanan pendidikan tinggi yang fleksibel dan berkualitas dengan sistem pembelajaran jarak jauh.</p>

<h3>Perkembangan</h3>
<p>Seiring dengan perkembangan teknologi dan kebutuhan masyarakat akan pendidikan tinggi, SALUT UT Samarinda terus berinovasi dalam memberikan layanan terbaik melalui:</p>
<ul>
<li>Tutorial online yang dapat diakses kapan saja</li>
<li>Layanan konsultasi akademik</li>
<li>Fasilitas pembelajaran yang modern</li>
<li>Pendampingan mahasiswa secara berkelanjutan</li>
</ul>',
                'is_active' => true,
                'order' => 3,
            ],
            // Halaman tambahan untuk menu dropdown
            [
                'title' => 'Tentang SALUT',
                'slug' => 'tentang-salut',
                'content' => '<h2>Tentang SALUT UT Samarinda</h2>
<p>Halaman ini sedang dalam pengembangan.</p>',
                'is_active' => true,
                'order' => 4,
            ],
            [
                'title' => 'Kepala dan Staf',
                'slug' => 'kepala-dan-staf',
                'content' => '<h2>Kepala dan Staf SALUT UT Samarinda</h2>
<p>Halaman ini sedang dalam pengembangan.</p>',
                'is_active' => true,
                'order' => 5,
            ],
            [
                'title' => 'Manajer Pembelajaran dan Ujian',
                'slug' => 'manajer-pembelajaran-ujian',
                'content' => '<h2>Manajer Pembelajaran dan Ujian</h2>
<p>Halaman ini sedang dalam pengembangan.</p>',
                'is_active' => true,
                'order' => 6,
            ],
        ];

        foreach ($pages as $pageData) {
            Page::updateOrCreate(
                ['slug' => $pageData['slug']],
                $pageData
            );
        }
    }
}
