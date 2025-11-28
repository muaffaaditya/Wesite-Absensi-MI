@extends('layouts.admin')

@section('title', 'Dashboard Admin | MI-Al Ihsan')

@section('content')
<div class="container">
    <br>
    {{-- Statistik Utama --}}
    <div class="row g-4 mb-5">
        <div class="col-md-3">
            <div class="card border-0 shadow-sm rounded-4 p-4 text-center bg-gradient bg-light">
                <i class="fas fa-user-shield fa-2x text-primary mb-2"></i>
                <h6 class="text-muted mb-1">Jumlah Admin</h6>
                <h3 class="fw-bold text-dark">{{ $total_admin ?? 0 }}</h3>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card border-0 shadow-sm rounded-4 p-4 text-center bg-gradient bg-light">
                <i class="fas fa-chalkboard-teacher fa-2x text-success mb-2"></i>
                <h6 class="text-muted mb-1">Jumlah Guru</h6>
                <h3 class="fw-bold text-dark">{{ $total_guru ?? 0 }}</h3>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card border-0 shadow-sm rounded-4 p-4 text-center bg-gradient bg-light">
                <i class="fas fa-user-tie fa-2x text-warning mb-2"></i>
                <h6 class="text-muted mb-1">Jumlah Kepala</h6>
                <h3 class="fw-bold text-dark">{{ $total_kepala ?? 0 }}</h3>
            </div>
        </div>

        <div class="col-md-3">
            <a href="{{ route('admin.absen.index') }}" class="text-decoration-none">
                <div class="card border-0 shadow-sm rounded-4 p-4 text-center bg-gradient bg-light">
                    <i class="fas fa-calendar-check fa-2x mb-2"></i>
                    <h6 class="mb-1">Absen</h6>
                    <h3 class="fw-bold">Masuk</h3>
                </div>
            </a>
        </div>
    </div>

    {{-- Row: Grafik & Tabel --}}
    <div class="row g-4">
        {{-- Grafik Absen --}}
        <div class="col-lg-4">
            <div class="card shadow-sm rounded-4 p-3 h-100">
                <h6 class="fw-bold mb-3">Grafik Absen Hari Ini</h6>
                <canvas id="grafikAbsen" height="150"></canvas>
            </div>
        </div>

        {{-- Tabel Pengumuman & Jadwal Dibuka --}}
        <div class="col-lg-8">
            {{-- Pengumuman Terbaru --}}
            <div class="card shadow-sm rounded-4 p-3 mb-4">
                <h6 class="fw-bold mb-3">Pengumuman Terbaru</h6>
                <ul class="list-group list-group-flush">
                    @forelse($pengumuman_terbaru as $p)
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            {{ $p->judul }}
                            <span class="text-muted small">{{ \Carbon\Carbon::parse($p->created_at)->format('d M Y') }}</span>
                        </li>
                    @empty
                        <li class="list-group-item text-center text-muted">Belum ada pengumuman.</li>
                    @endforelse
                </ul>
            </div>

            {{-- Jadwal Dibuka --}}
            <div class="card shadow-sm rounded-4 p-3">
                <h6 class="fw-bold mb-3">Jadwal Dibuka</h6>
                <ul class="list-group list-group-flush">
                    @forelse($jadwal_dibuka as $j)
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            {{ $j->nama_guru }}
                            <span class="text-muted small">{{ \Carbon\Carbon::parse($j->tanggal)->format('d M Y') }}</span>
                        </li>
                    @empty
                        <li class="list-group-item text-center text-muted">Belum ada jadwal dibuka.</li>
                    @endforelse
                </ul>
            </div>
        </div>
    </div>
</div>

{{-- Styling dashboard --}}
<style>
    .card { transition: none !important; }
    .card-header h6 { font-size: 1rem; }
</style>

{{-- Chart.js --}}
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const ctx = document.getElementById('grafikAbsen').getContext('2d');

    // Data absensi
    const sudahAbsen = {{ $sudah_absen ?? 0 }};
    const belumAbsen = {{ $belum_absen ?? 0 }};

    // Jika total 0, beri default 1 supaya chart tampil
    const dataAbsen = (sudahAbsen + belumAbsen === 0) ? [1, 0] : [sudahAbsen, belumAbsen];

    new Chart(ctx, {
        type: 'bar',
        data: {
            labels: ['Sudah Absen', 'Belum Absen'],
            datasets: [{
                label: 'Jumlah',
                data: dataAbsen,
                backgroundColor: ['#28a745', '#dc3545'],
                borderRadius: 5
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: { display: false },
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            return context.dataset.label + ': ' + context.raw;
                        }
                    }
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: { precision:0 }
                }
            }
        }
    });
</script>
@endsection
