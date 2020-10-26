<?php
namespace App;
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Search
 *
 * @author Konrad
 */
class Search {
    //put your code here
    public function showSongs($songs)
    {
        echo '<h2>Utwory</h2>';
                   echo '<table class="table table-hover table-borderless">';
                            echo '<thead>
                                        <th class="srodek">Tytuł</th>
                                        
                                        <th class="srodek">Autor</th>
                                        <th class="srodek">Gatunek</th>
                                        <th class="srodek">Album</th>
                                        <th class="srodek">Polubienia</th>
                                    </tr>
                                </thead>';  
                     foreach($songs as $val)
                     {
                         //dd($val);
                               echo '<tr>';
                               echo '<th class="srodek"><a href="?songid='.$val->idsongs.'">'.$val->title.'</a></th>';
                               echo '<th class="srodek">'.$val->name.'</th>';
                               echo '<th class="srodek">'.$val->genre.'</th>';
                               echo '<th class="srodek">'.$val->author.'</th>';
                               echo '<th class="srodek">'.$val->likes.'</th>';
                               echo '<th class="srodek"><img id="cover" src="'.$val->source.'" height="50px" width="50px" /></th>';
                               echo '</tr></a>';
                     }
                     echo '<tbody>';
                     //Zkonwertuj tablice php na javascript
    }
    public function showUsers($users){
        echo '<h2>Użytkownicy</h2>';
                   echo '<table class="table table-hover table-borderless">';
                            echo '<thead>
                                        <th class="srodek">Nazwa</th>
                                        
                                        <th class="srodek">Avatar</th>
                                    </tr>
                                </thead>';  
                     foreach($users as $val)
                     {
                         //dd($val);
                               echo '<tr>';
                               echo '<th class="srodek">'.$val->name.'</th>';
                               echo '<th class="srodek"><img id="cover" src="'.$val->avatar.'" height="50px" width="50px" /></th>';
                               echo '</tr></a>';
                     }
                     echo '<tbody>';
                     //Zkonwertuj tablice php na javascript
    }
}
