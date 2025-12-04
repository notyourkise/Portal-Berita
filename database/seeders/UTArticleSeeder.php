<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Article;
use App\Models\Category;
use App\Models\Tag;
use App\Models\User;
use Illuminate\Support\Str;

class UTArticleSeeder extends Seeder
{
    public function run(): void
    {
        $this->command->info('🎓 Membuat 10 artikel dummy tentang pendaftaran mahasiswa UT...');

        // Ambil user admin sebagai author
        $author = User::where('email', 'admin@admin.com')->first();
        if (!$author) {
            $author = User::first();
        }

        // Ambil kategori Pengumuman atau Informasi Akademik
        $category = Category::where('slug', 'pengumuman')->first();
        if (!$category) {
            $category = Category::where('slug', 'informasi-akademik')->first();
        }
        if (!$category) {
            $category = Category::first();
        }

        // Ambil tags yang relevan
        $tags = Tag::whereIn('slug', ['registrasi', 'pendaftaran', 's1', 's2', 'mata-kuliah'])->pluck('id')->toArray();

        $articles = [
            [
                'title' => 'Pembukaan Pendaftaran Mahasiswa Baru UT Samarinda Semester 2025.1',
                'excerpt' => 'SALUT UT Samarinda membuka pendaftaran mahasiswa baru untuk semester 2025.1. Calon mahasiswa dapat mendaftar mulai hari ini hingga akhir bulan.',
                'body' => $this->getArticleBody1(),
                'published_at' => now()->subDays(2),
                'views' => rand(150, 300),
                'is_featured' => true,
            ],
            [
                'title' => 'Panduan Lengkap Registrasi Online Mahasiswa Baru UT 2025',
                'excerpt' => 'Berikut adalah panduan lengkap untuk melakukan registrasi online sebagai mahasiswa baru Universitas Terbuka tahun 2025.',
                'body' => $this->getArticleBody2(),
                'published_at' => now()->subDays(5),
                'views' => rand(200, 400),
                'is_featured' => false,
            ],
            [
                'title' => 'Jadwal dan Syarat Pendaftaran Program S1 UT Samarinda',
                'excerpt' => 'Informasi lengkap mengenai jadwal pendaftaran, syarat administrasi, dan dokumen yang diperlukan untuk program S1 di UT Samarinda.',
                'body' => $this->getArticleBody3(),
                'published_at' => now()->subDays(7),
                'views' => rand(180, 350),
                'is_featured' => false,
            ],
            [
                'title' => 'Beasiswa Pendaftaran untuk Mahasiswa Baru UT 2025',
                'excerpt' => 'SALUT UT Samarinda menawarkan program beasiswa pendaftaran bagi calon mahasiswa berprestasi dan kurang mampu.',
                'body' => $this->getArticleBody4(),
                'published_at' => now()->subDays(10),
                'views' => rand(250, 500),
                'is_featured' => true,
            ],
            [
                'title' => 'Cara Memilih Program Studi yang Tepat di Universitas Terbuka',
                'excerpt' => 'Tips dan panduan untuk calon mahasiswa dalam memilih program studi yang sesuai dengan minat dan karir di masa depan.',
                'body' => $this->getArticleBody5(),
                'published_at' => now()->subDays(12),
                'views' => rand(150, 280),
                'is_featured' => false,
            ],
            [
                'title' => 'Pendaftaran Program Pascasarjana (S2) UT Samarinda Dibuka',
                'excerpt' => 'Pendaftaran mahasiswa baru program pascasarjana (S2) Universitas Terbuka kini telah dibuka untuk semester mendatang.',
                'body' => $this->getArticleBody6(),
                'published_at' => now()->subDays(14),
                'views' => rand(170, 320),
                'is_featured' => false,
            ],
            [
                'title' => 'Tutorial Pembayaran Biaya Pendaftaran Mahasiswa Baru UT',
                'excerpt' => 'Panduan step-by-step untuk melakukan pembayaran biaya pendaftaran mahasiswa baru melalui berbagai metode pembayaran.',
                'body' => $this->getArticleBody7(),
                'published_at' => now()->subDays(18),
                'views' => rand(200, 380),
                'is_featured' => false,
            ],
            [
                'title' => 'Informasi Penting: Perpanjangan Masa Pendaftaran UT 2025.1',
                'excerpt' => 'Masa pendaftaran mahasiswa baru diperpanjang hingga 2 minggu ke depan untuk memberikan kesempatan lebih luas bagi calon mahasiswa.',
                'body' => $this->getArticleBody8(),
                'published_at' => now()->subDays(20),
                'views' => rand(220, 420),
                'is_featured' => true,
            ],
            [
                'title' => 'Keunggulan Kuliah di Universitas Terbuka untuk Pekerja',
                'excerpt' => 'Sistem pembelajaran jarak jauh UT sangat cocok untuk Anda yang bekerja sambil kuliah. Simak keunggulannya di sini.',
                'body' => $this->getArticleBody9(),
                'published_at' => now()->subDays(23),
                'views' => rand(190, 360),
                'is_featured' => false,
            ],
            [
                'title' => 'FAQ Pendaftaran Mahasiswa Baru UT: Jawaban Lengkap',
                'excerpt' => 'Kumpulan pertanyaan yang sering diajukan seputar pendaftaran mahasiswa baru UT beserta jawabannya.',
                'body' => $this->getArticleBody10(),
                'published_at' => now()->subDays(25),
                'views' => rand(180, 340),
                'is_featured' => false,
            ],
        ];

        foreach ($articles as $articleData) {
            $article = Article::create([
                'category_id' => $category->id,
                'author_id' => $author->id,
                'title' => $articleData['title'],
                'slug' => Str::slug($articleData['title']) . '-' . time() . rand(100, 999),
                'excerpt' => $articleData['excerpt'],
                'body' => $articleData['body'],
                'status' => 'published',
                'published_at' => $articleData['published_at'],
                'views' => $articleData['views'],
                'is_featured' => $articleData['is_featured'],
                'allow_comments' => true,
            ]);

            // Attach tags
            if (!empty($tags)) {
                $article->tags()->attach(array_slice($tags, 0, rand(2, 4)));
            }

            $this->command->info("✓ Created: {$articleData['title']}");
        }

        $this->command->newLine();
        $this->command->info('🎉 Berhasil membuat 10 artikel tentang pendaftaran mahasiswa UT!');
    }

