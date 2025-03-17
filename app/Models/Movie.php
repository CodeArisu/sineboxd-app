<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
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
        'ratings',
        'poster',
        'category_id',
        'release_year',
    ];

    protected $hidden = [
        'created_at',
        'updated_at'
    ];

    public function genre() : BelongsToMany {
        return $this->belongsToMany(Genre::class)
        ->withTimestamps();
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
    public function cast() : hasOne {
        return $this->hasOne(Cast::class);
    }
    public function category() : BelongsToMany {
        return $this->belongsToMany(Category::class)
        ->withTimestamps();
    }
}