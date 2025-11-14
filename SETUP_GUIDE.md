# 🚀 Portal Berita - Setup & Running Guide

## ✅ Status Project
- Laravel 12 berhasil diinstall
- Filament 3.2 sudah terkonfigurasi
- Database PostgreSQL terhubung
- Packages SEO & Sitemap terinstall
- Admin user sudah dibuat

## 📋 Kredensial Admin

**Login Filament Admin:**
- URL: `http://portal-berita.test/admin` (Laragon) atau `http://localhost:8000/admin` (php artisan serve)
- Email: `admin@admin.com`
- Password: `password`

## 🔧 Cara Menjalankan Web

### ⚡ Opsi 1: Menggunakan PHP Artisan Serve (Recommended untuk Development)

```powershell
cd C:\laragon\www\portal-berita
php artisan serve
```

Akses:
- **Public**: http://localhost:8000
- **Admin Panel**: http://localhost:8000/admin

### 🌐 Opsi 2: Menggunakan Laragon Nginx

#### Langkah-langkah:

1. **Restart Nginx di Laragon**
   - Buka Laragon
   - Klik kanan pada icon Laragon
   - Pilih **Nginx** > **Reload**

2. **Tambahkan Entry di File Hosts (Jika belum)**
   - Buka Notepad as Administrator
   - Buka file: `C:\Windows\System32\drivers\etc\hosts`
   - Tambahkan baris ini:
   ```
   127.0.0.1    portal-berita.test
   ```
   - Save file

3. **Akses Website**
   - **Public**: http://portal-berita.test
   - **Admin Panel**: http://portal-berita.test/admin

## 🐛 Troubleshooting

### ❌ User Tidak Bisa Login di Filament

**Solusi:**
```powershell
cd C:\laragon\www\portal-berita
php artisan db:seed --class=AdminSeeder
```

Kredensial admin akan direset ke:
- Email: `admin@admin.com`
- Password: `password`

### ❌ 404 Not Found di Nginx Laragon

**Penyebab**: Virtual Host Nginx belum dikonfigurasi dengan benar

**Solusi**:
1. File konfigurasi Nginx sudah dibuat di: `C:\laragon\etc\nginx\sites-enabled\portal-berita.test.conf`
2. Restart Nginx dari Laragon
3. Pastikan file hosts sudah ditambahkan

### ❌ Session Error / CSRF Token Mismatch

**Solusi:**
```powershell
php artisan optimize:clear
php artisan config:clear
php artisan cache:clear
```

### ❌ Database Connection Error

**Pastikan:**
1. PostgreSQL sudah running di Laragon
2. Database `portal_berita` sudah dibuat
3. Kredensial di `.env` sudah benar:
   ```
   DB_CONNECTION=pgsql
   DB_HOST=127.0.0.1
   DB_PORT=5432
   DB_DATABASE=portal_berita
   DB_USERNAME=postgres
   DB_PASSWORD=1
   ```

## 📦 Command Berguna

### Migrasi Database
```powershell
php artisan migrate
```

### Rollback Migrasi
```powershell
php artisan migrate:rollback
```

### Fresh Migration + Seeder
```powershell
php artisan migrate:fresh --seed
```

### Membuat Admin Baru
```powershell
php artisan make:filament-user
```

### Clear All Cache
```powershell
php artisan optimize:clear
```

### Generate Storage Link
```powershell
php artisan storage:link
```

## 📝 Next Steps (Development Roadmap)

### Phase 1: Database Structure ✅ (Current)
- [x] Setup Laravel & Filament
- [x] Konfigurasi Database PostgreSQL
- [x] Install SEO & Sitemap packages
- [x] Buat Admin User
- [ ] Buat Migration untuk Categories
- [ ] Buat Migration untuk Tags
- [ ] Buat Migration untuk Articles
- [ ] Buat Migration untuk Pages

### Phase 2: Models & Relationships
- [ ] Buat Model Category dengan relasi
- [ ] Buat Model Tag dengan relasi
- [ ] Buat Model Article dengan relasi
- [ ] Buat Model Page

### Phase 3: Filament Resources (Admin Panel)
- [ ] Buat CategoryResource
- [ ] Buat TagResource
- [ ] Buat ArticleResource
- [ ] Buat PageResource
- [ ] Implementasi Role & Permission

### Phase 4: Frontend
- [ ] Buat Homepage (Blade Template)
- [ ] Buat Single Article Page
- [ ] Buat Category Page
- [ ] Buat Tag Page
- [ ] Buat Search Functionality

### Phase 5: SEO & Performance
- [ ] Implementasi SEO Meta Tags
- [ ] Generate Sitemap
- [ ] Setup Caching
- [ ] Image Optimization

## 🎯 Architecture Summary

```
Portal Berita
├── Backend (Filament Admin)
│   ├── URL: /admin
│   ├── Authentication: Laravel Breeze/Filament
│   ├── RBAC: Roles (Admin, Redaktur, Reporter)
│   └── CRUD: Articles, Categories, Tags, Pages
│
├── Frontend (Public)
│   ├── URL: /
│   ├── Views: Blade Templates
│   ├── CSS: Bootstrap 5
│   └── Routes: /, /news/{slug}, /category/{slug}, /tag/{slug}
│
└── Database (PostgreSQL)
    ├── users (dengan roles)
    ├── categories
    ├── tags
    ├── articles
    ├── article_tag (pivot)
    └── pages
```

## 📞 Need Help?

Jika ada masalah, jalankan command ini untuk diagnostik:

```powershell
php artisan about
php artisan route:list
php artisan migrate:status
```

---

**Last Updated**: 2025-11-10
**Laravel Version**: 12.0
**Filament Version**: 3.2
**Database**: PostgreSQL 14.5
