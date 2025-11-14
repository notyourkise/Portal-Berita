# 📸 Portal Berita - Testing Guide

## ✅ Cara Testing Admin Panel

### 1️⃣ Login ke Admin Panel

1. Jalankan server:
   ```powershell
   php artisan serve
   ```

2. Buka browser dan akses:
   ```
   http://localhost:8000/admin
   ```

3. Login dengan salah satu akun:
   - **Admin:** admin@admin.com / password
   - **Redaktur:** redaktur@admin.com / password  
   - **Reporter:** reporter@admin.com / password

---

### 2️⃣ Testing Categories

1. Di sidebar admin, klik **Categories**
2. Anda akan melihat 5 kategori:
   - Politik
   - Ekonomi
   - Teknologi
   - Olahraga
   - Entertainment

**Yang bisa dilakukan:**
- ✅ Lihat list categories
- ✅ Create category baru
- ✅ Edit category
- ✅ Delete category
- ✅ Toggle active/inactive
- ✅ Sort by order

---

### 3️⃣ Testing Tags

1. Di sidebar admin, klik **Tags**
2. Anda akan melihat 8 tags:
   - Breaking News
   - Trending
   - Viral
   - Investigasi
   - Opini
   - Analisis
   - Internasional
   - Nasional

**Yang bisa dilakukan:**
- ✅ Lihat list tags
- ✅ Create tag baru
- ✅ Edit tag
- ✅ Delete tag

---

### 4️⃣ Testing Articles

1. Di sidebar admin, klik **Articles**
2. Anda akan melihat 4 artikel sample:
   - 3 artikel Published (Politik, Teknologi, Olahraga)
   - 1 artikel Draft (Teknologi)

**Yang bisa dilakukan:**
- ✅ Lihat list articles
- ✅ Filter by status (draft/review/published/scheduled)
- ✅ Filter by category
- ✅ Search articles
- ✅ Create article baru
- ✅ Edit article
- ✅ Delete article
- ✅ Lihat detail article dengan:
  - Category
  - Author
  - Editor
  - Tags (multiple)
  - Cover image
  - Status
  - Published date
  - View count

**Fields dalam Article Form:**
- Title
- Slug (auto-generate)
- Category (dropdown)
- Excerpt
- Body (rich text editor)
- Cover Image
- Tags (multiple select)
- Status (draft/review/published/scheduled)
- Published At
- Scheduled At
- Is Featured (toggle)
- Allow Comments (toggle)
- SEO Fields:
  - Meta Title
  - Meta Description
  - Meta Keywords

---

### 5️⃣ Testing Pages

1. Di sidebar admin, klik **Pages**
2. Anda akan melihat 3 halaman:
   - Tentang Kami
   - Kontak
   - Kebijakan Privasi

**Yang bisa dilakukan:**
- ✅ Lihat list pages
- ✅ Create page baru
- ✅ Edit page
- ✅ Delete page
- ✅ Toggle active/inactive
- ✅ Sort by order

---

## 🧪 Test Scenarios

### Scenario 1: Buat Artikel Baru
1. Klik **Articles** → **Create**
2. Isi form:
   - Title: "Test Artikel Baru"
   - Slug: Auto-generate
   - Category: Pilih "Teknologi"
   - Excerpt: "Ini adalah excerpt test"
   - Body: Tulis konten artikel
   - Tags: Pilih "Breaking News" dan "Trending"
   - Status: "Published"
   - Published At: Sekarang
   - Is Featured: Ya
3. Klik **Create**
4. Cek apakah artikel muncul di list

### Scenario 2: Edit Category
1. Klik **Categories**
2. Pilih "Politik"
3. Ubah description
4. Save
5. Cek perubahan tersimpan

### Scenario 3: Test Auto-Slug
1. Buat category baru dengan name: "Berita Terkini"
2. Kosongkan field slug
3. Save
4. Slug otomatis akan menjadi "berita-terkini"

### Scenario 4: Test Relationships
1. Buat artikel baru
2. Assign ke category
3. Assign multiple tags
4. Set author & editor
5. Lihat di detail artikel apakah semua relasi muncul

---

## 🔍 What to Check

### Database:
```powershell
php artisan tinker
```

Then run:
```php
// Count data
App\Models\Category::count();  // Should be 5
App\Models\Tag::count();       // Should be 8
App\Models\Article::count();   // Should be 4
App\Models\Page::count();      // Should be 3

// Get published articles
App\Models\Article::published()->get();

// Get featured articles
App\Models\Article::featured()->get();

// Get article with relations
App\Models\Article::with(['category', 'author', 'tags'])->first();
```

---

## ✨ Expected Results

### After Login:
- ✅ Dashboard muncul
- ✅ Sidebar menu: Categories, Tags, Articles, Pages
- ✅ User menu di top right

### In Categories:
- ✅ 5 categories listed
- ✅ Bisa create/edit/delete
- ✅ Slug auto-generate

### In Tags:
- ✅ 8 tags listed
- ✅ Bisa create/edit/delete
- ✅ Slug auto-generate

### In Articles:
- ✅ 4 articles listed
- ✅ Status badges (Published/Draft)
- ✅ Featured star icon
- ✅ View count visible
- ✅ Bisa filter by status & category
- ✅ Bisa create artikel dengan rich text
- ✅ Bisa attach multiple tags
- ✅ Author & Editor terisi

### In Pages:
- ✅ 3 pages listed
- ✅ Active/inactive status
- ✅ Bisa create/edit/delete

---

## 🐛 Troubleshooting

### Error saat Create Article:
- Pastikan semua required fields terisi
- Pastikan category sudah ada
- Pastikan author_id valid

### Slug tidak auto-generate:
- Pastikan field slug dikosongkan
- Model sudah punya boot() method

### Relasi tidak muncul:
- Cek foreign key di database
- Pastikan migrations sudah dijalankan
- Cek relasi di model

---

## 📊 Database Check

### Check Tables:
```sql
-- Via Tinker
php artisan tinker

Schema::hasTable('categories');  // true
Schema::hasTable('tags');        // true
Schema::hasTable('articles');    // true
Schema::hasTable('article_tag'); // true
Schema::hasTable('pages');       // true
```

### Check Relationships:
```php
// Artikel dengan semua relasi
$article = App\Models\Article::with(['category', 'author', 'editor', 'tags'])->first();

$article->category->name;     // Nama kategori
$article->author->name;       // Nama author
$article->tags->pluck('name'); // Array nama tags
```

---

## ✅ Success Indicators

Jika semua ini berjalan, berarti **Phase 1-3 SUCCESS!** ✅

- ✅ Login berhasil
- ✅ CRUD Categories works
- ✅ CRUD Tags works
- ✅ CRUD Articles works
- ✅ CRUD Pages works
- ✅ Auto-slug works
- ✅ Relationships works
- ✅ Sample data loaded
- ✅ Filament resources accessible

---

**Next:** Phase 4 - Frontend Development! 🎨
