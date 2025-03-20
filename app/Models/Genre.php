<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Genre extends Model
{   
    protected $table = 'genres';
    protected $primaryKey = 'id';

    protected $fillable = [
        'name'
    ];

    public function movie(): BelongsToMany {
        return $this->belongsToMany(Movie::class, 'genre_movie');
    }
}
