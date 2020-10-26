@extends('layouts.app')

@section('content')
<?php
    // Start the session
    session_start();
    use App\Search;
?>

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>Player</title>
        <!-- Styles -->
        <link href="css/playerbladestyle.css" rel="stylesheet">
        <link href="css/style.css" rel="stylesheet">
        
        
    </head>

    <body>

        <?php 
            
            $search = new Search();
            if(isset($songs)&&$songs!=[]) {
                   $search->showSongs($songs);
            }
            if(isset($users)&&$users!=[]) {
                   $search->showUsers($users);
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