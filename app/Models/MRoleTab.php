<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class MRoleTab extends Model
{
    use HasFactory;

    protected $table = 'm_role_tab';

    protected $fillable =
    [
        'title'
    ];

    public function users()
    {
        return $this->hasMany(User::class, 'm_role_tab_id');
    }
}
