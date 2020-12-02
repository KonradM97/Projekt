<?php
//Głośność, trwający utwór i play
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Player
 *
 * @author Konrad
 */


class Player {
    //dostęp do źródeł
    private $album;
	private $titles=array();
	private $sources=array();
        private $authors=array();
        private $authorsId=array();
        private $covers=array();
        private $ids=array();
        private $jukebox_size;
        //dodanie polubień 26.10
        private $likes=array();
        //
            function __construct() {
                //Na starcie
                if(!isset($_GET['songid'])&&!isset($_GET['playlist'])&&!isset($_GET['album']))
                {
                   $this->fetch_most_liked();
                }
                else if(isset($_GET['songid']))
                {
                    $id=htmlspecialchars($_GET['songid']);
                    if($this->validate($id))
                    {
                        $this->fetch_song($id);
                    }
                    else
                    {
                        $this->fetch_most_liked();
                    }
                }
                else if(isset($_GET['playlist']))
                {
                    $id= htmlspecialchars($_GET['playlist']);
                    if($this->validate($id))
                    {
                        $query = "SELECT ispublic,author FROM playlists WHERE idplaylists=".$id;

                    $connect=mysqli_connect('localhost','root','','medium_strumieniowe');
		            $r=mysqli_query($connect,$query);
                     while($row=mysqli_fetch_assoc($r))
                     {
                            if($row['ispublic']==0&&Auth::user()->id!=$row['author'])
                            {
                                $this->fetch_most_liked();
                            }
                            else
                            {
                                $this->fetch_playlist($id);
                            }
                     }
                       
                    }
                    else
                    {
                        $this->fetch_most_liked();
                    }
                }
                else if(isset($_GET['album']))
                {
                    $id= htmlspecialchars($_GET['album']);
                    if($this->validate($id))
                    {
                        $this->fetch_album($id);
                    }
                    else
                    {
                        $this->fetch_most_liked();
                    }
                }
                $this->fetch_likes();
                $this->transferArrays();
                $this->showPlayer();
                ?>

        <?php
                
	}
        //walidator dla id (liczby)
        private function validate($id) {
            if (filter_var($id, FILTER_VALIDATE_INT)) {
                return true;
            } else {
                return false;
            }
        }
        public function fetch_most_liked() {
                    
                   

                     $connect=mysqli_connect('localhost','root','','medium_strumieniowe');
                    if(!$connect)
                    {
                            echo 'Błąd połączenia z serwerem';
                            return;
                    }
                     $query = "SELECT idsongs,author,title,s.source as songsource,u.name, c.source as coversource FROM `songs` s"
                             . " INNER JOIN users u ON s.author = u.id "
                             . "LEFT JOIN covers c on s.cover = c.idcovers "
                             . "ORDER BY `likes` DESC LIMIT 10";

                     $r=mysqli_query($connect,$query);
                     while($row=mysqli_fetch_assoc($r))
                     {
                            $this->ids[]=$row['idsongs'];
                            $this->titles[]= $row['title'];
                            $this->sources[]= $row['songsource'];
                            $this->authors[] = $row['name'];
                            $this->covers[] = $row['coversource'];
                            $this->authorsId[] = $row['author'];
                     }
                     $this->jukebox_size=count($this->ids);
                     //Zkonwertuj tablice php na javascript
                     
                     
                     //$this->alarm();
        }

        public function fetch_song($id)
        {
            
		 $connect=mysqli_connect('localhost','root','','medium_strumieniowe');
		if(!$connect)
		{
			echo 'Błąd połączenia z serwerem';
		}
		 $query = "SELECT idsongs,author,title,s.source as songsource,u.name, c.source as coversource FROM `songs` s"
                         . " INNER JOIN users u ON s.author = u.id"
                         . " LEFT JOIN covers c on s.cover = c.idcovers "
                         . "WHERE idsongs=".$id;

		  $r=mysqli_query($connect,$query);
                     while($row=mysqli_fetch_assoc($r))
                     {
                            $this->ids[]=$row['idsongs'];
                            $this->titles[]= $row['title'];
                            $this->sources[]= $row['songsource'];
                            $this->authors[] = $row['name'];
                            $this->covers[] = $row['coversource'];
                            $this->authorsId[] = $row['author'];
                     }
                     $this->jukebox_size=count($this->ids);
                     //Zkonwertuj tablice php na javascript
                     
                     
                 return true;
        }

