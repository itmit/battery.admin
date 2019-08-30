<?php

namespace App\Http\Controllers\Api;

use App\Models\Client;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;

class ShipmentApiController extends ApiBaseController
{
    public $successStatus = 200;

    /** 
     * Возвращает список дилеров
     * 
     * @return Response 
     */ 
    public function listOfDealers()
    { 

        $dealers = Client::where('role', '=', 'dealer')->get()->toArray();

        $response = [];

        foreach ($dealers as $dealer) {
            $response = [
                'uid' => $dealer->uid,
                'login' -> $dealer->login
            ];
        }

        return $this->sendResponse($response, 'Updated');

    }
    
}
