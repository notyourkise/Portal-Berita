# Cache Management - Portal Berita

## 📦 Implementasi Cache

### 1. Homepage Cache
**Durasi:** 10 menit (600 detik)
**Cache Key:** `homepage_data`

**Data yang di-cache:**
- Latest articles (7 artikel)
- Categorized articles (3 kategori × 4 artikel)
- Hot topics (5 tags)

### 2. Popular Articles Cache
**Durasi:** 1 jam (3600 detik)
**Cache Key:** `popular_articles`

**Data yang di-cache:**
- Top 5 artikel paling banyak dilihat

---

## 🔧 Cara Menggunakan

### Clear Cache Manual
Jalankan command ini setelah publish artikel baru atau update penting:

```bash
php artisan cache:clear-homepage
```

### Clear All Cache
Untuk clear semua cache aplikasi (termasuk config, views, routes):

```bash
php artisan cache:clear
php artisan config:clear
php artisan view:clear
php artisan route:clear
```

---

## ⚡ Performance Impact

**Sebelum Cache:**
- Homepage load: ~300-500ms
- Database queries: 10-15 queries per request
- Server load: High pada traffic tinggi

**Setelah Cache:**
- Homepage load: ~10-20ms (dari cache)
- Database queries: 0 queries (saat cache hit)
- Server load: Sangat rendah
- Cache rebuild: ~300ms setiap 10 menit sekali

---

## 🎯 Best Practices

1. **Publish Artikel Baru:**
   ```bash
   # Setelah publish artikel, clear cache agar muncul di homepage
   php artisan cache:clear-homepage
   ```

2. **Update Settings (Headline/Hot Topics):**
   ```bash
   # Cache otomatis akan refresh dalam 10 menit
   # Atau clear manual untuk update langsung
   php artisan cache:clear-homepage
   ```

3. **Production Deployment:**
   ```bash
   # Setelah deploy update code, clear semua cache
   php artisan optimize:clear
   ```

---

## 🔄 Auto Clear Cache (Future Enhancement)

**Option 1: Event Listener**
Otomatis clear cache saat artikel published:

```php
// Di ArticleObserver atau Event Listener
use Illuminate\Support\Facades\Cache;

public function updated(Article $article)
{
    if ($article->wasChanged('status') && $article->status === 'published') {
        Cache::forget('homepage_data');
        Cache::forget('popular_articles');
    }
}
```

**Option 2: Scheduled Task**
Clear cache otomatis setiap jam via Laravel Scheduler:

```php
// Di app/Console/Kernel.php
protected function schedule(Schedule $schedule)
{
    $schedule->command('cache:clear-homepage')->hourly();
}
```

---

## 📊 Monitoring Cache

Cek apakah cache berfungsi:

```php
// Di Tinker atau Controller
php artisan tinker

>>> Cache::has('homepage_data')
=> true // Cache exists

>>> Cache::get('homepage_data')
=> array:5 [...]

>>> Cache::forget('homepage_data')
=> true // Cache cleared
```

---

## ⚠️ Notes

- Cache menggunakan default driver (biasanya `file` di `.env`)
- Untuk production, gunakan Redis atau Memcached untuk performa lebih baik
- Cache otomatis expire setelah durasi yang ditentukan
- Manual clear cache hanya diperlukan jika ingin update langsung
