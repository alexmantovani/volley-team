<?php

namespace App\Http\Livewire;

use Livewire\Component;

class TournamentShow extends Component
{
    public $tournament;
    public $season;
    public $ranking;
    public $autosync;

    public function render()
    {
        return view('livewire.tournament-show');
    }

    // Necessaria per evitare errori dopo il render() - Strategia B
    // https://github.com/livewire/livewire/issues/27
    public function hydrate()
    {
        $this->ranking = $this->tournament->teams;
    }
}
