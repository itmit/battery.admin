<?php

namespace App\Http\Controllers\Api;

use App\Models\Client;
use App\Models\Delivery;
use App\Models\DeliveryDetails;
use App\Models\Shipment;
use App\Models\ShipmentDetail;
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

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'whom' => 'required|uuid|exists:clients,uid',
            'serials' => 'required|array'
        ]);

        if ($validator->fails()) {
            return $this->sendError($validator->errors(), "Validation error", 400);
        }

        $whom = Client::where('uid', $request->whom)->first()->id;

        $shipment = Shipment::create([
            'from' => auth('api')->user()->id,
            'whom' => $whom,
        ]);

        foreach ($request->serials as $serial) {
            ShipmentDetail::create([
                'shipment' => $shipment->id,
                'serial' => $serial
            ]);
        }

        return $this->sendResponse([], 'Stored');
    }

    public function show($id)
    {
        return $this->sendResponse(Shipment::where('shipments.id', $id)
        ->join('shipment_details', 'shipments.id', '=', 'shipment_details.shipment')
        ->join('delivery_details', 'shipment_details.serial', '=', 'delivery_details.SERIAL')
        ->join('batteries', 'delivery_details.ARTICLE', '=', 'batteries.tab_id')
        ->join('battery_categories', 'batteries.category_id', '=', 'battery_categories.id')
        ->get()
        ->toArray(), 'shipment');
    }

    public function index()
    {
        $user = auth('api')->user();
        if ($user->role == "stockman")
        {
            return $this->sendResponse(Shipment::where('from', $user->id)
            ->join('clients as from_client', 'shipments.from', '=', 'from_client.id')
            ->join('clients as whom_client', 'shipments.whom', '=', 'whom_client.id')
            ->select('shipments.id as shipment_id', 'shipments.created_at as created_at', 'shipments.updated_at as updated_at', 'from_client.uid as from', 'whom_client.uid as whom', 'from_client.login as from_client_name', 'whom_client.login as whom_client_name')
            ->get()
            ->toArray(), 'List of users shipments');
        }
        else {
            return $this->sendResponse(Shipment::where('whom', $user->id)
            ->join('clients as from_client', 'shipments.from', '=', 'from_client.id')
            ->join('clients as whom_client', 'shipments.whom', '=', 'whom_client.id')
            ->select('shipments.id as shipment_id', 'shipments.created_at as created_at', 'shipments.updated_at as updated_at', 'from_client.uid as from', 'whom_client.uid as whom', 'from_client.login as from_client_name', 'whom_client.login as whom_client_name')
            ->get()
            ->toArray(), 'List of users shipments');
        }
    }
    
}
