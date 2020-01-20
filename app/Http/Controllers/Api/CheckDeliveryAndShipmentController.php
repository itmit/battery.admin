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

    }
    
}