        public function fetch_playlist($id)
        {
            
                $this->titles=array();
                $this->sources=array();
                 $this->authors=array();
                $this->authorsId=array();
                $this->covers=array();
                 $this->ids=array();
		//weź ostatnin nutwór użytkownika
		 $connect=mysqli_connect('localhost','root','','medium_strumieniowe');
		if(!$connect)
		{
			echo 'Błąd połączenia z serwerem';
		}
		 $query = "SELECT idsongs,a.author,s.title,s.source as songsource,u.name, c.source as coversource FROM `songs` s"
                         . " LEFT JOIN albums a ON s.album = a.idalbums  LEFT JOIN users u ON s.author = u.id"
                         . "  LEFT JOIN covers c on s.cover = c.idcovers "
                         . "WHERE s.idsongs IN "
                         . "(SELECT song from songs_in_playlists sip WHERE sip.playlist=".$id.")";

		 $r=mysqli_query($connect,$query);
		 while($row=mysqli_fetch_assoc($r))
		 {
                        $this->ids[]=$row['idsongs'];
			$this->titles[]= $row['title'];
			$this->sources[]= $row['songsource'];
			$this->authors[] = $row['name'];
                        $this->covers[] = $row['coversource'];
                        $this->authorsId[] = $row['author'];
		 }
                 $this->jukebox_size=count($this->ids);
                 //Zkonwertuj tablice php na javascript
                 

                 //$this->refresh_player();
                // $this->set_song_by_index($index);  
                 return true;
        }
        public function fetch_album($id)
        {
            
                $this->titles=array();
                $this->sources=array();
                 $this->authors=array();
                $this->authorsId=array();
                $this->covers=array();
                 $this->ids=array();
		 $connect=mysqli_connect('localhost','root','','medium_strumieniowe');
		if(!$connect)
		{
			echo 'Błąd połączenia z serwerem';
                        return;
		}
		 $query = "SELECT idsongs,a.author,s.title,s.source as songsource,u.name, c.source as coversource FROM `songs` s"
                         . " INNER JOIN albums a ON s.album = a.idalbums"
                         . " LEFT JOIN users u ON s.author = u.id "
                         . "LEFT JOIN covers c on s.cover = c.idcovers WHERE a.idalbums=".$id;

		 $r=mysqli_query($connect,$query);
		 while($row=mysqli_fetch_assoc($r))
		 {
                        $this->ids[]=$row['idsongs'];
			$this->titles[]= $row['title'];
			$this->sources[]= $row['songsource'];
			$this->authors[] = $row['name'];
                        $this->covers[] = $row['coversource'];
                        $this->authorsId[] = $row['author'];
		 }
                 $this->jukebox_size=count($this->ids);
                 //Zkonwertuj tablice php na javascript
                 

                 //$this->refresh_player();
                // $this->set_song_by_index($index);  
                 return true;
        }
        public function fetch_likes()
        {
            if(isset(Auth::user()->id))
                {
                   $userId = Auth::user()->id;
                   $connect=mysqli_connect('localhost','root','','medium_strumieniowe');
                    if(!$connect)
                    {
                        echo 'Błąd połączenia z serwerem';
                        return;
                    }
                    //Wyciągnij tylko polubienia użytkownika
                    $query ="SELECT userId,songId FROM `likes` where userId=".$userId;
                    for($i=0;$i<count($this->ids);$i++)
                        {
                                $this->likes[$i]=false; 
                                
                        }
                    $r=mysqli_query($connect,$query);
                    while($row=mysqli_fetch_assoc($r))
                    {
                        for($i=0;$i<count($this->ids);$i++)
                        {
                            if($this->ids[$i]==$row['songId'])
                            {
                                $this->likes[$i]=true;
                                
                            }
                            
                        }
                    }
                }
                else
                {
                    return;
                }
            
        }
        //do debugowania
        function alarm()
        {
            ?>
<script type="text/javascript">alert("w7ywol");</script>
        <?php
            }
        
        //Konwersja tablicy na tą dla javascript
        
        function transferArrays()
        {
            ?>
                <script type="text/javascript">
                    
                var songs = <?php echo json_encode($this->sources); ?>;
                 var titles = <?php echo json_encode($this->titles); ?>;
                  var authors = <?php echo json_encode($this->authors); ?>;
                  var authorsids =  <?php echo json_encode($this->authorsId); ?>;
                  var ids = <?php echo json_encode($this->ids); ?>;
                   var p_size = <?php echo json_encode($this->jukebox_size); ?>;
                   var covers = <?php echo json_encode($this->covers); ?>;
                   var likes= <?php echo json_encode($this->likes); ?>;
                   var currentSong = 0;
                   //Dostanie id użytkownika który teraz korzysta z playera
                   var myId = <?php
                    if(isset(Auth::user()->id))
                    {
                        echo json_encode(Auth::user()->id);
                    }
                    else
                    {
                        echo json_encode(null);
                    }
                   ?>;
                    
                  var shuffled_songs=songs.slice();
                 var shuffled_songsTitle=titles.slice();
                  var shuffled_author=authors.slice();
                  var shuffled_authorids = authorsids.slice();
                   var shuffled_covers = covers.slice();
                   
                </script>
                
                <?php
                            
        }
        
    
        

