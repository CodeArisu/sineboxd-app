<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

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

}
