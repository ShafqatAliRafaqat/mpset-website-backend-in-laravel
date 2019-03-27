<?php

namespace App\Http\Controllers\User;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\LocationResource;
use App\Services\LocationService;
use Illuminate\Support\Facades\Auth;

class LocationController extends Controller {


    /** @var LocationService */
    private $service;

    public function __construct(){
        $this->service = new LocationService();
    }

    public function details($local,$id){
        
        $where = [
            ['id',$id],
            ['location_user_id',Auth::user()->id]
        ];

        $location = $this->service->find($where);
        
        return LocationResource::make($location);
    }
    
    public function create(Request $request) {
        
        $data = $request->all();

        $this->validateOrAbort($data, [
            'address' => 'required',
            'lat' => 'required',
            'lng' => 'required',
            'images' => 'required',
        ]);

        $location = $this->service->create([
            'address' => $data['address'],
            'lat' => $data['lat'],
            'lng' => $data['lng'],
            'images' => $data['images'],
            'location_user_id' => Auth::user()->id,
            'user_id' => Auth::user()->id,
        ]);

        return LocationResource::make($location);
    }

    public function update($local,$id,Request $request){
        
        $data = $request->all();

        $this->validateOrAbort($data, [
            'address' => 'required',
            'lat' => 'required',
            'lng' => 'required',
            'images' => 'required',
        ]);

        $where = [
            ['id',$id],
            ['location_user_id',Auth::user()->id],
        ];

        $location = $this->service->update($where,$data);

        return LocationResource::make($location);

    }
}
