<?php

namespace App\Http\Controllers\Api;

// use App\Models\Client;
// use Illuminate\Http\JsonResponse;
// use Illuminate\Http\Request;
// use Illuminate\Http\Response;
// use Illuminate\Support\Carbon;
// use Illuminate\Support\Facades\Auth;
// use Illuminate\Support\Facades\Hash;
// use Illuminate\Support\Facades\Validator;
// use Illuminate\Support\Facades\Storage;
// use Illuminate\Support\Facades\DB;

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

        return 'a';

        // $dealers = Client::where('role', '=', 'delaer')->get();

        // return $this->sendResponse([
        //     $dealers
        // ],
        //     'Updated');

    }
    
}
