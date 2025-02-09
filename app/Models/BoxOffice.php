<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class BoxOffice extends Model
{
    protected $primaryKey = 'id';

    protected $fillable = [
        'revenue'
    ];

    public function moviews(): BelongsTo {
        return $this->belongsTo(Moviews::class);
    }
}
