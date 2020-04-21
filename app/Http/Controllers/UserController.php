<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;


class UserController extends Controller
{

    /**
     * Display the specified resource.
     *
     * @param \App\User $user
     *
     */
    public function show(User $user)
    {
        //посмотреть может или админ или сам юзер
        if (Auth::check() && (Auth::user()->role || Auth::id() === $user->id))
            return view('user.user', ['user' => $user]);
        return redirect()->route('Home');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\User $user
     *
     */
    public function edit(User $user)
    {
        //изменить может или админ или сам юзер
        if (Auth::check() && (Auth::user()->role || Auth::id() === $user->id))
            return view('user.edit', ['user' => $user]);
        return redirect()->route('Home');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\User $user
     *
     */
    public function update(Request $request, User $user)
    {
        //ПРОВЕРКА ДОСТУПА К ВОЗМОЖНОСТИ ПОМЕНЯТЬ ДАННЫЕ
        //если админ меняет чужие данные
        if (Auth::user()->role && (Auth::id() !== $user->id)) {
            $access = true;
        }
        //если кто-то меняет свои данные
        elseif (Hash::check($request->post('current-password'), $user->password)) {
            $access = true;
        }
        else{
            $alert = ['type' => 'danger', 'text' => 'Данные не изменены. Неправильный пароль'];
            $access = false;
        }
        //проверка совпадения паролей
        if($request->post('password') !== $request->post('password_confirmation')){
            $alert = ['type' => 'danger', 'text' => 'Данные в полях "Пароль" и "Подтвердите пароль"не совпадают.'];
            $access = false;
        }


        //если проверки пройдены, то можно менять
        if ($access) {

            //если пароль не менялся, то возьмём его из юзера
            if ($request->post('password') === null)
                $password = $user->password;
            else
                $password = Hash::make($request->post('password'));

            //заполним и сохраним
            $user->fill([
                'name' => $request->post('name'),
                'password' => $password,
                'email' => $request->post('email'),
                'role' => ($request->post('user-role') === 'on') ? 1 : 0
            ]);
            $user->save();

            $alert = ['type' => 'success', 'text' => 'Данные изменены успешно.'];
            return redirect()->route('user.show', $user)->with('alert', $alert);
        }

        return redirect()->route('user.edit', $user)->with('alert', $alert);

//        $this->validate($request, News::rules(), [], News::fieldNames());
//        dd('update');
//        'password' => ,
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\User $user
     */
    public
    function destroy(User $user)
    {
        $user->delete();
        $alert = ['type' => 'info', 'text' => 'Пользователь удалён.'];
        return redirect()->route('admin.users')->with('alert', $alert);
    }






//    /**
//     * Display a listing of the resource.
//     *
//     * @return \Illuminate\Http\Response
//     */
//    public function index()
//    {
//        //
//    }
//    /**
//     * Show the form for creating a new resource.
//     *
//     * @return \Illuminate\Http\Response
//     */
//    public function create()
//    {
//        //
//    }
//    /**
//     * Store a newly created resource in storage.
//     *
//     * @param \Illuminate\Http\Request $request
//     * @return \Illuminate\Http\Response
//     */
//    public function store(Request $request)
//    {
//        //
//    }
}
