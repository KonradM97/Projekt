@extends('layouts.app2')

@section('content')
<?php
use App\Profile;
$profile = new Profile();

?>
 <link href="css/style2.css" rel="stylesheet">
  <link href="css/profilestyle.css" rel="stylesheet">
   <script>
    var icon = false;
   jQuery(document).ready(function($) {
            $(".clickable-row").click(function() {
                window.location = $(this).data("href");
            });
        });
        
        </script>
  <script type="text/javascript">
                $(document).ready(function(){
                    $('#profile_songs').slideUp(0);
                    $('#profile_albums').slideUp(0);
                    $('#profile_playlist').slideUp(0);
                    @guest
                    @else
                    var follow = <?php echo json_encode($profile->ifYouFollow($user->id)); ?>;
                    if(follow==1)
                    {
                        icon = true;
                        document.getElementById("follow").innerHTML='<img  id="followicon" src="img/unfollow.png"  width="20px" height="20px">Obserwujesz';
                    }
                    @endguest
                });
                function hideall()
                {
                    $('#profile_all').slideUp(0);
                    $('#profile_songs').slideUp(0);
                    $('#profile_albums').slideUp(0);
                    $('#profile_playlist').slideUp(0);
                }
                function showAll()
                {
                    hideall();
                    $('#profile_all').slideDown(300);
                }
                function showSongs()
                {
                    hideall();
                    $('#profile_songs').slideDown(300);
                }
                function showAlbums()
                {
                    hideall();
                    $('#profile_albums').slideDown(300);
                }
                function showPlaylist()
                {
                     hideall();
                     $('#profile_playlist').slideDown(300);
                }
                //Odnnośnie obserwowań
                @guest
                @else
                function follow()
                {  
                    var follower = <?php echo json_encode($user->id); ?>;
                    event.preventDefault();
                            var isLike = event.target.previousElementSibling == null;
                            $.ajaxSetup({
                                headers: {
                                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                }
                            });
                            $.ajax({
                                type: "POST",
                                url: "follow",
                                data: '{"follower":'+follower+'}',
                                contentType: "application/json; charset=utf-8",
                                dataType: "json"
                            });
                    //sprawdź i zmień przycisk
                    if(icon)
                    {
                        document.getElementById("follow").innerHTML='<img  id="followicon" src="img/follow.png"  width="20px" height="20px">Obserwuj';
                        icon=false;
                    }
                    else
                    {
                        document.getElementById("follow").innerHTML='<img  id="followicon" src="img/unfollow.png"  width="20px" height="20px">Obserwujesz';
                        icon=true;
                    }
                    
                }
                //usuwanko
                var id;
                function deleteSong(id)
                {
                    if (confirm('Czy napewno chcesz usunąć bezpowrotnie ten utwór?')) {
                        var myid=id
                        $.ajaxSetup({
                                headers: {
                                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                }
                            });
                            $.ajax({
                                type: 'GET',
                                url: 'deletesong',
                                data: {id: myid},
                                contentType: 'application/json; charset=utf-8',
                                dataType: 'json',
                            });
                            //Schowaj po usunięciu
                    } else {}
                }
                function deleteAlbum(id)
                {
                    if (confirm('Czy napewno chcesz usunąć bezpowrotnie ten album?')) {
                        var myid=id
                        $.ajaxSetup({
                                headers: {
                                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                }
                            });
                            $.ajax({
                                type: 'GET',
                                url: 'deletealbum',
                                data: {id: myid},
                                contentType: 'application/json; charset=utf-8',
                                dataType: 'json',
                            });
                            //Schowaj po usunięciu
                    } else {}
                }
                function deletePlaylist(id)
                {
                    if (confirm('Czy napewno chcesz usunąć bezpowrotnie tą playlistę?')) {
                        var myid=id
                        $.ajaxSetup({
                                headers: {
                                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                }
                            });
                            $.ajax({
                                type: 'GET',
                                url: 'deleteplaylist',
                                data: {id: myid},
                                contentType: 'application/json; charset=utf-8',
                                dataType: 'json',
                            });
                            //Schowaj po usunięciu
                    } else {}
                }
                function deleteUser(id)
                {
                    if (confirm('Czy napewno chcesz usunąć bezpowrotnie użytkownika?')) {
                        var myid=id
                        $.ajaxSetup({
                                headers: {
                                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                }
                            });
                            $.ajax({
                                type: 'GET',
                                url: 'deleteuser',
                                data: {id: myid},
                                contentType: 'application/json; charset=utf-8',
                                dataType: 'json',
                            });
                            //Schowaj po usunięciu
                    } else {}
                }
                function sendmessage()
                {
                    modal.style.display = "none";
                    //Ajax to zło (robione od 21-23:30 bo cudzysłowy)
                    //Zrobić walidację
                    var textval, rec;
                    var val = String(document.getElementById("messageText").value);
                    var reciver = <?php echo json_encode($user->id); ?>;
                    $.ajaxSetup({
                                headers: {
                                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                }
                            });
                            $.ajax({
                                type: 'GET',
                                url: 'sendmessage',
                                data: {textval: val, rec: reciver},
                                contentType: 'application/json; charset=utf-8',
                                dataType: 'json',
                                
                            });
                        
                }
                @endguest
  </script>
