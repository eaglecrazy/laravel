<?php

namespace App\Http\Controllers;

use App\Adaptors\Adaptor;
use Illuminate\Http\Request;
use Socialite;

//        http://laravel.local/auth/vk/response

class SocialLoginController extends Controller
{
    public function loginVK()
    {
        return Socialite::with('vkontakte')->redirect();
    }

    public function responseVK(Adaptor $userAdaptor)
    {
        try {
            $user = Socialite::driver('vkontakte')->user();
        } catch (InvalidStateException $exception) {
            dd($exception);
        }
        $user = $userAdaptor->getUserBySocId($user, 'vk');

        if ($user === 'emailerror') {
            $alert = ['type' => 'danger', 'text' => 'Пользователь с таким e-mail уже зарегистрирован. Авторизуйтесь по логину и паролю.'];
            return redirect()->route('login')->with('alert', $alert);
        }

        \Auth::login($user);
        return redirect()->route('Home');
    }
}
