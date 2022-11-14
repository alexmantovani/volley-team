<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Result extends Model
{
    use HasFactory;

    protected $guarded = [];

    // public function sets()
    // {
    //     return $this->hasMany(Set::class);
    // }

    public function teams()
    {
        return $this->belongsToMany(Team::class);
    }
}
