<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Auth;
use Image;

class UserController extends Controller
{
    public function profile()
    {
        return view('profile', array('user' => Auth::user()));
    }
    
    public function update_avatar(Request $request)
    {
        if($request->hasFile('avatar')){
            $avatar = $request->file('avatar');
            $filename = Auth::user()->id.time().$avatar->getClientOriginalExtension();
            if(!is_dir('uploads/avatars/'.Auth::user()->id))
                {
                    mkdir ( 'uploads/avatars/'.Auth::user()->id);
                }
            Image::make($avatar)->resize(300,300)->save(public_path('uploads\\avatars\\'.Auth::user()->id.'\\'.$filename));
            $user = Auth::user();
            $user->avatar = 'uploads/avatars/'.Auth::user()->id.'/'.$filename;
            $user->save();
        }
        
       return view('profile',array('user' => Auth::user()));
    }
}
