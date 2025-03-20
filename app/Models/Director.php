<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Director extends Model
{
    protected $primaryKey = 'id';

    protected $fillable = [
        'name'
    ];

    public function movie(): HasMany {
        return $this->hasMany(Movie::class);
    }
}
