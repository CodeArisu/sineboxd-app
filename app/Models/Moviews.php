<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasOneOrMany;

class Moviews extends Model
{
    protected $primaryKey = 'id';

    protected $fillable = [
        'title',
        'description',
        'genre_id',
        'director_id',
        'budget_id',
        'box_office_id',
        'cast_id',
        'release_year',
    ];

    public function genre() : HasMany {
        return $this->hasMany(Genre::class);
    }

    public function director() : HasOneOrMany {
        return $this->hasMany(Director::class);
    }

    public function budget() : HasOne {
        return $this->hasOne(Budget::class);
    }

    public function boxOffice() : HasOne {
        return $this->hasOne(BoxOffice::class);
    }

    public function cast() : HasOne {
        return $this->hasOne(Cast::class);
    }
}
