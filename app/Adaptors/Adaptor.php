<?php

namespace App\Adaptors;

use App\User;
use SocialiteProviders\Manager\OAuth2\User as UserOAuth;


class Adaptor{
    public function getUserBySocId(UserOAuth $user, string $socName){

//изменить доступ к роутам


        $userInSysiem = User::query()
            ->where('id_in_soc', $user->id)
            ->where('type_auth', $socName)
            ->first();
            dd($userInSysiem);
    }
}
