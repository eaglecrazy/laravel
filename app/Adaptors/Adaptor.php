<?php

namespace App\Adaptors;

use App\User;
use SocialiteProviders\Manager\OAuth2\User as UserOAuth;


class Adaptor
{
    public function getUserBySocId(UserOAuth $oauth_user, string $socName)
    {
        //если юзер есть, то вернём его.
        $new_user = User::query()
            ->where('social_id', $oauth_user->id)
            ->where('type_auth', $socName)
            ->first();

        //проверка на уникальность email
        $email = $oauth_user->accessTokenResponseBody['email'];
        if(User::query()->where('email', $email)->first())
            return 'emailerror';

        //если юзер не зарегистрирован
        if (is_null($new_user)) {
            $new_user = new User();
            $new_user->fill([
                'name' => $oauth_user->getName() ? $oauth_user->getName() : '',
                'email' => $email,
                'password' => '',
                'role' => 0,
                'social_id' => $oauth_user->getId() ? $oauth_user->getId() : '',
                'type_auth' => 'vk',
                'avatar' => $oauth_user->getAvatar() ? $oauth_user->getAvatar() : '',
            ]);
            $new_user->save();
        }
        return $new_user;
    }
}
