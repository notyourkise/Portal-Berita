# 🧪 RBAC Testing Guide - Portal Berita

## 📋 Test Credentials

| Role | Email | Password | Permissions |
|------|-------|----------|-------------|
| **Admin** | admin@admin.com | password | Full Access (27 permissions) |
| **Redaktur** | redaktur@admin.com | password | Moderate Access (9 permissions) |
| **Reporter** | reporter@admin.com | password | Limited Access (6 permissions) |

---

## 🎯 Test Scenarios

### ✅ **Scenario 1: Reporter Workflow**

**Login:** `reporter@admin.com` / `password`

**Test Cases:**
1. **Create New Article**
   - [ ] Klik "Articles" → "New Article"
   - [ ] Form hanya menampilkan: Title, Slug, Excerpt, Body, Cover Image, SEO
   - [ ] **TIDAK** menampilkan: Author, Editor, Featured, View Count
   - [ ] Author otomatis terisi dengan nama Reporter
   - [ ] Buat artikel dengan status "Draft"
   - [ ] **Expected:** Artikel berhasil dibuat ✅

2. **Submit for Review**
   - [ ] Edit artikel yang baru dibuat
   - [ ] Ubah status dari "Draft" → "In Review"
   - [ ] **Expected:** Status berubah ✅
   - [ ] **Expected:** TIDAK bisa pilih "Published" atau "Scheduled" ❌

3. **View Own Articles Only**
   - [ ] Kembali ke Articles list
   - [ ] **Expected:** Hanya melihat artikel yang dibuat sendiri ✅
   - [ ] **Expected:** TIDAK melihat artikel dari user lain ❌

4. **Cannot Delete Published Article**
   - [ ] Coba delete artikel dengan status "Published"
   - [ ] **Expected:** Tombol delete tidak muncul ❌

5. **Cannot Edit Other's Articles**
   - [ ] Logout, login sebagai Admin
   - [ ] Buat artikel baru
   - [ ] Logout, login kembali sebagai Reporter
   - [ ] **Expected:** Artikel dari Admin TIDAK muncul di list ❌

---

### ✅ **Scenario 2: Redaktur Workflow**

**Login:** `redaktur@admin.com` / `password`

**Test Cases:**
1. **View All Articles**
   - [ ] Klik "Articles"
   - [ ] **Expected:** Melihat SEMUA artikel (termasuk dari Reporter & Admin) ✅

2. **Approve Article from Reporter**
   - [ ] Cari artikel dengan status "In Review"
   - [ ] Klik Edit
   - [ ] Ubah status dari "In Review" → "Published"
   - [ ] Isi Published Date (otomatis hari ini)
   - [ ] Save
   - [ ] **Expected:** Status berubah ✅
   - [ ] **Expected:** Editor ID otomatis terisi dengan ID Redaktur ✅

3. **Create and Publish Own Article**
   - [ ] Klik "New Article"
   - [ ] Form menampilkan lebih banyak field (Author, Status, Published Date)
   - [ ] Buat artikel dengan status "Published"
   - [ ] **Expected:** Artikel langsung published ✅

4. **Schedule Article**
   - [ ] Buat artikel baru
   - [ ] Pilih status "Scheduled"
   - [ ] Isi Scheduled Date (tanggal masa depan)
   - [ ] Save
   - [ ] **Expected:** Artikel tersimpan dengan scheduled date ✅

5. **Cannot Delete Published Article**
   - [ ] Coba delete artikel yang sudah Published
   - [ ] **Expected:** Tombol delete tidak muncul ❌
   - [ ] **Only Admin** yang bisa delete published articles

---

### ✅ **Scenario 3: Admin Workflow**

**Login:** `admin@admin.com` / `password`

**Test Cases:**
1. **Full Access to All Features**
   - [ ] Klik "Articles"
   - [ ] **Expected:** Melihat SEMUA artikel ✅
   - [ ] **Expected:** Tombol "New Article" tersedia ✅

2. **Create Article with Manual Author**
   - [ ] Klik "New Article"
   - [ ] **Expected:** Field "Author" dapat dipilih manual ✅
   - [ ] Pilih Reporter sebagai Author
   - [ ] Buat artikel dengan status "Published"
   - [ ] **Expected:** Artikel tersimpan dengan Author = Reporter ✅

3. **Toggle Featured Article**
   - [ ] Edit artikel apapun
   - [ ] **Expected:** Checkbox "Featured" muncul ✅
   - [ ] Toggle Featured ON
   - [ ] Save
   - [ ] **Expected:** Artikel menjadi featured ✅

4. **Delete Any Article**
   - [ ] Kembali ke Articles list
   - [ ] Pilih artikel dengan status "Published"
   - [ ] **Expected:** Tombol delete tersedia ✅
   - [ ] Klik delete
   - [ ] **Expected:** Artikel terhapus (soft delete) ✅

