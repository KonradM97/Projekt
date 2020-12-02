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

    public function aboutSong($song)
    {
        $mysong = DB::select('SELECT idsongs, s.source as ssource, s.title as stitle, s.genre as sgenre, s.likes as slikes,license, a.title as atitle,u.name as uname,
         u.id, c.source as csource FROM `songs` s LEFT JOIN covers c on s.cover = c.idcovers INNER JOIN users u on s.author=u.id LEFT JOIN albums a on s.album=a.idalbums WHERE s.idsongs ='.$song);
        
        foreach($mysong as $val)
        {
            //głowne informacje o utworze pokazywane zawsze
            
            echo '<h1>Właśnie odtwarzasz:</h1>';
            echo '<div id="song_info">';
            echo '<div id="song_image">';
            echo '<img src="'.$val->csource.'" height="100px" width="100px" />';
            echo '</div>';
            echo '<div id="song_likes">';
            echo 'Polubienia<br />'.
            $val->slikes.'<br />';
            echo 'Album<br />'.
            $val->atitle;
            echo '</div>';
            echo '<div id="song_title">'.$val->stitle.'</div>';
            

            echo
            'Autor<br/>'.
            '<a href="user='.$val->id.'">'.$val->uname.'</a><br />';
            
            //zamknij song_info
            echo '</div>';
            //dodatkowo licencja i gatunek
            if($val->license!=null)
            {
                echo 'Licencja<br />'.
                ''.$val->license.'<br />';
            }
            if($val->sgenre!=null)
            {
                echo 'Gatunek:'.
                ''.$val->sgenre.'<br />';
            }
            
        }
        
    }
    public function aboutAlbum($albumid)
    {
        $album = DB::select('SELECT title, genre,a.describe, c.source as source, u.name as uname FROM `albums` a LEFT JOIN covers c on a.cover = c.idcovers INNER JOIN users u on u.id=a.author WHERE a.idalbums ='.$albumid);
        
        foreach($album as $val)
        {
            //głowne informacje o albumie pokazywane zawsze
            
            echo '<h1>Właśnie odtwarzasz:</h1>';
            echo '<div id="album_info">';
            echo '<div id="album_name">'.
            $val->title;
            echo '</div>';
            echo '<div id="album_image">';
            echo '<img src="'.$val->source.'" height="200px" width="200px" />';
            echo '</div>';
            echo '<div id="album_author">Autor:<br />'.
            $val->uname;
            echo '</div>';
            //dodatkowo gatunek
            if($val->genre!=null)
            {
                echo 'Gatunek:'.
                ''.$val->genre.'<br />';
            }
            if($val->describe!=null)
            {
                echo 'Opis:'.
                ''.$val->describe.'<br />';
            }
            //zamknij album_info
            echo '</div>';
            echo '<h1>Utwory albumu:</h1>';
            $mysongs = DB::select('SELECT * FROM `songs` s WHERE album ='.$albumid);
            echo '<table id="searching" class="table table-hover table-borderless">';
            echo '<thead>
                    <tr>
                        <th class="srodek">Tytuł</th>
                        <th class="srodek">Polubienia</th>
                    </tr>
                </thead>';
            foreach($mysongs as $val)
            {
                //dd($val);
                    echo '<tr style="cursor: pointer" class="clickable-row" data-href="?songid='.$val->idsongs.'">';
                    echo '<td class="srodek">'.$val->title.'</td>';
                    echo '<td class="srodek">'.$val->likes.'</td>';
                    echo '</tr>';
            }
            echo '</table>';
            
            
        }
        
    }
    public function aboutPlaylist($playlistid)
    {
        $playlist = DB::select('SELECT playlistName,ispublic,author, u.name as uname FROM `playlists` p INNER JOIN users u on u.id=p.author WHERE p.idplaylists ='.$playlistid);
        
        foreach($playlist as $val)
        {
            //sprawdź co to playlista prywatna
            if($val->ispublic==0&&Auth::user()->id!=$val->author)
            {
                echo '<p style="color: red">Playlista prywatna!</p>';
                return;
            }
            //głowne informacje o playliście pokazywane zawsze
            
            echo '<h1>Właśnie odtwarzasz:</h1>';
            echo '<div id="album_info">';
            echo '<div id="album_name">'.
            $val->playlistName;
            echo '</div>';
            echo '<div id="album_author">Autor:<br />'.
            $val->uname;
            echo '</div>';
            //dodatkowo gatunek
            //zamknij album_info
            echo '</div>';
            echo '<h1>Utwory playlisty:</h1>';
            $mysongs = DB::select('SELECT * FROM `songs` s WHERE album ='.$playlistid);
            echo '<table id="searching" class="table table-hover table-borderless">';
            echo '<thead>
                    <tr>
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
                    echo '</tr>';
            }
            echo '</table>';
            
            
        }
        
    }
    public function fetch_newest_songs()
    {
       $mysongs = DB::select('SELECT s.idsongs, s.title,u.name as author ,c.source, s.genre,a.title as atitle,s.likes FROM `songs` s 
       LEFT JOIN covers c on s.cover = c.idcovers
       LEFT JOIN albums a on s.album = a.idalbums
       INNER JOIN users u on u.id = s.author
        ORDER BY s.`created_at` DESC LIMIT 10');
       $this->show_songs($mysongs);
    }

    public function show_songs($mysongs)
    {
        echo '<table class="">';
        echo '<thead>
                    <th class="srodek">Tytuł</th>
                    <th class="srodek">Gatunek</th>
                    <th class="srodek">Autor</th>
                    <th class="srodek">Album</th>
                    <th class="srodek">Polubienia</th>
                    <th></th>
                    
                </tr>
            </thead>';
        foreach($mysongs as $val)
        {
            //dd($val);
                echo '<tr style="cursor: pointer" class="clickable-row" data-href="?songid='.$val->idsongs.'">';
                echo '<td>'.$val->title.'</td>';
                echo '<td class="text-center">'.$val->genre.'</td>';
                echo '<td class="text-center">'.$val->author.'</td>';
                echo '<td class="text-center">'.$val->atitle.'</td>';
                echo '<td class="text-center">'.$val->likes.'</td>';
                echo '<td class="text-center"><img src="'.$val->source.'" height="50px" width="50px" /></td>';
                echo '</tr>';
        }
        echo '</table>';
    }

    public function fetch_newest_albums()
    {
       $myalbums = DB::select('SELECT u.id, s.idalbums,s.title, u.name, c.source FROM `albums` s
       INNER JOIN users u on u.id = s.author
        LEFT JOIN covers c on s.cover = c.idcovers
        ORDER BY s.`created_at` DESC LIMIT 10');
       $this->show_albums($myalbums);
    }

    public function show_albums($myalbums)
    {
        foreach($myalbums as $val)
        {
        echo '<div class="album-tile card text-center" style="background-color:var(--secondary-color);color:#fff;">'
            . '<a href="?album='.$val->idalbums.'">'
                . '<img src="'.$val->source.'" height="100px" width="100px" />'
                . '<br />'
                . '<b>'.$val->title.'<b></a><br />'
                . '<a href="user='.$val->id.'">'
                .$val->name
                . '</a></div>';
        }
                     //Zkonwertuj tablice php na javascript
    }
    public function fetch_followers_songs()
    {
        $flwsongs = DB::select('SELECT s.idsongs, s.title,u.name as author ,c.source, s.genre,a.title as atitle,s.likes FROM `songs` s 
        LEFT JOIN covers c on s.cover = c.idcovers
        LEFT JOIN albums a on s.album = a.idalbums
        INNER JOIN users u ON u.id=s.author
        INNER JOIN user_follows uf on uf.follows = s.author
        WHERE uf.follower ='.Auth::user()->id.'
        ORDER BY s.`created_at`
        DESC LIMIT 10');
        $this->show_songs($flwsongs);
    }
   
}
