@extends('layout.app')
@section('title', 'Dashboard')
@section('content')
<div class="container mt-5">
    <!-- Header Section -->
    <div class="d-flex align-items-center mb-4">
        <div class="bg-primary bg-gradient rounded-circle p-3 me-3">
            <i class="fas fa-user-plus text-white"></i>
        </div>
        <div>
            <h2 class="mb-1">Tambah Data Dosen</h2>
            <p class="text-muted mb-0">Lengkapi form untuk menambahkan data dosen baru</p>
        </div>
    </div>

    <!-- Form Card -->
    <div class="card border-0 shadow-sm">
        <div class="card-header bg-white py-3 border-bottom">
            <h5 class="mb-0">
                <i class="fas fa-edit me-2 text-primary"></i>
                Form Data Dosen
            </h5>
        </div>

        <div class="card-body p-4">
            <form action="/dosen/store" method="POST">
                @csrf

                <div class="row">
                    <div class="col-lg-6">
                        <div class="mb-4">
                            <label for="nama" class="form-label fw-semibold">
                                <i class="fas fa-user me-2 text-primary"></i>
                                Nama Lengkap
                            </label>
                            <input type="text" class="form-control form-control-lg" name="nama" id="nama" placeholder="Masukkan nama lengkap dosen" required>
                        </div>
                    </div>

                    <div class="col-lg-6">
                        <div class="mb-4">
                            <label for="nidn" class="form-label fw-semibold">
                                <i class="fas fa-id-badge me-2 text-primary"></i>
                                NIDN
                            </label>
                            <input type="text" class="form-control form-control-lg" name="nidn" id="nidn" placeholder="Masukkan NIDN" required>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-lg-6">
                        <div class="mb-4">
                            <label for="email" class="form-label fw-semibold">
                                <i class="fas fa-envelope me-2 text-primary"></i>
                                Email
                            </label>
                            <input type="email" class="form-control form-control-lg" name="email" id="email" placeholder="Masukkan alamat email" required>
                        </div>
                    </div>

                    <div class="col-lg-6">
                        <div class="mb-4">
                            <label for="prodi" class="form-label fw-semibold">
                                <i class="fas fa-graduation-cap me-2 text-primary"></i>
                                Program Studi
                            </label>
                            <input type="text" class="form-control form-control-lg" name="prodi" id="prodi" placeholder="Masukkan program studi" required>
                        </div>
                    </div>
                </div>

                <hr class="my-4">

                <div class="d-flex gap-3 justify-content-end">
                    <a href="/dosen" class="btn btn-secondary btn-lg px-4">
                        <i class="fas fa-arrow-left me-2"></i>
                        Kembali
                    </a>
                    <button type="submit" class="btn btn-success btn-lg px-4">
                        <i class="fas fa-save me-2"></i>
                        Simpan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<style>
.form-control:focus {
    border-color: #0d6efd;
    box-shadow: 0 0 0 0.2rem rgba(13, 110, 253, 0.15);
    transform: translateY(-1px);
    transition: all 0.3s ease;
}

.form-control {
    transition: all 0.3s ease;
    border: 2px solid #e9ecef;
}

.form-control:hover {
    border-color: #ced4da;
}

.btn {
    transition: all 0.3s ease;
}

.btn:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 8px rgba(0,0,0,0.1);
}

.card {
    transition: box-shadow 0.3s ease;
}

.form-label {
    color: #495057;
    margin-bottom: 0.75rem;
}

.bg-gradient {
    background: linear-gradient(135deg, var(--bs-primary), #0056b3);
}
</style>
@endsection
