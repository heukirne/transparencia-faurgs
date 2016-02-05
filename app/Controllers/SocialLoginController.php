<?php

namespace App\Controllers;

use App\Models\User;
use App\Controllers\Controller;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers;

class SocialLoginController extends Controller
{

    use AuthenticatesAndRegistersUsers, ThrottlesLogins;

    protected $redirectTo = '/faurgs/';
    protected $redirectAfterLogout = '/faurgs/';

    public function __construct()
    {
        //$this->middleware('guest', ['except' => 'getLogout']);
    }

    public function redirectToProvider($provider)
    {
        return Socialite::driver($provider)->redirect();
    }

    public function handleProviderCallback($provider)
    {
        try {
            $user = Socialite::driver($provider)->user();
        } catch (\Exception $e) {
            return redirect('/faurgs/auth/'.$provider);
        }

        $authUser = $this->findOrCreateUser($user);

        \Auth::login($authUser, true);

        return redirect('/faurgs/unidades');
    }

    private function findOrCreateUser($user)
    {

        if ($authUser = User::where('email', $user->email)->first()) {
            return $authUser;
        }

        $newUser = new User([
            'name' => isset($user->name) ? $user->name : $user->nickname,
            'email' => $user->email,
        ]);
        $newUser->save();

        return $newUser;

    }

}