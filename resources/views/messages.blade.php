@extends('layouts.app2')

@section('content')
<?php
    use App\Profile;
    $profile = new Profile();
?>

<link href="css/messages.css" rel="stylesheet">

<div id="messages-container" class="container">
   <h1 class="my-2">Wiadomości</h1>
   <?php
    if(isset($result))
    {
        foreach($result as $var)
        {
            /*echo '<div class="message-box my-4">';
            echo '<div class="icon"><img height="50px" src="'.$var->avatar.'"></div>';
            echo '<div class="sender">'.$var->name.'</div>';
            echo '<div class="text">'.$var->messagetext.'</div>';
            echo '<div class="sent"> Wysłano: '.$var->added.'</div>';

            echo '</div>';*/


            echo '<div class="message flex">';
            echo '<div class="message-avatar"><img src="'.$var->avatar.'"></div>';
            echo '<div class="message-content">'.$var->name.' ('.$var->added.') pisze:<br>'.$var->messagetext.'</div>';
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
