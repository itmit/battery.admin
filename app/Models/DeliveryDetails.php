<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DeliveryDetails extends Model
{
    protected $table = 'delivery_details';

    protected $hidden = ['id'];    

    protected $guarded = ['id'];
}
