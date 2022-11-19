<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Illuminate\Support\Facades\Log;

class CPVolleyParser extends Model
{
    use HasFactory;

    function cleanString($str)
    {
        return str_replace(array("\r\n", "\r", "\n", "\t", " "), '', $str);
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
        for ($i = 1; $i <= 5; $i++) {
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


    public function getScore($result)
    {
        // Ricavo il numero di set
        if ($result[0] > $result[1]) { // Vince la squadra di casa
            if ($result[0] == $result[1] + 1) {
                return [2, 1];
            } else {
                return [3, 0];
            }
        } else { // Vince la squadra ospide
            if ($result[0] + 1 == $result[1]) {
                return [1, 2];
            } else {
                return [0, 3];
            }
        }
    }

    public function getSetInformation($text)
    {
        $dati = explode("-", $text);
        if (count($dati) != 2) {
            return [null, null];
        }

        return $dati;
    }

    public function parseRounds($url = '')
    {
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
        }
    }

    /*
     Riporta tutti gli incontri di una determinata giornata (per creare il calendario)
     */
    public function parseRoundMatches($url = '')
    {
        $res = file_get_contents($url);

        $dom = new \DomDocument();
        @$dom->loadHTML($res);
        $trs = $dom->getElementsByTagName('table')[1]
            ->getElementsByTagName('tbody')[0]
            ->getElementsByTagName('tr');

        $array = array();

        // Ogni loop contiene una riga della tabella dei risultati
        foreach ($trs as $tr) {
            $tds = $tr->getElementsByTagName('td');

            // Deve contenere precisamente le colonne che voglio io
            if ($tds->length != 9) {
                // Log::error($url);
                Log::error('Parser: Error (length ' . $tds->length . ')');

                return null;
            }

            $result = [
                "date" => $this->cleanString($tds[0]->textContent),
                "team" => [$tds[1]->textContent, $tds[2]->textContent],
            ];

            array_push($array, $result);

            Log::info('Parser: Trovato nuovo match ' . $result["team"][0] . " - " . $result["team"][1]);
        }

        return $array;
    }

    /*
     Riporta le location di dove si svolgeranno tutti gli incontri del campionato
     */
    public function parseLocationMatches($url = '')
    {
        $res = file_get_contents($url);

        $dom = new \DomDocument();
        @$dom->loadHTML($res);
        $trs = $dom->getElementsByTagName('table')[3]
            ->getElementsByTagName('tbody')[0]
            ->getElementsByTagName('tr');

        $array = array();

        // Ogni loop contiene una riga della tabella dei risultati
        foreach ($trs as $tr) {
            $tds = $tr->getElementsByTagName('td');
            if ($tds->length == 1) { // La riga che contiene il numero della giornata
                continue;
            }

            // Deve contenere precisamente le colonne che voglio io
            if ($tds->length != 8) {
                // Log::error($url);
                Log::error('Parser: Error (length ' . $tds->length . ')');

                return null;
            }

            $result = [
                "time" => $this->cleanString($tds[2]->textContent),
                "location" => $tds[3]->textContent,
                "gym" => $tds[4]->textContent,
                "team" => [$tds[5]->textContent, $tds[6]->textContent],
            ];

            array_push($array, $result);

            Log::info('Parser: Trovato nuovo match ' . $result["team"][0] . " - " . $result["team"][1]);
        }

        return $array;
    }

    /*
     Riporta i risultati di una giornata
     */
    public function parseResultMatches($url = '')
    {
        $res = file_get_contents($url);

        $dom = new \DomDocument();
        @$dom->loadHTML($res);
        $trs = $dom->getElementsByTagName('table')[1]
            ->getElementsByTagName('tbody')[0]
            ->getElementsByTagName('tr');

        $array = array();

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

            $setWon = explode("-", $this->cleanString($tds[3]->textContent));
            $result = [
                "date" => $this->cleanString($tds[0]->textContent),
                "team" => [$tds[1]->textContent, $tds[2]->textContent],
                "set_won" => $setWon,
                "set_lost" => array_reverse($setWon),
                "set_1" => $this->getSetInformation($this->cleanString($tds[4]->textContent)),
                "set_2" => $this->getSetInformation($this->cleanString($tds[5]->textContent)),
                "set_3" => $this->getSetInformation($this->cleanString($tds[6]->textContent)),
                "set_4" => $this->getSetInformation($this->cleanString($tds[7]->textContent)),
                "set_5" => $this->getSetInformation($this->cleanString($tds[8]->textContent)),
                "score" => $this->getScore($setWon),
            ];

            array_push($array, $result);

            Log::info('Parser: Trovato nuovo match ' . $result["team"][0] . " - " . $result["team"][1] . " " . $result["set_won"][0] . " - " . $result["set_won"][1]);
        }

        return $array;
    }
}
