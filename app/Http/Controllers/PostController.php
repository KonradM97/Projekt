<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Auth;
use Laravel\Ui\Presets\React;
use SebastianBergmann\Environment\Console;
use Validator;
class PostController extends Controller
{
    public function likePost(Request $request)
    {
       if(isset(Auth::user()->id))
       {
            $userId = Auth::user()->id;
            $r = $request;
            $repeat = DB::select('select * from likes where userId='.$userId.' AND songId = '.$r['songId']);
            if($repeat==[])
            {
                //dodaj like z wyzwalaczem dodającym o 1
                $result = DB::insert("INSERT INTO `likes` (`userId`, `songId`) VALUES ('".$userId."', '".$r['songId']."')");      
            }
            else 
            {
                //usuń like (to pierwesze można jako wyzwalacz)
                DB::update("UPDATE `songs` SET `likes` = `likes`-1 WHERE `songs`.`idsongs` =".$r['songId']);
                $result = DB::delete("DELETE from `likes` where `userId` = ".$userId." AND songId = ".$r['songId']);
            }
       }
    }
    public function followPost(Request $request)
    {
        $userId = Auth::user()->id;
        $follows = $request['follower'];
        $repeat = DB::select('SELECT follower, follows FROM user_follows WHERE follower='.$userId.' AND  follows='.$follows);
        if($repeat==[])
            {
                //dodaj like z wyzwalaczem dodającym o 1
                $result = DB::insert("INSERT INTO `user_follows` (`follower`, `follows`) VALUES ('".$userId."', '".$follows."')");      
            }
        else
        {
            DB::delete("DELETE from `user_follows` where `follower` = ".$userId." AND follows = ".$follows);
        }
    }
    public function sendMessage(Request $request)
    {
        //walidacja

            $r=$request;
            $sender = Auth::user()->id;
            $reciver =$r['rec'];
            $te = $r['textval'];
            DB::insert('INSERT INTO `messages` (`sender`, `reciver`, `messagetext`) VALUES ("'.$sender.'", "'.$reciver.'", "'.$te.'")');

    }
    public function deleteSong(Request $request)
    {
        $r = $request;
        DB::delete("DELETE FROM `songs` WHERE idsongs =".$r['id']);
    }
    public function deleteAlbum(Request $request)
    {
        $r = $request;
        DB::delete("DELETE FROM `albums` WHERE idalbums =".$r['id']);
    }
    public function deletePlaylist(Request $request)
    {
        $r = $request;
        DB::delete("DELETE FROM `playlists` WHERE idplaylists =".$r['id']);
    }
    public function deleteUser(Request $request)
    {
        $r = $request;
        DB::delete("DELETE FROM `users` WHERE id =".$r['id']);
    }
    ///playlisty
    public function addplaylist(Request $r)
    {
        //DB nie pozwala na powtórki więc nie trzeba sprawdzać

        DB::insert('INSERT INTO `songs_in_playlists` (`song`, `playlist`) VALUES ('.$r['pid'].','.$r['sid'].')');
    }
}
