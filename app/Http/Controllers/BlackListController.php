<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\BlackList;
use App\Http\Resources\BlackListResource;

class BlackListController extends Controller{


    public function index (Request $request){
        
        $data = file_get_contents("http://geoplugin.net/json.gp?ip=".$request->ip);

        $data = json_decode($data,true);

        $code = $data['geoplugin_countryCode'];
        
        $backlist = BlackList::where('country_code',$code)->first();
        
        if(!$backlist){
            return [
                'data' => [
                    'all_features' => false,
                    'features' => [],
                ]
            ];
        }

        return  BlackListResource::make($backlist);
    }

}
