<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Pengaduan {{ $report->number_registration }}</title>
    <style>
        body { font-family: sans-serif; }
        .header { text-align: center; margin-bottom: 20px; }
        .section { margin-bottom: 15px; }
        .section h4 { margin-bottom: 5px; }
        .transactions, .documents { width: 100%; border-collapse: collapse; }
        .transactions th, .transactions td,
        .documents th, .documents td {
            border: 1px solid #000; padding: 5px; font-size: 12px;
        }
    </style>
</head>
<body>
    <div class="header">
        <h2>Pengaduan {{ $report->number_registration }}</h2>
    </div>

    <div class="section">
        <h4>Isi Pengaduan:</h4>
        <p>{{ $report->report }}</p>
    </div>

    <div class="section">
        <h4>Riwayat Status:</h4>
        <table class="transactions">
            <thead>
                <tr>
                    <th>Status</th>
                    <th>Tanggal</th>
                    <th>Petugas</th>
                </tr>
            </thead>
            <tbody>
                @foreach($report->transactions as $tx)
                <tr>
                    <td>{{ $tx->status->title }}</td>
                    <td>{{ $tx->approve_dates ? $tx->approve_dates->format('d/m/Y H:i') : '-' }}</td>
                    <td>{{ optional($tx->officer)->name }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="section">
        <h4>Dokumen Pendukung:</h4>
        @if($report->documents->isEmpty())
            <p>Tidak ada dokumen pendukung.</p>
        @else
            <table class="documents">
                <thead>
                    <tr><th>Nama File</th></tr>
                </thead>
                <tbody>
                    @foreach($report->documents as $doc)
                    <tr>
                        <td>{{ basename($doc->filename) }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
    </div>
</body>
</html>