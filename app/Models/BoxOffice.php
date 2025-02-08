<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BoxOffice extends Model
{
    protected $primaryKey = 'id';

    protected $fillable = [
        'revenue'
    ];
}
