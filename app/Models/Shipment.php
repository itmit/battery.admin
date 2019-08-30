<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Shipment extends Model
{
    /**
     * @var array
     */
    protected $fillable = [
        'client_id',
        'dealer_id',
    ];

    /**
     * @var string
     */
    protected $table = 'shipments';

    public function client() 
    {
        return $this->belongsTo(Client::class, 'client')->get()->first();        
    }
}
