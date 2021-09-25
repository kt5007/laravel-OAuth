<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Laravel\Socialite\Facades\Socialite;
use App\SocialAccount;
use App\User;
use Exception;

class SocialLoginController extends Controller
{
    // GitHubの認証ページヘユーザーを転送するためのルート
    public function redirectToProvider(String $provider)
    {
        return Socialite::driver($provider)->redirect();
    }

    // GitHubの認証後に戻るルート
    public function providerCallback(String $provider)
    {
        // エラーならwelcome pageに遷移
        try {
            $social_user = Socialite::with($provider)->user();
        } catch (Exception $e) {
            return redirect('/welcome');
        }

        // nameかnickNameをuserNameにする
        if ($social_user->getName()) {
            $user_name = $social_user->getName();
        } else {
            $user_name = $social_user->getNickName();
        }

        // userテーブルに保存
        $auth_user = User::firstOrCreate([
            'email' => $social_user->getEmail(), 
            'name' => $user_name
        ]);

        // social accountテーブルに保存
        $auth_user->socialAccounts()->firstOrCreate([
            'provider_id'=>$social_user->getId(),
            'provider_name'=>$provider
        ]);

        // ログイン
        auth()->login($auth_user);

        // homeページに転送
        return redirect()->to('/home'); 
    }
}
