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


# Laravel PDF Export Guide

Panduan lengkap untuk export PDF di Laravel menggunakan package **barryvdh/laravel-dompdf**.

## 📦 Instalasi Package

### 1. Install via Composer
```bash
composer require barryvdh/laravel-dompdf
```

### 2. Publish Config (Opsional)
```bash
php artisan vendor:publish --provider="Barryvdh\DomPDF\ServiceProvider"
```

## ⚙️ Konfigurasi

### 3. Auto-Discovery
Laravel akan secara otomatis register service provider. Jika tidak, tambahkan di `config/app.php`:

```php
'providers' => [
    // ...
    Barryvdh\DomPDF\ServiceProvider::class,
],

'aliases' => [
    // ...
    'PDF' => Barryvdh\DomPDF\Facade\Pdf::class,
],
```

## 🎯 Implementasi Dasar

### 4. Buat Controller Method
```php
<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Http;

class MahasiswaController extends Controller
{
    // Method untuk export PDF
    public function exportPdf()
    {
        // Ambil data dari API
        $response = Http::get(config('services.api.api_base_url').'/mahasiswa');
        $mahasiswa = $response->json();
        
        // Load view dan generate PDF
        $pdf = Pdf::loadView('mahasiswa.pdf', compact('mahasiswa'));
        
        // Download PDF
        return $pdf->download('data-mahasiswa.pdf');
    }
    
    // Method untuk preview PDF di browser
    public function previewPdf()
    {
        $response = Http::get(config('services.api.api_base_url').'/mahasiswa');
        $mahasiswa = $response->json();
        
        $pdf = Pdf::loadView('mahasiswa.pdf', compact('mahasiswa'));
        
        // Stream PDF ke browser
        return $pdf->stream('data-mahasiswa.pdf');
    }
}
```

### 5. Buat Template PDF
Buat file `resources/views/mahasiswa/pdf.blade.php`:

```html
<!DOCTYPE html>
<html>
<head>
    <title>Data Mahasiswa</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }
        .header {
            text-align: center;
            margin-bottom: 30px;
        }
        .header h1 {
            color: #333;
            border-bottom: 2px solid #333;
            padding-bottom: 10px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
            font-weight: bold;
        }
        tr:nth-child(even) {
            background-color: #f9f9f9;
        }
        .footer {
            margin-top: 30px;
            text-align: right;
            font-size: 12px;
            color: #666;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>DATA MAHASISWA</h1>
        <p>Dicetak pada: {{ date('d/m/Y H:i:s') }}</p>
    </div>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>NIM</th>
                <th>Nama</th>
                <th>Email</th>
                <th>Program Studi</th>
            </tr>
        </thead>
        <tbody>
            @foreach($mahasiswa as $index => $mhs)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $mhs['nim'] ?? '-' }}</td>
                <td>{{ $mhs['nama'] ?? '-' }}</td>
                <td>{{ $mhs['email'] ?? '-' }}</td>
                <td>{{ $mhs['prodi'] ?? '-' }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="footer">
        <p>Total: {{ count($mahasiswa) }} mahasiswa</p>
    </div>
</body>
</html>
```

### 6. Tambahkan Routes
Di `routes/web.php`:

```php
// Export PDF routes
Route::get('/mahasiswa/export-pdf', [MahasiswaController::class, 'exportPdf']);
Route::get('/mahasiswa/preview-pdf', [MahasiswaController::class, 'previewPdf']);
```

### 7. Tambahkan Button di View
Di `resources/views/mahasiswa/index.blade.php`:

```html
@extends('layout.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h2>Data Mahasiswa</h2>
                <div>
                    <a href="/mahasiswa/preview-pdf" class="btn btn-info" target="_blank">
                        <i class="fas fa-eye"></i> Preview PDF
                    </a>
                    <a href="/mahasiswa/export-pdf" class="btn btn-danger">
                        <i class="fas fa-file-pdf"></i> Export PDF
                    </a>
                </div>
            </div>
            
            <!-- Tabel mahasiswa -->
            <table class="table table-striped">
                <!-- ... isi tabel ... -->
            </table>
        </div>
    </div>
</div>
@endsection
```

## 🎨 Kustomisasi Lanjutan

### 8. Konfigurasi PDF Options
```php
public function exportPdf()
{
    $response = Http::get(config('services.api.api_base_url').'/mahasiswa');
    $mahasiswa = $response->json();
    
    $pdf = Pdf::loadView('mahasiswa.pdf', compact('mahasiswa'))
        ->setPaper('a4', 'portrait')  // atau 'landscape'
        ->setOptions([
            'defaultFont' => 'sans-serif',
            'isHtml5ParserEnabled' => true,
            'isPhpEnabled' => true
        ]);
    
    return $pdf->download('data-mahasiswa.pdf');
}
```

