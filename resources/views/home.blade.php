@extends('layouts.app')

@section('content')

<script src="https://code.jquery.com/jquery-3.5.0.js"></script>
<link href="css/homebladestyle.css" rel="stylesheet">
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            
            <div class="row">
                <button class="col-md-4 col-md-offset add" id="addSong" onclick="showAddSong()" >Dodaj utwór</button>
                 <button class="col-md-4 col-md-offset add" id="addAlbum"onclick="showAddAlbum()">Dodaj album</button>
                <button class="col-md-4 col-md-offset add" id="addPlaylist" onclick="showAddPlaylist()">Dodaj playlistę</button>
            </div>
            <script type="text/javascript">
                $(document).ready(function(){
                    $('#addSongForm').slideUp(0);
                     $('#addAlbumForm').slideUp(0);
                     $('#addPlaylistForm').slideUp(0);
                    $('#albums').hide();
                    
                });
                function hideall()
                {
                    $('#addPlaylistForm').slideUp(0);
                    $('#addSongForm').slideUp(0);
                     $('#addAlbumForm').slideUp(0);
                    $('#albums').hide();
                }
                function showAddSong()
                {
                    hideall();
                    $('#addSongForm').slideDown(500);
                }
                function showAlbums()
                {
                    $('#albums').show();
                }
                function setAlbum(a)
                {
                    
                    document.getElementById('albumset').value=a;
                }
                function showAddAlbum()
                {
                    hideall();
                    $('#addAlbumForm').slideDown(500);
                }
                function showAddPlaylist()
                {
                     hideall();
                     $('#addPlaylistForm').slideDown(500);
                }
                            </script>
            <div class="row">
                <?php 
                if(isset($error))
                {
                    echo '<p style="color:red">'.$error.'</p>';
                }
                ?>
                
                
                
            <div class="form-group col-md-6" id="addSongForm">
                            <form enctype="multipart/form-data" action="addSong" method="POST">
                                <label>Tytuł</label><input type="text" class="form-control" name="title" required><br/>
                                <label>Plik</label><input type="file" class="form-control" name="source" required accept="audio/*"><br/>
                                <label>Album(opcj.)</label><input type="number" class="form-control" name="album" id="albumset" onclick="showAlbums()"><br/>
                                <label>Gatunek(opcj.)</label><input type="text" class="form-control" name="genre" ><br/>
                                <label>Okładka(opcj.)</label><input type="file" class="form-control" name="cover"><br/>
                                <label>Autor towarzyszący(opcj.)</label><input type="text" class="form-control" name="feat"><br/>
                                <label>Licencja(opcj.)</label><input type="text" class="form-control" name="license"><br/>
                                @csrf
                                
                                <button type="submit" name="addSong" class="btn btn-primary">Dodaj</button>
                            </form>
            </div>
                <div class="form-group col-md-6" id="albums">
                                <h2>Dostępne albumy</h2>
                                <?php
                                    $connect=mysqli_connect('localhost','root','','medium_strumieniowe');
                                    if(!$connect)
                                    {
                                            echo 'Błąd połączenia z serwerem';
                                    }
                                    $query = "SELECT idalbums, title from albums WHERE author = ".Auth::user()->id;
                                    $albums=mysqli_query($connect,$query);
                                    foreach ($albums as $a)
                                    {
                                        echo '<div class="col-md-12" id="album"><a href="#" onclick="setAlbum('.$a['idalbums'].')">'
                                       .$a['title'].'</a></div>';
                                    }
                                    
                                ?>
                            </div>
            <div class="form-group col-md-12" id="addAlbumForm">
                            <form enctype="multipart/form-data" action="addAlbum" method="POST">
                                <label>Tytuł</label><input type="text" class="form-control" name="title" required><br/>
                                <label>Opis</label><input type="text" class="form-control" name="describe" ><br/>
                                <label>Gatunek(opcj.)</label><input type="text" class="form-control" name="genre" ><br/>
                                <label>Okładka(opcj.)</label><input type="file" class="form-control" name="cover"><br/>
                                @csrf
                                
                                <button type="submit" name="addAlbum" class="btn btn-primary">Dodaj</button>
                            </form>
            </div>
                <div class="form-group col-md-12" id="addPlaylistForm">
                            <form enctype="multipart/form-data" action="addPlaylist" method="POST">
                                <label>Tytuł</label><input type="text" class="form-control" name="name" required><br/>
                                <label>Publiczna?</label><input type="checkbox" class="form-control" name="public" value="publiczna" ><br/>                                
                                @csrf
                                
                                <button type="submit" name="addPlaylist" class="btn btn-primary">Dodaj</button>
                            </form>
            </div>

                            
            </div>
            
        </div>
    </div>
</div>
@endsection