    private function getArticleBody1()
    {
        return <<<HTML
<h2>Pendaftaran Mahasiswa Baru Dibuka</h2>
<p><strong>Samarinda</strong> - Sentra Layanan Universitas Terbuka (SALUT) Samarinda dengan bangga mengumumkan pembukaan pendaftaran mahasiswa baru untuk semester 2025.1. Pendaftaran dibuka mulai hari ini dan akan berlangsung hingga akhir bulan ini.</p>

<p>Calon mahasiswa dapat mendaftar melalui sistem online yang telah disediakan di website resmi UT atau langsung datang ke kantor SALUT UT Samarinda untuk mendapatkan bantuan langsung dari staf kami.</p>

<h2>Program Studi yang Tersedia</h2>
<p>Universitas Terbuka Samarinda menawarkan berbagai program studi untuk jenjang S1 dan S2, antara lain:</p>
<ul>
<li>Fakultas Ekonomi: Manajemen, Akuntansi, Ekonomi Pembangunan</li>
<li>Fakultas Hukum, Ilmu Sosial dan Ilmu Politik (FHISIP): Ilmu Administrasi, Ilmu Pemerintahan, Ilmu Komunikasi</li>
<li>Fakultas Sains dan Teknologi (FST): Matematika, Statistika, Teknologi Pangan</li>
<li>Fakultas Keguruan dan Ilmu Pendidikan (FKIP): Pendidikan berbagai bidang studi</li>
</ul>

<h2>Syarat Pendaftaran</h2>
<p>Calon mahasiswa S1 harus memiliki ijazah SMA/sederajat, sedangkan untuk S2 harus memiliki ijazah S1. Dokumen yang perlu disiapkan meliputi:</p>
<ol>
<li>Fotokopi ijazah dan transkrip nilai</li>
<li>Fotokopi KTP</li>
<li>Pas foto terbaru ukuran 3x4</li>
<li>Bukti pembayaran biaya pendaftaran</li>
</ol>

<h2>Informasi Lebih Lanjut</h2>
<p>Untuk informasi lebih lengkap, calon mahasiswa dapat menghubungi SALUT UT Samarinda melalui telepon atau datang langsung ke kantor kami. Staf kami siap membantu Anda dalam proses pendaftaran.</p>

<p>Jangan lewatkan kesempatan emas ini untuk melanjutkan pendidikan tinggi dengan sistem pembelajaran yang fleksibel dan berkualitas!</p>
HTML;
    }

    private function getArticleBody2()
    {
        return <<<HTML
<h2>Langkah-Langkah Registrasi Online</h2>
<p>Registrasi online mahasiswa baru UT kini semakin mudah dan praktis. Berikut adalah panduan lengkap untuk melakukan pendaftaran:</p>

<h3>1. Persiapan Dokumen</h3>
<p>Sebelum memulai registrasi online, pastikan Anda telah menyiapkan scan dokumen berikut dalam format PDF atau JPG:</p>
<ul>
<li>Ijazah terakhir (SMA untuk S1, S1 untuk S2)</li>
<li>Transkrip nilai</li>
<li>KTP yang masih berlaku</li>
<li>Pas foto background merah ukuran 3x4</li>
<li>Kartu Keluarga</li>
</ul>

<h3>2. Akses Portal Pendaftaran</h3>
<p>Kunjungi website resmi Universitas Terbuka di <strong>www.ut.ac.id</strong> dan klik menu "Pendaftaran Mahasiswa Baru". Anda akan diarahkan ke portal registrasi online.</p>

<h3>3. Buat Akun</h3>
<p>Isi formulir pendaftaran dengan data yang benar dan lengkap. Pastikan alamat email yang digunakan aktif karena akan digunakan untuk verifikasi dan komunikasi selanjutnya.</p>

<h3>4. Pilih Program Studi</h3>
<p>Pilih program studi yang Anda minati. Perhatikan baik-baik syarat dan ketentuan dari masing-masing program studi.</p>

<h3>5. Upload Dokumen</h3>
<p>Upload semua dokumen yang telah disiapkan. Pastikan file dapat terbaca dengan jelas dan ukuran file tidak melebihi batas maksimal yang ditentukan.</p>

<h3>6. Pembayaran</h3>
<p>Lakukan pembayaran biaya pendaftaran sesuai dengan instruksi yang diberikan. Simpan bukti pembayaran untuk keperluan verifikasi.</p>

<h2>Tips Sukses Registrasi Online</h2>
<ul>
<li>Gunakan koneksi internet yang stabil</li>
<li>Pastikan data yang diinput sudah benar sebelum submit</li>
<li>Simpan screenshot atau print out setiap tahapan pendaftaran</li>
<li>Hubungi customer service jika mengalami kendala</li>
</ul>

<p>Selamat mendaftar dan selamat bergabung di keluarga besar Universitas Terbuka!</p>
HTML;
    }

