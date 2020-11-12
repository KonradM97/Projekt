<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Auth;
use Validator;
use Image;
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
    public function like(Request $request)
    {
        //console.log($request);
    }
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
    public function addSong(Request $request)
    {
        $data = $request->validate([
            'title' => 'required|max:45',
            'source' => 'required',
        ]);
        
        $validator = Validator::make($request->all(), [
            'source' => 'required|mimetypes:audio/mp3,application/octet-stream,audio/ogg,audio/wav',
            'title' => 'required|min:3,max:45'
        ]);
        if($validator->fails())
        {
            return view('home',array('error' => 'Błąd w nazwie lub typie pliku!'));
        }
        else
        {
        if(!is_dir('../storage/app/uploads/'.Auth::user()->id))
                {
                    mkdir ( '../storage/app/uploads/'.Auth::user()->id);
                }
        if(!is_dir('../storage/app/uploads/covers/'.Auth::user()->id))
                {
                    mkdir ( '../storage/app/uploads/covers/'.Auth::user()->id);
                }
        $file = $request->file('source');
        $filename = Auth::user()->id.time().".".$file->getClientOriginalExtension();
        $source = $request->file('source')->storePubliclyAs('uploads/'.Auth::user()->id,$filename);
        $cover=null;
        if($request['cover']!=null)
        {
            $filecover = $request->file('cover');
            $filecovername = Auth::user()->id.time().".".$filecover->getClientOriginalExtension();
            $coversource = $request->file('cover')->storePubliclyAs('uploads/covers/'.Auth::user()->id,$filecovername);
            $cover = DB::table('covers')->insertGetId(
            ['source' => '../storage/app/'.$coversource]
            );
        }
       //Baza danych
        $id = DB::table('songs')->insertGetId(
            ['source' => '../storage/app/'.$source, 'title' => $request['title'],'author' =>Auth::user()->id,
                'album'=> $request['album'],'genre'=> $request['genre'],'feat' =>$request['feat'],
                'license' => $request['license'],'cover'=>$cover]
        );
        //okładka
        }
        return view('home',array('user' => Auth::user()));
    }
    
    //Dodaj album
    public function addAlbum(Request $request)
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
        
        return view('home',array('user' => Auth::user()));
    }
    private function ispublic($request)
    {
        if($request['public']=="publiczna")
        {
            return true;
        }
         
        return false;
    }
    public function addPlaylist(Request $request)
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
        
        
        return view('home',array('user' => Auth::user()));
    }
    public function update_avatar(Request $request)
    {
        if($request->hasFile('avatar')){
            $avatar = $request->file('avatar');
            $filename = Auth::user()->id.time().$avatar->getClientOriginalExtension();
            if(!is_dir('../storage/app/uploads/avatars/'.Auth::user()->id))
                {
                    mkdir ( '../storage/app/uploads/avatars/'.Auth::user()->id);
                }
            Image::make($avatar)->resize(300,300)->save(public_path('../storage/app/uploads/avatars/'.Auth::user()->id.'\\'.$filename));
            $user = Auth::user();
            $user->avatar = '../storage/app/uploads/avatars/'.Auth::user()->id.'/'.$filename;
            $user->save();
        }
        
       return view('home',array('user' => Auth::user()));
    }
}
