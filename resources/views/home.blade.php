@extends('layouts.app')

@section('content')
<link href="css/homebladestyle.css" rel="stylesheet">
<script src="https://code.jquery.com/jquery-3.5.0.js"></script>
<div class="container">
        <div class="col-md-12">

            <div class="row">
                <h1 class="my-1">Panel użytkownika {{ Auth::user()->name}}</h1>
                <!-- komunikaty-->
                <?php
                    if(isset($error))
                    {
                        echo '<p style="color:red">Błąd: '.$error.'!</p>';
                    }
                    if(isset($resultstatus))
                    {
                        echo '<p style="color:green">Zmieniono!</p>';
                    }
                ?>
            </div>

            <div id="userinfo" class="text-center my-1">
                <img src="{{Auth::user()->avatar}}" />
                <form enctype="multipart/form-data" action="home" method="POST">
                    <input type="file" name="avatar"><br/>
                    @csrf
                    <input type="submit" value="Zmień zdjęcie" class="btn btn-primary"><br/>
                </form>
            </div>

            <div class="row">
                <div id="addbuttons" class="flex">
                    <button class="btn btn-primary" id="addSong" onclick="showAddSong()" >Dodaj utwór</button>
                    <button class="btn btn-primary" id="addAlbum" onclick="showAddAlbum()">Dodaj album</button>
                    <button class="btn btn-primary" id="addPlaylist" onclick="showAddPlaylist()">Dodaj playlistę</button>
                    <button class="btn btn-primary" id="changenameButton" onclick="showChangeName()">Zmień nazwę</button>
                    <button class="btn btn-primary" id="changepasswordButton">Zmień hasło</button>
                </div>
            </div>

            <script type="text/javascript">
                $(document).ready(function(){
                    $('#addSongForm').slideUp(0);
                     $('#addAlbumForm').slideUp(0);
                     $('#addPlaylistForm').slideUp(0);
                    $('#albums').hide();
                    $('#changeNametForm').hide();
                });
                function hideall()
                {
                    $('#addPlaylistForm').slideUp(0);
                    $('#addSongForm').slideUp(0);
                     $('#addAlbumForm').slideUp(0);
                    $('#albums').hide();
                    $('#changeNametForm').hide();
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
                function showChangeName()
                {
                    hideall();
                    $('#changeNametForm').slideDown(500);
                }
            </script>

            <div id="forms">

                <div class="form-group col-md-6" id="changeNametForm">
                    <p style="color: red">Uwaga! Zmiana nazwy użytkownika skutkuje tym, że osoby, które cię znały nie będą mogły cię znaleźć w wyszukiwarce!</p>
                    <form enctype="multipart/form-data" action="changeName" method="POST">
                        <label>Nowa nazwa</label><input type="text" class="form-control" name="name" pattern=".{3,}" title="Nazwa musi mieć conajmniej 3 znaki"  required><br/>
                        <label>Potwierdź nazwę</label><input type="text" class="form-control" name="confirm_name" required><br/>
                        @csrf
                        <input type="submit" name="changeName" value="Zmień" class="btn btn-secondary">
                    </form>
                </div>

                <div class="form-group col-md-6" id="addSongForm">
                    <form enctype="multipart/form-data" action="addSong" method="POST">
                        <label>Tytuł</label><input type="text" class="form-control" name="title" required><br/>
                        <label>Plik</label><input type="file" class="form-control" name="source" required accept=".mp3,.ogg|audio/*"><br/>
                        <label>Album(opcj.)</label><input type="number" class="form-control" name="album" id="albumset" onclick="showAlbums()"><br/>
                        <label>Gatunek(opcj.)</label><input type="text" class="form-control" name="genre" ><br/>
                        <label>Okładka(opcj.)</label><input type="file" class="form-control" name="cover"><br/>
                        <label>Autor towarzyszący(opcj.)</label><input type="text" class="form-control" name="feat"><br/>
                        <label>Licencja(opcj.)</label><input type="text" class="form-control" name="license"><br/>
                        @csrf

                        <button type="submit" name="addSong" class="btn btn-secondary">Dodaj</button>
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

                        <button type="submit" name="addAlbum" class="btn btn-secondary">Dodaj</button>
                    </form>
                </div>

                <div class="form-group col-md-12" id="addPlaylistForm">
                    <form enctype="multipart/form-data" action="addPlaylist" method="POST">
                        <label>Tytuł</label><input type="text" class="form-control" name="name" required><br/>
                        <label>Publiczna?</label><input type="checkbox" class="form-control" name="public" value="publiczna" ><br/>
                        @csrf

                        <button type="submit" name="addPlaylist" class="btn btn-secondary">Dodaj</button>
                    </form>
                </div>


            </div>

        </div>

    <div id="chgpasswdform" class="modal">

<!-- Modal content -->
<div class="modal-content">
  <span class="close">&times;</span>
  <h2>Zmień hasło</h2>

  <form method="POST" action="{{ route('change.password') }}">

@csrf
<div class="form-group row">

    <label for="password" class="col-md-4 col-form-label text-md-right">Obecne hasło</label>
    <div class="col-md-6">
        <input id="password" type="password" class="form-control" name="current_password" autocomplete="current-password">
    </div>
</div>
<div class="form-group row">
    <label for="password" class="col-md-4 col-form-label text-md-right">Nowe hasło</label>
    <div class="col-md-6">
        <input id="new_password" type="password" class="form-control" name="new_password" autocomplete="current-password">
    </div>
</div>
<div class="form-group row">
    <label for="password" class="col-md-4 col-form-label text-md-right">Potwierdź hasło</label>
    <div class="col-md-6">
        <input id="new_confirm_password" type="password" class="form-control" name="new_confirm_password" autocomplete="current-password">
    </div>
</div>
<div class="form-group row mb-0">
    <div class="col-md-8 offset-md-4">
        <button type="submit" class="btn btn-primary">
            Zmień hasło
        </button>
    </div>

</div>

</form>
</div>

</div>
</div>

<script>
//Zmień hasło
var modal = document.getElementById("chgpasswdform");
//var chgpasswdbtn = document.getElementById("changepasswordconfirm");
// Get the button that opens the modal
var btn = document.getElementById("changepasswordButton");

// Get the <span> element that closes the modal
var span = document.getElementsByClassName("close")[0];

// When the user clicks the button, open the modal
btn.onclick = function() {
  modal.style.display = "block";
}
// When the user clicks on <span> (x), close the modal
span.onclick = function() {
  modal.style.display = "none";
}

// When the user clicks anywhere outside of the modal, close it
window.onclick = function(event) {
  if (event.target == modal) {
    modal.style.display = "none";
  }
}
</script>
@endsection