    private function getArticleBody3()
    {
        return <<<HTML
<h2>Jadwal Pendaftaran Semester 2025.1</h2>
<p>Berikut adalah jadwal lengkap pendaftaran mahasiswa baru program S1 di SALUT UT Samarinda:</p>

<table style="width: 100%; border-collapse: collapse; margin: 20px 0;">
<tr style="background-color: #214594; color: white;">
<th style="padding: 10px; border: 1px solid #ddd;">Kegiatan</th>
<th style="padding: 10px; border: 1px solid #ddd;">Tanggal</th>
</tr>
<tr>
<td style="padding: 10px; border: 1px solid #ddd;">Pembukaan Pendaftaran</td>
<td style="padding: 10px; border: 1px solid #ddd;">1 Januari 2025</td>
</tr>
<tr style="background-color: #f5f5f5;">
<td style="padding: 10px; border: 1px solid #ddd;">Batas Akhir Pendaftaran</td>
<td style="padding: 10px; border: 1px solid #ddd;">31 Januari 2025</td>
</tr>
<tr>
<td style="padding: 10px; border: 1px solid #ddd;">Registrasi Mata Kuliah</td>
<td style="padding: 10px; border: 1px solid #ddd;">1-15 Februari 2025</td>
</tr>
<tr style="background-color: #f5f5f5;">
<td style="padding: 10px; border: 1px solid #ddd;">Masa Perkuliahan</td>
<td style="padding: 10px; border: 1px solid #ddd;">1 Maret 2025</td>
</tr>
</table>

<h2>Persyaratan Umum</h2>
<p>Untuk mendaftar sebagai mahasiswa program S1, calon mahasiswa harus memenuhi persyaratan berikut:</p>

<h3>A. Persyaratan Akademik</h3>
<ol>
<li>Lulusan SMA/MA/SMK/Paket C atau sederajat</li>
<li>Memiliki ijazah yang telah dilegalisir</li>
<li>Transkrip nilai yang telah dilegalisir</li>
</ol>

<h3>B. Persyaratan Administrasi</h3>
<ol>
<li>Fotokopi KTP yang masih berlaku</li>
<li>Fotokopi Kartu Keluarga</li>
<li>Pas foto terbaru ukuran 3x4 (background merah) sebanyak 2 lembar</li>
<li>Surat keterangan sehat dari dokter</li>
</ol>

<h2>Biaya Pendaftaran</h2>
<p>Biaya pendaftaran untuk program S1 adalah sebagai berikut:</p>
<ul>
<li>Biaya Pendaftaran: Rp 300.000,-</li>
<li>SPP per semester: Mulai dari Rp 1.500.000,- (tergantung jumlah SKS)</li>
<li>Biaya registrasi mata kuliah: Sesuai jumlah SKS yang diambil</li>
</ul>

<h2>Fasilitas Mahasiswa</h2>
<p>Sebagai mahasiswa UT Samarinda, Anda akan mendapatkan berbagai fasilitas, antara lain:</p>
<ul>
<li>Akses ke tutorial online dan tatap muka</li>
<li>Perpustakaan digital dengan ribuan e-book</li>
<li>Bimbingan akademik oleh tutor berpengalaman</li>
<li>Ruang belajar yang nyaman</li>
<li>Konsultasi akademik gratis</li>
</ul>

<p>Untuk informasi lebih detail, silakan kunjungi kantor SALUT UT Samarinda atau hubungi kami via WhatsApp.</p>
HTML;
    }

    private function getArticleBody4()
    {
        return <<<HTML
<h2>Program Beasiswa untuk Mahasiswa Baru</h2>
<p><strong>Samarinda</strong> - SALUT UT Samarinda berkomitmen untuk memberikan akses pendidikan yang lebih luas bagi masyarakat. Untuk itu, kami menawarkan berbagai program beasiswa bagi calon mahasiswa baru tahun 2025.</p>

<h3>1. Beasiswa Prestasi Akademik</h3>
<p>Beasiswa ini diberikan kepada calon mahasiswa yang memiliki prestasi akademik cemerlang. Kriteria:</p>
<ul>
<li>Nilai rata-rata rapor minimal 8.5</li>
<li>Memiliki sertifikat prestasi akademik tingkat kabupaten/kota atau lebih tinggi</li>
<li>Lulus seleksi wawancara</li>
</ul>
<p><strong>Benefit:</strong> Pembebasan biaya pendaftaran + potongan SPP 50% untuk semester pertama</p>

<h3>2. Beasiswa Kurang Mampu</h3>
<p>Ditujukan bagi calon mahasiswa dari keluarga kurang mampu yang memiliki motivasi tinggi untuk belajar. Kriteria:</p>
<ul>
<li>Memiliki Surat Keterangan Tidak Mampu (SKTM) dari kelurahan</li>
<li>Surat rekomendasi dari kepala sekolah</li>
<li>Surat pernyataan kesanggupan belajar</li>
</ul>
<p><strong>Benefit:</strong> Pembebasan biaya pendaftaran + subsidi SPP hingga 75%</p>

<h3>3. Beasiswa Anak Guru</h3>
<p>Khusus untuk anak dari guru aktif yang ingin melanjutkan pendidikan. Kriteria:</p>
<ul>
<li>Orang tua merupakan guru aktif (PNS/Non-PNS)</li>
<li>Melampirkan SK pengangkatan sebagai guru</li>
<li>Surat keterangan aktif mengajar</li>
</ul>
<p><strong>Benefit:</strong> Potongan SPP 30% selama masa studi</p>

<h2>Cara Mendaftar Beasiswa</h2>
<ol>
<li>Lengkapi formulir pendaftaran mahasiswa baru</li>
<li>Download formulir beasiswa di website UT</li>
<li>Lengkapi dokumen persyaratan beasiswa</li>
<li>Submit berkas ke SALUT UT Samarinda</li>
<li>Tunggu pengumuman hasil seleksi</li>
</ol>

<h2>Jadwal Penting</h2>
<ul>
<li>Pembukaan pendaftaran beasiswa: 1 Januari 2025</li>
<li>Batas pengumpulan berkas: 20 Januari 2025</li>
<li>Seleksi administrasi: 21-25 Januari 2025</li>
<li>Wawancara: 26-28 Januari 2025</li>
<li>Pengumuman: 30 Januari 2025</li>
</ul>

<p>Jangan sia-siakan kesempatan emas ini! Raih mimpi Anda untuk kuliah di Universitas Terbuka dengan bantuan beasiswa.</p>
HTML;
    }

