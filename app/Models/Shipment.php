<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Shipment extends Model
{
    protected $table = 'shipments';

    protected $hidden = ['id'];    

    protected $guarded = ['id'];
}