### 9. Export dengan Filter/Parameter
```php
public function exportPdfByProdi(Request $request)
{
    $prodi = $request->get('prodi');
    
    $response = Http::get(config('services.api.api_base_url').'/mahasiswa', [
        'prodi' => $prodi
    ]);
    $mahasiswa = $response->json();
    
    $pdf = Pdf::loadView('mahasiswa.pdf', compact('mahasiswa', 'prodi'));
    
    return $pdf->download("mahasiswa-{$prodi}.pdf");
}
```

### 10. Template dengan Header/Footer
```html
<!DOCTYPE html>
<html>
<head>
    <title>Data Mahasiswa</title>
    <style>
        @page {
            margin: 100px 25px;
        }
        header {
            position: fixed;
            top: -60px;
            left: 0px;
            right: 0px;
            height: 50px;
            background-color: #f8f9fa;
            color: #333;
            text-align: center;
            line-height: 35px;
        }
        footer {
            position: fixed;
            bottom: -60px;
            left: 0px;
            right: 0px;
            height: 50px;
            background-color: #f8f9fa;
            color: #333;
            text-align: center;
            line-height: 35px;
        }
        /* CSS lainnya */
    </style>
</head>
<body>
    <header>
        <h3>UNIVERSITAS EXAMPLE</h3>
    </header>
    
    <footer>
        <p>Halaman <span class="pagenum"></span></p>
    </footer>
    
    <!-- Konten PDF -->
</body>
</html>
```

## 🔧 Tips & Troubleshooting

### 11. Mengatasi Error Memory
Di `config/dompdf.php`:
```php
'options' => [
    'chroot' => realpath(base_path()),
    'allowed_protocols' => [
        'file://' => ['rules' => []],
        'http://' => ['rules' => []],
        'https://' => ['rules' => []],
    ],
    'log_output_file' => null,
    'enable_font_subsetting' => false,
    'pdf_backend' => 'CPDF',
    'default_media_type' => 'screen',
    'default_paper_size' => 'a4',
    'default_paper_orientation' => 'portrait',
    'default_font' => 'serif',
    'dpi' => 96,
    'enable_php' => false,
    'enable_javascript' => true,
    'enable_remote' => true,
    'font_height_ratio' => 1.1,
    'enable_html5_parser' => true,
],
```

### 12. Include Image
```html
<!-- Menggunakan path absolute -->
<img src="{{ public_path('images/logo.png') }}" alt="Logo" width="100">

<!-- Atau base64 encode -->
<img src="data:image/png;base64,{{ base64_encode(file_get_contents(public_path('images/logo.png'))) }}" alt="Logo" width="100">
```

### 13. Custom Font
```php
// Di controller
$pdf = Pdf::loadView('mahasiswa.pdf', compact('mahasiswa'));
$pdf->getDomPDF()->getCanvas()->get_cpdf()->addInfo('Title', 'Data Mahasiswa');
```

## 🚀 Implementasi Lengkap untuk Dosen

### 14. Controller Dosen dengan PDF Export
```php
<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Barryvdh\DomPDF\Facade\Pdf;

class DosenController extends Controller
{
    // ... method lainnya ...
    
    public function exportPdf()
    {
        $response = Http::get(config('services.api.api_base_url').'/dosen');
        $dosen = $response->json();
        
        $pdf = Pdf::loadView('dosen.pdf', compact('dosen'))
            ->setPaper('a4', 'landscape'); // Landscape untuk data yang lebih lebar
        
        return $pdf->download('data-dosen-'.date('Y-m-d').'.pdf');
    }
    
    public function exportSinglePdf($nidn)
    {
        $response = Http::get(config('services.api.api_base_url').'/dosen/'.$nidn);
        $dosen = $response->json();
        
        $pdf = Pdf::loadView('dosen.single-pdf', compact('dosen'));
        
        return $pdf->download("dosen-{$nidn}.pdf");
    }
}
```

### 15. Routes untuk Dosen PDF
```php
Route::get('/dosen/export-pdf', [DosenController::class, 'exportPdf']);
Route::get('/dosen/export-pdf/{nidn}', [DosenController::class, 'exportSinglePdf']);
```

## 📝 Kesimpulan

Dengan mengikuti panduan ini, Anda dapat:

- ✅ Export data ke PDF dengan tampilan yang profesional
- ✅ Kustomisasi layout dan styling PDF
- ✅ Implementasi preview dan download PDF  
- ✅ Mengatasi masalah umum dalam generate PDF
- ✅ Export data individual atau bulk data

**Package barryvdh/laravel-dompdf** adalah solusi yang sangat baik untuk kebutuhan export PDF di Laravel karena mudah digunakan dan powerful! 🎯
