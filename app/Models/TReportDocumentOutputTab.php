<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TReportDocumentOutputTab extends Model
{
    use HasFactory;

    protected $table = 't_report_document_output_tab';

    protected $fillable =
    [
        't_report_tab_id',
        'filename'
    ];

    public function report()
    {
        return $this->belongsTo( TReportTab::class, 't_report_tab_id');
    }
}
