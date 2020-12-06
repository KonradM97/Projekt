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

        echo '<div class="container"><h2 class="my-2">Utwory</h2>';
                   echo '<table id="searching" class="table table-hover table-borderless">';
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
                               echo '<tr style="cursor: pointer" class="clickable-row" data-href="?songid='.$val->idsongs.'">';
                               echo '<td class="srodek">'.$val->title.'</td>';
                               echo '<td class="text-center">'.$val->name.'</td>';
                               echo '<td class="text-center">'.$val->genre.'</td>';
                               echo '<td class="text-center">'.$val->author.'</td>';
                               echo '<td class="text-center">'.$val->likes.'</td>';
                               echo '<td class="text-center"><img id="cover" src="'.$val->source.'" height="50px" width="50px" /></td>';
                               echo '</tr>';
                     }
                     echo '</table></div>';
                     //Zkonwertuj tablice php na javascript
    }
    public function showUsers($users){
        echo '<div class="container"><h2 class="my-2">Użytkownicy</h2>';
                   echo '<table id="searching" class="table table-hover table-borderless">';
                            echo '<thead>
                                        <th class="srodek">Nazwa</th>

                                        <th class="srodek">Avatar</th>
                                    </tr>
                                </thead>';
                     foreach($users as $val)
                     {
                         //dd($val);
                               echo '<tr style="cursor: pointer" class="clickable-row" data-href="user='.$val->id.'">';
                               echo '<td class="srodek">'.$val->name.'</td>';
                               echo '<td class="srodek"><img id="cover" src="'.$val->avatar.'" height="50px" width="50px" /></td>';
                               echo '</tr></a>';
                     }
                     echo '</table></div>';
                     //Zkonwertuj tablice php na javascript
    }
    public function showAlbums($albums){
        echo '<div class="container"><h2 class="my-2">Albumy</h2>';
                   echo '<table id="searching" class="table table-hover table-borderless">';
                            echo '<thead>
                                        <th class="srodek">Nazwa</th>
                                        <th class="srodek">Gatunek</th>
                                        <th class="srodek">Polubień</th>

                                    </tr>
                                </thead>';
                            foreach($albums as $val)
                     {
                         //dd($val);
                               echo '<tr style="cursor: pointer" class="clickable-row" data-href="?album='.$val->idalbums.'">';
                               echo '<td class="srodek">'.$val->title.'</td>';
                               echo '<td class="text-center">'.$val->genre.'</td>';
                               echo '<td class="text-center">'.$val->likes.'</td>';
                               echo '<td class="text-center"><img id="cover" src="'.$val->source.'" height="50px" width="50px" /></td>';
                               echo '</tr></a>';
                     }
                     echo '</table></div>';
    }
    public function showPlaylists($playlists){
        echo '<div class="container"><h2 class="my-2">Playlisty</h2>';
                   echo '<table id="searching" class="table table-hover table-borderless">';
                            echo '<thead>
                                        <th class="srodek">Nazwa</th>
                                        <th class="srodek">Autor</th>
                                        <th class="srodek">Polubień</th>
                                    </tr>
                                </thead>';
                            foreach($playlists as $val)
                     {
                         //dd($val);
                               echo '<tr style="cursor: pointer" class="clickable-row" data-href="?playlist='.$val->idplaylists.'">';
                               echo '<td class="srodek">'.$val->playlistName.'</td>';
                               echo '<td class="text-center">'.$val->name.'</td>';
                               echo '<td class="text-center">'.$val->likes.'</td>';
                               echo '</tr></a>';
                     }
                     echo '</table></div>';
    }

}
