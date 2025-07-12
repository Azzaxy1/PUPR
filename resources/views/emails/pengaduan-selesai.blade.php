<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Pengaduan Selesai</title>
    <style>
        .container {
            max-width: 600px;
            margin: 0 auto;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            line-height: 1.6;
        }

        .header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 30px 20px;
            text-align: center;
            border-radius: 10px 10px 0 0;
        }

        .header h1 {
            margin: 0;
            font-size: 24px;
            font-weight: bold;
        }

        .content {
            padding: 30px 20px;
            background-color: #f8f9fa;
        }

        .footer {
            background-color: #6b7280;
            color: white;
            padding: 20px;
            text-align: center;
            border-radius: 0 0 10px 10px;
        }

        .status {
            background-color: #10b981;
            color: white;
            padding: 8px 15px;
            border-radius: 20px;
            font-weight: bold;
            display: inline-block;
        }

        .attachment-box {
            background: linear-gradient(135deg, #e3f2fd 0%, #f0f8ff 100%);
            padding: 20px;
            border-radius: 10px;
            margin: 25px 0;
            border-left: 5px solid #2196f3;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }

        .attachment-box h4 {
            margin-top: 0;
            color: #1976d2;
            font-size: 18px;
        }

        .attachment-list {
            background: white;
            padding: 15px;
            border-radius: 8px;
            margin: 15px 0;
        }

        .attachment-item {
            padding: 10px;
            border-bottom: 1px solid #e0e0e0;
            display: flex;
            align-items: center;
        }

        .attachment-item:last-child {
            border-bottom: none;
        }

        .attachment-icon {
            width: 30px;
            height: 30px;
            background: #4CAF50;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 10px;
            color: white;
            font-weight: bold;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
            background: white;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }

        td {
            padding: 15px;
            border-bottom: 1px solid #e0e0e0;
        }

        td:first-child {
            background-color: #f8f9fa;
            font-weight: bold;
            color: #495057;
        }

        .process-steps {
            background: white;
            padding: 20px;
            border-radius: 10px;
            margin: 20px 0;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }

        .process-steps ol {
            margin: 0;
            padding-left: 20px;
        }

        .process-steps li {
            margin: 10px 0;
            font-size: 16px;
        }

        .highlight-box {
            background: linear-gradient(135deg, #fff3e0 0%, #ffe0b2 100%);
            padding: 20px;
            border-radius: 10px;
            margin: 20px 0;
            border-left: 5px solid #ff9800;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="header">
            <h1>🏛️ PUPR Pengaduan Sistem</h1>
            <p style="margin: 10px 0 0 0; opacity: 0.9;">Kementerian Pekerjaan Umum dan Perumahan Rakyat</p>
        </div>

        <div class="content">
            <h2 style="color: #2c3e50; margin-bottom: 20px;">✅ Pengaduan Anda Telah Selesai</h2>

            <p>Yth. <strong>{{ $pemohon->name }}</strong>,</p>

            <p>Dengan bangga kami informasikan bahwa pengaduan Anda telah <strong>selesai diproses</strong> oleh tim
                PUPR:</p>

            <table>
                <tr>
                    <td style="width: 35%;">📋 No. Registrasi</td>
                    <td><strong>{{ $pengaduan->number_registration }}</strong></td>
                </tr>
                <tr>
                    <td>📝 Isi Laporan</td>
                    <td>{{ Str::limit($pengaduan->report, 200) }}</td>
                </tr>
                <tr>
                    <td>🎯 Status</td>
                    <td><span class="status">SELESAI</span></td>
                </tr>
                <tr>
                    <td>📅 Tanggal Selesai</td>
                    <td><strong>{{ now()->locale('id')->translatedFormat('l, d F Y - H:i') }} WIB</strong></td>
                </tr>
            </table>

            @if ($pengaduan->documentOutputs->count() > 0)
                <div class="attachment-box">
                    <h4>📎 Dokumen Resmi Terlampir</h4>
                    <p>Email ini dilengkapi dengan <strong>{{ $pengaduan->documentOutputs->count() }} dokumen
                            resmi</strong> sebagai jawaban atas pengaduan Anda:</p>

                    <div class="attachment-list">
                        @foreach ($pengaduan->documentOutputs as $index => $file)
                            <div class="attachment-item">
                                <div class="attachment-icon">{{ $index + 1 }}</div>
                                <div>
                                    <strong>Dokumen {{ $index + 1 }}</strong><br>
                                    <small style="color: #666;">{{ basename($file->filename) }}</small>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <div class="highlight-box">
                        <strong>💡 Cara Melihat Dokumen:</strong><br>
                        Dokumen telah dilampirkan pada email ini. Silakan scroll ke bawah atau cek bagian "Attachments"
                        di email client Anda untuk mengunduh dan melihat dokumen lengkap.
                    </div>
                </div>
            @endif

            <div class="process-steps">
                <h4 style="color: #2c3e50; margin-top: 0;">🔄 Alur Proses yang Telah Dilalui:</h4>
                <ol>
                    <li>✅ <strong>Diterima</strong> oleh Petugas Layanan</li>
                    <li>✅ <strong>Diverifikasi</strong> oleh Ketua UKI</li>
                    <li>✅ <strong>Dianalisis</strong> oleh Bidang/Satker/SNVT</li>
                    <li>✅ <strong>Diselesaikan</strong> oleh Kepala BBWS</li>
                </ol>
            </div>

            <p
                style="margin-top: 30px; padding: 20px; background: linear-gradient(135deg, #e8f5e8 0%, #f0f8f0 100%); border-radius: 10px; border-left: 5px solid #4CAF50;">
                <strong>🙏 Terima kasih</strong> atas partisipasi dan kepercayaan Anda dalam sistem pengaduan PUPR.
                Kami berkomitmen untuk terus meningkatkan pelayanan demi kemajuan infrastruktur Indonesia.
            </p>
        </div>

        <div class="footer">
            <p style="margin: 0; font-weight: bold;">&copy; {{ date('Y') }} PUPR - Kementerian Pekerjaan Umum dan
                Perumahan Rakyat</p>
            <p style="font-size: 12px; margin: 10px 0 0 0; opacity: 0.8;">
                🤖 Email ini dikirim secara otomatis. Mohon tidak membalas email ini.<br>
                Untuk pertanyaan lebih lanjut, silakan hubungi layanan pengaduan PUPR.
            </p>
        </div>
    </div>
</body>

</html>
