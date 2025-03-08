<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Cast extends Model
{   
    protected $table = 'cast_movie';
    protected $primaryKey = 'id';

    protected $fillable = [
        'actor_id',
        'movie_id',
        'known_for',
        'character_name'
    ];

    public function movie(): BelongsTo {
        return $this->belongsTo(Movie::class);
    }

    public function actor(): BelongsTo {
        return $this->belongsTo(Actor::class);
    }
}