    private function getArticleBody5()
    {
        return <<<HTML
<h2>Pentingnya Memilih Program Studi yang Tepat</h2>
<p>Memilih program studi adalah salah satu keputusan paling penting dalam perjalanan pendidikan Anda. Pilihan yang tepat akan membuka peluang karir yang lebih baik di masa depan.</p>

<h3>Faktor-Faktor yang Perlu Dipertimbangkan</h3>

<h4>1. Minat dan Bakat</h4>
<p>Pilihlah program studi yang sesuai dengan minat dan bakat Anda. Kuliah akan terasa lebih menyenangkan jika Anda mempelajari hal yang Anda sukai.</p>

<h4>2. Prospek Karir</h4>
<p>Pelajari prospek karir dari program studi yang Anda minati. Pertimbangkan kebutuhan pasar kerja dan peluang pengembangan karir di masa depan.</p>

<h4>3. Kemampuan Finansial</h4>
<p>Sesuaikan pilihan program studi dengan kemampuan finansial. UT menawarkan biaya kuliah yang terjangkau dengan sistem pembayaran yang fleksibel.</p>

<h4>4. Waktu dan Komitmen</h4>
<p>Pertimbangkan waktu yang Anda miliki. Sistem pembelajaran jarak jauh UT sangat cocok untuk Anda yang bekerja sambil kuliah.</p>

<h2>Program Studi Populer di UT Samarinda</h2>

<h3>Manajemen</h3>
<p>Program studi yang mempersiapkan lulusan menjadi manajer profesional dengan kompetensi di bidang pemasaran, keuangan, SDM, dan operasional.</p>

<h3>Akuntansi</h3>
<p>Menghasilkan lulusan yang kompeten dalam bidang akuntansi keuangan, perpajakan, audit, dan sistem informasi akuntansi.</p>

<h3>Pendidikan</h3>
<p>Berbagai program studi kependidikan yang mempersiapkan guru profesional sesuai dengan bidang keahliannya.</p>

<h3>Ilmu Komunikasi</h3>
<p>Mempelajari berbagai aspek komunikasi massa, public relations, periklanan, dan jurnalistik.</p>

<h2>Tips Memilih Program Studi</h2>
<ol>
<li><strong>Riset mendalam:</strong> Cari informasi sebanyak mungkin tentang program studi yang diminati</li>
<li><strong>Konsultasi:</strong> Diskusikan dengan orang tua, guru, atau konselor pendidikan</li>
<li><strong>Kunjungi kampus:</strong> Datang ke SALUT UT Samarinda untuk mendapatkan informasi langsung</li>
<li><strong>Pertimbangkan passion:</strong> Pilih sesuai dengan passion Anda, bukan hanya karena tren</li>
<li><strong>Pikirkan jangka panjang:</strong> Pertimbangkan bagaimana program studi ini akan membantu karir Anda 5-10 tahun ke depan</li>
</ol>

<p>SALUT UT Samarinda siap membantu Anda dalam menentukan pilihan program studi yang tepat. Hubungi kami untuk konsultasi gratis!</p>
HTML;
    }

    private function getArticleBody6()
    {
        return <<<HTML
<h2>Pendaftaran Program Pascasarjana (S2) Dibuka</h2>
<p><strong>Samarinda</strong> - Universitas Terbuka membuka pendaftaran untuk program pascasarjana (S2) semester 2025.1. Program S2 UT dirancang khusus untuk profesional yang ingin meningkatkan kompetensi tanpa meninggalkan pekerjaan.</p>

<h3>Program Studi S2 yang Tersedia</h3>

<h4>1. Magister Manajemen (MM)</h4>
<p>Program yang dirancang untuk mengembangkan kemampuan manajerial dan kepemimpinan dalam organisasi bisnis modern.</p>
<p><strong>Konsentrasi:</strong></p>
<ul>
<li>Manajemen Sumber Daya Manusia</li>
<li>Manajemen Pemasaran</li>
<li>Manajemen Keuangan</li>
</ul>

<h4>2. Magister Pendidikan (M.Pd)</h4>
<p>Mempersiapkan tenaga pendidik profesional dengan kompetensi akademik dan pedagogik yang tinggi.</p>
<p><strong>Konsentrasi:</strong></p>
<ul>
<li>Pendidikan Matematika</li>
<li>Pendidikan Bahasa Indonesia</li>
<li>Pendidikan Bahasa Inggris</li>
<li>Teknologi Pendidikan</li>
</ul>

<h4>3. Magister Administrasi Publik (MAP)</h4>
<p>Menghasilkan lulusan yang kompeten dalam administrasi dan kebijakan publik.</p>

<h2>Keunggulan S2 Universitas Terbuka</h2>
<ul>
<li><strong>Fleksibilitas Waktu:</strong> Kuliah kapan saja, di mana saja sesuai waktu Anda</li>
<li><strong>Biaya Terjangkau:</strong> Lebih ekonomis dibanding universitas konvensional</li>
<li><strong>Dosen Berkualitas:</strong> Diajar oleh praktisi dan akademisi berpengalaman</li>
<li><strong>Terakreditasi BAN-PT:</strong> Semua program studi terakreditasi nasional</li>
<li><strong>Tutorial Berkualitas:</strong> Tutorial online dan tatap muka yang interaktif</li>
</ul>

<h2>Syarat Pendaftaran S2</h2>
<ol>
<li>Memiliki gelar S1 dari perguruan tinggi terakreditasi</li>
<li>IPK minimal 2.75 (skala 4.00)</li>
<li>Memiliki pengalaman kerja minimal 1 tahun (diutamakan)</li>
<li>Melampirkan surat rekomendasi dari atasan atau dosen</li>
<li>Lulus tes masuk (jika diperlukan)</li>
</ol>

<h2>Dokumen yang Diperlukan</h2>
<ul>
<li>Fotokopi ijazah S1 yang telah dilegalisir</li>
<li>Fotokopi transkrip nilai S1 yang telah dilegalisir</li>
<li>Fotokopi KTP</li>
<li>Pas foto 3x4 background merah (4 lembar)</li>
<li>CV terbaru</li>
<li>Surat rekomendasi</li>
<li>Proposal penelitian (untuk beberapa program studi)</li>
</ul>

<h2>Biaya Kuliah S2</h2>
<p>Biaya kuliah S2 di UT sangat terjangkau dengan sistem pembayaran per semester. Tersedia juga program cicilan dan beasiswa bagi yang memenuhi syarat.</p>

<p>Daftar sekarang dan tingkatkan karir Anda dengan gelar Magister dari Universitas Terbuka!</p>
HTML;
    }

