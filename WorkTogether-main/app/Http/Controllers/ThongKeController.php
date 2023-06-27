<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;
use app\congviec;


class ThongKeController extends Controller
{

    public function checksessionlogin() {
        return session()->has('dangnhap');
    }

    function thongke()
    {
        if (!$this->checksessionlogin() ) {
            session()->flash('mess','Vui lòng đăng nhập');
            return redirect()->route('login');
        }
        $user= session('dangnhap.user_info');
        $user_info = DB::table('nhanvien')
        ->join('donvi', 'nhanvien.MaDV', '=', 'donvi.MaDV')
        ->join('phanquyen', 'nhanvien.MaQuyen', '=', 'phanquyen.MaQuyen')
        ->where('nhanvien.MaNV',$user->MaNV )
        ->where('nhanvien.trangthai',1)
        ->first();
        if (empty($user_info)) {
            session()->flash('mess','Tài khoản của bạn đang bị khóa hoặc không tồn tại vui lòng đăng nhập lại!!!');
            return redirect()->route('login');
        }
        $donvi = DB::table('donvi') ->where('donvi.MaDV',$user_info->MaDV)->first();
        if (empty($donvi)) {
            session()->flash('mess','Không thể tìm thấy đơn vị của bạn vui lòng đăng nhập lại!!!');
            return redirect()->route('login');
        }  else if ($user_info->MaQuyen!='002' || $user->MaNV != $donvi->Matruongphong) {
            session()->flash('mess','Bạn Không Có Quyền Thực Hiện Chức Năng Này');
            return redirect()->route('IndexUser');
        } else {
            $data = [];
            $data = DB::table('congviec')
            ->join('congviec_nhanvien','congviec_nhanvien.MaCV','=','congviec.MaCV')
            ->join('nhanvien','nhanvien.MaNV','=','congviec_nhanvien.MaNV')
            ->where('nhanvien.MaDV',$user_info->MaDV)
            ->where('congviec_nhanvien.Trangthai','=',2)
            ->get();
            foreach($data as $item) {
                $sogio = 0;
                $sogio = DB::table('nhatkycv') 
                ->where('nhatkycv.MaCV',$item->MaCV)
                ->sum('nhatkycv.sogio');
                $item->sogio=$sogio;
                $sonk = 0;
                $sonk = DB::table('nhatkycv')->where('nhatkycv.MaCV',$item->MaCV) ->count();
                $item ->sonk = $sonk;
            }
            $dsnv = DB::table('nhanvien')
            ->where('nhanvien.MaDV',$user_info->MaDV)
            ->where('nhanvien.trangthai',1)
            ->get();
            $dscv = DB::table('congviec')
            ->get();
            $data->dsnv = $dsnv->all();
            $data->dscv = $dscv->all();
            // dd($data);
             return view('thongke.thongke',['user_info'=>$user_info,'data'=>$data]);
         }
    }

    public function xemthongke(Request $re) {
        // dd($re->all());
        // $month = $re->time;
        // $month = $month->format('m');
        // dd($month);
        if (!$this->checksessionlogin() ) {
            session()->flash('mess','Vui lòng đăng nhập');
            return redirect()->route('login');
        }
        $user= session('dangnhap.user_info');
        $user_info = DB::table('nhanvien')
        ->join('donvi', 'nhanvien.MaDV', '=', 'donvi.MaDV')
        ->join('phanquyen', 'nhanvien.MaQuyen', '=', 'phanquyen.MaQuyen')
        ->where('nhanvien.MaNV',$user->MaNV )
        ->where('nhanvien.trangthai',1)
        ->first();
        if (empty($user_info)) {
            session()->flash('mess','Tài khoản của bạn đang bị khóa hoặc không tồn tại vui lòng đăng nhập lại!!!');
            return redirect()->route('login');
        }
        $donvi = DB::table('donvi') ->where('donvi.MaDV',$user_info->MaDV)->first();
        if (empty($donvi)) {
            session()->flash('mess','Không thể tìm thấy đơn vị của bạn vui lòng đăng nhập lại!!!');
            return redirect()->route('login');
        }  else if ($user_info->MaQuyen!='002' || $user->MaNV != $donvi->Matruongphong) {
            session()->flash('mess','Bạn Không Có Quyền Thực Hiện Chức Năng Này');
            return redirect()->route('IndexUser');
        } else {
            $data = [];
            $query = DB::table('congviec')
            ->join('congviec_nhanvien','congviec_nhanvien.MaCV','=','congviec.MaCV')
            ->join('nhanvien','nhanvien.MaNV','=','congviec_nhanvien.MaNV')
            ->where('nhanvien.MaDV',$user_info->MaDV)
            ->whereYear('congviec_nhanvien.NgayGiao',$re->year);
            if (!empty($re->msnv)){
                $query ->where('congviec_nhanvien.MaNV',$re->msnv);
            }

            if (!empty($re->mscv)){
                $query ->where('congviec_nhanvien.MaCV',$re->mscv);
            }
            if (!empty($re->month)){
                $query ->whereMonth('congviec_nhanvien.NgayGiao', '=', $re->month);
            }
            $data = $query ->get();
            foreach($data as $item) {
                $sogio = 0;
                $sogio = DB::table('nhatkycv') 
                ->where('nhatkycv.MaCV',$item->MaCV)
                ->sum('nhatkycv.sogio');
                $item->sogio=$sogio;
                $sonk = 0;
                $sonk = DB::table('nhatkycv')->where('nhatkycv.MaCV',$item->MaCV) ->count();
                $item ->sonk = $sonk;
            }
            $dsnv = DB::table('nhanvien')
            ->where('nhanvien.MaDV',$user_info->MaDV)
            ->where('nhanvien.trangthai',1)
            ->get();
            $dscv = DB::table('congviec')
            ->get();
            $data->dsnv = $dsnv->all();
            $data->dscv = $dscv->all();
            // dd($data);
             return view('thongke.thongke',['user_info'=>$user_info,'data'=>$data]);
        }
    }
}
