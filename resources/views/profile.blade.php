@extends('layouts.app')

@section('content')
<?php
use App\Profile;
$profile = new Profile();
?>
 <link href="css/style.css" rel="stylesheet">
  <link href="css/profilestyle.css" rel="stylesheet">
   <script>jQuery(document).ready(function($) {
            $(".clickable-row").click(function() {
                window.location = $(this).data("href");
            });
        });</script>
  <script type="text/javascript">
                $(document).ready(function(){
                    $('#profile_songs').slideUp(0);
                    $('#profile_albums').slideUp(0);
                    $('#profile_playlist').slideUp(0);
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
        </div>
        <div class="showlist" id="profile_songs">
            <h1>Utwory</h1><br/>
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
           
        </div>
    </div>
   </div>
    <div id="info">
        <h1>{{$user->name}}</h1><img src="{{$user->avatar}}" width="200px"
    height="200px">
        <h3>Obserwujący</h3>
        <h3>Obserwowani</h3>
    </div>
    
</div>
@endsection
