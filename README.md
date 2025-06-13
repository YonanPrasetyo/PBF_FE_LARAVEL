# Laravel Frontend Setup Guide

Panduan lengkap untuk setup Laravel sebagai frontend yang mengkonsumsi API backend.

## 📋 Persiapan Awal

### 1. Install Laravel
```bash
composer create-project "laravel/laravel:^10.0" example-app
```
> Ini akan membuat folder dengan nama `example-app` (atau nama yang Anda tentukan)

### 2. Masuk ke VS Code
```bash
cd example-app
code .
```

### 3. Install Dependencies
Buka terminal di VS Code, lalu jalankan:

#### Cara sesuai dokumentasi Laravel:
```bash
npm install && npm run build
composer run dev
```

#### Jika cara di atas tidak bisa:
```bash
set NODE_OPTIONS=--max-old-space-size=4096
npm install
npm run build
npm run dev
```

## ⚙️ Konfigurasi Environment

### 4. Ubah Session Driver
Edit file `.env` dan ubah:
```env
SESSION_DRIVER=file
```

### 5. Tambahkan API Base URL
Tambahkan di file `.env`:
```env
API_BASE_URL=http://localhost:8080
```

### 6. Konfigurasi Services
Edit file `config/services.php` dan tambahkan:
```php
'api' => [
    'api_base_url' => env('API_BASE_URL'),
],
```

## 🎛️ Membuat Controllers

### 7. Generate Controllers
```bash
php artisan make:controller MahasiswaController
php artisan make:controller DosenController
php artisan make:controller DashboardController
```

### 8. Buat Function Index di MahasiswaController
```php
<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class MahasiswaController extends Controller
{
    public function index()
    {
        $response = Http::get(config('services.api.api_base_url').'/mahasiswa');
        return view('mahasiswa.index', [
            'mahasiswa' => $response->json()
        ]);
    }
}
```

## 📁 Struktur Views

### 9. Buat Folder dan File Views
```
resources/
├── views/
    ├── layout/
    │   └── app.blade.php
    ├── pages/
    │   └── dashboard.blade.php
    ├── mahasiswa/
    │   └── index.blade.php
    └── dosen/
        ├── index.blade.php
        ├── create.blade.php
        └── edit.blade.php
```

### 10. Test View Mahasiswa
Isi file `resources/views/mahasiswa/index.blade.php`:
```php
@dd($mahasiswa);
```

## 🛣️ Setup Routes

### 11. Konfigurasi Routes
Edit file `routes/web.php`:
```php
<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MahasiswaController;
use App\Http\Controllers\DosenController;
use App\Http\Controllers\DashboardController;

// Dashboard Routes
Route::get('/', function () {
    return view('pages.dashboard');
});
Route::get('/dashboard', [DashboardController::class, 'index']);

// Mahasiswa Routes
Route::get('/mahasiswa', [MahasiswaController::class, 'index']);

// Dosen Routes
Route::get('/dosen', [DosenController::class, 'index']);
Route::get('/dosen/create', [DosenController::class, 'create']);
Route::post('/dosen/store', [DosenController::class, 'store']);
Route::get('/dosen/edit/{nidn}', [DosenController::class, 'edit']);
Route::put('/dosen/update', [DosenController::class, 'update']);
Route::delete('/dosen/delete/{nidn}', [DosenController::class, 'destroy']);
```

## 📝 CRUD Operations untuk Dosen

### 12. Implementasi DosenController
```php
<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class DosenController extends Controller
{
    public function index()
    {
        $response = Http::get(config('services.api.api_base_url').'/dosen');
        return view('dosen.index', [
            'dosen' => $response->json()
        ]);
    }

    public function create()
    {
        return view('dosen.create');
    }

    public function store(Request $request)
    {
        $response = Http::post(config('services.api.api_base_url').'/dosen', $request->all());
        
        if ($response->successful()) {
            return redirect('/dosen')->with('success', 'Data dosen berhasil ditambahkan');
        }
        
        return back()->with('error', 'Gagal menambahkan data dosen');
    }

    public function edit($nidn)
    {
        $response = Http::get(config('services.api.api_base_url').'/dosen/'.$nidn);
        return view('dosen.edit', [
            'dosen' => $response->json()
        ]);
    }

    public function update(Request $request)
    {
        $response = Http::put(config('services.api.api_base_url').'/dosen/'.$request->nidn, $request->all());
        
        if ($response->successful()) {
            return redirect('/dosen')->with('success', 'Data dosen berhasil diupdate');
        }
        
        return back()->with('error', 'Gagal mengupdate data dosen');
    }

    public function destroy($nidn)
    {
        $response = Http::delete(config('services.api.api_base_url').'/dosen/'.$nidn);
        
        if ($response->successful()) {
            return redirect('/dosen')->with('success', 'Data dosen berhasil dihapus');
        }
        
        return back()->with('error', 'Gagal menghapus data dosen');
    }
}
```

## 📋 Template Form

### 13. Form Create Dosen
File `resources/views/dosen/create.blade.php`:
```php
@extends('layout.app')

@section('content')
<div class="container">
    <h2>Tambah Dosen</h2>
    
    <form action="/dosen/store" method="POST">
        @csrf
        <div class="form-group">
            <label>NIDN:</label>
            <input type="text" name="nidn" class="form-control" required>
        </div>
        <div class="form-group">
            <label>Nama:</label>
            <input type="text" name="nama" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-primary">Simpan</button>
        <a href="/dosen" class="btn btn-secondary">Kembali</a>
    </form>
</div>
@endsection
```

### 14. Form Edit Dosen
File `resources/views/dosen/edit.blade.php`:
```php
@extends('layout.app')

@section('content')
<div class="container">
    <h2>Edit Dosen</h2>
    
    <form action="/dosen/update" method="POST">
        @csrf
        @method('PUT')
        <input type="hidden" name="nidn" value="{{ $dosen['nidn'] }}">
        
        <div class="form-group">
            <label>NIDN:</label>
            <input type="text" name="nidn" class="form-control" value="{{ $dosen['nidn'] }}" readonly>
        </div>
        <div class="form-group">
            <label>Nama:</label>
            <input type="text" name="nama" class="form-control" value="{{ $dosen['nama'] }}" required>
        </div>
        <button type="submit" class="btn btn-primary">Update</button>
        <a href="/dosen" class="btn btn-secondary">Kembali</a>
    </form>
</div>
@endsection
```

## 🚀 Menjalankan Aplikasi

### 15. Start Development Server
```bash
php artisan serve
```

Aplikasi akan berjalan di `http://localhost:8000`

## 📌 Catatan Penting

- Pastikan API backend sudah berjalan di `http://localhost:8080`
- Gunakan `@csrf` token untuk semua form POST/PUT/DELETE
- Gunakan `@method('PUT')` dan `@method('DELETE')` untuk HTTP methods selain GET/POST
- Implementasikan error handling yang proper untuk response API
- Tambahkan validasi form sesuai kebutuhan

## 🔧 Troubleshooting

### Jika npm install gagal:
```bash
npm cache clean --force
rm -rf node_modules package-lock.json
npm install
```

### Jika ada error CORS:
Pastikan backend API sudah dikonfigurasi untuk menerima request dari frontend Laravel.