    private function getArticleBody7()
    {
        return <<<HTML
<h2>Metode Pembayaran Biaya Pendaftaran</h2>
<p>Universitas Terbuka menyediakan berbagai metode pembayaran yang mudah dan aman untuk memudahkan calon mahasiswa dalam melakukan pembayaran biaya pendaftaran.</p>

<h3>1. Transfer Bank</h3>
<p>Anda dapat melakukan transfer ke rekening resmi UT:</p>
<ul>
<li><strong>Bank Mandiri:</strong> 1234567890 a.n. Universitas Terbuka</li>
<li><strong>Bank BNI:</strong> 0987654321 a.n. Universitas Terbuka</li>
<li><strong>Bank BRI:</strong> 1122334455 a.n. Universitas Terbuka</li>
</ul>
<p><em>Catatan: Simpan bukti transfer sebagai bukti pembayaran</em></p>

<h3>2. Virtual Account</h3>
<p>Gunakan nomor virtual account yang diberikan saat registrasi online. Setiap calon mahasiswa akan mendapatkan nomor virtual account unik.</p>

<h4>Cara Pembayaran via Virtual Account:</h4>
<ol>
<li>Login ke internet banking atau mobile banking</li>
<li>Pilih menu "Transfer" atau "Pembayaran"</li>
<li>Pilih "Virtual Account"</li>
<li>Masukkan nomor virtual account Anda</li>
<li>Nominal akan muncul otomatis</li>
<li>Konfirmasi pembayaran</li>
<li>Simpan bukti transaksi</li>
</ol>

<h3>3. ATM</h3>
<p>Pembayaran juga dapat dilakukan melalui ATM bank yang bekerja sama dengan UT.</p>

<h4>Langkah pembayaran via ATM:</h4>
<ol>
<li>Masukkan kartu ATM dan PIN</li>
<li>Pilih menu "Transaksi Lainnya"</li>
<li>Pilih "Pembayaran/Pembelian"</li>
<li>Pilih "Pendidikan"</li>
<li>Pilih "Universitas Terbuka"</li>
<li>Masukkan nomor registrasi Anda</li>
<li>Konfirmasi pembayaran</li>
<li>Simpan struk sebagai bukti</li>
</ol>

<h3>4. Minimarket (Indomaret/Alfamart)</h3>
<p>Bagi yang tidak memiliki rekening bank, pembayaran dapat dilakukan di Indomaret atau Alfamart terdekat.</p>

<h4>Cara bayar di Indomaret/Alfamart:</h4>
<ol>
<li>Datang ke kasir</li>
<li>Sebutkan ingin membayar "Universitas Terbuka"</li>
<li>Berikan nomor registrasi atau kode pembayaran</li>
<li>Kasir akan memproses pembayaran</li>
<li>Bayar sesuai nominal yang tertera</li>
<li>Simpan struk pembayaran</li>
</ol>

<h3>5. Payment Gateway (Kartu Kredit/Debit Online)</h3>
<p>Saat melakukan registrasi online, Anda dapat langsung membayar menggunakan kartu kredit atau debit melalui payment gateway yang tersedia.</p>

<h2>Verifikasi Pembayaran</h2>
<p>Setelah melakukan pembayaran, lakukan langkah berikut:</p>
<ol>
<li>Login ke portal mahasiswa UT</li>
<li>Upload bukti pembayaran di menu "Verifikasi Pembayaran"</li>
<li>Tunggu konfirmasi (maksimal 1x24 jam)</li>
<li>Cek email untuk notifikasi pembayaran terverifikasi</li>
</ol>

<h2>Penting untuk Diperhatikan</h2>
<ul>
<li>Pastikan nama di bukti transfer sesuai dengan nama pendaftar</li>
<li>Simpan bukti pembayaran hingga proses pendaftaran selesai</li>
<li>Jangan transfer ke rekening selain yang tertera di website resmi</li>
<li>Hubungi customer service jika ada kendala</li>
</ul>

<p>Untuk bantuan lebih lanjut, hubungi SALUT UT Samarinda atau layanan customer care UT pusat.</p>
HTML;
    }

