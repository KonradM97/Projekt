@extends('layouts.app2')

@section('content')
<?php
use App\Profile;
$profile = new Profile();

?>
 <link href="css/style2.css" rel="stylesheet">
  <link href="css/messages.css" rel="stylesheet">
<div id="messages-panel">
   <h1>Wiadomości</h1>
   <?php
   if(isset($result))
   {
       foreach($result as $var)
       {
           echo '<div class="message-box">';
           echo '<div class="icon"><img height="50px" src="'.$var->avatar.'"></div>';
            echo '<div class="sender">'.$var->name.'</div>';
           echo '<div class="text">'.$var->messagetext.'</div>';
           echo '<div class="sent"> Wysłano: '.$var->added.'</div>';
            
            echo '</div>';
           
       }
   }
   else
   {
       echo '<h2>Brak wiadomości</h2>';
   }
   ?>
</div>


@endsection
