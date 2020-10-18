<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Auth;
use Validator;
use File;
class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return $this->showView();
        
    }
    public function showView()
    {
                //return view('home');
        //pobierz utwory danego użytkownika
        $songs = DB::table('songs')->where('author','=',Auth::user()->id)->get();
        //pobierz playlisty danego użytkownika
        $playlists = DB::table('playlists')->where('author','=',Auth::user()->id)->get();
        $albums = DB::table('albums')->where('author','=',Auth::user()->id)->get();
        return view('home',['songs'=>$songs,'playlists'=>$playlists,'albums'=>$albums]);
    }
    public function addSong($request)
    {
        $data = $request->validate([
            'title' => 'required|max:45',
            'source' => 'required',
        ]);
        $validator = Validator::make($request->all(), [
            'source' => 'required|mimes:mpga,wav',
            'cover' => 'mimes:jpeg,jpg,png',
        ]);
        if(!is_dir('uploads/'.Auth::user()->id))
                {
                    mkdir ( 'uploads/'.Auth::user()->id);
                }
        if(!is_dir('covers/'.Auth::user()->id))
                {
                    mkdir ( 'covers/'.Auth::user()->id);
                }
        $file = $request->file('source');
        $filename = Auth::user()->id.time().".".$file->getClientOriginalExtension();
        $source = $request->file('source')->storePubliclyAs('uploads/'.Auth::user()->id,$filename);
        $cover=null;
        if($request['cover']!=null)
        {
            $filecover = $request->file('cover');
            $filecovername = Auth::user()->id.time().".".$filecover->getClientOriginalExtension();
            $coversource = $request->file('cover')->storePubliclyAs('covers/'.Auth::user()->id,$filecovername);
            $cover = DB::table('covers')->insertGetId(
            ['source' => '../storage/app/'.$coversource, 'name'=>$filecovername]
            );
        }
       //Baza danych
        $id = DB::table('songs')->insertGetId(
            ['source' => '../storage/app/'.$source, 'title' => $request['title'],'author' =>Auth::user()->id,
                'album'=> $request['album'],'genre'=> $request['genre'],'feat' =>$request['feat'],
                'license' => $request['license'],'cover'=>$cover]
        );
        //okładka
        
        $succes = '<h1>Wysłano</h1><br/>'.
                '<h2><a href="#">Powrót dp strony</a></h2>';
        return $succes;
    }
    
    //Dodaj album
    public function addAlbum($request)
    {
        $data = $request->validate([
            'title' => 'required|max:45',
        ]);
        $validator = Validator::make($request->all(), [
            'cover' => 'mimes:jpeg,jpg,png',
        ]);
        $cover=null;
         if($request['cover']!=null)
        {
            $filecover = $request->file('cover');
            $filecovername = Auth::user()->id.time().".".$filecover->getClientOriginalExtension();
            $coversource = $request->file('cover')->storePubliclyAs('covers/'.Auth::user()->id,$filecovername);
            $cover = DB::table('covers')->insertGetId(
            ['source' => '../storage/app/'.$coversource, 'name'=>$filecovername]
            );
        }
        
        $id = DB::table('albums')->insertGetId(
            ['title' => $request['title'],'author' =>Auth::user()->id,
                'genre'=> $request['genre'],'cover' =>$cover
              ]
        );
        
        $succes = '<h1>Wysłano</h1><br/>'.
                '<h2><a href="#">Powrót dp strony</a></h2>';
        return $succes;
    }
    private function ispublic($request)
    {
        if($request['public']=="publiczna")
        {
            return true;
        }
         
        return false;
    }
    public function addPlaylist($request)
    {
       
        $data = $request->validate([
            'name' => 'required|max:100',
        ]);
         if($request['name']!=null)
        {
             if($this->ispublic($request))
             {
                    $playlist = DB::table('playlists')->insertGetId(
               ['playlistName' => $request['name'],
                   'author'=>Auth::user()->id,
                   'ispublic' => 1]
               );
             }
             else
             {
                  $playlist = DB::table('playlists')->insertGetId(
               ['playlistName' => $request['name'],
                   'author'=>Auth::user()->id,
                   'ispublic' => 0]
               );
                  
             }
        }
        
        
        $succes = '<h1>Wysłano</h1><br/>'.
                '<h2><a href="#">Powrót dp strony</a></h2>';
        return dd('test');
    }
    
    public function send_data(Request $request)
    {
        if(isset($request['addSong']))
        {
            $this->addSong($request);
        }
        else if(isset($request['addAlbum']))
        {
            $this->addAlbum($request);
        }
        else if(isset($request['addPlaylist']))
        {
            
            $this->addPlaylist($request);
        }
        //tworzenie katalogu użytkownika jeśli nie istnieje
        
    }
}