    private function getArticleBody8()
    {
        return <<<HTML
<h2>Perpanjangan Masa Pendaftaran</h2>
<p><strong>Pengumuman Penting</strong> - Mengingat masih banyaknya calon mahasiswa yang belum menyelesaikan proses pendaftaran, SALUT UT Samarinda memutuskan untuk memperpanjang masa pendaftaran mahasiswa baru semester 2025.1.</p>

<h3>Jadwal Baru</h3>
<table style="width: 100%; border-collapse: collapse; margin: 20px 0;">
<tr style="background-color: #214594; color: white;">
<th style="padding: 10px; border: 1px solid #ddd;">Keterangan</th>
<th style="padding: 10px; border: 1px solid #ddd;">Jadwal Lama</th>
<th style="padding: 10px; border: 1px solid #ddd;">Jadwal Baru</th>
</tr>
<tr>
<td style="padding: 10px; border: 1px solid #ddd;">Batas Akhir Pendaftaran</td>
<td style="padding: 10px; border: 1px solid #ddd;">31 Januari 2025</td>
<td style="padding: 10px; border: 1px solid #ddd;"><strong>14 Februari 2025</strong></td>
</tr>
<tr style="background-color: #f5f5f5;">
<td style="padding: 10px; border: 1px solid #ddd;">Registrasi Mata Kuliah</td>
<td style="padding: 10px; border: 1px solid #ddd;">1-15 Februari 2025</td>
<td style="padding: 10px; border: 1px solid #ddd;"><strong>15-28 Februari 2025</strong></td>
</tr>
<tr>
<td style="padding: 10px; border: 1px solid #ddd;">Masa Perkuliahan Dimulai</td>
<td style="padding: 10px; border: 1px solid #ddd;">1 Maret 2025</td>
<td style="padding: 10px; border: 1px solid #ddd;"><strong>1 Maret 2025</strong> (tetap)</td>
</tr>
</table>

<h2>Alasan Perpanjangan</h2>
<p>Keputusan perpanjangan ini diambil dengan mempertimbangkan beberapa faktor:</p>
<ul>
<li>Masih banyak calon mahasiswa yang sedang melengkapi dokumen</li>
<li>Kendala teknis dalam proses upload dokumen</li>
<li>Permintaan dari berbagai daerah yang membutuhkan waktu lebih untuk pengurusan dokumen</li>
<li>Memberikan kesempatan lebih luas bagi masyarakat untuk bergabung dengan UT</li>
</ul>

<h2>Apa yang Perlu Dilakukan Calon Mahasiswa?</h2>

<h3>Bagi yang Belum Mendaftar:</h3>
<ol>
<li>Segera akses portal pendaftaran di website UT</li>
<li>Lengkapi formulir pendaftaran dengan benar</li>
<li>Siapkan dokumen yang diperlukan</li>
<li>Lakukan pembayaran biaya pendaftaran</li>
<li>Submit pendaftaran sebelum 14 Februari 2025</li>
</ol>

<h3>Bagi yang Sudah Mendaftar:</h3>
<ol>
<li>Cek status pendaftaran Anda di portal mahasiswa</li>
<li>Lengkapi dokumen jika masih ada yang kurang</li>
<li>Pastikan pembayaran sudah terverifikasi</li>
<li>Siapkan diri untuk registrasi mata kuliah</li>
</ol>

<h2>Layanan Bantuan Diperpanjang</h2>
<p>Untuk membantu calon mahasiswa, SALUT UT Samarinda memperpanjang jam operasional layanan bantuan:</p>
<ul>
<li><strong>Senin-Jumat:</strong> 08.00 - 17.00 WITA</li>
<li><strong>Sabtu:</strong> 08.00 - 14.00 WITA</li>
<li><strong>Online Support:</strong> 24/7 via WhatsApp dan Email</li>
</ul>

<h2>Program Khusus Periode Perpanjangan</h2>
<p>Untuk calon mahasiswa yang mendaftar di periode perpanjangan, tersedia:</p>
<ul>
<li>Konsultasi gratis pemilihan program studi</li>
<li>Bantuan teknis pengisian formulir online</li>
<li>Fast track verifikasi dokumen</li>
<li>Potongan biaya administrasi khusus</li>
</ul>

<h2>Jangan Lewatkan Kesempatan Ini!</h2>
<p>Perpanjangan ini adalah kesempatan terakhir untuk bergabung di semester 2025.1. Manfaatkan waktu tambahan ini dengan sebaik-baiknya.</p>

<p>Untuk informasi lebih lanjut, hubungi SALUT UT Samarinda melalui telepon, WhatsApp, atau datang langsung ke kantor kami.</p>

<p><strong>Daftar sekarang, raih masa depan gemilang bersama Universitas Terbuka!</strong></p>
HTML;
    }

