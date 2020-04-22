<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Socialite;

//        http://laravel.local/auth/vk/response

class SocialLoginController extends Controller
{
    public function loginVK(){
        return Socialite::with('vkontakte')->redirect();
    }
    public function responseVK(){
        $user = Socialite::driver('vkontakte')->user();
        dd($user);
    }
}
