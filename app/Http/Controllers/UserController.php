<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use Auth;
use Image;

class UserController extends Controller
{
    //Na przyszłośc
    public function edit()
    {
        
    }
    public function update()
    {
        
    }
    public function profile($id)
    {
        $user = DB::select('SELECT * from users where id = '.$id);
        //Sprawdź czy istnieje
        if($user!=[])
        {
            $nuser=$user[0];//korzystamy tylko z jednego użytkownika
            $songs = DB::select('select * from songs s INNER JOIN users u ON s.author = u.id LEFT JOIN covers c on s.cover = c.idcovers where author='.$id);
            $albums = DB::select('select * from albums a INNER JOIN users u ON a.author = u.id where author='.$id);
            
            if(isset(Auth::user()->id)&&Auth::user()->id==$id)
            {
                $playlists = DB::select('select * from playlists where author='.$id.' AND ispublic = 1');
            }
            else
            {
                $playlists = DB::select('select * from playlists where author='.$id);
            }
            //$followers = DB::select('SELECT * from user_follows INNER JOIN');
            return view('profile', array('user' => $nuser,'songs' => $songs, 'albums' => $albums));
        }
        else
        {
            echo '<div id="error"><h1 style="font-family:monospace">Nie ma takiego użytkownika!</h1>';
        }
    }

    
}
