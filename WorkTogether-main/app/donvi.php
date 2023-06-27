<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


class donvi extends Model
{

    protected $table ='donvi'; //ten table
    protected $primaryKey ='MaDV'; // khoa chinh
    protected $keyType ='string'; //loai data
    public $encrementing = false; // co tu dong tang ha khong?  
    public $timestamps=false;
  
}
