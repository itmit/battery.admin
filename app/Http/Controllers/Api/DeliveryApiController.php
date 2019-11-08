<?php

namespace App\Http\Controllers\Api;

use App\Models\Client;
use App\Models\Delivery;
use App\Models\DeliveryDetails;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class DeliveryApiController extends ApiBaseController
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
            'serial_numbers' => 'required',
            'dealer_uuid' => 'required|uuid'
        ]);

        if ($validator->fails()) {
            return $this->sendError($validator->errors(), "Validation error", 401);
        }

        DB::beginTransaction();
            $record = new Delivery;
            $record->uuid = (string) Str::uuid();
            $record->client_id = auth('api')->user()->id;
            $record->dealer_uuid = $request->input('dealer_uuid');
            $record->type = 1;
            $record->save();
            $id = $record->id;

            foreach ($request->serial_numbers as $serial_number) {
                $record = new DeliveryDetails;
                $record->delivery_id = $id;
                $record->serial_number = $serial_number;
                $record->save();
            }
        DB::commit();

        return 'a';
    }

    public function checkBattery(Request $request)
    { 
        $validator = Validator::make($request->all(), [
            'serial_number' => 'required'
        ]);

        if ($validator->fails()) {
            return $this->sendError($validator->errors(), "Validation error", 401);
        }

        $battery = DeliveryDetails::where('serial_number', '=', $request->serial_number)->latest()->first()->toArray();

        if($battery == NULL)
        {
            return $this->sendError('Error', 'Аккумулятор не найден');
        } 

        return $this->sendResponse($battery, 'Аккумулятор');
    }
    
}
