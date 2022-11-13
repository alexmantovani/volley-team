<?php

namespace Tests\Unit;

// use PHPUnit\Framework\TestCase;

use App\Models\Tournament;
use Tests\TestCase;

class TournamentTest extends TestCase
{
    /**
     * A basic unit test teams.
     *
     * @return void
     */
    public function test_teams()
    {
        $tournament = Tournament::find(1);
        $this->assertEquals($tournament->teams->count(), 10);

        $tournament = Tournament::find(2);
        $this->assertEquals($tournament->teams->count(), 6);
    }
}
