<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Laporan Absensi</title>
    <style>
        body { font-family: Arial, sans-serif; }
        .header { text-align: center; margin-bottom: 20px; }
        .table { width: 100%; border-collapse: collapse; }
        .table th, .table td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        .table th { background-color: #f2f2f2; }
        .badge { padding: 2px 6px; border-radius: 10px; font-size: 12px; }
        .badge-hadir { background-color: #d1fae5; color: #065f46; }
        .badge-pulang_cepat { background-color: #fef3c7; color: #92400e; }
        .badge-izin { background-color: #dbeafe; color: #1e40af; }
        .badge-sakit { background-color: #fee2e2; color: #991b1b; }
    </style>
</head>
<body>
    <div class="header">
        <h1>Laporan Absensi</h1>
        <p>Periode: {{ $period === 'daily' ? 'Harian' : 'Bulanan' }} - {{ $date }}</p>
    </div>

    <table class="table">
        <thead>
            <tr>
                <th>Nama User</th>
                <th>Tanggal</th>
                <th>Waktu Masuk</th>
                <th>Waktu Pulang</th>
                <th>Alasan Pulang Cepat</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach($attendances as $attendance)
            <tr>
                <td>{{ $attendance->user->name }}</td>
                <td>{{ $attendance->tanggal->format('d/m/Y') }}</td>
                <td>{{ $attendance->jam_masuk ?? '-' }}</td>
                <td>{{ $attendance->jam_pulang ?? '-' }}</td>
                <td>{{ $attendance->alasan ?? '-' }}</td>
                <td>
                    <span class="badge badge-{{ $attendance->status }}">
                        {{ ucfirst(str_replace('_', ' ', $attendance->status)) }}
                    </span>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div style="margin-top: 20px; text-align: right;">
        <p>Dicetak pada: {{ now()->format('d/m/Y H:i:s') }}</p>
    </div>
</body>
</html>