<?php

namespace App\Http\Controllers\Api;

use App\User;
use App\Location;
use App\UserDetail;
use GuzzleHttp\Client;
use Intervention\Image\Facades\Image;
use App\Helpers\FileHelper;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class AuthController extends Controller
{
    public function register(Request $request)
    {

        $request->validate([
        'nick_name' => 'required',
        'email' => 'required|email|unique:users',
        'password' => 'required|min:6'
        ]);

        $input = $request->all();
        $path=NULL;

        if($request->avatar){
            
            $img = Image::make($request->avatar)->resize(300, 300);
            
            $result = FileHelper::getAndCreatePath($img->filename,'avatar');

            $extension = substr($img->mime,strpos($img->mime,'/')+1);

            $result['name'] = $result['name'].str_random(15).'.'.$extension;

            $path = $result['path']."/".$result['name'];

            $img->save($path, 60);
        }

        $user = User::create([
            'avatar' => $path,
            'name' => $input['nick_name'],
            'email' => $input['email'],
            'password' => bcrypt($input['password']),
        ]);

        UserDetail::create([
            'user_id' => $user->id,
            'first_name' => $input['first_name'],
            'last_name' => $input['last_name'],
            'phone' => $input['phone'],
            'gender' => $input['gender'],
        ]);
        // if($file_data = $request->file('location_image')){
        //     $file_name = $file_data->getClientOriginalName();
        //     Storage::disk('public')->put($file_name, File::get($file_data));
        // }
    

        // $userlocation = new Location();

        // $userlocation->user_id = $user->id;
        // $userlocation->location_longitude = $request->location_longitude;
        // $userlocation->location_latitude = $request->location_latitude;
        // $userlocation->location_image = $file_name;
        // $userlocation->avatar = $file_name1;

        // $userlocation->save();

        $http = new Client;
        
        $response = $http->post('http://localhost/Laravel/MPSET/public/oauth/token', [
            'form_params' => [  
                'grant_type' => 'password',
                'client_id' => '2',
                'client_secret' => 'uYcWKWNaDsLDTta3AJxdBAxIkK5CynwA8axzqdNY',
                'username' => $request->email,
                'password' => $request->password,
                'scope' => '',
            ],
        ]);

        return response(['user'=>$user ]);
    }

    public function login(Request $request)
    {
        $request->validate([
			'email'=>'required|email',
            'password' => 'required|min:6'
            ]);
		$user= User::where('email',$request->email)->first();
		if(!$user){
			return response(['status'=>'error','message'=>'User not found']);
		}
		if(Hash::check($request->password, $user->password)){
            $http = new Client;
            $response = $http->post('http://localhost/Laravel/MPSET/public/oauth/token', [
                'form_params' => [
                    'grant_type' => 'password',
                    'client_id' => '2',
                    'client_secret' => 'uYcWKWNaDsLDTta3AJxdBAxIkK5CynwA8axzqdNY',
                    'username' => $request->email,
                    'password' => $request->password,
                    'scope' => '',
                ],
            ]);
			return response(['auth' => json_decode((string)$response->getBody(), true), 'user' => $user]);
		}else{
			return response(['message'=>'password not match','status'=>'error']);
		}
    }

}
