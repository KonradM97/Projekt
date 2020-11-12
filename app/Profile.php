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
    public function ifYouFollow($id)
    {
        $findfollow = DB::select('SELECT follower, follows FROM user_follows WHERE follower='.Auth::user()->id.' AND  follows='.$id);
        if(empty($findfollow))
        {
            return 0;
        }
        return 1;
    }
    public function fetch_newest_songs($id)
    {
       $mysongs = DB::select('SELECT s.idsongs,s.title,u.name,s.genre,s.likes,c.source FROM `songs` s
       LEFT JOIN covers c on s.cover = c.idcovers
       INNER JOIN users u on u.id = s.author
       WHERE author='.$id.' ORDER BY s.`created_at` DESC');
       $this->show_songs($mysongs);
    }

    public function fetch_most_liked_songs($id)
    {
        $mysongs = DB::select('SELECT s.idsongs,s.title,u.name,s.genre,s.likes,c.source FROM `songs` s
       LEFT JOIN covers c on s.cover = c.idcovers
       INNER JOIN users u on u.id = s.author
       WHERE author='.$id.' ORDER BY s.`likes` DESC
       LIMIT 10' );
       $this->show_songs($mysongs);
    }
    function show_songs($mysongs)
    {
        echo '<table id="searching" class="table table-hover table-borderless">';
                            echo '<thead>
                                        <th class="srodek">Tytuł</th>
                                        <th class="srodek">Gatunek</th>
                                        <th class="srodek">Twórca</th>
                                        <th class="srodek">Polubienia</th>
                                    </tr>
                                </thead>';
                     foreach($mysongs as $val)
                     {
                         //dd($val);
                               echo '<tr style="cursor: pointer" class="clickable-row" data-href="?songid='.$val->idsongs.'">';
                               echo '<td class="srodek">'.$val->title.'</td>';
                               echo '<td class="srodek">'.$val->genre.'</td>';
                               echo '<td class="srodek">'.$val->name.'</td>';
                               echo '<td class="srodek">'.$val->likes.'</td>';
                               echo '<td class="srodek"><img src="'.$this->check_cover($val->source).'" height="50px" width="50px" /></td>';
                               echo '</tr>';
                     }
        echo '</table>';

    }
    public function fetch_albums($id)
    {
       $myalbums = DB::select('SELECT * FROM `albums` s LEFT JOIN covers c on s.cover = c.idcovers WHERE author='.$id);
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

    }
    public function fetch_playlists($id)
    {
        $SELECT_Playlists = 'SELECT * FROM `playlists` p WHERE p.author = '.$id;
        $SELECT = 'SELECT * FROM `playlists` p INNER JOIN songs_in_playlists sip ON sip.playlist = p.idplaylists INNER JOIN songs s ON sip.song = s.idsongs LEFT JOIN covers c on s.cover = c.idcovers WHERE p.author = '.$id;
        if(isset(Auth::user()->id))
        {
            if($id!=Auth::user()->id)
            {
                $SELECT.=' AND p.ispublic = 1';
                $SELECT_Playlists.=' AND p.ispublic = 1';
            }
        }
        else
        {
            $SELECT.=' AND p.ispublic = 1';
            $SELECT_Playlists.=' AND p.ispublic = 1';
        }
       $mysongs_in_playlists = DB::select($SELECT);
       $myplaylists = DB::select($SELECT_Playlists);
       $this->show_playlists($myplaylists,$mysongs_in_playlists);
    }

    function show_playlists($plylists,$songsIP)
    {
        foreach($plylists as $pl)
        {
            //<h3 style="float:right;">'.' Polubień: '.$pl->likes.'</h3> może kiedyś
            echo '<h3>'.$pl->playlistName.'</h3><br />';
            echo '<table id="searching" class="table table-hover table-borderless">';
                                echo '<thead>
                                            <th class="srodek">Tytuł</th>
                                            <th class="srodek">Gatunek</th>
                                            <th class="srodek">Polubień</th>
                                            <th class="srodek">Okładka</th>
                                        </tr>
                                    </thead>';
                        foreach($songsIP as $val)
                        {
                            //sprawdzenie czy utwór jest w danej playliście
                            if($val->playlist==$pl->idplaylists)
                            {
                                echo '<tr style="cursor: pointer" class="clickable-row" data-href="?songid='.$val->idsongs.'">';
                                echo '<td class="srodek">'.$val->title.'</td>';
                                echo '<td class="srodek">'.$val->genre.'</td>';
                                echo '<td class="srodek">'.$val->likes.'</td>';
                                echo '<td class="srodek"><img src="'.$this->check_cover($val->source).'" height="50px" width="50px" /></td>';
                                echo '</tr>';
                            }
                        }
            echo '</table>';
                    }
    }
    //Pasek oserwujący i obserwowani
    public function count_followers($id)
    {
        $count = DB::select('SELECT COUNT(*) AS count FROM `user_follows` WHERE follows = '.$id);
        echo $count[0]->count;
    }
    public function count_following($id)
    {
        $count = DB::select('SELECT COUNT(*) AS count FROM `user_follows` WHERE follower = '.$id);
        echo $count[0]->count;
    }
    public function fetch_followers($id)//obserwujący
    {
        $followers = DB::select('SELECT id,name, avatar FROM users RIGHT JOIN user_follows as uf ON uf.follower = id WHERE uf.follows = '.$id.' ORDER BY id LIMIT 10');
        $this->show_follow($followers);
    }
    function show_follow($followers)
    {
        foreach($followers as $val)
        {
            echo '<div class="follower">'
                    . '<a href="user='.$val->id.'">'
                    . '<img src="'.$this->check_cover($val->avatar).'" height="50px" width="50px" />'
                    . $val->name
                    . '</a>'
                    . '</div>';
        }
    }
    public function fetch_following($id)//obserwujący
    {
        $followers = DB::select('SELECT id,name, avatar FROM users RIGHT JOIN user_follows as uf ON uf.follows = id WHERE uf.follower = '.$id.' ORDER BY id LIMIT 10');
        $this->show_follow($followers);
    }

}
