<!DOCTYPE html>
<html>
<head>
    <title>Laporan Jadwal Guru</title>
    <style>
        body { font-family: sans-serif; margin: 0; padding: 0; }
        table { width: 100%; border-collapse: collapse; margin-top: 15px; }
        table, th, td { border: 1px solid black; }
        th, td { padding: 6px; text-align: center; font-size: 12px; }
        th { background-color: #f2f2f2; }
        h4 { text-align: center; margin: 5px 0; font-weight: bold; }
        .kop-surat { text-align: center; margin-bottom: 5px; }
        .kop-surat h5 { margin: 0; font-weight: bold; font-size: 14px; }
        .kop-surat h6 { margin: 2px 0; font-weight: normal; font-size: 12px; }
        .kop-surat hr { border: 2px solid black; margin-top: 5px; }
        p.keterangan { text-align: center; font-size: 15px; margin: 10px 0; }
        .tanggal-cetak { text-align: right; font-size: 12px; margin-top: 10px; }
    </style>
</head>
<body>
    
    <!-- Kop Surat -->
    <div class="kop-surat">
        <h4>LAPORAN JADWAL GURU</h4>
        <h5>MI AL-Ihsan Tebel</h5>
        <h6>
            MIS AL-IHSAN beralamat di JL RA MUSTIKA TEBEL TIMUR Rt 05 Rw 06 Tebel<br>
            Kec. Gedangan, Kab. Sidoarjo, Jawa Timur.
        </h6>
        <br>
        <hr> <!-- Garis tebal di bawah alamat -->
    </div>
    <br>
    <!-- Keterangan -->
    <p class="keterangan">Berikut adalah daftar jadwal guru untuk periode yang tersedia di sistem.</p>

    <!-- Tabel Jadwal -->
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Hari</th>
                <th>Jam</th>
                <th>Tanggal</th>
                <th>Status Absen</th>
            </tr>
        </thead>
        <tbody>
            @foreach($jadwal as $key => $item)
            <tr>
                <td>{{ $key + 1 }}</td>
                <td>{{ $item->hari }}</td>
                <td>{{ $item->jam_mulai }} - {{ $item->jam_selesai }}</td>
                <td>{{ \Carbon\Carbon::parse($item->tanggal)->translatedFormat('d F Y') }}</td>
                <td>{{ $item->status_absen }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
    <br>
    <!-- Tanggal Cetak di Bawah Tabel -->
    <div class="tanggal-cetak">
        Sidoarjo, {{ \Carbon\Carbon::now()->translatedFormat('d F Y') }}
    </div>

</body>
</html>
