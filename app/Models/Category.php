<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Category extends Model
{
    protected $table = 'categories';
    protected $primaryKey = 'id';

    protected $fillable = [
        'category',
    ];

    protected $hidden = [
        'created_at',
        'updated_at'
    ];

    public function movies() : HasMany
    {
        return $this->hasMany(Movie::class);
    }
}
