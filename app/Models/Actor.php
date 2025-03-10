<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Actor extends Model
{
    protected $table = 'actors';
    protected $primaryKey = 'id';

    protected $fillable = [
        'name',
        'nationality'
    ];

    public function cast(): BelongsToMany {
        return $this->belongsToMany(Cast::class);
    }
}
