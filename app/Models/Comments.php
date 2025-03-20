<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Comments extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'movie_id',
        'parent_id', // for replies
        'content' // contents
    ];

    public function user() : BelongsTo
    {
        return $this->belongsTo(User::class);
    }
    public function movie() : BelongsTo
    {
        return $this->belongsTo(Movie::class);
    }
    public function replies() : HasMany
    {
        return $this->hasMany(comments::class, 'parent_id')
        ->with('replies');
    }
}