    //Pokaż odtwarzacz
    
    function showPlayer()
    {
    ?>
                <link href="css/playerstyle.css" rel="stylesheet"/>
                  <script src="https://code.jquery.com/jquery-3.5.0.js"></script>
                <link href="css/jukeboxstyle.css" rel="stylesheet"/>
                <div id="main">
                    
	<div  id="jukebox">
            <h2>Kolejka</h2>
            
            <div id="songs">
                <script type="text/javascript">
                       for(var step=0;step<p_size;step++){
                           document.write("<div id='song'>");
                           document.write("<a href='#' onclick='index("+step+")'>");
                           document.write(shuffled_songsTitle[step]);
                           document.write("</a>");
                           document.write("<div class='autor'> by ");
                           document.write(shuffled_author[step]);
                           document.write("</div></div><br/>");
                           
                       }
                       function index(c)
                       {
                           currentSong=c;
                           song.src = songs[currentSong];
                            songTitle.textContent = titles[currentSong];
                            author.textContent = authors[currentSong];
                            if(covers[currentSong])
                            {
                                 document.getElementById("cover").src= covers[currentSong];   
                            }
                             else
                            {
                                document.getElementById("cover").src= "img/nullcover.png";
                            }
                            //26.10
                            if(likes[currentSong])
                            {
                                 document.getElementById("like").src="img/liked.png";
                            }
                            else
                            {
                                document.getElementById("like").src="img/like.png";
                            }
                            document.getElementById('playbutton').src='img/Pause.png';
                            song.play();
                       }
                </script>
                
            </div>
            
	</div>
                    <div id="options">
                            
                            <!-- Pasek głośności-->
                            
                            <!-- Guziki powtórzenia i losowania-->
                        <div id="atendofsong">
                            <button id="repeat" onclick="repeat()"><img id="replayButton" src="img/replay.png" height="90%" width="90%"/></button>
                            <button id="shuffle" onclick="shuffle()"><img id="shuffleButton" src="img/inorder.png" height="90%" width="90%"/></button>
                        </div>
                        </div>
                    <div id="player">
                        <!-- Guziki odtwarzacza-->
                        <div id="buttons">
                            <button id="pre" onclick="pre()"><img src="img/Pre.png" height="90%" width="90%"/></button>
                            <button id="play" onclick="playOrPauseSong()"><img id="playbutton" src="img/Play.png"/></button>
                            <button id="next" onclick="next()"><img src="img/Next.png" height="90%" width="90%"/></button>
                            
                            
                        </div>
                        <div id="rightButtons">
                        <img id="show" src="img/playlist.png" />
                        <img id="like" class="like" src="img/like.png"/>
                        </div>
                        <div id="image">
                            <img id="cover" src="img/nullcover.png"/>
                        </div>
                        
                        
                        <!-- Informacje o autorze i nazwie utworu-->
                        <div id="info">
                            
                           
                            <div id="songTitle">Demo</div><br/>
                             <div id="author">DemoAuthor</div>
                        </div>
                        
                    </div>
                    <div id="bar">
                        <!-- Postęp utworu-->
                        <div id="seek-bar">

                               <input type="range" min="1" max="300" value="1" class="slider" id="timeRange">
                        </div>
                        <div id="volume-bar">
                                <input type="range" min="0" max="100" value="80" class="slider" id="volRange">
                            </div>
                       <!-- <div id="time">0:00</div> czas nie działa właściwie-->
                    </div>
                    
                </div>
            </body>
            <script type="text/javascript">
                //Czy odpalony play
                var playing=false;
                ////pasek czasu utworu
                var fillBar = document.getElementById("fill");
		var progressBar = document.getElementById("timeRange");		
                var seekBar= document.getElementById("seek-bar");
                ///pasek głośności
                var volBar = document.getElementById("volRange");
                document.getElementById("volRange").oninput = function() {
                    this.style.background = 'linear-gradient(to right, #82CFD0 0%, #82CFD0 ' + this.value + '%, #fff ' + this.value + '%, white 100%)'
                  };
                $(window).on("load resize", function() {
                var sliderWidth = $('[type=range]').width();
                $('.custom-style-element-related-to-range').remove();
                $('<style class="custom-style-element-related-to-range">input[type="range"]::-webkit-slider-thumb { box-shadow: -' + sliderWidth + 'px 0 0 ' + sliderWidth + 'px;}<style/>').appendTo('head');
              });
              var p = volBar.value;
                var t = progressBar;
              //początek//////////////
                $(document).ready(function(){
                    $('#jukebox').slideUp(0);
                    var p = volBar.value;
                    var t = progressBar;
                    //początkowy dźwięk
                    if (typeof(Storage) !== "undefined") {
                    // Retrieve
                    p = sessionStorage.getItem("volume");
                    
                    volBar.value=p;
                    t = sessionStorage.getItem("time");
                    }
                    
                    modifyVolume(p);
                    $['S']
                });
                var showed=false;
                $( "#show" ).click(function() {
                    
                    if(showed)
                    {
                            $( "#jukebox" ).slideUp( "slow","swing","complete");
                        showed=false;
                    }
                    else
                    {
                            $( "#jukebox" ).slideDown( "slow","swing","complete");
                        showed=true;
                    }
                  });
                //kliknięcie polubienia
                    $(".like").click(function() {
                        if(myId!=null)
                        {
                            event.preventDefault();
                            var isLike = event.target.previousElementSibling == null;
                            $.ajaxSetup({
                                headers: {
                                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                }
                            });
                            $.ajax({
                                type: "POST",
                                url: "like",
                                data: '{"islike":true,"songId":'+ids[currentSong]+'}',
                                contentType: "application/json; charset=utf-8",
                                dataType: "json"
                            });
                            if(!likes[currentSong])
                            {
                                document.getElementById("like").src="img/liked.png";
                                likes[currentSong]=true;
                            }
                            else
                            {
                                document.getElementById("like").src="img/like.png";
                                likes[currentSong]=false;
                            }
                            
                        }
                        else
                        {
                            alert('Zaloguj się by móc polubić utwór!');
                        }
                    });
                
                var activeBar = false; 
                var activetBar = false; 
                //

                var song = new Audio();//Obiekt odpowiedzialny za muzykę
                         
                var repeatPressed = 1; //czy włączony repeat
                var shufflePressed = false; //czy włączone losowe wybieranie
                //
                //Odtwórz przy odpaleniu strony
                
               
               //Pobierz dane utworu do odtwarzacza
                 function playSong(){
                     if(!shufflePressed){
                         song.src = songs[currentSong];
                         songTitle.textContent = titles[currentSong];
                         author.textContent = authors[currentSong];
                            song.play();
                         
                         }
                     else{
                        
                        song.src = shuffled_songs[currentSong];
                        songTitle.textContent = shuffled_songsTitle[currentSong];
                        author.textContent = shuffled_author[currentSong];
                        
                        }
                     
                    //pobierz okładkę
                     if(!shufflePressed){
                          //Jeśli utwór ma okładkę
                            if(covers[currentSong])
                            {
                                 document.getElementById("cover").src= covers[currentSong];   
                            }
                             else
                            {
                                document.getElementById("cover").src= "img/nullcover.png";
                            }    
                        }
                        else
                        {
                             //Jeśli utwór ma okładkę
                            if(shuffled_covers[currentSong])
                            {
                                 document.getElementById("cover").src= shuffled_covers[currentSong];   
                            }
                             else
                            {
                                document.getElementById("cover").src= "img/nullcover.png";
                            }    
                                
                        }
                       //Pobierz polubienie
                       //26.10
                            if(likes[currentSong])
                            {
                                document.getElementById("like").src="img/liked.png";
                                 
                                 
                            }
                            else
                            {
                               
                                document.getElementById("like").src="img/like.png";
                            }
                       
                    
                }
                //Przy załadowaniu strony
                window.onload = playSong();
		//Wybiera co zrobić po kliknięciu play/pause
                function playOrPauseSong(){
                    if(song.paused){
                        song.play();
                        if (typeof(Storage) !== "undefined") {
                        // Store
                        sessionStorage.setItem("start", true);
                        }
                        document.getElementById('playbutton').src='img/Pause.png';
                    }
                    else{
                        song.pause();
                        sessionStorage.setItem("start", false);
                        document.getElementById('playbutton').src='img/Play.png';
                    }
                }
                
                
                song.addEventListener('timeupdate',function(){ 

                    var position = song.currentTime / song.duration;
                    
                    //document.getElementById('time').textContent = song.currentTime //pasek czasu na razie nieaktywny bo potrzebuje funkcji rozkładające
                    //
                    //Postęp paska utworu w czasie
                    //progressBar.setAttribute('value',position*300);
                    progressBar.value = position*300;
                    if (typeof(Storage) !== "undefined") {
                    // Store
                    sessionStorage.setItem("time", position*300);
                    }
                    //powtórz 1
                    if(song.currentTime==song.duration&&repeatPressed == 0)
                    {
                        song.play();
                    }
                    //nie powtarzaj
                    else if(song.currentTime==song.duration&&repeatPressed == 1)
                    {
                        if(currentSong <p_size-1){
                        currentSong++;
                        playSong();
                        }

                        
                    }
                    //powtórz całą playlistę
                    else if(song.currentTime==song.duration&&repeatPressed  == 2)
                    {
                        if(currentSong <p_size-1){
                        currentSong++;
                        }
                        else if(currentSong == p_size-1){
                        currentSong=0;
                        }
                        playSong();
                    }
                });
                /////////////////////////////////////////////////
                    //Zmiana przycisku powtórz
                   function repeat()
                   {
                       if(repeatPressed == 0){
                           document.getElementById('repeat').style.background = "gray";
                            document.getElementById('replayButton').src = 'img/replay.png';
                        repeatPressed = 1;
                    }
                    else if(repeatPressed == 1){
                        document.getElementById('repeat').style.background = "lightgray";
                         repeatPressed = 2;
                    }
                    else{                  
                        document.getElementById('repeat').style.background = "lightgray";
                        document.getElementById('replayButton').src = 'img/replayone.png';
                         repeatPressed = 0;
                    }
                }
                   //pomieszanie utworów
                   function shufflearray(a,b,c,d,e) {
                        for (let i = a.length - 1; i > 0; i--) {
                            const j = Math.floor(Math.random() * (i + 1));
                            [a[i], a[j]] = [a[j], a[i]];
                            [b[i], b[j]] = [b[j], b[i]];
                            [c[i], c[j]] = [c[j], c[i]];
                            [d[i], d[j]] = [d[j], d[i]];
                            [e[i], e[j]] = [e[j], e[i]];
                        }
                        
                    }
                    //Przucisk mieszania
                   function shuffle()
                   {
                       if(shufflePressed == false){
                        document.getElementById('shuffle').style.background = "lightgray";
                        document.getElementById('shuffleButton').src = 'img/random.png';
                        shufflePressed = true;
                        
                        shufflearray(shuffled_songs,shuffled_songsTitle,shuffled_author,shuffled_authorids,shuffled_covers);
                       
                    }
                    else{
                        document.getElementById('shuffle').style.background = "gray";
                        document.getElementById('shuffleButton').src = 'img/inorder.png';
                        shufflePressed = false;
                    }
                   }
                   
                   ///////////////Następny i poprzedni utwór
                   function next(){
                    if(currentSong <p_size-1){
                        
                            currentSong++;
                        playSong();
                    }
                    else if(currentSong == p_size-1){
                        if(repeatPressed == 2)
                        {
                            currentSong=0;
                        }
                    }
                    playSong();
                    document.getElementById('playbutton').src='img/Pause.png';
                     }
                function pre(){
                    if(currentSong > 0){
                        currentSong--;
                    }
                    playSong();
                    document.getElementById('playbutton').src='img/Pause.png';
                }
                /////////////////////////Obsługa paska czasu utworu////////////////////

                    function getPosition () {
					let p = (seekBar.offsetLeft) / seekBar.clientWidth;
					p = clamp(0, p, 1);
					return p;
				}
				 function modifyTime(p) {
					//fillBar.style.width = p * 100 + '%';
					song.currentTime = p * song.duration;
                                        progressBar.value = p * 300;
				}
				progressBar.addEventListener("click",function (e){
					let p = (e.clientX - seekBar.offsetLeft) / seekBar.clientWidth;
					modifyTime(p);
				},false);
                                
                //////////////////////////////obsługa paska głośności///////////
                 function modifyVolume(p) {
                    song.volume = p * 0.01;

                }
                volBar.addEventListener("click",function (e){
                    if (typeof(Storage) !== "undefined") {
                    // Store
                    sessionStorage.setItem("volume", volBar.value);
                    }
                    let p = volBar.value;
                    modifyVolume(p);
                },false);
                volBar.addEventListener("mousemove",function (e){
                    if (typeof(Storage) !== "undefined") {
                    // Store
                    sessionStorage.setItem("volume", volBar.value);
                    }
                        let p = volBar.value;
                        modifyVolume(p);
                },false);

            </script>
    <?php
    
    }
}