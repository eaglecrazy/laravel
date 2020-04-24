<?php

namespace App\Http\Controllers;

use App\Adaptors\Adaptor;
use Illuminate\Http\Request;
use Socialite;

//        http://laravel.local/auth/vk/response

class SocialLoginController extends Controller
{
    public function login($social){
        return Socialite::with($social)->redirect();
    }

    public function response($social, Adaptor $userAdaptor)
    {
        try {
            $user = Socialite::driver($social)->user();
        } catch (\Exception $exception) {
            abort(404);
        }

        $user = $userAdaptor->getUserBySocId($user, $social);

        if (is_string($user)) {
            $alert = ['type' => 'danger', 'text' => "Пользователь с таким e-mail уже зарегистрирован. Авторизуйтесь через $user."];
            return redirect()->route('login')->with('alert', $alert);
        }

        \Auth::login($user);
        return redirect()->route('Home');
    }




}
