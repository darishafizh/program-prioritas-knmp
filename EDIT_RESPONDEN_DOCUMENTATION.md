# Fitur Edit Responden - Dokumentasi Implementasi

## 📋 Ringkasan
Fitur **Edit Responden** telah diimplementasikan sebagai menu terpisah per responden, mirip dengan fitur PDF export. User dapat memilih responden dari list dan mengedit data mereka.

## 🎯 Fitur yang Diimplementasikan

### 1. **Menu Edit Responden di Survey Index**
- **Lokasi**: `resources/views/survey/index.blade.php`
- **Tombol**: Tombol kuning "Edit Responden" (`btn-warning`) dengan icon `mdi-account-edit`
- **Posisi**: Di sebelah tombol "Input Survey" (tombol primer)
- **Route**: `forms.edit-responden`

### 2. **Halaman List Edit Responden**
- **File**: `resources/views/survey/forms/edit-responden.blade.php` (BARU)
- **Style**: Gradient purple header, responsive card grid layout
- **Konten per responden card**:
  - Avatar (👨/👩 based on jenis_kelamin)
  - Nama responden
  - NIK
  - Jenis kelamin
  - Tanggal wawancara
  - Nama enumerator
  - Total soal yang terisi
  - Tanggal terakhir diperbarui
  - Status badge (Terisi/Belum Terisi)
  - Tombol "Edit Data" untuk masuk ke form

### 3. **Controller Method - editRespondenList()**
- **File**: `app/Http/Controllers/FormsController.php`
- **Method**: `editRespondenList(Knmp $knmp)` (BARU)
- **Fungsi**: 
  - Ambil semua responden untuk KNMP tertentu
  - Hitung status completion per responden (dari tabel tingkat_kebahagiaan_nelayan)
  - Ambil tanggal terakhir diperbarui
  - Return data ke view `survey.forms.edit-responden`

### 4. **Route Baru**
- **File**: `routes/web.php`
- **Route**: 
  ```
  Route::get('/{knmp}/edit-responden', [FormsController::class, 'editRespondenList'])->name('forms.edit-responden');
  ```
- **Parameter**: `knmp` (KNMP ID)
- **Name**: `forms.edit-responden`

### 5. **Integrasi dengan Form Index**
- **File**: `resources/views/survey/forms/index.blade.php`
- **Perubahan**: 
  - Tambah parameter `$selectedRespondenId` dari query string
  - Responden select di form akan pre-select berdasarkan responden parameter
  - Contoh URL: `/survey/forms/{knmp}?responden={responden_id}`

### 6. **Update FormsController::index()**
- **File**: `app/Http/Controllers/FormsController.php`
- **Perubahan**:
  - Terima parameter `Request $request`
  - Ambil `responden` dari query string: `$request->query('responden')`
  - Pass `$selectedRespondenId` ke view
  - Form akan auto-select responden jika ada parameter

## 📊 Data Flow

```
Survey Index (survey.index)
    ↓
Click "Edit Responden" button
    ↓
FormsController::editRespondenList($knmp)
    ↓
Fetch all responden for KNMP
Calculate completion status
    ↓
Render edit-responden.blade.php (list view)
    ↓
Click "Edit Data" button on responden card
    ↓
Redirect to: /survey/forms/{knmp}?responden={responden_id}
    ↓
FormsController::index($knmp, $request)
    ↓
Extract $selectedRespondenId from query string
    ↓
Pass to forms/index.blade.php
    ↓
Form displays with responden pre-selected
    ↓
User can now edit that responden's data
```

## 🎨 UI Design
- **Color Scheme**: 
  - Primary gradient: `#667eea` to `#764ba2` (purple)
  - Card shadow: `0 2px 12px rgba(0, 0, 0, 0.08)`
  - Hover effect: `translateY(-5px)` with enhanced shadow
  
- **Responsive Grid**:
  - Desktop (1200px+): 3 columns
  - Tablet (768px-1200px): 2-3 columns
  - Mobile (< 576px): 1 column (full width)

- **Status Badges**:
  - Complete: Green background (`#d4edda`), green text (`#155724`)
  - Incomplete: Red background (`#f8d7da`), red text (`#721c24`)

## 📁 Files Affected

### New Files
- ✅ `resources/views/survey/forms/edit-responden.blade.php` - List responden untuk edit

### Modified Files
- ✅ `routes/web.php` - Tambah route `forms.edit-responden`
- ✅ `app/Http/Controllers/FormsController.php` - Tambah method `editRespondenList()` + update method `index()`
- ✅ `resources/views/survey/index.blade.php` - Tambah button "Edit Responden"
- ✅ `resources/views/survey/forms/index.blade.php` - Tambah support untuk `$selectedRespondenId`

## 🔄 User Journey

1. User membuka halaman Survey (survey.index)
2. User melihat list KNMP dengan 4 tombol action: Input Survey, Edit Responden, Lihat PDF, Evidence
3. User klik tombol "Edit Responden" (kuning) → Masuk halaman list responden
4. Halaman menampilkan card grid dengan info semua responden untuk KNMP tersebut
5. User klik "Edit Data" pada salah satu responden card
6. User masuk ke form kuesioner dengan responden sudah pre-selected
7. User dapat edit semua data responden (A-J sections)
8. Setelah submit, user kembali ke form dengan status berhasil

## ✨ Keunggulan Implementasi
- ✅ Pola yang konsisten dengan fitur "Daftar Kuesioner PDF"
- ✅ Responsive design untuk semua ukuran device
- ✅ Clear visual distinction (warna kuning untuk Edit Responden)
- ✅ Pre-selection otomatis responden dari edit-responden page
- ✅ Status completion indicator (Terisi/Belum Terisi)
- ✅ Informasi lengkap per responden (NIK, enumerator, tanggal update)
- ✅ Breadcrumb navigation untuk konteks yang jelas

## 🚀 Testing Checklist
- [ ] Klik tombol "Edit Responden" di survey index
- [ ] Verify list responden muncul dengan card grid
- [ ] Klik "Edit Data" pada salah satu responden
- [ ] Verify form muncul dengan responden pre-selected
- [ ] Edit data responden dan submit
- [ ] Verify status badge berubah dari "Belum Terisi" ke "Terisi"
- [ ] Test responsive design di berbagai ukuran (mobile, tablet, desktop)
- [ ] Verify breadcrumb navigation berfungsi

## 📝 Notes
- Fitur ini adalah alternatif dari embedded edit buttons yang sebelumnya ada di dalam accordion sections
- Sekarang edit untuk setiap responden bisa diakses dari menu terpisah yang dedicated
- Pola ini membuat UI lebih clean dan terstruktur
