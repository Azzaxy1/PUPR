<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Pengaduan Selesai</title>
    <style>
        .container {
            max-width: 600px;
            margin: 0 auto;
            font-family: Arial, sans-serif;
        }

        .header {
            background-color: #2563eb;
            color: white;
            padding: 20px;
            text-align: center;
        }

        .content {
            padding: 20px;
            background-color: #f8f9fa;
        }

        .footer {
            background-color: #6b7280;
            color: white;
            padding: 15px;
            text-align: center;
        }

        .btn {
            background-color: #10b981;
            color: white;
            padding: 10px 20px;
            text-decoration: none;
            border-radius: 5px;
            display: inline-block;
        }

        .status {
            background-color: #10b981;
            color: white;
            padding: 5px 10px;
            border-radius: 3px;
        }

        .attachment-box {
            background-color: #e3f2fd;
            padding: 15px;
            border-radius: 8px;
            margin: 20px 0;
            border-left: 4px solid #2196f3;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
        }

        td {
            padding: 8px;
            border: 1px solid #ddd;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="header">
            <h1>PUPR Pengaduan Sistem</h1>
        </div>

        <div class="content">
            <h2>Pengaduan Anda Telah Selesai</h2>

            <p>Yth. {{ $pemohon->name }},</p>

            <p>Pengaduan Anda dengan detail berikut telah selesai diproses:</p>

            <table>
                <tr>
                    <td style="width: 30%;"><strong>No. Registrasi:</strong></td>
                    <td>{{ $pengaduan->number_registration }}</td>
                </tr>
                <tr>
                    <td><strong>Isi Laporan:</strong></td>
                    <td>{{ Str::limit($pengaduan->report, 150) }}</td>
                </tr>
                <tr>
                    <td><strong>Status:</strong></td>
                    <td><span class="status">SELESAI</span></td>
                </tr>
                <tr>
                    <td><strong>Tanggal Selesai:</strong></td>
                    <td>{{ now()->format('d/m/Y H:i') }}</td>
                </tr>
            </table>

            @if ($pengaduan->documentOutputs->count() > 0)
                <!-- 📎 Info tentang file attachment -->
                <div class="attachment-box">
                    <h4 style="margin-top: 0; color: #1976d2;">📎 Dokumen Terlampir</h4>
                    <p>Email ini dilengkapi dengan {{ $pengaduan->documentOutputs->count() }} dokumen resmi:</p>
                    <ul>
                        @foreach ($pengaduan->documentOutputs as $index => $file)
                            <li><strong>Dokumen {{ $index + 1 }}</strong> - {{ basename($file->filename) }}</li>
                        @endforeach
                    </ul>
                    <p><em>Silakan periksa lampiran email ini untuk melihat dokumen lengkap.</em></p>
                </div>
            @endif

            <p>Pengaduan Anda telah diproses melalui seluruh tahapan:</p>
            <ol>
                <li>✅ Diterima oleh Petugas Layanan</li>
                <li>✅ Diverifikasi oleh Ketua UKI</li>
                <li>✅ Dianalisis oleh Bidang/Satker/SNVT</li>
                <li>✅ Diselesaikan oleh Kepala BBWS</li>
            </ol>

            <p>Terima kasih atas partisipasi Anda dalam sistem pengaduan PUPR.</p>
        </div>

        <div class="footer">
            <p>&copy; {{ date('Y') }} PUPR - Kementerian Pekerjaan Umum dan Perumahan Rakyat</p>
            <p style="font-size: 12px; margin-top: 10px;">
                Email ini dikirim secara otomatis. Mohon tidak membalas email ini.
            </p>
        </div>
    </div>
</body>

</html>
