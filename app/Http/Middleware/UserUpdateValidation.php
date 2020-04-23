<?php

namespace App\Http\Middleware;

use App\User;
use App\Http\Controllers\Auth\RegisterController;
use Illuminate\Support\Facades\Validator;

use Closure;

class UserUpdateValidation
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        //если это изменение данных юзера
        if ($request->method() === 'PUT') {
            $this->validator($request->all())->validate();
        }
        return $next($request);
    }


    protected function validator(array $data)
    {
        $rules = RegisterController::getUserValidationRules(User::find($data['id']));
//        dd($rules);
        //если пароль не вводили, то он останется старым, проверять его не надо
        if($data['password'] === null && $data['password_confirmation'] === null)
            unset($rules['password']);

        return Validator::make($data, $rules);
    }

}
