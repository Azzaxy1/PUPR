<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserDetailTab extends Model
{
    use HasFactory;

    protected $table = 'user_detail_tab';

    protected $fillable =
    [
        'user_tab_id',
        'number_identification',
        'number_phone',
        'address',
        'working',
        'address_office'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_tab_id', 'id');
    }
}
