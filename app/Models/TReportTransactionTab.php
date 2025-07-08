<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TReportTransactionTab extends Model
{
    use HasFactory;

    protected $table = 't_report_transaction_tab';

    protected $fillable =
    [
        't_report_tab_id',
        'user_id',
        'status_ref',
        'status_active',
        'approve_dates',
        'm_status_tab_id',
        'notes'
    ];

    public function report()
    {
        return $this->belongsTo(TReportTab::class, 't_report_tab_id');
    }

    public function status()
    {
        return $this->belongsTo(MStatusTab::class, 'm_status_tab_id', 'id');
    }

    public function officer()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
