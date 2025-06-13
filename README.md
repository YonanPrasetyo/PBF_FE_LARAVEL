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

## 🚀 Menjalankan Aplikasi

### 10. Start Development Server
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
