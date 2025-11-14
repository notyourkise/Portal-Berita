# Reading Time Estimator - Portal Berita

## 📚 Fitur Reading Time

Otomatis menghitung estimasi waktu baca artikel berdasarkan jumlah kata.

---

## 🎯 Cara Kerja

### Formula Perhitungan:
```
Reading Time (menit) = Total Words ÷ 200 words/minute
```

**Asumsi:**
- Rata-rata orang baca: **200 kata per menit**
- Minimum waktu baca: **1 menit** (untuk artikel pendek)
- HTML tags dikecualikan dari perhitungan

---

## 💻 Implementasi

### 1. Model Accessor (Article.php)

```php
// Hitung waktu baca dalam menit
public function getReadingTimeAttribute()
{
    $words = str_word_count(strip_tags($this->body));
    $minutes = ceil($words / 200);
    return max(1, $minutes);
}

// Format text display
public function getReadingTimeTextAttribute()
{
    $time = $this->reading_time;
    
    if ($time == 1) {
        return '1 menit';
    }
    
    return $time . ' menit';
}
```

### 2. Penggunaan di Blade Templates

**Di Halaman Detail Artikel:**
```blade
<div class="article-meta">
    <i class="bi bi-book text-primary"></i>
    <strong>{{ $article->reading_time_text }}</strong> baca
</div>
```

**Di Card Homepage:**
```blade
<span>
    <i class="bi bi-book text-primary"></i> 
    {{ $article->reading_time }} mnt
</span>
```

---

## 📊 Contoh Perhitungan

| Jumlah Kata | Waktu Baca |
|-------------|------------|
| 150 kata | 1 menit |
| 400 kata | 2 menit |
| 800 kata | 4 menit |
| 1,500 kata | 8 menit |
| 3,000 kata | 15 menit |

---

## 🎨 Display Locations

Reading time ditampilkan di:

1. ✅ **Article Detail Page** - Di meta information (author, tanggal, views)
2. ✅ **Homepage Headline Card** - Di bawah excerpt
3. ⏸️ **Category Archive** - (Optional, bisa ditambahkan)
4. ⏸️ **Search Results** - (Optional, bisa ditambahkan)
5. ⏸️ **Tag Archive** - (Optional, bisa ditambahkan)

---

## 🔧 Customization

### Ubah Kecepatan Baca

Jika ingin adjust untuk audience yang berbeda:

```php
// Untuk pembaca cepat (250 wpm)
$minutes = ceil($words / 250);

// Untuk pembaca lambat (150 wpm) 
$minutes = ceil($words / 150);

// Untuk technical content (175 wpm)
$minutes = ceil($words / 175);
```

### Format Display Custom

```php
// Tampilkan detik untuk artikel sangat pendek
public function getReadingTimeTextAttribute()
{
    $words = str_word_count(strip_tags($this->body));
    $seconds = ($words / 200) * 60;
    
    if ($seconds < 60) {
        return 'Kurang dari 1 menit';
    }
    
    $minutes = ceil($seconds / 60);
    return $minutes . ' menit baca';
}
```

### Dengan Icon Emoji

```blade
<span>
    📖 {{ $article->reading_time_text }}
</span>
```

---

## 🎯 Benefits

### User Experience:
- ✅ User tahu berapa lama waktu yang diperlukan
- ✅ Meningkatkan engagement (user prepare waktu)
- ✅ Mengurangi bounce rate
- ✅ Meningkatkan trust & transparency

### SEO:
- ✅ Rich snippet potential (structured data)
- ✅ Meningkatkan dwell time
- ✅ Better user signals untuk Google

### Analytics:
- ✅ Bisa track reading completion rate
- ✅ Optimize artikel length berdasarkan data
- ✅ A/B testing artikel pendek vs panjang

---

## 📈 Future Enhancements

### 1. Reading Progress Bar
```javascript
// Show progress bar saat user scroll
let articleHeight = document.querySelector('.article-body').scrollHeight;
let windowHeight = window.innerHeight;
let scrolled = (window.scrollY / (articleHeight - windowHeight)) * 100;
```

### 2. Estimated Reading Time by Section
```php
// Hitung per section atau halaman
public function getReadingTimePerPageAttribute()
{
    return ceil($this->reading_time / $this->total_pages);
}
```

### 3. Personalized Reading Speed
```php
// Track user actual reading speed dan adjust
// Store di session atau user profile
```

---

## ⚡ Performance

**Impact:** Minimal
- Perhitungan dilakukan on-the-fly saat accessor dipanggil
- Menggunakan native PHP `str_word_count()`
- Tidak ada database query tambahan
- Hasil bisa di-cache jika diperlukan

**Optimization (Optional):**
```php
// Cache reading time di database column
Schema::table('articles', function($table) {
    $table->integer('reading_time')->nullable();
});

// Update saat artikel di-save
public function setBodyAttribute($value)
{
    $this->attributes['body'] = $value;
    $this->attributes['reading_time'] = ceil(
        str_word_count(strip_tags($value)) / 200
    );
}
```

---

## 📝 Testing

```bash
php artisan tinker

>>> $article = Article::first()
>>> $article->reading_time
=> 5

>>> $article->reading_time_text
=> "5 menit"
```

---

## ✅ Checklist Implementation

- [x] Model accessor untuk `reading_time`
- [x] Model accessor untuk `reading_time_text`
- [x] Display di article detail page
- [x] Display di homepage headline card
- [ ] Display di category archive (optional)
- [ ] Display di search results (optional)
- [ ] Display di tag archive (optional)
- [ ] Schema.org structured data (optional)
- [ ] Reading progress bar (optional)
