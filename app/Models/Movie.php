<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasOneOrMany;

class Movie extends Model
{
    protected $table = 'movies';
    protected $primaryKey = 'id';

    protected $fillable = [
        'title',
        'description',
        'director_id',
        'budget_id',
        'box_office_id',
        'release_year',
        'updated_at'
    ];

    public function genre() : HasMany {
        return $this->hasMany(Genre::class);
    }

    public function director() : HasOneOrMany {
        return $this->hasMany(Director::class);
    }

    public function budget() : HasOne {
        return $this->hasOne(Budget::class, 'id');
    }

    public function boxOffice() : HasOne {
        return $this->hasOne(BoxOffice::class, 'id');
    }

    public function cast() : HasOne {
        return $this->hasOne(Cast::class);
    }
}
