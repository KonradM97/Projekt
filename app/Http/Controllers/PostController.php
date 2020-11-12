<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Auth;

class PostController extends Controller
{
    public function likePost(Request $request)
    {
       if(isset(Auth::user()->id))
       {
            $userId = Auth::user()->id;
            $r = $request;
            $repeat = DB::select('select * from likes where userId=1 AND songId = '.$r['songId']);
            if($repeat==[])
            {
                //dodaj like z wyzwalaczem dodającym o 1
                $result = DB::insert("INSERT INTO `likes` (`userId`, `songId`) VALUES ('1', '".$r['songId']."')");      
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
}
