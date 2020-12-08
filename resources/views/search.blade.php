@extends('layouts.app2')

@section('content')
<?php
    // Start the session
    session_start();
    use App\Search;
?>

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

        <script>jQuery(document).ready(function($) {
            $(".clickable-row").click(function() {
                window.location = $(this).data("href");
            });
        });</script>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>Player</title>
        <!-- Styles -->

        <link href="css/style2.css" rel="stylesheet">
    </head>

    <body>
    <div class="container">
        <h1>Wyniki wyszukiwania</h1>

        <?php

            $search = new Search();
            if(isset($songs)&&$songs!=[]) {
                   $search->showSongs($songs);
            }
            if(isset($users)&&$users!=[]) {
                   $search->showUsers($users);
            }
            if(isset($albums)&&$albums!=[]) {
                   $search->showAlbums($albums);
            }
            if(isset($playlists)&&$playlists!=[]){
                $search->showPlaylists($playlists);
            }
            if($songs==[]&&$users==[]&&$albums==[]&&$playlists==[])
            {
                echo '<h1>Brak wyników dla zapytania: '.$_GET['searchFor'];
            }
        ?>

    </body>
    <script>
        $(document).ready(function(){
                    //$('#wyszukaj').hide();
                    $('#albums').hide();
                });
                function showsearch(){
                    $('#wyszukaj').slideToggle(500);
                }
    </script>
</html>
@endsection
