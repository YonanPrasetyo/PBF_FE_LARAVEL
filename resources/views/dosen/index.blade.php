@extends('layout.app')
@section('title', 'Dashboard')
@section('content')
<div class="container mt-4">
    <!-- Header Section -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="mb-1">
                <i class="fas fa-chalkboard-teacher me-2 text-primary"></i>
                Data Dosen
            </h2>
            <p class="text-muted mb-0">Kelola data dosen dan informasi akademik</p>
        </div>
        <a href="/dosen/create" class="btn btn-primary btn-lg shadow-sm">
            <i class="fas fa-plus me-2"></i>Tambah Dosen
        </a>
    </div>

    <!-- Modern Table Card -->
    <div class="card border-0 shadow-sm">
        <div class="card-header bg-white py-3 border-bottom">
            <h5 class="mb-0">
                <i class="fas fa-table me-2 text-primary"></i>
                Daftar Dosen
            </h5>
        </div>

        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead class="bg-light">
                        <tr>
                            <th class="border-0 px-4 py-3">
                                <div class="d-flex align-items-center">
                                    <i class="fas fa-user me-2 text-muted"></i>
                                    Nama
                                </div>
                            </th>
                            <th class="border-0 px-4 py-3">
                                <div class="d-flex align-items-center">
                                    <i class="fas fa-id-badge me-2 text-muted"></i>
                                    NIDN
                                </div>
                            </th>
                            <th class="border-0 px-4 py-3">
                                <div class="d-flex align-items-center">
                                    <i class="fas fa-envelope me-2 text-muted"></i>
                                    Email
                                </div>
                            </th>
                            <th class="border-0 px-4 py-3">
                                <div class="d-flex align-items-center">
                                    <i class="fas fa-graduation-cap me-2 text-muted"></i>
                                    Prodi
                                </div>
                            </th>
                            <th class="border-0 px-4 py-3 text-center" width="150">
                                <i class="fas fa-cogs me-2 text-muted"></i>
                                Aksi
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($dosen as $d)
                        <tr>
                            <td class="px-4 py-3">
                                <div class="d-flex align-items-center">
                                    <div class="avatar-circle bg-primary bg-gradient rounded-circle d-flex align-items-center justify-content-center me-3">
                                        <span class="text-white fw-bold">{{ strtoupper(substr($d['nama'], 0, 2)) }}</span>
                                    </div>
                                    <div>
                                        <div class="fw-semibold text-dark">{{ $d['nama'] }}</div>
                                        <small class="text-muted">Dosen</small>
                                    </div>
                                </div>
                            </td>
                            <td class="px-4 py-3">
                                <span class="badge bg-light text-dark border px-3 py-2 rounded-pill">
                                    {{ $d['nidn'] }}
                                </span>
                            </td>
                            <td class="px-4 py-3">
                                <div class="d-flex align-items-center">
                                    <i class="fas fa-envelope text-muted me-2"></i>
                                    <span>{{ $d['email'] }}</span>
                                </div>
                            </td>
                            <td class="px-4 py-3">
                                <span class="badge bg-info bg-gradient text-white px-3 py-2 rounded-pill">
                                    {{ $d['prodi'] }}
                                </span>
                            </td>
                            <td class="px-4 py-3 text-center">
                                <div class="d-flex justify-content-center gap-2">
                                    <a href="/dosen/edit/{{ $d['nidn'] }}" class="btn btn-warning btn-sm rounded-pill">
                                        <i class="fas fa-edit me-1"></i>Edit
                                    </a>
                                    <form action="/dosen/delete/{{ $d['nidn'] }}" method="POST" style="display:inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-danger btn-sm rounded-pill" onclick="return confirm('Yakin ingin menghapus data dosen {{ $d['nama'] }}?')">
                                            <i class="fas fa-trash me-1"></i>Hapus
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<style>
.avatar-circle {
    width: 45px;
    height: 45px;
    font-size: 16px;
}

.table-hover tbody tr:hover {
    background-color: rgba(0, 123, 255, 0.05);
    transform: scale(1.002);
    transition: all 0.2s ease-in-out;
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

.badge {
    font-weight: 500;
    font-size: 0.85em;
}

.btn-sm {
    padding: 0.4rem 0.8rem;
    font-size: 0.85rem;
}
</style>
@endsection
