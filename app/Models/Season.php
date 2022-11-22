<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Season extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function teams()
    {
        return $this->hasMany(Team::class);
    }

    public function tournaments()
    {
        return $this->hasMany(Tournament::class);
    }


    /**
     * Indica se il tornato è attivo o meno
     *
     * @return boolean
     */
    public function getIsActiveAttribute()
    {
        $activeSeasonId = Setting::valueForKey('active_season_id');
        return ($this->id == $activeSeasonId);
    }

    /**
     * Imposta questa stagione come attiva
     * @return Season
     */
    public function setActive()
    {
        Setting::setValueForKey('active_season_id', $this->id);

        return $this;
    }

    /**
     * Riporta la stagione in corso
     * @return Season
     */
    public static function active()
    {
        $activeSeasonId = Setting::valueForKey('active_season_id');

        // Ho trovato la stagione attiva
        if ($activeSeasonId > 0) return Season::find($activeSeasonId);

        return null;
    }
}
