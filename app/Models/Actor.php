<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Actor extends Model
{
    protected $table = 'actors';
    protected $primaryKey = 'id';

    protected $fillable = [
        'name',
        'profile',
        'gender_id',
    ];

    protected $hidden = [
        'created_at',
        'updated_at'
    ];

    public function cast() : BelongsToMany 
    {
        return $this->belongsToMany(Cast::class);
    }

    public function gender() : BelongsTo
    {
        return $this->belongsTo(Gender::class);
    }
}
