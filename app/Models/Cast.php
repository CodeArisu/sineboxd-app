<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Cast extends Model
{
    protected $primaryKey = 'id';

    protected $fillable = [
        'actor_id'
    ];

    public function moviews(): BelongsTo {
        return $this->belongsTo(Moviews::class);
    }
}
