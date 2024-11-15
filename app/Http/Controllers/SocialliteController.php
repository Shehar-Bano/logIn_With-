<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Laravel\Socialite\Facades\Socialite;

class SocialliteController extends Controller
{
    public function googleProvider($provider)
    {
        if($provider){
            return Socialite::driver($provider)->redirect();
        }
        abort(404);

    }
    public function googleLoginCallback($provider)
    {

        try{
         $googleUser = Socialite::driver($provider)->user();
        $user = User::where('provider_id', $googleUser->id)->first();
        if($user){
            Auth::login($user);
            return redirect('dashboard');
        }else{
            $newUser = User::create([
                'name' => $googleUser->name,
                'email' => $googleUser->email,
                'password'=>Hash::make('123456'),
                'provider_id'=> $googleUser->id,
            ]);
            Auth::login($newUser);
            return redirect('dashboard');
        }

        }
        catch(Exception $e){
            dd($e);
        }


    }
}
