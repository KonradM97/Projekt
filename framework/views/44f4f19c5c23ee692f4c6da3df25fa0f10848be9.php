<?php
    // Start the session
    session_start();
?>

<!DOCTYPE html>
<html lang="<?php echo e(str_replace('_', '-', app()->getLocale())); ?>">

    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Player</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">
        <!-- Bootstrap -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>
        <!-- Styles -->
        <link href="css/playerbladestyle.css" rel="stylesheet">
        <link href="css/style.css" rel="stylesheet">

        
    </head>

    <body>
        <div id="logo"><h2>Songerr</h2></div>
       <div  class="flex-center position-ref full-height">
            <?php if(Route::has('login')): ?>
            
                <div class="top-right links">
                    <?php if(auth()->guard()->check()): ?>
                        <a href="<?php echo e(url('/home')); ?>">Home</a>
                    <?php else: ?>
                        <a href="<?php echo e(route('login')); ?>">Login</a>

                        <?php if(Route::has('register')): ?>
                            <a href="<?php echo e(route('register')); ?>">Register</a>
                        <?php endif; ?>
                    <?php endif; ?>
                </div>
            <?php endif; ?>
        </div>
<div class="left-panel">
    
    
                
            <!-- Formularz wyszukiwania utworów -->
            <form action="" method="GET" name="search_form">
                <div class="input-group mb-3 w-50 mx-auto">
                    <input class="form-control" type="text" size="60" name="k" value="<?php if (isset($_GET['k'])) echo $_GET['k']; ?>" />
                    <div class="input-group-append">
                        <button class="btn btn-success" type="submit">Szukaj</button>
                    </div>
                </div>
            </form>

            <?php

                // Wyszukiwanie utworów

                if(isset($_GET['k']) && $_GET['k'] != ''){
                    $k = trim($_GET['k']);
                    $keywords = explode(' ', $k);
                    
                    $query = "SELECT idsongs ,s.title as tytul,s.genre,s.likes, name, a.title FROM songs s, users, albums a WHERE ";

                    foreach($keywords as $word){
                        $query .= "s.title LIKE '%" . $word . "%' OR ";
                    }

                    $query = substr($query, 0, strlen($query) - 3);

                    $connect=mysqli_connect('localhost', 'root', '', 'medium_strumieniowe');

                    if(!$connect){
                        echo 'Błąd połączenia z serwerem';
                    }
                    else{
                        $result = mysqli_query($connect, $query);
                        $result_count = mysqli_num_rows($result);

                        if($result_count > 0){
                            echo 'Znaleziono wyników pasujących do wyszukiwania: ' . $result_count . '<hr class="bg-success">';

                            echo '<table class="table table-hover table-borderless">';
                            echo '<thead>
                                    <tr>
                                        <th>Tytuł</th>
                                        <th class="srodek">Album</th>
                                        <th class="srodek">Autor</th>
                                        <th class="srodek">Gatunek</th>
                                        <th class="srodek">Polubienia</th>
                                    </tr>
                                </thead><tbody>';

                            while($row = mysqli_fetch_assoc($result)){
                                echo '<tr>
                                        <td><a href="?songid='.$row['idsongs'].'">'.$row['tytul'].'</a></td>
                                         <td class="srodek"><a href="?songid='.$row['idsongs'].'">'.$row['title'].'</a></td>
                                        <td class="srodek"><a href="?songid='.$row['idsongs'].'">'.$row['name'].'</a></td>
                                        <td class="srodek"><a href="?songid='.$row['idsongs'].'">'.$row['genre'].'</a></td>
                                        <td class="srodek"><a href="?songid='.$row['idsongs'].'">'.$row['likes'].'</a></td>
                                    </tr>';
                            }

                            echo '</tbody></table>';

                        }
                        else{
                            echo "Brak wyników wyszukiwania";
                        }
                    }
                }
            ?>
                
        </div>
        <?php 
            $odtwarzacz = new Player();
            //$odtwarzacz ->show_jukebox();
            //Przekazuje referencje do odtwarzacza liście odtwarzania
            if(isset($_GET["songid"])) {
                $id = htmlspecialchars($_GET["songid"]);
                   $connect=mysqli_connect('localhost','root','','medium_strumieniowe');
		if(!$connect)
		{
			echo 'Błąd połączenia z serwerem';
		}
		 $query = "SELECT idsongs,a.title as author,s.title,s.source as songsource,u.name, c.source as coversource, s.genre, s.likes FROM `songs` s"
                         . " INNER JOIN users u ON s.author = u.id"
                         . " LEFT JOIN covers c on s.cover = c.idcovers "
                         . " LEFT JOIN albums a on s.album = a.idalbums "
                         . " WHERE idsongs=".$id;

		  $r=mysqli_query($connect,$query);
                   echo '<table class="table table-hover table-borderless">';
                            echo '<thead>
                                        <th class="srodek">Tytuł</th>
                                        
                                        <th class="srodek">Autor</th>
                                        <th class="srodek">Gatunek</th>
                                        <th class="srodek">Album</th>
                                        <th class="srodek">Polubienia</th>
                                    </tr>
                                </thead>';
                     while($row=mysqli_fetch_assoc($r))
                     {
                         echo '<tr>';
                            echo '<th class="srodek">'.$row['title'].'</th>';
                            
                            echo '<th class="srodek">'.$row['name'].'</th>';
                            echo '<th class="srodek">'.$row['genre'].'</th>';
                            echo '<th class="srodek">'.$row['author'].'</th>';
                            echo '<th class="srodek">'.$row['likes'].'</th>';
                            echo '<th><button id="like"><img src="img/like.png" height="60%" width="60%"></button></th>';
                            echo '<th class="srodek"><img id="cover" src="'.$row['coversource'].'" height="50px" width="50px" /></th>';
                            
                     }
                     echo '<tbody>';
                     //Zkonwertuj tablice php na javascript
                     
                 
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
<?php /**PATH C:\xampp\htdocs\projekt_zespolowy(stable)\resources\views/player.blade.php ENDPATH**/ ?>