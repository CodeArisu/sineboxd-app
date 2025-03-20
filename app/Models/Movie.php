<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

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
        'ratings',
        'poster',
        'backdrop',
        'category_id',
        'runtime',
        'release_year',
    ];

    protected $hidden = [
        'created_at',
        'updated_at'
    ];

    public function genres() : BelongsToMany {
        return $this->belongsToMany(Genre::class, 'genre_movie');
    }
    public function director() : BelongsTo {
        return $this->belongsTo(Director::class);
    }
    public function budget() : HasOne {
        return $this->hasOne(Budget::class, 'id');
    }
    public function boxOffice() : HasOne {
        return $this->hasOne(BoxOffice::class, 'id');
    }
    public function cast() : hasOne {
        return $this->hasOne(Cast::class);
    }
    public function category() : BelongsToMany {
        return $this->belongsToMany(Category::class)
        ->withTimestamps();
    }
    public function comments() : HasMany
    {
        return $this->hasMany(Comments::class);
    }
}