<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MCodeTab extends Model
{
    use HasFactory;

    protected $table = 'm_code_tab';

    protected $fillable =
    [
        'prefix',
        'start',
        'length',
        'year',
        'description'
    ];
}
