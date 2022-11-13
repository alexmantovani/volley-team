<?php

namespace Tests\Unit;

// use PHPUnit\Framework\TestCase;
use Tests\TestCase;

class TeamTest extends TestCase
{
    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function test_tournaments()
    {
        $team = \App\Models\Team::find(1);

        // Questo team appartiene al primo torneo
        $tournament = $team->tournaments->first();
        $this->assertEquals($tournament->id, 1);

        // Questo team appartiene anche al secondo torneo
        $tournament = $team->tournaments->last();
        $this->assertEquals($tournament->id, 2);
    }
}
