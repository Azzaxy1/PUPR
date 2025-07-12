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
        // Attach semua dokumen output
        if ($this->pengaduan->documentOutputs->count() > 0) {
            foreach ($this->pengaduan->documentOutputs as $document) {
                $filePath = storage_path('app/' . $document->filename);

                if (file_exists($filePath)) {
                    $email->attach($filePath, [
                        'as' => basename($document->filename),
                        'mime' => $this->getMimeType($filePath),
                    ]);
                }
            }
        }

        return $email;
    }

    /**
     * Deteksi MIME type berdasarkan ekstensi file
     */
    private function getMimeType($filePath)
    {
        $extension = strtolower(pathinfo($filePath, PATHINFO_EXTENSION));

        $mimeTypes = [
            'pdf' => 'application/pdf',
            'doc' => 'application/msword',
            'docx' => 'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
            'xls' => 'application/vnd.ms-excel',
            'xlsx' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
            'jpg' => 'image/jpeg',
            'jpeg' => 'image/jpeg',
            'png' => 'image/png',
            'gif' => 'image/gif',
            'txt' => 'text/plain',
            'zip' => 'application/zip',
            'rar' => 'application/x-rar-compressed',
        ];

        return $mimeTypes[$extension] ?? 'application/octet-stream';
    }
}
