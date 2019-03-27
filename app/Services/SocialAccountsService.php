<?php
namespace App\Services;

use App\User;
use App\LinkedSocialAccount;
use Illuminate\Http\Request;

class SocialAccountsService {

    /**
     * Find or create user instance by provider user instance and provider name.
     *
     * @param  $providerUser
     * @param string $provider
     *
     * @return User
     */

    public function findOrCreate(Request $request) : User {

        $linkedSocialAccount = LinkedSocialAccount::where('provider_name', $request->provider_name)
            ->where('provider_id', $request->provider_id)
            ->first();

        if ($linkedSocialAccount) {
            return $linkedSocialAccount->user;
        }

        $user = User::where('email', $request->email)->whereNotNull("email")->first();

        if (!$user) {
            $user = User::create([
                'nick_name' => $request->name,
                'first_name' => $request->name,
                'last_name' => $request->name,
                'email' => $request->email,
            ]);
        }

        $user->linkedSocialAccounts()->create([
            'provider_id' => $request->provider_id,
            'provider_name' => $request->provider_name,
        ]);

        return $user;

    }
}
