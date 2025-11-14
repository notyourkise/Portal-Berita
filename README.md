# 📰 Portal Berita - Sistem Manajemen Berita Modern

Portal Berita adalah Content Management System (CMS) berbasis web untuk mengelola berita online. Dibangun dengan Laravel 12 dan Filament 3, sistem ini menyediakan panel admin yang powerful dan tampilan frontend yang responsif.

## 🌟 Fitur Utama

### Panel Admin (Filament)

-   ✅ **Manajemen Artikel** - CRUD artikel dengan Rich Text Editor
-   ✅ **Kategori & Tag** - Organisasi konten yang fleksibel
-   ✅ **Role & Permission** - 3 level akses (Admin, Redaktur, Reporter)
-   ✅ **Media Management** - Upload dan optimasi gambar otomatis
-   ✅ **SEO Tools** - Meta title, description, keywords per artikel
-   ✅ **Penjadwalan** - Publish artikel di waktu yang ditentukan
-   ✅ **Dashboard Analytics** - Statistik artikel, views, dan trending

### Frontend

-   ✅ **Responsive Design** - Mobile, Tablet, Desktop optimized
-   ✅ **Dark Mode** - Toggle tema gelap/terang
-   ✅ **Reading Time** - Estimasi waktu baca artikel
-   ✅ **Trending Topics** - Hot topics berdasarkan popularitas
-   ✅ **Search** - Pencarian artikel dengan filter
-   ✅ **SEO Friendly** - Meta tags, Open Graph, RSS Feed
-   ✅ **Performance** - Image optimization, database indexing, caching

## 📋 System Requirements

Sebelum instalasi, pastikan sistem Anda memiliki:

### Software yang Dibutuhkan

-   **PHP** >= 8.2 (Disarankan PHP 8.3)
-   **Composer** >= 2.0
-   **PostgreSQL** >= 13 atau **MySQL** >= 8.0
-   **Node.js** >= 18.x & **NPM** >= 9.x (untuk asset compilation)
-   **Web Server** - Apache atau Nginx (Opsional, bisa gunakan built-in PHP server)

### PHP Extensions yang Diperlukan

```
- BCMath
- Ctype
- Fileinfo
- JSON
- Mbstring
- OpenSSL
- PDO
- PDO_PGSQL (untuk PostgreSQL) atau PDO_MYSQL (untuk MySQL)
- Tokenizer
- XML
- GD atau Imagick (untuk image processing)
```

### Rekomendasi Environment

Untuk kemudahan, gunakan salah satu:

