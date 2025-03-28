<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Gender extends Model
{   

    protected $table = 'genders';
    protected $primaryKey = 'id';

    protected $fillable = [
        'gender'
    ];

    public function actor() : hasOne 
    {
        return $this->hasOne(Actor::class);
    }
}
