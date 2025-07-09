<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

class PengaduanSelesaiMail extends Mailable
{
    use Queueable, SerializesModels;

    public $pengaduan;
    public $pemohon;

    public function __construct($pengaduan, $pemohon)
    {
        $this->pengaduan = $pengaduan;
        $this->pemohon = $pemohon;
    }

    public function build()
    {
        $email = $this->subject('Pengaduan Anda Telah Selesai - ' . $this->pengaduan->number_registration)
            ->view('emails.pengaduan-selesai')
            ->with([
                'pengaduan' => $this->pengaduan,
                'pemohon' => $this->pemohon,
            ]);

        // 📎 ATTACH SEMUA FILE DARI t_report_document_output_tab
        foreach ($this->pengaduan->documentOutputs as $index => $file) {
            $storagePath = storage_path('app/public/' . $file->filename);

            if (file_exists($storagePath)) {
                $email->attach($storagePath, [
                    'as' => 'Dokumen_Resmi_' . ($index + 1) . '_' . basename($file->filename),
                    'mime' => $this->getMimeType($file->filename),
                ]);
                Log::info('File attached successfully: ' . basename($file->filename));
            } else {
                Log::error('File not found: ' . $storagePath);
            }
        }

        return $email;
    }

    /**
     * Deteksi MIME type berdasarkan ekstensi file
     */
    private function getMimeType($filename)
    {
        $extension = strtolower(pathinfo($filename, PATHINFO_EXTENSION));

        return match ($extension) {
            'pdf' => 'application/pdf',
            'jpg', 'jpeg' => 'image/jpeg',
            'png' => 'image/png',
            'doc' => 'application/msword',
            'docx' => 'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
            'xls' => 'application/vnd.ms-excel',
            'xlsx' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
            default => 'application/octet-stream',
        };
    }
}
