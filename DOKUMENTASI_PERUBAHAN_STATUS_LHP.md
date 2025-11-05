# Dokumentasi Perubahan Status LHP

## Deskripsi
Implementasi perubahan status LHP menjadi 'Di Proses' saat file diupload pada form data dukung rekomendasi dan temuan.

## URL yang Terpengaruh
- `http://127.0.0.1:8002/adminTL/datadukung/rekom/{id}`
- `http://127.0.0.1:8002/adminTL/datadukung/temuan/{id}`

## Perubahan yang Dilakukan

### 1. Model Pengawasan (app/Models/Pengawasan.php)
**Ditambahkan:**
- `$table` property untuk menentukan nama tabel
- `$fillable` array untuk mass assignment fields termasuk `status_LHP`

```php
protected $table = 'pengawasans';

protected $fillable = [
    'tipe',
    'jenis',
    'wilayah',
    'pemeriksa',
    'status_LHP',
    'id_penugasan',
    'tglkeluar'
];
```

### 2. AdminTL Controller (app/Http/Controllers/AdminTL/FE/DashboardAminTLController.php)
**Dimodifikasi 2 method:**

#### a. Method `uploadFile()`
- Ditambahkan logika update status_LHP setelah file berhasil diupload
- Update dilakukan pada record pengawasan berdasarkan `id_pengawasan`

#### b. Method `uploadFileRekomendasi()`
- Ditambahkan logika update status_LHP setelah file berhasil diupload
- Update dilakukan pada record pengawasan berdasarkan `id_pengawasan`

### 3. Pemeriksa Controller (app/Http/Controllers/Pemeriksa/Fe/DashboardPemeriksa.php)
**Dimodifikasi method `uploadFile()`:**
- Ditambahkan logika update status_LHP setelah file berhasil diupload

### 4. OPD Controller (app/Http/Controllers/OPD/Fe/DashboardOPD.php)
**Dimodifikasi method `uploadFile()`:**
- Ditambahkan logika update status_LHP setelah file berhasil diupload

### 5. OpdTL Controller (app/Http/Controllers/OpdTL/OpdTLController.php)
**Dimodifikasi method `uploadFile()`:**
- Ditambahkan logika update status_LHP setelah file berhasil diupload

## Logika Perubahan Status
Pada setiap method upload file yang dimodifikasi, ditambahkan kode berikut:

```php
// Update status_LHP to 'Di Proses' when file is uploaded
$pengawasan = Pengawasan::find($request->id_pengawasan);
if ($pengawasan) {
    $pengawasan->status_LHP = 'Di Proses';
    $pengawasan->save();
    Log::info('Updated status_LHP to Di Proses', [
        'id_pengawasan' => $request->id_pengawasan
    ]);
}
```

## Behavior
- Saat user mengupload file pada form data dukung (rekomendasi atau temuan)
- Status LHP akan otomatis berubah dari status sebelumnya menjadi 'Di Proses'
- Perubahan ini berlaku untuk semua role (AdminTL, Pemeriksa, OPD, OpdTL)
- Logging ditambahkan untuk tracking perubahan status

## Testing
- Syntax check berhasil pada semua file yang dimodifikasi
- Laravel server dapat dijalankan tanpa error
- Semua import dan dependency sudah tersedia

## Catatan
- Perubahan hanya terjadi saat upload file berhasil
- Jika upload file gagal, status LHP tidak akan berubah
- Model Pengawasan sudah ter-import di semua controller yang dimodifikasi
