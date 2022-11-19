<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tournament extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function season()
    {
        return $this->belongsTo(Season::class);
    }

    public function teams()
    {
        return $this->belongsToMany(Team::class)
        ->withPivot([
            "score",
            "set_won",
            "set_lost",
        ]);
    }

    public function results()
    {
        return $this->hasMany(Result::class);
    }

    public function rounds()
    {
        return $this->results->groupBy('round');
    }

}
