<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    function index()
   {
        if (!$this->checksessionlogin()) {
            return redirect()->route('login');
        } else {
            $user= session('dangnhap.user_info');
            $data = DB::table('nhanvien')
            ->join('donvi', 'nhanvien.MaDV', '=', 'donvi.MaDV')
            ->join('phanquyen', 'nhanvien.MaQuyen', '=', 'phanquyen.MaQuyen')
            ->where('nhanvien.MaNV',$user->MaNV )
            ->first();

            if ($data ->MaQuyen === "001") {
                $congvieccanlam = [];
                $congvieccanlam = DB::table('congviec')
                ->select('congviec.MaCV','congviec.Tieude','congviec_nhanvien.HanDK')
                -> join('congviec_nhanvien','congviec.MaCV','=','congviec_nhanvien.MaCV')
                -> join('nhanvien','nhanvien.MaNV','=','congviec_nhanvien.MaNV')
                -> where('congviec.MaDV',$data ->MaDV)
                -> where('congviec_nhanvien.MaNV',$data->MaNV)
                -> where('congviec_nhanvien.Trangthai','<>',2)
                ->orderby('congviec_nhanvien.HanDK','ASC')
                ->skip(0)
                ->take(3)
                ->get();
                $data->congvieccanlam = $congvieccanlam->all();
            }
        // dd($data);
            return view('user.index',['user_info'=>$data]);
        }
   }

    public function checksessionlogin() {
        return session()->has('dangnhap');
    }

    
}
