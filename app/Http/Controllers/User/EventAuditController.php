<?php

namespace App\Http\Controllers\User;

use App\Http\Resources\EventAuditResource;
use App\Services\EventAuditService;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class EventAuditController extends Controller {

    /** @var EventAuditService */
    private $service;

    /**
     * EventController constructor.
     */
    public function __construct(){
        $this->service = new EventAuditService();
    }

    public function index(Request $request){

        $audits = $this->service->all([
            ['event_id',$request->event_id]
        ]);

        return EventAuditResource::collection($audits);
    }

}
