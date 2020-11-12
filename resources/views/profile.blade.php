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
                @endguest
  </script>
<div class="content">
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
            <?php
            $profile->fetch_albums($user->id);
            ?>
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
        <div class="showlist" id="profile_albums">
           <h1> Albumy</h1><br/>
           <?php
           $profile->fetch_albums($user->id);
           ?>
        </div>
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
        <button title="Wiadomość"><img src="img/message.png" width="20px" height="20px">Wiadomość</button>
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
@endsection