<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class congviec extends Model
{
    protected $table='congviec';
    protected $primaryKey='MaCV';
    protected $keyType='string';
    public $encrementing = false;
    public $timestamps= false;
}
