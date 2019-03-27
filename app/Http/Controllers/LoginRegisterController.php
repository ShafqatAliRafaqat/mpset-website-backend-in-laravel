<?php

namespace App\Http\Controllers;

use App\User;
use App\Location;
use App\UserDetail;
use GuzzleHttp\Client;
use App\Helpers\FileHelper;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Http\Resources\UserResource;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Storage;
use App\Services\SocialAccountsService;
use App\Http\Controllers\IssueTokenTrait;
use App\LinkedSocialAccount as SocialAccount;
use Illuminate\Support\Facades\Route;
use App\Services\UserService;

class LoginRegisterController extends Controller {

    use IssueTokenTrait;

    public function socialLogin(Request $request){

        $input = $request->all();

        $this->validateOrAbort($input,[
    		'name' => 'required',
    		'email' => 'nullable|email',
    		'provider_name' => 'required',
    		'provider_id' => 'required'
        ]);

        $saService = new SocialAccountsService();
        
        $saService->findOrCreate($request);
        
    	return $this->issueToken($request, 'social');
    }

    public function register(Request $request) {
        
        $input = $request->all();

        $input['avatar'] = $request->avatar;

        $service = new UserService();

        $user = $service->create($input);

        $input = [
            'email'  =>  $request->email,
            'password' => $request->password
        ];

        return $this->loginWithPassword($input);
    }

    public function login(Request $request) {

        $input = $request->all();

        $this->validateOrAbort($input,[
            'email' => 'required|email',
            'password' => 'required|min:6'
        ]);

        return $this->loginWithPassword($input);
    }


    private function loginWithPassword($input) {

        $user = User::where('email', $input['email'])->first();

        if (!$user || !Hash::check($input['password'], $user->password)) {
            return abort(400,"The username or password is incorrect");
        }

        $http = new Client;

        $host = env('APP_URL');
        
        $response = $http->post("$host/oauth/token", [
            'form_params' => [
                'grant_type' => 'password',
                'client_id' => env('PASSPORT_CLIENT_ID'),
                'client_secret' => env('PASSPORT_SECRET'),
                'username' => $input['email'],
                'password' => $input['password'],
                'scope' => '',
            ],
        ]);

        return response([
            'auth' => json_decode((string)$response->getBody(), true),
            'user' => UserResource::make($user)
        ]);
    }
    
}
