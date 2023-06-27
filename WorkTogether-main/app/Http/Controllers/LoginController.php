<?php

namespace App\Http\Controllers;

use App\nguoidung;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use App\config\session;
use auth;

class LoginController extends Controller
{
    function index()
   {
        if (!$this->checksessionlogin()) {
            return view('login');
        } else {
        return redirect()->route('IndexUser');
        }
   }

   public function check(Request $re){

    if (empty($re)) {   
        session()->flash('mess','Vui Lòng nhập user name và password');
        return redirect()->route('login');
    } else {
            $u=null;
            $u =  DB::table('nhanvien')->where('TenDN',$re->user_id )->first();
            if (!$u || $u->Is_deleted !=null) {
                session()->flash('mess','Không Tồn tại ID người dùng! vui lòng thử lại');
                return redirect()->route('login');
            } else if(!Hash::check($re->passwd,$u->MatKhau)){
                session()->flash('mess','sai passsword!');
                return redirect()->route('login');
            } else if ($u->trangthai != 1) {
                session()->flash('mess','Xin lỗi, tài khoản bị khoá!');
                return redirect()->route('login');
            } else {
                $D = [];
                $D =  DB::table('donvi')->where('MaDV',$u->MaDV )->first();
                if (!$D) {
                    session()->flash('mess','Xin lỗi đơn vị của bạn đang bị lỗi!!!');
                    return redirect()->route('login');
                } else {
                session()->put('dangnhap',['user_info'=>$u]);
                return redirect()->route('IndexUser');
                }
            }
        }
    }

    public function checksessionlogin() {
        return session()->has('dangnhap');
    }
}
