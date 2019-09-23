<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Shipment extends Model
{
    /**
     * @var array
     */
    protected $guarded = ['id'];

    /**
     * @var string
     */
    protected $table = 'shipments';

    public function shipmentGoods()
    {
        return $this->hasMany(ShipmentGoods::class);
    }

    // public function client() 
    // {
    //     return $this->belongsTo(Client::class, 'client')->get()->first();        
    // }
}
