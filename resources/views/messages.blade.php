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
            echo '<div id="'.$var->idmessages.'" class="message flex">';
            echo '<div class="message-avatar"><img src="'.$var->avatar.'"></div>';
            echo '<div class="message-content"><a href="user='.$var->sender.'">'.$var->name.'('.$var->added.') pisze:<br>'.$var->messagetext.'</a></div>';
            echo '<button onclick="deleteMessage('.$var->idmessages.')" class="delete"><img src="img/delete.png" height="25px" width="25px"></button>';
            echo '</div>';
            
        }
    }
    else
    {
        echo '<h2>Brak wiadomości</h2>';
    }
   ?>
</div>
<script>
function deleteMessage(id)
                {
                    if (confirm('Czy napewno chcesz usunąć bezpowrotnie wiadomość?')) {
                        var myid=id
                        $.ajaxSetup({
                                headers: {
                                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                }
                            });
                            $.ajax({
                                type: 'GET',
                                url: 'deletemessage',
                                data: {id: myid},
                                contentType: 'application/json; charset=utf-8',
                                dataType: 'json',
                            });
                            //Schowaj po usunięciu
                            var idS="id";
                            idS.concat(idS,myid);
                            document.getElementById(id).style.display = "none"; 
                    } else {}
                }
</script>

@endsection
