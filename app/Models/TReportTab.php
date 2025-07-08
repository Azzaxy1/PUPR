<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TReportTab extends Model
{
    use HasFactory;

    protected $table = 't_report_tab';

    protected $fillable =
    [
        'user_id',
        'number_registration',
        'report',
        'm_status_tab_id'
    ];

    public function documents()
    {
        return $this->hasMany( TReportDocumentTab::class, 't_report_tab_id' );
    }

    public function transactions()
    {
        return $this->hasMany( TReportTransactionTab::class, 't_report_tab_id' );
    }

    public function status()
    {
        return $this->belongsTo( MStatusTab::class, 'm_status_tab_id');
    }

    public function user()
    {
        return $this->belongsTo( User::class, 'user_id');
    }

    public function documentOutputs()
    {
        return $this->hasMany(TReportDocumentOutputTab::class, 't_report_tab_id');
    }
}
