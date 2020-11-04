<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App;
use Illuminate\Support\Facades\DB;
/**
 * Description of Profile
 *
 * @author Konrad
 */
class Profile {
    public function check_cover($cover)
    {
        if($cover==null)
        {
            return "img/nullcover.png";
        }
        else
        {
            return $cover;
        }    
        
    }
    public function fetch_newest_songs($Id)
    {
       $mysongs = DB::select('SELECT * FROM `songs` s LEFT JOIN covers c on s.cover = c.idcovers WHERE author='.$Id.' ORDER BY s.`created_at` DESC');
       $this->show_songs($mysongs);
    }
    public function fetch_most_liked_songs($Id)
    {
       $mysongs = DB::select('SELECT * FROM `songs` s LEFT JOIN covers c on s.cover = c.idcovers WHERE author='.$Id.' ORDER BY s.`likes` DESC');
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
                               echo '<td class="srodek"><img src="'.$this->check_cover($val->source).'" height="50px" width="50px" /></td>';
                               echo '</tr>';
                     }
        echo '</table>';
                     
    }
    public function fetch_albums($Id)
    {
       $myalbums = DB::select('SELECT * FROM `albums` s LEFT JOIN covers c on s.cover = c.idcovers WHERE author='.$Id);
       $this->show_albums($myalbums);
    }
    public function show_albums($myalbums)
    {
                     foreach($myalbums as $val)
                     {
                        echo '<div class="singlealbum">'
                         . '<a href="?album='.$val->idalbums.'">'
                                . '<img src="'.$this->check_cover($val->source).'" height="100px" width="100px" />'
                                . $val->title
                                . '</a>'
                                . '</div>';
                     }
        echo '</table>';
                     //Zkonwertuj tablice php na javascript
    }
    
}