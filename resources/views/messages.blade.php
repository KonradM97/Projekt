@extends('layouts.app2')

@section('content')
<?php
    use App\Profile;
    $profile = new Profile();
?>

<link href="css/messages.css" rel="stylesheet">

<div id="messages-container" class="container">
   <h1 class="my-1">Wiadomości</h1>
   <?php
    if(isset($result))
    {
        foreach($result as $var)
        {
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
