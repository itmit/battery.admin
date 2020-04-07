<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ShipmentDetail extends Model
{
    protected $table = 'shipment_details';

    protected $hidden = ['id'];    

    protected $guarded = ['id'];
}
