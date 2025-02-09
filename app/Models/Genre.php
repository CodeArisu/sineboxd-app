<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Genre extends Model
{
    protected $primaryKey = 'id';

    protected $fillable = [
        'genre'
    ];

    public function moviews(): BelongsToMany {
        return $this->belongsToMany(Moviews::class);
    }
}
