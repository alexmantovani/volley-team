<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StatParser extends Model
{
    use HasFactory;

    static public function parsePage()
    {
        $res = file_get_contents('https://www.cpvolley.it/faenza-lugo-ravenna/campionato/2186/1/open-misto-girone-a');

        $dom = new DomDocument();
        $dom->loadHTML($res);
dd($dom);
        //DOMElement
        // $table = $dom->getElementById('tablepress-3');

        // //DOMNodeList
        // $child_elements = $table->getElementsByTagName('tr');
        // $row_count = $child_elements->length ;
    }
}
