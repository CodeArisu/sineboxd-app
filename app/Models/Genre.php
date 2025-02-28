<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Genre extends Model
{   
    protected $table = 'genres';
    protected $primaryKey = 'id';

    protected $fillable = [
        'genre'
    ];

    public function movie(): BelongsToMany {
        return $this->belongsToMany(Movie::class);
    }
}
