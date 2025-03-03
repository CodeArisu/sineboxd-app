<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Budget extends Model
{
    protected $primaryKey = 'id';

    protected $fillable = [
        'budget'
    ];

    public function movie(): BelongsTo {
        return $this->belongsTo(Movie::class, 'budget_id');
    }
}
