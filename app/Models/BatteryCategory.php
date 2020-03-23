<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BatteryCategory extends Model
{
    /**
     * @var array
     */
    protected $guarded = ['id'];

    /**
     * @var string
     */
    protected $table = 'battery_categories';
}
