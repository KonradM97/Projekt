@extends('layouts.app')

<?php
    // Start the session
    session_start();
?>

@section('content');
<div class="container text-white">
                
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

            $query = "SELECT * FROM songs WHERE ";

            foreach($keywords as $word){
                $query .= "title LIKE '%" . $word . "%' OR ";
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
                                <th class="srodek">Autor</th>
                                <th class="srodek">Gatunek</th>
                                <th class="srodek">Polubienia</th>
                            </tr>
                        </thead><tbody>';

                    while($row = mysqli_fetch_assoc($result)){
                        echo '<tr>
                                <td>'.$row['title'].'</td>
                                <td class="srodek">'.$row['author'].'</td>
                                <td class="srodek">'.$row['genre'].'</td>
                                <td class="srodek">'.$row['likes'].'</td>
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
@endsection
