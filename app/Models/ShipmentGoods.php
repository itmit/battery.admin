<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class ShipmentGoods extends Model
{
    /**
     * @var array
     */
    protected $fillable = [
        'shipment_id',
        'serial_number',
    ];

    /**
     * @var string
     */
    protected $table = 'shipment_goods';

    public function shipment()
    {
        return $this->belongsTo(Shipment::class);
    }

    // public function client() 
    // {
    //     return $this->belongsTo(Client::class, 'client')->get()->first();        
    // }
}
