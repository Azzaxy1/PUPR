<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MStatusTab extends Model
{
    use HasFactory;

    protected $table = 'm_status_tab';

    protected $fillable =
    [
        'title',
        'color'
    ];
}