    private function getArticleBody9()
    {
        return <<<HTML
<h2>Kuliah Sambil Bekerja? UT Solusinya!</h2>
<p>Bagi Anda yang sudah bekerja namun ingin melanjutkan pendidikan ke jenjang yang lebih tinggi, Universitas Terbuka adalah pilihan yang tepat. Sistem pembelajaran jarak jauh UT dirancang khusus untuk para pekerja yang memiliki keterbatasan waktu.</p>

<h2>Keunggulan Kuliah di UT untuk Pekerja</h2>

<h3>1. Fleksibilitas Waktu Belajar</h3>
<p>Anda tidak perlu meninggalkan pekerjaan untuk kuliah. Materi pembelajaran dapat diakses kapan saja, 24/7 melalui platform online UT. Anda dapat belajar di waktu luang, seperti:</p>
<ul>
<li>Setelah jam kerja</li>
<li>Saat akhir pekan</li>
<li>Bahkan saat istirahat makan siang</li>
<li>Sesuai dengan jadwal shift kerja Anda</li>
</ul>

<h3>2. Tutorial Fleksibel</h3>
<p>UT menyediakan dua jenis tutorial:</p>
<ul>
<li><strong>Tutorial Online:</strong> Dapat diakses kapan saja tanpa harus datang ke kampus</li>
<li><strong>Tutorial Tatap Muka:</strong> Dilaksanakan di akhir pekan atau malam hari, disesuaikan dengan waktu mahasiswa</li>
</ul>

<h3>3. Tidak Ada Sistem SKS Minimum</h3>
<p>Anda bebas menentukan jumlah mata kuliah yang akan diambil setiap semester. Bisa mengambil banyak saat tidak sibuk kerja, atau sedikit saat pekerjaan padat.</p>

<h3>4. Lokasi Ujian Fleksibel</h3>
<p>UT memiliki puluhan lokasi ujian di seluruh Indonesia. Anda dapat memilih lokasi ujian yang paling dekat dengan tempat tinggal atau tempat kerja.</p>

<h3>5. Biaya Terjangkau</h3>
<p>Biaya kuliah di UT jauh lebih terjangkau dibanding universitas konvensional. Anda hanya membayar sesuai dengan jumlah mata kuliah yang diambil.</p>

<h3>6. Materi Berkualitas</h3>
<p>Materi pembelajaran UT disusun oleh para ahli di bidangnya dan telah disesuaikan dengan kebutuhan dunia kerja. Teori yang dipelajari langsung dapat diterapkan di tempat kerja.</p>

<h2>Testimoni Mahasiswa UT yang Bekerja</h2>

<blockquote style="background-color: #f5f5f5; padding: 20px; border-left: 5px solid #214594; margin: 20px 0;">
<p><em>"Awalnya saya ragu apakah bisa kuliah sambil kerja. Tapi sistem UT yang fleksibel membuat saya bisa manage waktu dengan baik. Sekarang saya sudah semester 6 dan tidak pernah cuti kuliah."</em></p>
<p><strong>- Ahmad, Karyawan Swasta</strong></p>
</blockquote>

<blockquote style="background-color: #f5f5f5; padding: 20px; border-left: 5px solid #214594; margin: 20px 0;">
<p><em>"Ilmu yang saya dapat di UT langsung bisa saya aplikasikan di kantor. Bahkan atasan saya support saya untuk kuliah karena performance kerja saya juga meningkat."</em></p>
<p><strong>- Siti, Guru SD</strong></p>
</blockquote>

<h2>Tips Sukses Kuliah Sambil Bekerja</h2>
<ol>
<li><strong>Buat Jadwal Belajar Rutin:</strong> Luangkan minimal 1-2 jam setiap hari untuk belajar</li>
<li><strong>Manfaatkan Waktu Luang:</strong> Gunakan waktu perjalanan untuk membaca materi</li>
<li><strong>Bergabung dengan Kelompok Belajar:</strong> Diskusi dengan sesama mahasiswa UT yang juga bekerja</li>
<li><strong>Komunikasi dengan Atasan:</strong> Beri tahu atasan bahwa Anda kuliah, minta pengertian saat ujian</li>
<li><strong>Jangan Ambil Terlalu Banyak:</strong> Sesuaikan jumlah SKS dengan kemampuan waktu Anda</li>
<li><strong>Manfaatkan Tutorial Online:</strong> Lebih efisien waktu dibanding harus datang ke kampus</li>
</ol>

<h2>Program Studi Populer untuk Pekerja</h2>

<h3>Manajemen</h3>
<p>Cocok untuk Anda yang bekerja di bidang bisnis dan ingin naik jabatan.</p>

<h3>Akuntansi</h3>
<p>Ideal untuk staff keuangan yang ingin meningkatkan kompetensi.</p>

<h3>Ilmu Komunikasi</h3>
<p>Pas untuk yang bekerja di media, marketing, atau public relations.</p>

<h3>Administrasi Negara/Niaga</h3>
<p>Pilihan tepat untuk PNS atau pegawai perusahaan.</p>

<h2>Mulai Perjalanan Pendidikan Anda</h2>
<p>Jangan biarkan kesibukan kerja menghalangi impian Anda untuk mendapatkan gelar sarjana. Dengan UT, Anda bisa kuliah tanpa mengorbankan karir.</p>

<p><strong>Daftar sekarang dan buktikan bahwa bekerja dan kuliah bisa berjalan beriringan!</strong></p>

<p>Hubungi SALUT UT Samarinda untuk konsultasi gratis mengenai program studi yang sesuai dengan pekerjaan Anda.</p>
HTML;
    }