<div class="container">
   <div id="listing">
    <div id="choose">
        <button onclick="showAll()">Wszystko</button>
        <button onclick="showSongs()">Utwory</button>
        <button onclick="showAlbums()">Albumy</button>
        <button onclick="showPlaylist()">Playlisty</button>
     </div>
    <div id="choose_content">
        <div class="showlist" id="profile_all">
            <h1>Wszystko</h1><br/>
            <h2>Najlepsze utwory</h2><br/>
            <?php
            $profile->fetch_most_liked_songs($user->id);
             ?>
            <h2>Albumy</h2>
            <div class="grid grid-4 showlist" >
            <?php
            $profile->fetch_albums($user->id);
            ?>
            </div>
            <h2>Playlisty</h2>
            <?php
            $profile->fetch_playlists($user->id);
            ?>
        </div>
        <div class="showlist" id="profile_songs">
            <h1>Najnowsze Utwory</h1><br/>
            <?php
            $profile->fetch_newest_songs($user->id);
            ?>
        </div>
        <div id="profile_albums"><h1> Albumy</h1><br/>
        <div class="grid grid-4 showlist" >
           
           <?php
           $profile->fetch_albums($user->id);
           ?>
        </div></div>
        <div class="showlist" id="profile_playlist">
           <h1>Playlisty</h1><br/>

           <?php
           $profile->fetch_playlists($user->id);
           ?>

        </div>
    </div>
   </div>
    <div id="userinfo">
        <h1>{{$user->name}}</h1>
        <img src="{{$user->avatar}}" width="180px" height="180px"><br />
        @guest
        @else
        <button onclick="follow()" id="follow" class="follow" title="Obserwuj"><img  id="followicon" src="img/follow.png"  width="20px" height="20px">Obserwuj</button><br />
        <button  title="Wiadomość" id="message"><img src="img/message.png" width="20px" height="20px">Wiadomość</button>
        <?php
        if(Auth::user()->Admin==1)
        {
                    echo '<button onclick="deleteUser('.$user->id.')" class="delete"><img src="img/delete.png" height="25px" width="25px"></button>';
        }
        ?>
<div id="messageform" class="modal">

<!-- Modal content -->
<div class="modal-content">
  <span class="close">&times;</span>
  <h2>Nowa wiadomość</h2>

      <textarea id="messageText" >Napisz</textarea>
      <button id="sendmessage" onclick="sendmessage()">Wyślij</button>
</div>

</div>
        @endguest
        <h3>Obserwujący <?php $profile->count_followers($user->id);?></h3>
        <?php
           $profile->fetch_followers($user->id);
        ?>
        <h3>Obserwowani <?php $profile->count_following($user->id);?></h3>
        <?php
          $profile->fetch_following($user->id);
        ?>
    </div>

</div>
<script>
//Obsługa wiadomości
var modal = document.getElementById("messageform");
var sendmessagebtn = document.getElementById("sendmessage");
var btn = document.getElementById("message");
var span = document.getElementsByClassName("close")[0];
btn.onclick = function() {
  modal.style.display = "block";
}
span.onclick = function() {
  modal.style.display = "none";
}

window.onclick = function(event) {
  if (event.target == modal) {
    modal.style.display = "none";
  }
}
</script>
@endsection