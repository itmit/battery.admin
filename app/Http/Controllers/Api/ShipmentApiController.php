<?php

namespace App\Http\Controllers\Api;

use App\Models\Client;
use App\Models\Shipment;
use App\Models\ShipmentGoods;
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

class ShipmentApiController extends ApiBaseController
{
    public $successStatus = 200;
    private $data = null;

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

        $data = $request;
        return $data->dealer_uuid;

        DB::transaction(function ($data) {
            $record = new Shipment;
            $record->uuid = Str::uuid();
            $record->client_id = auth('api')->user()->id;
            $record->dealer_uuid = $data->dealer_uuid;
            $record->save();
            $id = $record->id;

            foreach ($data->serial_numbers as $serial_number) {
                $battery = DeliveryDetails::where('serial_number', '=', $serial_number)->first();

                if(!$battery)
                {
                    return response()->json(['error'=>'Батарии с таким серийным номером не найдено'], 500);     
                }

                ShipmentGoods::create([
                    'delivery_id' => $id,
                    'serial_number' => $battery->serial_number,
                    'delivery_note' => $battery->delivery_note,
                    'SSCC' => $battery->SSCC,
                    'TAB_ID' => $battery->TAB_ID,
                    'production_date' => $battery->production_date,
                    'delivery_date' => $battery->delivery_date,
                    'TAB_description' => $battery->TAB_description,
                    'CustomerOrderNumber' => $battery->CustomerOrderNumber,
                    'Customer_Buyer' => $battery->Customer_Buyer,
                    'Customer_buyer_ID' => $battery->Customer_buyer_ID,
                    'Customer_Receiver' => $battery->Customer_Receiver,
                    'Customer_Receiver_ID' => $battery->Customer_Receiver_ID,
                ]);
            }
        });

        return $this->sendResponse([], 'Отгрузка создана');
    }
    
}
