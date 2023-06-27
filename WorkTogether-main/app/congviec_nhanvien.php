<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class congviec_nhanvien extends Model
{
    protected $table='congviec_nhanvien';
    protected $primaryKey='magiao';
    protected $keyType='int';
    public $encrementing = false;
    public $timestamps= false;
}
