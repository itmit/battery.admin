<?php

namespace App\Http\Controllers\Api;

use App\Models\Client;
use App\Models\Shipment;
use App\Models\ShipmentGoods;
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
        $columns = ['uid', 'login'];
        $dealers = Client::where('role', '=', 'dealer')->get($columns)->toArray();

        return $this->sendResponse($dealers, 'List of dealers');
    }

    /** 
     * Создает новую отгрузку, состоящую из серийных номеров товара
     * 
     * @return Response 
     */ 
    public function store(Request $request)
    { 
        $validator = Validator::make($request->all(), [
            'uid' => 'required|uuid',
            'serial_numbers' => 'required',
            'dealer_id' => 'required'
        ]);

        if ($validator->fails()) {
            return $this->sendError($validator->errors(), "Validation error", 401);
        }

        DB::beginTransaction();
            $record = new Shipment;
            $record->uid = $request->input('uid');
            $record->client_id = auth('api')->user()->id;
            $record->dealer_id = $request->input('dealer_id');
            $record->save();
            $id = $record->id;

            foreach ($request->serial_numbers as $serial_number) {
                $record = new ShipmentGoods;
                $record->shipment_id = $id;
                $record->serial_number = $request->serial_numbers;
                $record->save();
            }
        DB::commit();

        return 'a';
    }
    
}
