<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Role extends Model
{   
    protected $primaryKey = 'id';

    // allows fillable role column
    protected $fillable = [
        'role'
    ];

    // Role table belongs to User table
    public function users(): BelongsTo {
        return $this->belongsTo(User::class);
    }  
}
