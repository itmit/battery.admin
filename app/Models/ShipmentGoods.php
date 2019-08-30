<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

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

    public function client() 
    {
        return $this->belongsTo(Client::class, 'client')->get()->first();        
    }
}
