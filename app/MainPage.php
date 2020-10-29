<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App;
use Illuminate\Support\Facades\DB;
use Auth;
/**
 * Description of MainPage
 *
 * @author Konrad
 */
class MainPage {
    public function fetch_newest_songs()
    {
       $mysongs = DB::select('SELECT * FROM `songs` s LEFT JOIN covers c on s.cover = c.idcovers ORDER BY s.`created_at` DESC LIMIT 10');
       $this->show_songs($mysongs);
    }
    public function show_songs($mysongs)
    {
        echo '<table id="searching" class="table table-hover table-borderless">';
                            echo '<thead>
                                        <th class="srodek">Tytuł</th>
                                        <th class="srodek">Gatunek</th>
                                        <th class="srodek">Album</th>
                                        <th class="srodek">Polubienia</th>
                                    </tr>
                                </thead>';  
                     foreach($mysongs as $val)
                     {
                         //dd($val);
                               echo '<tr style="cursor: pointer" class="clickable-row" data-href="?songid='.$val->idsongs.'">';
                               echo '<td class="srodek">'.$val->title.'</td>';
                               echo '<td class="srodek">'.$val->genre.'</td>';
                               echo '<td class="srodek">'.$val->author.'</td>';
                               echo '<td class="srodek">'.$val->likes.'</td>';
                               echo '<td class="srodek"><img src="'.$val->source.'" height="50px" width="50px" /></td>';
                               echo '</tr>';
                     }
        echo '</table>';
    }
    public function fetch_newest_albums()
    {
       $myalbums = DB::select('SELECT * FROM `albums` s LEFT JOIN covers c on s.cover = c.idcovers ORDER BY s.`created_at` DESC LIMIT 10');
       $this->show_albums($myalbums);
    }
    public function show_albums($myalbums)
    {
                     foreach($myalbums as $val)
                     {
                        echo '<div class="singlealbum">'
                         . '<a href="?album='.$val->idalbums.'">'
                                . '<img src="'.$val->source.'" height="100px" width="100px" />'
                                . $val->title
                                . '</a>'
                                . '</div>';
                     }
        echo '</table>';
                     //Zkonwertuj tablice php na javascript
    }
    public function fetch_followers_songs()
    {
        
    }
}
