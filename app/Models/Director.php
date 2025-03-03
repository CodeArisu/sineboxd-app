<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Director extends Model
{
    protected $primaryKey = 'id';

    protected $fillable = [
        'name'
    ];

    public function movie(): BelongsTo {
        return $this->belongsTo(Movie::class);
    }
}
