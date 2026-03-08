<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Laporan Tiket IT Support</title>
    <style>
        body { font-family: sans-serif; font-size: 12px; }
        h2 { text-align: center; margin-bottom: 20px; }
        table { width: 100%; border-collapse: collapse; }
        th, td { border: 1px solid #333; padding: 6px; text-align: left; }
        th { background-color: #f2f2f2; }
    </style>
</head>
<body>
    <h2>Laporan Daftar Tiket IT Support</h2>
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>ID Tiket</th>
                <th>Tanggal</th>
                <th>Pelapor</th>
                <th>Unit</th>
                <th>Teknisi</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach($tickets as $index => $t)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $t->ticket_id }}</td>
                <td>{{ $t->waktu_laporan->format('d/m/Y H:i') }}</td>
                <td>{{ $t->nama_pelapor }}</td>
                <td>{{ $t->unit }}</td>
                <td>{{ $t->user ? $t->user->name : '-' }}</td>
                <td>{{ $t->status }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
