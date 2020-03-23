<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Battery extends Model
{
    /**
     * @var array
     */
    protected $guarded = ['id'];

    /**
     * @var string
     */
    protected $table = 'batteries';
}
