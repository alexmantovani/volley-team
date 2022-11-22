<?php

namespace Tests\Unit;

// use PHPUnit\Framework\TestCase;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use \App\Models\Season;
use \App\Models\Team;
use \App\Models\Player;
use \App\Models\Tournament;

class TournamentTest extends TestCase
{
    use RefreshDatabase;

    public function setUp() :void
    {
        parent::setUp();

        $season = Season::create(['name' => 'Anno 2022/23']);

        Team::factory()->count(14)
            ->has(Player::factory()->count(10))
            ->create();

        $tournament = $season->tournaments()->create(['name' => 'Torneo Ufficiale']);
        $tournament->teams()->sync([1, 2, 3, 4, 5, 6, 7, 8, 9, 10]);

        $tournament = $season->tournaments()->create(['name' => 'Torneo Funi']);
        $tournament->teams()->sync([1, 2, 3, 4, 11, 12]);
    }

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
