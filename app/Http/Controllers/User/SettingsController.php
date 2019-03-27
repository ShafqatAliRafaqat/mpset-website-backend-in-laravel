<?php

namespace App\Http\Controllers\User;

use App\Helpers\FileHelper;
use App\Http\Resources\SettingResource;
use App\Setting;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Intervention\Image\Facades\Image;

class SettingsController extends Controller{

    public function index(){
        $settings = Setting::get();
        return SettingResource::collection($settings);
    }

    public function update(Request $request){

        $input = $request->all();

        if($request->default_avatar){

            $img = Image::make($request->default_avatar)->resize(300, 300);

            $result = FileHelper::getAndCreatePath($img->filename, 'avatar');

            $extension = substr($img->mime, strpos($img->mime, '/') + 1);

            $result['name'] = $result['name'] . str_random(15) . '.' . $extension;

            $path = $result['path'] . "/" . $result['name'];

            $img->save($path, 60);

            $input['default_avatar'] = $path;
        }

        foreach ($input as $key => $value){
            Setting::where('key',$key)
                ->update([
                    'value' => $value
                ]);
        }

        $settings = Setting::get();

        return [
            'message' => 'Settings Updated Successfully',
            'data' => SettingResource::collection($settings)
        ];

    }

}
