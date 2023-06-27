<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class congviec extends Model
{
    use HasFactory;
    protected $table ='congviec'; //ten table
    protected $primaryKey ='MaCV'; // khoa chinh
    protected $keyType ='string'; //loai data
    protected $fillable =['MaCV','Tieude','Noidung','Ngaytao','Maphongban','Manguoitao'];
    public $encrementing = false; // co tu dong tang ha khong?  
    public $timestamps=false;
}