-   **Windows**: [Laragon](https://laragon.org/) (sudah include PHP, PostgreSQL/MySQL, Composer)
-   **Mac**: [Laravel Valet](https://laravel.com/docs/valet) atau [MAMP PRO](https://www.mamp.info/)
-   **Linux**: [Laravel Homestead](https://laravel.com/docs/homestead) atau manual install

## 🚀 Instalasi & Konfigurasi

### Langkah 1: Clone Repository

```bash
# Clone repository dari GitHub
git clone https://github.com/notyourkise/Portal-Berita.git

# Masuk ke folder project
cd Portal-Berita
```

### Langkah 2: Install Dependencies

```bash
# Install PHP dependencies dengan Composer
composer install

# Install Node.js dependencies
npm install
```

> **Catatan**: Proses ini akan memakan waktu beberapa menit tergantung koneksi internet.

### Langkah 3: Konfigurasi Environment

```bash
# Copy file .env.example menjadi .env
# Windows (PowerShell):
Copy-Item .env.example .env

# Mac/Linux:
cp .env.example .env
```

### Langkah 4: Generate Application Key

```bash
php artisan key:generate
```

### Langkah 5: Konfigurasi Database

Buka file `.env` dengan text editor (Notepad++, VS Code, dll), lalu sesuaikan pengaturan database:

#### Untuk PostgreSQL:

```env
DB_CONNECTION=pgsql
DB_HOST=127.0.0.1
DB_PORT=5432
DB_DATABASE=portal_berita
DB_USERNAME=postgres
DB_PASSWORD=your_password
```

#### Untuk MySQL:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=portal_berita
DB_USERNAME=root
DB_PASSWORD=your_password
```

### Langkah 6: Buat Database

#### PostgreSQL (menggunakan pgAdmin atau terminal):

```sql
CREATE DATABASE portal_berita;
```

#### MySQL (menggunakan phpMyAdmin atau terminal):

```sql
CREATE DATABASE portal_berita CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
```

### Langkah 7: Jalankan Migration & Seeder

```bash
# Jalankan migration untuk membuat tabel
php artisan migrate

# Jalankan seeder untuk mengisi data awal (Admin, Categories, Sample Articles)
php artisan db:seed --class=MasterSeeder
```

> **Output yang diharapkan**: Anda akan melihat progress bar untuk setiap seeder (RolePermissionSeeder, AdminSeeder, CategorySeeder, TagSeeder, dll)

### Langkah 8: Buat Storage Link

```bash
php artisan storage:link
```

### Langkah 9: Compile Frontend Assets

```bash
# Development (dengan file watching)
npm run dev

# Production (optimized & minified)
npm run build
```

### Langkah 10: Jalankan Aplikasi

```bash
# Jalankan development server
php artisan serve
```

Aplikasi akan berjalan di: **http://127.0.0.1:8000**

## 🔐 Akun Default

Setelah instalasi, gunakan akun berikut untuk login ke Admin Panel:

### Admin

-   **URL**: http://127.0.0.1:8000/admin
-   **Email**: admin@admin.com
-   **Password**: password

### Redaktur (Editor)

-   **Email**: redaktur@admin.com
-   **Password**: password

### Reporter

-   **Email**: reporter@admin.com
-   **Password**: password

> ⚠️ **PENTING**: Segera ganti password default setelah login pertama kali!

## 📁 Struktur Folder Utama

```
Portal-Berita/
├── app/
│   ├── Filament/          # Admin panel resources
│   ├── Http/Controllers/  # Frontend controllers
│   ├── Models/            # Eloquent models
│   ├── Observers/         # Model observers (cache invalidation)
│   ├── Services/          # Business logic services
│   └── Helpers/           # Helper functions
├── database/
│   ├── migrations/        # Database migrations
│   └── seeders/           # Database seeders
├── public/
│   ├── css/              # Compiled CSS
│   ├── js/               # Compiled JavaScript
│   └── storage/          # Public file storage (symlink)
├── resources/
│   ├── views/
│   │   ├── frontend/     # Frontend templates
│   │   └── filament/     # Admin customization
│   ├── css/              # Source CSS files
│   └── js/               # Source JavaScript files
├── routes/
│   └── web.php           # Route definitions
├── storage/
│   └── app/public/       # File uploads (articles, covers)
└── .env                  # Environment configuration
```

## 🎨 Kustomisasi

### Mengubah Logo & Branding

1. **Admin Panel Logo**:

    - Edit: `app/Providers/Filament/AdminPanelProvider.php`
    - Method: `->brandLogo()`, `->brandName()`

2. **Frontend Logo**:
    - Edit: `resources/views/frontend/layouts/app.blade.php`
    - Ganti gambar di folder: `public/images/`

### Mengubah Warna Tema

1. **Admin Panel**:

    - Edit: `app/Providers/Filament/AdminPanelProvider.php`
    - Method: `->colors([])`

2. **Frontend**:
    - Edit: `resources/views/frontend/layouts/app.blade.php` (section `<style>`)
    - Variabel CSS: `--primary-color`, `--secondary-color`, dll

### Menambah/Mengubah Kategori

1. Login ke Admin Panel
2. Navigasi ke: **Content Management > Categories**
3. Klik **New Category** atau edit existing
4. Isi: Name, Slug, Description, Icon

### Mengatur Homepage Settings

1. Login ke Admin Panel
2. Navigasi ke: **Settings**
3. Tab **Featured Articles**: Pilih artikel untuk headline
4. Tab **Popular Articles**: Akan otomatis berdasarkan views

## 🛠️ Troubleshooting

### Error: "vendor/autoload.php not found"

```bash
composer install
```

### Error: "Permission denied" pada storage/logs

```bash
# Windows (PowerShell as Admin):
icacls storage /grant Users:F /t
icacls bootstrap/cache /grant Users:F /t

# Mac/Linux:
chmod -R 775 storage bootstrap/cache
chown -R www-data:www-data storage bootstrap/cache
```

### Error: Database connection failed

-   Pastikan PostgreSQL/MySQL sudah running
-   Cek kredensial di file `.env`
-   Test koneksi database dengan tool (pgAdmin/phpMyAdmin)

### Error: "Class not found"

```bash
composer dump-autoload
php artisan config:clear
php artisan cache:clear
```

### Gambar tidak muncul

```bash
php artisan storage:link
```

### CSS/JS tidak ter-load

```bash
npm run build
php artisan config:clear
```

## 🔧 Command Artisan Berguna

```bash
# Clear semua cache
php artisan optimize:clear

# Clear specific cache
php artisan cache:clear
php artisan config:clear
php artisan route:clear
php artisan view:clear

# Refresh database (HATI-HATI: akan hapus semua data)
php artisan migrate:fresh --seed

# Buat user admin baru
php artisan db:seed --class=AdminSeeder

# Generate sitemap
php artisan sitemap:generate
```

## 📊 Performance Optimization

Sistem ini sudah dilengkapi dengan optimasi:

1. **Image Optimization**: Otomatis generate 4 ukuran (large, medium, small, thumbnail)
2. **Database Indexing**: Index pada kolom yang sering di-query
3. **Query Caching**: Homepage cache 10 menit
4. **Lazy Loading**: Gambar di-load saat terlihat di viewport
5. **Responsive Images**: Srcset untuk berbagai ukuran layar

## 🚀 Deployment ke Production

### Persiapan

1. **Update .env untuk Production**:

```env
APP_ENV=production
APP_DEBUG=false
APP_URL=https://yourdomain.com

DEBUGBAR_ENABLED=false
```

2. **Optimize aplikasi**:

```bash
composer install --optimize-autoloader --no-dev
php artisan config:cache
php artisan route:cache
php artisan view:cache
npm run build
```

3. **Set permissions**:

```bash
chmod -R 755 storage bootstrap/cache
```

### Server Requirements

-   PHP >= 8.2 dengan semua extensions
-   PostgreSQL >= 13 atau MySQL >= 8.0
-   Composer
-   SSL Certificate (untuk HTTPS)

### Recommended Hosting

-   **Shared Hosting**: Pastikan support Laravel & composer
-   **VPS**: DigitalOcean, Linode, Vultr
-   **Platform**: Laravel Forge, Ploi, ServerPilot
-   **Cloud**: AWS, Google Cloud, Azure

## 📞 Support & Dokumentasi

-   **GitHub Repository**: https://github.com/notyourkise/Portal-Berita
-   **Laravel Documentation**: https://laravel.com/docs
-   **Filament Documentation**: https://filamentphp.com/docs

## 📝 License

This project is licensed under the MIT License.

## 🙏 Credits

Dibuat dengan:

-   [Laravel 12](https://laravel.com) - PHP Framework
-   [Filament 3](https://filamentphp.com) - Admin Panel
-   [Bootstrap 5](https://getbootstrap.com) - CSS Framework
-   [Intervention Image](https://image.intervention.io) - Image Processing
-   [Spatie Laravel Permission](https://spatie.be/docs/laravel-permission) - Role & Permission

---

**Dibuat dengan ❤️ untuk Portal Berita Indonesia**
