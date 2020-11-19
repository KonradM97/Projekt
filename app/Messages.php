<?php
namespace App;
use Illuminate\Support\Facades\DB;
use Auth;
use PhpParser\Node\Stmt\Return_;

class Messages {
    public function getMessageCount()
    {
        $howmany = DB::select("SELECT count(*) as ile FROM `messages` WHERE reciver=".Auth::user()->id." and isviewed=0");
        if($howmany[0]->ile==0)
        {
            return "";
        }
        return $howmany[0]->ile;
    }
}
?>