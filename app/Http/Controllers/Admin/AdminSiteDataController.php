<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\BlackList;

class AdminSiteDataController extends Controller {

    public function index(){
        return [
            'data' => [
                'features' => $this->getKeyValue(BlackList::$FEATURES),
            ]
        ];
    }

    private function getKeyValue($array) {

        $elements = [];

        if ($array) {
            foreach ($array as $key => $value) {
                $elements[] = [
                    'key' => $key,
                    'value' => $value
                ];
            }
        }

        return $elements;
    }

}
