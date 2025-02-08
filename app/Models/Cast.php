<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cast extends Model
{
    protected $primaryKey = 'id';

    protected $fillable = [
        'actor_id'
    ];
}
