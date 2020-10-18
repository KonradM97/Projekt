<?php

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
	private $index;
            function __construct() {
                
                if(!isset($_GET['songid'])&&!isset($_GET['playlistid'])&&!isset($_GET['albumid']))
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
                else if(isset($_GET['playlistid']))
                {
                    $id= htmlspecialchars($_GET['playlistid']);
                    if($this->validate($id))
                    {
                        $this->fetch_playlist($id);
                    }
                    else
                    {
                                    $this->fetch_most_liked();
                    }
                }
                else if(isset($_GET['albumid']))
                {
                    $id= htmlspecialchars($_GET['albumid']);
                    if($this->validate($id))
                    {
                        $this->fetch_album($id);
                    }
                    else
                    {
                                    $this->fetch_most_liked();
                    }
                }
                $this->showPlayer();
                ?>

        <?php
                
	}
        
        private function validate($id) {
            if (filter_var($id, FILTER_VALIDATE_INT)) {
                return true;
            } else {
                return false;
            }
        }
        public function fetch_most_liked() {
             $_SESSION["first"]=false;
                    $this->index = 0;
                    //weź ostatnin nutwór użytkownika

                     $connect=mysqli_connect('localhost','root','','medium_strumieniowe');
                    if(!$connect)
                    {
                            echo 'Błąd połączenia z serwerem';
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
                     $this->transferArrays();
                     
                     //$this->alarm();
        }

        public function fetch_song($id)
        {
            $this->index = 0;
		//weź ostatnin nutwór użytkownika
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
                     $this->transferArrays();
                     
                 return true;
        }

        public function fetch_playlist($id)
        {
            $this->index = 0;
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
                 $this->transferArrays();

                 //$this->refresh_player();
                // $this->set_song_by_index($index);  
                 return true;
        }
        public function fetch_album($id)
        {
            $this->index = 0;
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
                 $this->transferArrays();

                 //$this->refresh_player();
                // $this->set_song_by_index($index);  
                 return true;
        }
        
        function alarm()
        {
            ?>
<script type="text/javascript">alert("w7ywol");</script>
        <?php
            }
        function transferArrays()
        {
            ?>
                <script type="text/javascript">
                    
                var songs = <?php echo json_encode($this->sources); ?>;
                 var titles = <?php echo json_encode($this->titles); ?>;
                  var authors = <?php echo json_encode($this->authors); ?>;
                  var authorsids =  <?php echo json_encode($this->authorsId); ?>;
                  
                   var p_size = <?php echo json_encode($this->jukebox_size); ?>;
                   var covers = <?php echo json_encode($this->covers); ?>;
                   
                   var currentSong = 0;
                   
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
                            document.getElementById('playbutton').src='img/Pause.png';
                            song.play();
                       }
                </script>
            </div>
            
	</div>
                    <div id="options">
                            
                            <!-- Pasek głośności-->
                            <div id="volume-bar">
                                <div id="vfill"></div>
                                <div id="vhandle"></div>
                            </div>
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
                             <button id="show" ><img src="img/playlist.png" height="90%" width="90%"/></button>
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
                                <div id="fill"></div>
                                <div id="handle"></div>
                        </div>
                        
                       <!-- <div id="time">0:00</div> czas nie działa właściwie-->
                    </div>
                    
                </div>
            </body>
            <script type="text/javascript">
                $(document).ready(function(){
                    $('#jukebox').slideUp(0);
                });
                var showed=false;
                $( "#show" ).click(function() {
                    if(showed)
                    {
                            $( "#jukebox" ).slideUp( "slow", function() {
                        });
                        showed=false;
                    }
                    else
                    {
                            $( "#jukebox" ).slideDown( "slow", function() {
                        });
                        showed=true;
                    }
                  });
                
                
                ////
                var fillBar = document.getElementById("fill");
				
                var seekBar= document.getElementById("seek-bar");
                ///
                var volfillBar = document.getElementById("vfill");
                var volBar= document.getElementById("volume-bar");
                var activeBar = false; 
                var activetBar = false; 
                //

                var song = new Audio();//Obiekt odpowiedzialny za muzykę
                var repeatPressed = 1; //czy włączony repeat
                var shufflePressed = false; //czy włączone losowe wybieranie
                window.onload = playSong();
               
               //Pobierz dane utworu do odtwarzacza i odtwórz
                 function playSong(){
                     if(!shufflePressed){
                         song.src = songs[currentSong];
                         songTitle.textContent = titles[currentSong];
                         author.textContent = authors[currentSong];//authors[currentSong];
                         start_it();
                         }
                     else{
                        song.src = shuffled_songs[currentSong];
                        songTitle.textContent = shuffled_songsTitle[currentSong];
                        author.textContent = shuffled_author[currentSong];
                        
                        }
                     
                    
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
                       
                       //Jeśli nie
                      
                    song.play();
                }
		//Wybiera co zrobić po kliknięciu play/pause
                function playOrPauseSong(){

                    if(song.paused){
                        song.play();
                        document.getElementById('playbutton').src='img/Pause.png';
                    }
                    else{
                        song.pause();
                        document.getElementById('playbutton').src='img/Play.png';
                    }
                }

                song.addEventListener('timeupdate',function(){ 

                    var position = song.currentTime / song.duration;
                    
                    //document.getElementById('time').textContent = song.currentTime //pasek czasu na razie nieaktywny bo potrzebuje funkcji rozkładające
                    //
                    //Po skończeniu utworu
                    fillBar.style.width = position * 100 +'%';
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
                        
                            document.getElementById('playbutton').src='img/Play.png';
                        
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
                   //pomieszane utwory
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
					fillBar.style.width = p * 100 + '%';
					song.currentTime = p * song.duration;
                                        
				}
				seekBar.addEventListener("click",function (e){
					let p = (e.clientX - seekBar.offsetLeft) / seekBar.clientWidth;
					modifyTime(p);
				},false);
                                seekBar.addEventListener("mousedown",function (e){
                                    activetBar = true;

                                },false);
                                seekBar.addEventListener("mousemove",function (e){
                                    if(activetBar == true){
                                        let p = (e.clientX - seekBar.offsetLeft) / seekBar.clientWidth;
					modifyTime(p);
                                    }
                                },false);
                                seekBar.addEventListener("mouseup",function (e){
                                    activetBar = false;
                                },false);
                //////////////////////////////obsługa paska głośności///////////
                 function modifyVolume(p) {
                    volfillBar.style.width = p * 100 + '%';
                    song.volume = 1*p;

                }
                volBar.addEventListener("click",function (e){
                    
                    let p = (e.clientX - volBar.offsetLeft) / volBar.clientWidth;
                    modifyVolume(p);
                },false);
                volBar.addEventListener("mousedown",function (e){
                    activeBar = true;
                    
                },false);
                volBar.addEventListener("mousemove",function (e){
                    if(activeBar == true){
                        let p = (e.clientX - volBar.offsetLeft) / volBar.clientWidth;
                        modifyVolume(p);
                    }
                },false);
                volBar.addEventListener("mouseup",function (e){
                    activeBar = false;
                },false);
                
            </script>
    <?php
    
    }
}
