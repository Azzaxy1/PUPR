<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Final {{ $report->number_registration }}</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; color: #333; margin: 0; padding: 20px; }
        .header { text-align: center; margin-bottom: 30px; }
        .header h1 { font-size: 24px; margin: 0; }
        .header p { margin: 5px 0; font-size: 14px; }
        .section { margin-bottom: 20px; }
        .section h2 { font-size: 18px; margin-bottom: 10px; border-bottom: 1px solid #ccc; padding-bottom: 5px; }
        .section p, .section ul { font-size: 14px; margin: 0; }
        ul { padding-left: 20px; }
        ul li { margin-bottom: 5px; }
        .footer { text-align: right; font-size: 12px; margin-top: 40px; }
    </style>
</head>
<body>
    <div class="header">
        <h1>Laporan Final Pengaduan</h1>
        <p>No. Registrasi: <strong>{{ $report->number_registration }}</strong></p>
        <p>Tanggal Selesai: <strong>{{ optional($report->transactions->where('status_active',1)->last()->approve_dates)->format('d/m/Y H:i') }}</strong></p>
    </div>

    <div class="section">
        <h2>Informasi Pemohon</h2>
        <p><strong>Nama:</strong> {{ optional($report->user)->name }}</p>
        <p><strong>Email:</strong> {{ optional($report->user)->email }}</p>
    </div>

    <div class="section">
        <h2>Isi Laporan</h2>
        <p>{{ $report->report }}</p>
    </div>

    <div class="section">
        <h2>Dokumen Output</h2>
        @if($report->documentOutputs->isEmpty())
            <p>Tidak ada dokumen output.</p>
        @else
            <ul>
                @foreach($report->documentOutputs as $doc)
                    <li>{{ basename($doc->filename) }}</li>
                @endforeach
            </ul>
        @endif
    </div>

    <div class="footer">
        <p>Dicetak pada {{ now()->format('d/m/Y H:i') }}</p>
    </div>
</body>
</html>
