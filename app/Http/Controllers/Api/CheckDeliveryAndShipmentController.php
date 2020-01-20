<?php

namespace App\Http\Controllers\Api;

use App\Models\Client;
use App\Models\Shipment;
use App\Models\ShipmentGoods;
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

class CheckDeliveryAndShipmentController extends ApiBaseController
{
    public $successStatus = 200;

    public function getDeliveries()
    {
        $deliveries = Delivery::all()->toArray();

        return $this->sendResponse($deliveries, 'Список отгрузок');
    }

    public function getShipments()
    {
        $shipments = Shipment::all()->toArray();

        return $this->sendResponse($shipments, 'Список отгрузок');
    }

    public function getDeliveriesAndShipments()
    {
        $data = [];
        $data['deliveries'] = Delivery::all()->toArray();
        $data['shipments'] = Shipment::all()->toArray();

        return $this->sendResponse($data, 'Список отгрузок');
    }

    public function getBatteriesFromDelivery(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'delivery_uuid' => 'required'
        ]);
        $delivery = Delivery::where('uuid', '=', $request->delivery_uuid)->first();
        $batteries = DeliveryDetails::where('delivery_id', '=', $delivery->id)->get()->toArray();
        return $this->sendResponse($batteries, 'Список батарей');
    }

    public function getBatteriesFromShipment(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'shipment_uuid' => 'required'
        ]);
        $delivery = Shipment::where('uuid', '=', $request->shipment_uuid)->first();
        $batteries = ShipmentGoods::where('shipment_id', '=', $delivery->id)->get()->toArray();
        return $this->sendResponse($batteries, 'Список батарей');
    }
    
}
