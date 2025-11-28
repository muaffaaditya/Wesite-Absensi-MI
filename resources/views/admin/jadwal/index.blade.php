@extends('layouts.admin')

@section('title', 'Kelola Jadwal | Dashboard Admin')

@section('content')
<div class="container py-4">

    {{-- Breadcrumb --}}
    <nav aria-label="breadcrumb" class="mb-3">
        <ol class="breadcrumb bg-light p-3 rounded">
            <li class="breadcrumb-item">
                <a href="{{ route('admin.dashboard') }}" class="text-decoration-none text-success">
                    <i class="fas fa-home"></i> Dashboard
                </a>
            </li>
            <li class="breadcrumb-item active" aria-current="page">Kelola Jadwal</li>
        </ol>
    </nav>

    {{-- Judul & Tombol --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="fw-bold text-dark">
            <i class="fas fa-calendar-alt me-2 text-dark"></i>Kelola Jadwal Guru
        </h4>
        <div class="d-flex gap-2 flex-wrap">
            {{-- Tambah Jadwal --}}
            <button class="btn btn-success shadow-sm" data-bs-toggle="modal" data-bs-target="#modalTambahJadwal">
                <i class="fas fa-plus-circle me-1"></i>Tambah Jadwal
            </button>
            {{-- Cetak PDF --}}
            <a href="{{ route('admin.jadwal.cetak.pdf') }}" target="_blank" class="btn btn-danger shadow-sm">
                <i class="fas fa-file-pdf me-1"></i>Cetak PDF
            </a>
            {{-- Cetak Excel --}}
            <a href="{{ route('admin.jadwal.cetak.excel') }}" class="btn btn-primary shadow-sm">
                <i class="fas fa-file-excel me-1"></i>Cetak Excel
            </a>
        </div>
    </div>

    {{-- Filter Tanggal --}}
    <form method="GET" action="{{ route('admin.jadwal.index') }}" class="row g-3 mb-3">
        <div class="col-md-4">
            <label class="form-label fw-semibold">Tanggal Awal</label>
            <input type="date" name="tanggal_awal" value="{{ request('tanggal_awal') }}" class="form-control shadow-sm">
        </div>
        <div class="col-md-4">
            <label class="form-label fw-semibold">Tanggal Akhir</label>
            <input type="date" name="tanggal_akhir" value="{{ request('tanggal_akhir') }}" class="form-control shadow-sm">
        </div>
        <div class="col-md-4 d-flex align-items-end gap-2">
            <button type="submit" class="btn btn-primary shadow-sm w-50">
                <i class="fas fa-filter me-1"></i>Filter
            </button>
            <a href="{{ route('admin.jadwal.index') }}" class="btn btn-outline-danger shadow-sm w-50">
                <i class="fas fa-sync-alt me-1"></i>Reset
            </a>
        </div>
    </form>

    {{-- Tabel Jadwal --}}
    <div class="card shadow-sm border-0">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>No</th>
                            <th>Hari</th>
                            <th>Jam</th>
                            <th>Tanggal</th>
                            <th>Status Absen</th>
                            <th class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($jadwal as $key => $item)
                        <tr>
                            <td>{{ $key + 1 }}</td>
                            <td>{{ $item->hari }}</td>
                            <td>{{ $item->jam_mulai }} - {{ $item->jam_selesai }}</td>
                            <td>{{ \Carbon\Carbon::parse($item->tanggal)->translatedFormat('d F Y') }}</td>
                            <td>
                                <span class="badge {{ $item->status_absen == 'Dibuka' ? 'bg-success' : 'bg-secondary' }}">
                                    {{ $item->status_absen }}
                                </span>
                            </td>
                            <td class="text-center">
                                <div class="d-flex justify-content-center gap-1 flex-wrap">
                                    {{-- Buka Absen --}}
                                    <form action="{{ route('admin.jadwal.buka', $item->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        <button class="btn btn-sm btn-success" title="Buka Absen">
                                            <i class="fas fa-door-open"></i>
                                        </button>
                                    </form>
                                    {{-- Tutup Absen --}}
                                    <form action="{{ route('admin.jadwal.tutup', $item->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        <button class="btn btn-sm btn-warning" title="Tutup Absen">
                                            <i class="fas fa-door-closed"></i>
                                        </button>
                                    </form>
                                    {{-- Edit --}}
                                    <button class="btn btn-sm btn-primary" title="Edit" data-bs-toggle="modal" data-bs-target="#modalEdit{{ $item->id }}">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    {{-- Hapus --}}
                                    <form action="{{ route('admin.jadwal.destroy', $item->id) }}" method="POST" class="d-inline form-delete">
                                        @csrf
                                        @method('DELETE')
                                        <button type="button" class="btn btn-sm btn-danger btn-hapus" title="Hapus">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>

                        {{-- Modal Edit Jadwal --}}
                        <div class="modal fade" id="modalEdit{{ $item->id }}" tabindex="-1" data-bs-backdrop="static">
                            <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content">
                                    <form action="{{ route('admin.jadwal.update', $item->id) }}" method="POST">
                                        @csrf
                                        @method('PUT')
                                        <div class="modal-header">
                                            <h5 class="modal-title">Edit Jadwal</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="mb-2">
                                                <label>Hari</label>
                                                <select name="hari" class="form-select" required>
                                                    @foreach(['Senin','Selasa','Rabu','Kamis','Jumat','Sabtu'] as $hari)
                                                        <option value="{{ $hari }}" {{ $item->hari == $hari ? 'selected' : '' }}>{{ $hari }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="mb-2">
                                                <label>Jam Mulai</label>
                                                <input type="time" name="jam_mulai" class="form-control" value="{{ $item->jam_mulai }}" required>
                                            </div>
                                            <div class="mb-2">
                                                <label>Jam Selesai</label>
                                                <input type="time" name="jam_selesai" class="form-control" value="{{ $item->jam_selesai }}" required>
                                            </div>
                                            <div class="mb-2">
                                                <label>Tanggal</label>
                                                <input type="date" name="tanggal" class="form-control" value="{{ $item->tanggal }}" required>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="submit" class="btn btn-primary">Simpan</button>
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center text-muted py-3">Data tidak ditemukan</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

{{-- Modal Tambah Jadwal --}}
<div class="modal fade" id="modalTambahJadwal" tabindex="-1" data-bs-backdrop="static">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <form action="{{ route('admin.jadwal.store') }}" method="POST">@csrf
                <div class="modal-header">
                    <h5 class="modal-title">Tambah Jadwal Guru</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-2">
                        <label>Hari</label>
                        <select name="hari" class="form-select" required>
                            <option value="">Pilih Hari</option>
                            @foreach(['Senin','Selasa','Rabu','Kamis','Jumat','Sabtu'] as $hari)
                                <option value="{{ $hari }}">{{ $hari }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-2">
                        <label>Jam Mulai</label>
                        <input type="time" name="jam_mulai" class="form-control" required>
                    </div>
                    <div class="mb-2">
                        <label>Jam Selesai</label>
                        <input type="time" name="jam_selesai" class="form-control" required>
                    </div>
                    <div class="mb-2">
                        <label>Tanggal</label>
                        <input type="date" name="tanggal" class="form-control" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-success">Simpan</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- SweetAlert2 --}}
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
document.addEventListener('DOMContentLoaded', function () {
    @if(session('success'))
        Swal.fire({
            icon: 'success',
            title: 'Berhasil!',
            text: '{{ session("success") }}',
            timer: 2000,
            showConfirmButton: false
        });
    @endif

    document.querySelectorAll('.btn-hapus').forEach(btn => {
        btn.addEventListener('click', function(e) {
            e.preventDefault();
            const form = this.closest('form');
            Swal.fire({
                title: 'Yakin ingin menghapus?',
                text: "Data jadwal ini akan dihapus secara permanen!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#e74c3c',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Ya, Hapus',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) form.submit();
            });
        });
    });

    var modals = document.querySelectorAll('.modal');
    modals.forEach(modal => {
        modal.addEventListener('show.bs.modal', () => {
            document.body.style.overflow = 'hidden';
            document.body.style.paddingRight = '0px';
        });
        modal.addEventListener('hidden.bs.modal', () => {
            document.body.style.overflow = '';
            document.body.style.paddingRight = '';
        });
    });
});
</script>

<style>
.btn-group .btn { margin-right: 0.25rem; }
.table-responsive { overflow-x: auto; }
table { white-space: nowrap; }
</style>
@endsection