5. **Access All Resources**
   - [ ] **Expected:** Menu sidebar menampilkan: Articles, Categories, Tags, Pages ✅
   - [ ] **Expected:** Bisa create/edit/delete semua resources ✅

---

## 🔍 **Permission Matrix**

| Permission | Reporter | Redaktur | Admin |
|------------|:--------:|:--------:|:-----:|
| **Articles** |
| View Own Articles | ✅ | ✅ | ✅ |
| View All Articles | ❌ | ✅ | ✅ |
| Create Article | ✅ | ✅ | ✅ |
| Edit Own Article | ✅ | ✅ | ✅ |
| Edit Any Article | ❌ | ✅ | ✅ |
| Delete Draft Article | ✅ | ✅ | ✅ |
| Delete Published Article | ❌ | ❌ | ✅ |
| Publish Article | ❌ | ✅ | ✅ |
| Schedule Article | ❌ | ✅ | ✅ |
| Toggle Featured | ❌ | ❌ | ✅ |
| **Categories** |
| View Categories | ✅ | ✅ | ✅ |
| Create Category | ❌ | ✅ | ✅ |
| Edit Category | ❌ | ✅ | ✅ |
| Delete Category | ❌ | ❌ | ✅ |
| **Tags** |
| View Tags | ✅ | ✅ | ✅ |
| Create Tag | ❌ | ✅ | ✅ |
| Edit Tag | ❌ | ✅ | ✅ |
| Delete Tag | ❌ | ❌ | ✅ |
| **Pages** |
| View Pages | ✅ | ✅ | ✅ |
| Create Page | ❌ | ✅ | ✅ |
| Edit Page | ❌ | ✅ | ✅ |
| Delete Page | ❌ | ❌ | ✅ |

---

## 🚀 **Quick Test Commands**

### Check User Permissions via Tinker
```bash
php artisan tinker
```

```php
// Check Reporter permissions
$reporter = User::where('email', 'reporter@admin.com')->first();
$reporter->getAllPermissions()->pluck('name');

// Check Redaktur permissions
$redaktur = User::where('email', 'redaktur@admin.com')->first();
$redaktur->getAllPermissions()->pluck('name');

// Check Admin permissions
$admin = User::where('email', 'admin@admin.com')->first();
$admin->getAllPermissions()->pluck('name');

// Test specific permission
$reporter->can('publish article'); // false
$redaktur->can('publish article'); // true
$admin->can('delete article');     // true
```

---

## 📝 **Test Checklist Summary**

### Reporter (6 permissions)
- ✅ Can view own articles
- ✅ Can create articles (draft/review only)
- ✅ Can edit own draft articles
- ✅ Can delete own draft articles
- ❌ Cannot publish articles
- ❌ Cannot view/edit other's articles
- ❌ Cannot manage categories/tags/pages

### Redaktur (9 permissions)
- ✅ Can view all articles
- ✅ Can create/edit any article
- ✅ Can publish articles
- ✅ Can schedule articles
- ✅ Can manage categories/tags/pages
- ❌ Cannot delete published articles
- ❌ Cannot toggle featured
- ❌ Cannot manage users

### Admin (27 permissions)
- ✅ Full access to all features
- ✅ Can delete any article
- ✅ Can toggle featured
- ✅ Can manage all resources
- ✅ Can manage users & settings

---

## 🐛 **Common Issues & Solutions**

### Issue 1: "Access Denied" when testing
**Solution:** Clear cache
```bash
php artisan optimize:clear
```

### Issue 2: Permissions not working
**Solution:** Check role assignment
```bash
php artisan tinker
User::find(1)->roles->pluck('name'); // Should show role
```

### Issue 3: Can't login
**Solution:** Re-seed users
```bash
php artisan db:seed --class=AdminSeeder
```

---

## ✅ **Expected Results**

After testing all scenarios:
- [ ] Reporter dapat create artikel draft/review
- [ ] Reporter hanya melihat artikel sendiri
- [ ] Redaktur dapat approve/publish artikel
- [ ] Redaktur dapat manage categories/tags
- [ ] Admin memiliki full access
- [ ] Auto-slug generation bekerja
- [ ] Auto-author assignment untuk Reporter
- [ ] Auto-editor assignment untuk Redaktur saat publish
- [ ] Published date auto-set untuk status published
- [ ] Scheduled date required untuk status scheduled

---

**Status Testing:** 
- [ ] Belum ditest
- [ ] Sedang ditest
- [ ] ✅ Semua test passed!

**Tested by:** _____________  
**Date:** _____________  
**Notes:** _____________
