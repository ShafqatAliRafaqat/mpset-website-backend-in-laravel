<?php
namespace App\Services;

use App\BlackList;
use Illuminate\Support\Facades\Validator;

class Service {
    protected function validateOrAbort($input,$rules){
        $validator = Validator::make($input,$rules);

        if($validator->fails()){
            abort(400,$validator->errors()->first());
        }
    }
}