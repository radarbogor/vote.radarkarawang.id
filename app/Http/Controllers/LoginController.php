<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Laravel\Socialite\Facades\Socialite;

class LoginController extends Controller
{
    //redirect google login
    public function redirectToGoogle(){
        Http::withUserAgent("mozilla/5.0 (linux; android 4.1.1; galaxy nexus build/jro03c) applewebkit/535.19 (khtml, like gecko) chrome/18.0.1025.166 mobile safari/535.19");

        return Socialite::driver('google')->redirect();
    }

    //callback google login
    public function handleGoogleCallback(){
        Http::withUserAgent("mozilla/5.0 (linux; android 4.1.1; galaxy nexus build/jro03c) applewebkit/535.19 (khtml, like gecko) chrome/18.0.1025.166 mobile safari/535.19");

        try{
            $googleUser = Socialite::driver('google')->user();

            // Update atau create data login google
            $this->registerOrLoginUser($googleUser);

            return redirect()->route('home');

        }catch(\Throwable $th){
           return redirect()->route('google.login');
        }
    }

    //redirect facebook login
    public function redirectToFacebook(){
        Http::withUserAgent("mozilla/5.0 (linux; android 4.1.1; galaxy nexus build/jro03c) applewebkit/535.19 (khtml, like gecko) chrome/18.0.1025.166 mobile safari/535.19");

        return Socialite::driver('facebook')->redirect();
    }

    //callback facebook login
    public function handleFacebookCallback(){
        Http::withUserAgent("mozilla/5.0 (linux; android 4.1.1; galaxy nexus build/jro03c) applewebkit/535.19 (khtml, like gecko) chrome/18.0.1025.166 mobile safari/535.19");

        try{
            $facebookUser = Socialite::driver('facebook')->user();

            // Update atau create data login facebook
            $this->registerOrLoginUser($facebookUser);

            return redirect()->route('home');
        }catch(\Throwable $th){
           return redirect()->route('facebook.login');
        }
    }

    public function logout(){
        Http::withUserAgent("mozilla/5.0 (linux; android 4.1.1; galaxy nexus build/jro03c) applewebkit/535.19 (khtml, like gecko) chrome/18.0.1025.166 mobile safari/535.19");

        Auth::guard('web')->logout();
        session()->flush();
        return redirect('/');
    }

    public function registerOrLoginUser($data) {
        $user = User::updateOrCreate([
            'provider_id' => $data->id,
        ],[
            'avatar' => $data->avatar,
            'name' => $data->name,
            'email' => $data->email,
            'provider_token' => $data->token,
            'provider_refresh_token' => $data->refreshToken,
        ]);

        Auth::login($user);
    }

}

