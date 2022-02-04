<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;
use App\Models\User;

class UserController extends Controller
{
    public function login()
    {
        return view('auth.user.login');
    }

    public function google()
    {
        return Socialite::driver('google')->redirect();
    }

    public function handleProviderCallback()
    {

        //return 'provider callback';
        $callback = Socialite::driver('google')->stateless()->user();
        $data = [
             'name' => $callback->getName(),
             'email' => $callback->getEmail(),
             'avatar' => $callback->getAvatar(),
             'email_verified_at' => date('Y-m-d H:i:s', time()),
         ];

         $user = User::firstOrCreate(['email'=> $data['email']], $data);
    }
}
