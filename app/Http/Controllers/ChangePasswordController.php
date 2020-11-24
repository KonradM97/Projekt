<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Rules\MatchOldPassword;

use Illuminate\Support\Facades\Hash;
use Validator;
use App\User;
use Illuminate\Support\Facades\DB;
use Auth;

class ChangePasswordController extends Controller

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

        view('messages',array('result' => "Yes"));

    } 

   

    /**

     * Show the application dashboard.

     *

     * @return \Illuminate\Contracts\Support\Renderable

     */

    public function store(Request $request)

    {
        $validator =Validator::make($request->all(), [
            'current_password' => ['required', new MatchOldPassword],

            'new_password' => ['required'],

            'new_confirm_password' => ['same:new_password']
        ]);
        if($validator->fails())
        {
            return view('home',array('error' => 'Złe dane w zmianie hasła!'));
        }
   

        User::find(auth()->user()->id)->update(['password'=> Hash::make($request->new_password)]);
        DB::update("UPDATE `users` SET `password` = '".Hash::make($request->new_password)."' WHERE `id` = ".Auth::user()->id); 
   

        return view('home',array('user' => Auth::user(),'resultstatus' => "Zmieniono!"));

    }

}