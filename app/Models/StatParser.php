<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Illuminate\Support\Facades\Log;

class StatParser extends Model
{
    use HasFactory;

    function cleanString($str)
    {
        return str_replace(array("\r\n", "\r", "\n", "\t", " "), '', $str);
    }

    public function parsePage($url = '')
    {
        $url = 'https://www.cpvolley.it/faenza-lugo-ravenna/campionato/2186/1/open-misto-girone-a';

        $res = file_get_contents($url);

        $dom = new \DomDocument();
        @$dom->loadHTML($res);
        $trs = $dom->getElementsByTagName('table')[1]
            ->getElementsByTagName('tbody')[0]
            ->getElementsByTagName('tr');

        // Ogni loop contiene una riga della tabella dei risultati
        foreach ($trs as $tr) {
            $tds = $tr->getElementsByTagName('td');

            // Deve contenere precisamente le colonne che voglio io
            if ($tds->length != 9) {
                // Log::error($url);
                Log::error('Parser: Error (length ' . $tds->length . ')');

                return false;
            }

            // Verifico che il match si sia disputato
            $risultato = $this->cleanString($tds[3]->textContent);
            if (!strlen($risultato)) {
                // Log::info($url);
                Log::info('Parser: Match senza risultati ' . $tds[1]->textContent . ' - ' . $tds[2]->textContent);

                continue;
            }

            $result = [
                "date" => $this->cleanString($tds[0]->textContent),
                // "home" => $this->cleanString($tds[1]->textContent),
                // "visitor" => $this->cleanString($tds[2]->textContent),
                "team" => [$tds[1]->textContent, $tds[2]->textContent],
                "result" => explode("-", $this->cleanString($tds[3]->textContent)),
                "set1" => explode("-", $this->cleanString($tds[4]->textContent)),
                "set2" => explode("-", $this->cleanString($tds[5]->textContent)),
                "set3" => explode("-", $this->cleanString($tds[6]->textContent)),
                "set4" => explode("-", $this->cleanString($tds[7]->textContent)),
                "set5" => explode("-", $this->cleanString($tds[8]->textContent)),
            ];

            $this->addResults($result, 0); // Casa
            $this->addResults($result, 1); // Ospiti

            Log::info('Parser: Trovato nuovo match ' . $result["team"][0] . " - " . $result["team"][1] . " " . $result["result"][0] . " - " . $result["result"][1]);
        }

        return true;
    }

    // $index corrisponde a 0 = casa   1 = ospiti
    public function addResults($result, $index)
    {
        // Creo il match
        $match = Result::create([]);

        // Cerco il team
        $team = Team::where('name', $result["team"][$index])->first();
        if (!$team) {
            $team = Team::create([
                'name' => $result["team"][$index]]
            );

        }

        $winner = $this->isWinner($result["result"], $index);
        $setWins = $this->setWins($result, $index);

        $match->teams()->attach($team->id, [
            'visitor_team' => $index,
            'winner' => $winner,
            'set_wins' => $setWins,
        ]);
    }

    public function isWinner($result, $index)
    {
        switch ($index) {
            case 0: // In casa
                return ($result[0] > $result[1]);
            case 1: // Ospite
                return ($result[1] > $result[0]);
        }
    }

    public function setWins($result, $index)
    {
        $wins = 0;
        for ($i=1; $i <= 5; $i++) {
            $key = "set" . $i;
            $risultato = $result[$key];

            if (count($risultato) == 1) {
                continue;
            }

            switch ($index) {
                case 0: // In casa
                    $wins += ($risultato[0] > $risultato[1] ? 1 : 0);
                    break;
                case 1: // Ospite
                    $wins += ($risultato[1] > $risultato[0] ? 1 : 0);
                    break;
                }
        }
        Log::info('Parser: wins ' . $wins);

        return $wins;
    }
}