    private function getArticleBody10()
    {
        return <<<HTML
<h2>Pertanyaan yang Sering Diajukan (FAQ)</h2>
<p>Berikut adalah kumpulan pertanyaan yang paling sering ditanyakan oleh calon mahasiswa UT beserta jawabannya:</p>

<h3>Umum</h3>

<h4>1. Apa itu Universitas Terbuka?</h4>
<p><strong>Jawab:</strong> Universitas Terbuka adalah Perguruan Tinggi Negeri yang menyelenggarakan pendidikan tinggi dengan sistem pembelajaran jarak jauh. UT memungkinkan mahasiswa untuk belajar tanpa harus datang ke kampus setiap hari.</p>

<h4>2. Apakah ijazah UT diakui?</h4>
<p><strong>Jawab:</strong> Ya, ijazah UT diakui secara nasional dan internasional. UT adalah PTN yang terakreditasi BAN-PT dan lulusan UT memiliki hak yang sama dengan lulusan perguruan tinggi lainnya.</p>

<h4>3. Siapa saja yang bisa kuliah di UT?</h4>
<p><strong>Jawab:</strong> Siapa saja yang memiliki ijazah SMA/sederajat untuk S1 atau ijazah S1 untuk S2. UT terbuka untuk semua usia dan latar belakang, termasuk yang sudah bekerja.</p>

<h3>Pendaftaran</h3>

<h4>4. Bagaimana cara mendaftar di UT?</h4>
<p><strong>Jawab:</strong> Pendaftaran dapat dilakukan secara online melalui website resmi UT atau datang langsung ke SALUT UT Samarinda. Prosesnya mudah dan cepat.</p>

<h4>5. Berapa biaya pendaftaran?</h4>
<p><strong>Jawab:</strong> Biaya pendaftaran untuk program S1 adalah Rp 300.000,- dan untuk S2 adalah Rp 500.000,-. Biaya ini sudah termasuk biaya administrasi awal.</p>

<h4>6. Apa saja dokumen yang diperlukan?</h4>
<p><strong>Jawab:</strong> Dokumen yang diperlukan meliputi fotokopi ijazah dan transkrip yang dilegalisir, fotokopi KTP, pas foto 3x4, dan bukti pembayaran.</p>

<h3>Sistem Pembelajaran</h3>

<h4>7. Apakah harus datang ke kampus?</h4>
<p><strong>Jawab:</strong> Tidak harus. Sebagian besar pembelajaran dilakukan secara online. Tutorial tatap muka bersifat opsional dan biasanya dijadwalkan di akhir pekan.</p>

<h4>8. Bagaimana sistem ujiannya?</h4>
<p><strong>Jawab:</strong> Ujian dilaksanakan di lokasi-lokasi yang telah ditentukan UT. Anda dapat memilih lokasi ujian yang terdekat. Ujian biasanya dilaksanakan pada akhir pekan.</p>

<h4>9. Berapa lama waktu kuliah di UT?</h4>
<p><strong>Jawab:</strong> Untuk S1 minimal 4 tahun (8 semester) dan maksimal 12 tahun. Untuk S2 minimal 2 tahun (4 semester) dan maksimal 7 tahun.</p>

<h3>Biaya</h3>

<h4>10. Berapa biaya kuliah per semester?</h4>
<p><strong>Jawab:</strong> Biaya kuliah dihitung berdasarkan jumlah SKS yang diambil. Untuk S1 sekitar Rp 100.000 - Rp 200.000 per SKS tergantung program studi. Rata-rata mahasiswa mengeluarkan Rp 1.500.000 - Rp 3.000.000 per semester.</p>

<h4>11. Apakah ada beasiswa?</h4>
<p><strong>Jawab:</strong> Ya, UT menyediakan berbagai jenis beasiswa seperti beasiswa prestasi, beasiswa kurang mampu, dan beasiswa khusus untuk profesi tertentu (guru, TNI/Polri, dll).</p>

<h4>12. Apakah bisa dicicil?</h4>
<p><strong>Jawab:</strong> Ya, pembayaran SPP dapat dicicil. Anda juga dapat mengatur jumlah SKS yang diambil sesuai kemampuan finansial.</p>

<h3>Mata Kuliah</h3>

<h4>13. Berapa mata kuliah yang harus diambil per semester?</h4>
<p><strong>Jawab:</strong> Tidak ada batasan minimum atau maksimum. Anda bebas menentukan sendiri jumlah mata kuliah yang akan diambil sesuai dengan waktu dan kemampuan.</p>

<h4>14. Apa yang terjadi jika tidak lulus mata kuliah?</h4>
<p><strong>Jawab:</strong> Anda dapat mengulang mata kuliah tersebut di semester berikutnya. Tidak ada batasan jumlah mengulang.</p>

<h3>Tutorial</h3>

<h4>15. Apakah tutorial wajib diikuti?</h4>
<p><strong>Jawab:</strong> Tutorial tidak wajib, tetapi sangat dianjurkan karena membantu pemahaman materi dan persiapan ujian.</p>

<h4>16. Berapa biaya tutorial?</h4>
<p><strong>Jawab:</strong> Biaya tutorial online sudah termasuk dalam SPP. Untuk tutorial tatap muka, ada biaya tambahan yang relatif terjangkau.</p>

<h3>Lain-lain</h3>

<h4>17. Apakah bisa pindah dari kampus lain ke UT?</h4>
<p><strong>Jawab:</strong> Ya, UT menerima mahasiswa pindahan dengan ketentuan tertentu. Mata kuliah yang sudah lulus dapat dikonversi.</p>

<h4>18. Apakah lulusan UT bisa melanjutkan S2/S3?</h4>
<p><strong>Jawab:</strong> Ya, lulusan UT dapat melanjutkan pendidikan ke jenjang lebih tinggi di UT maupun perguruan tinggi lainnya di dalam dan luar negeri.</p>

<h4>19. Bagaimana jika saya ingin cuti kuliah?</h4>
<p><strong>Jawab:</strong> Anda dapat mengajukan cuti kuliah maksimal 4 semester berturut-turut. Tidak ada biaya cuti di UT.</p>

<h4>20. Dimana saya bisa mendapat informasi lebih lanjut?</h4>
<p><strong>Jawab:</strong> Anda dapat mengunjungi SALUT UT Samarinda, menghubungi kami via telepon/WhatsApp, atau mengakses website resmi UT di www.ut.ac.id</p>

<h2>Masih Ada Pertanyaan?</h2>
<p>Jika pertanyaan Anda belum terjawab di FAQ ini, jangan ragu untuk menghubungi kami:</p>
<ul>
<li><strong>Telepon:</strong> (0541) 123456</li>
<li><strong>WhatsApp:</strong> 0812-3456-7890</li>
<li><strong>Email:</strong> salut.samarinda@ut.ac.id</li>
<li><strong>Alamat:</strong> Jl. Pendidikan No. 123, Samarinda</li>
</ul>

<p>Tim SALUT UT Samarinda siap membantu Anda!</p>
HTML;
    }
}
