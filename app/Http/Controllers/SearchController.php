<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Validator;

class SearchController extends Controller
{
    //transofrmuj
    public function search(Request $r)
    {
        $validator = Validator::make($r->all(), [
            'searchFor' => 'required|min:3,max:45'
        ]);
        if($validator->fails())
        {
            return view('player',array('error' => 'Błąd w nazwie lub typie pliku!'));
        }
        else
        {
            $songs = DB::select('select * from songs s INNER JOIN users u ON s.author = u.id LEFT JOIN covers c on s.cover = c.idcovers where UPPER(title) LIKE UPPER("%'.$r['searchFor'].'%")');
            $albums = DB::select('select * from albums a INNER JOIN users u ON a.author = u.id where UPPER(title) LIKE UPPER("%'.$r['searchFor'].'%")');
            $playlists = DB::select('select * from playlists where UPPER(playlistName) LIKE UPPER("%'.$r['searchFor'].'%")');
            $users = DB::select('select id,email,name,avatar from users where UPPER(name) LIKE UPPER("%'.$r['searchFor'].'%") OR UPPER(username) LIKE UPPER("%'.$r['searchFor'].'%")');
        }
        
        return view('player',['songs'=>$songs,'playlists'=>$playlists,'albums'=>$albums,'users'=>$users]);
        
    }
    
    /*if(isset($_GET['k']) && $_GET['k'] != ''){
                    $k = trim($_GET['k']);
                    $keywords = explode(' ', $k);
                    
                    $query = "SELECT idsongs ,s.title as tytul,s.genre,s.likes, name, a.title FROM songs s, users, albums a WHERE ";

                    foreach($keywords as $word){
                        $query .= "s.title LIKE '%" . $word . "%' OR ";
                    }

                    $query = substr($query, 0, strlen($query) - 3);

                    $connect=mysqli_connect('localhost', 'root', '', 'medium_strumieniowe');

                    if(!$connect){
                        echo 'Błąd połączenia z serwerem';
                    }
                    else{
                        $result = mysqli_query($connect, $query);
                        $result_count = mysqli_num_rows($result);

                        if($result_count > 0){
                            echo 'Znaleziono wyników pasujących do wyszukiwania: ' . $result_count . '<hr class="bg-success">';

                            echo '<table class="table table-hover table-borderless">';
                            echo '<thead>
                                    <tr>
                                        <th>Tytuł</th>
                                        <th class="srodek">Album</th>
                                        <th class="srodek">Autor</th>
                                        <th class="srodek">Gatunek</th>
                                        <th class="srodek">Polubienia</th>
                                    </tr>
                                </thead><tbody>';

                            while($row = mysqli_fetch_assoc($result)){
                                echo '<tr>
                                        <td><a href="?songid='.$row['idsongs'].'">'.$row['tytul'].'</a></td>
                                         <td class="srodek"><a href="?songid='.$row['idsongs'].'">'.$row['title'].'</a></td>
                                        <td class="srodek"><a href="?songid='.$row['idsongs'].'">'.$row['name'].'</a></td>
                                        <td class="srodek"><a href="?songid='.$row['idsongs'].'">'.$row['genre'].'</a></td>
                                        <td class="srodek"><a href="?songid='.$row['idsongs'].'">'.$row['likes'].'</a></td>
                                    </tr>';
                            }

                            echo '</tbody></table>';

                        }
                        else{
                            echo "Brak wyników wyszukiwania";
                        }
                    }
                }*/
}
