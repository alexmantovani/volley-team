<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Team extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function tournaments()
    {
        return $this->belongsToMany(Tournament::class);
    }

    public function players()
    {
        return $this->belongsToMany(Player::class);
    }

    public function results()
    {
        return $this->belongsToMany(Result::class);
    }

}
