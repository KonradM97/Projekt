<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Auth;
class MessagesController extends Controller
{
    //
    public function mymessages()
    {
        DB::update("UPDATE `messages` SET `isviewed` = 1 WHERE `reciver` = ".Auth::user()->id);
        $select = DB::select("SELECT messagetext, sender, idmessages ,added, name, avatar FROM `messages` INNER JOIN users u on messages.sender=u.id WHERE reciver =".Auth::user()->id);
        return view('messages',array('result' => $select));
    }

}
