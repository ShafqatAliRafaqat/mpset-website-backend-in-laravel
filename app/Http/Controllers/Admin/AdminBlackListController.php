<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\BlackListService;
use App\Http\Resources\BlackListResource;

class AdminBlackListController extends Controller{

    /** @var BlackListService */
    private $service;
    private $validationRules ;

    public function __construct(){
        $this->service = new BlackListService();
        $this->validationRules = [
            'country_code' => 'required',
            'country' => "required",
            'all_features' => 'required',
            'features' => 'present',
        ];
    }

    public function index(){
        $blackLists = $this->service->allWithPagination();
        return BlackListResource::collection($blackLists);
    }

    public function create(Request $request){
        
        $data = $request->all();
        
        $this->validateOrAbort($data,$this->validationRules);

        $backList = $this->service->create($data);
        return [
            'data' => BlackListResource::make($backList),
            'message' => 'Country Blocked Successfully'
        ];
    }

    public function update($local,$id,Request $request){
        
        $data = $request->all();
        
        $this->validateOrAbort($data,$this->validationRules);

        $backList = $this->service->update($id,$data);

        return [
            'data' => BlackListResource::make($backList),
            'message' => 'Settings Updated Successfully'
        ];
    }

    public function destory($local,$id){
        $this->service->delete($id);
        return [
            'message' => 'Settings Deleted Successfully'
        ];
    }

}
