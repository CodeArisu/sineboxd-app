<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class MovieCast extends Model
{
    protected $primaryKey = 'id';

    protected $fillable = [
        'actor_id'
    ];

    public function movie(): BelongsTo {
        return $this->belongsTo(Movie::class);
    }

    public function actor(): BelongsToMany {
        return $this->belongsToMany(Actor::class);
    }
}
