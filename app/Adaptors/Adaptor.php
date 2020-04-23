<?php

namespace App\Adaptors;

use App\User;
//use SocialiteProviders\Manager\OAuth2\User as UserOAuth;
use Laravel\Socialite\Two\User as UserOAuth;


class Adaptor
{
    private $socialNames = [
        'site' => 'логин и пароль',
        'vkontakte' => 'В контакте',
        'github' => 'Github',
    ];

    public function getUserBySocId(UserOAuth $oauth_user, string $socName)
    {

        switch($socName){
            case 'vkontakte' : $user_data = $this->getUserDataVkontakte($oauth_user, $socName); break;
            case 'github' : $user_data = $this->getUserDataGithub($oauth_user, $socName); break;
//            default : abort(404);
        }

        //проверка существования юзера
        $new_user = User::query()
            ->where('social_id', $user_data['social_id'])
            ->where('type_auth', $user_data['type_auth'])
            ->first();

        //если юзер не существует
        if (is_null($new_user)) {

            //проверка уникальности email
            $user_with_email = User::query()->where('email', $user_data['email'])->first();

            //ВОПРОС
            //Нужно ли тут авторизовывать пользователя, если он регистрировался через логин и пароль
            //или на гитхабе, а теперь авторизуется через ВК и у него совпадает email с в БД?
            //Или не авторизовывать и отобразить ошибку, чтобы он авторизовывался так как в первый раз?
            //Сейчас не авторизую.
            if (isset($user_with_email))
                return $this->socialNames[$user_with_email->type_auth];

            $new_user = new User();
            $new_user->fill($user_data);
            $new_user->save();
        }
        return $new_user;
    }

    private function getUserDataVkontakte(UserOAuth $user, $socName)
    {
        dd($user->getAvatar());
        return[
                'name' => $user->getName() ? $user->getName() : ($user->getNickname() ? $user->getNickname() : ''),
                'email' => $user->accessTokenResponseBody['email'],
                'password' => '',
                'role' => 0,
                'social_id' => $user->getId() ? $user->getId() : '',
                'type_auth' => $socName,
                'avatar' => $user->getAvatar() ? $user->getAvatar() : '',
        ];
    }

    private function getUserDataGithub(UserOAuth $user, $socName)
    {
        return[
            'name' => $user->getName() ? $user->getName() : ($user->getNickname() ? $user->getNickname() : ''),
            'email' => $user->email,
            'password' => '',
            'role' => 0,
            'social_id' => $user->getId() ? $user->getId() : '',
            'type_auth' => $socName,
            'avatar' => $user->getAvatar() ? $user->getAvatar() : '',
        ];
    }
}
