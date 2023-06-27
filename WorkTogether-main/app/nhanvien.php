<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;


class nhanvien extends Model
{
    protected $table='nhanvien';
    protected $primaryKey='MaNV';
    protected $keyType='string';
    public $encrementing = false;
    public $timestamps= false;
}
