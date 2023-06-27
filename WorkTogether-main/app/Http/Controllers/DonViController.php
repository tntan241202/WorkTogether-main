<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\donvi;
use  Illuminate\Database\Query;

class DonViController extends Controller
{
    public function checksessionlogin() {
        return session()->has('dangnhap');
    }
    public function listdonvi()
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
        }  else if ($user_info->MaQuyen!='000') {
            session()->flash('mess','Bạn Không Có Quyền Thực Hiện Chức Năng Này');
            return redirect()->route('IndexUser');
        }  else {
            $data = DB::table('donvi')
            ->paginate(5);
            $truongphong =DB::table('donvi')
            ->join('nhanvien', 'nhanvien.MaNV', '=', 'donvi.Matruongphong')
            ->whereNull('nhanvien.is_deleted')
            ->where('nhanvien.trangthai' , 1)
            ->get();
            foreach ($data ->all() as $item) {
                $soluong = 0;
                $soluong= DB::table('nhanvien')->where('nhanvien.MaDV',$item->MaDV) -> count();
                $item->tentp ="Chưa có trưởng phòng";
                $item->soluong=$soluong;
                foreach ($truongphong as $a) {
                    if ($item->Matruongphong===$a->MaNV) {
                        $item->tentp = $a->TenNV;
                    }
                }
            }
          return  view ('donvi.listdonvi',['user_info'=>$user_info,'list_dv'=>$data]);
        }
        
    }
    public function themdonvi()
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
        }  else if ($user_info->MaQuyen!='000') {
            session()->flash('mess','Bạn Không Có Quyền Thực Hiện Chức Năng Này');
            return redirect()->route('IndexUser');
        } else {
            return  view ('donvi.themdonvi',['user_info'=>$user_info]);
        }
        
    }

    public function luudonvi(Request $re) {
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
        }  else if ($user_info->MaQuyen!='000') {
            session()->flash('mess','Bạn Không Có Quyền Thực Hiện Chức Năng Này');
            return redirect()->route('IndexUser');
        } else {   
            $re->validate([
                'tendv'=>'required|max:120|string|unique:donvi,TenPhong',
                'mota'=>'required|max:120|string',
            ],[
                'tendv.required' => 'Vui lòng không để trống tên đơn vị!',
                'tendv.max' => 'Tên vừa nhập có độ dài không hợp lệ! (<= 120 ký tự)',
                'tendv.string'=>'Tên đơn vị vừa nhập không hợp lệ ("A-z","-","_")',
                'tendv.unique'=>'Tên đơn vị đã tồn tại',
                'mota.required' => 'Vui lòng không để trống mô tả đơn vị!',
                'mota.max' => 'Tên vừa nhập có độ dài không hợp lệ! (<= 120 ký tự)',
                'mota.string'=>'Mô tả vừa nhập chứa kí tự không hợp lệ',

            ]);
            
            $stt = DB::table('donvi')->count()+1;
            $ma ="DV".$stt;
            DB::table('donvi')->insert([
                'TenPhong' => $re-> tendv,
                'Mota' => $re -> mota,
                'Logo' => 'addlogo.jpg'
            ]);
            session()->flash('success','Thêm đơn vị thành công. thông tin đã được ghi vào CSDL');
            return redirect()->route('listdonvi');
        }
    }

    public function updatedonvi(Request $re) {
        // dd($re->all());
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
        }  else if ($user_info->MaQuyen!='000') {
            session()->flash('mess','Bạn Không Có Quyền Thực Hiện Chức Năng Này');
            return redirect()->route('IndexUser');
        } else {  
            $dv= DB::table('donvi') -> where('donvi.MaDV',$re->madv) -> first();
            if (empty( $dv)) {
                session()->flash('mess','Lỗi hệ thống');
                return redirect()->route('IndexUser');
            }

            if (!empty($re->truongphong)) {
                $nv= DB::table('nhanvien') 
                -> where('nhanvien.MaNV',$re->truongphong) 
                -> where('nhanvien.MaDV',$re->madv) 
                -> first();
                if (empty($nv)){
                    session()->flash('mess','Hệ Thống vừa cập nhật Nhân viên vừa chọn không thuộc phòng ban này! vui lòng thử lại');
                    return redirect()->route('listdonvi');
                }
            }
            if ($dv->TenPhong === $re->tendv && $dv->Mota === $re->mota && $dv->Matruongphong === $re->truongphong) {
                return redirect()->route('listdonvi');
            } 
            if ($dv->TenPhong != $re->tendv) {
                $re->validate(['tendv'=>'required|max:120|string|unique:donvi,TenPhong'],[
                    'tendv.required' => 'Vui lòng không để trống tên đơn vị!',
                    'tendv.max' => 'Tên vừa nhập có độ dài không hợp lệ! (<= 120 ký tự)',
                    'tendv.string'=>'Tên đơn vị vừa nhập không hợp lệ ("A-z","-","_")',
                    'tendv.unique'=>'Tên đơn vị đã tồn tại',
                ]);
            }
            if ($dv->Mota != $re->mota) {
                $re->validate([
                    'mota'=>'required|max:120|string',
                ],[

                    'mota.required' => 'Vui lòng không để trống mô tả đơn vị!',
                    'mota.max' => 'Tên vừa nhập có độ dài không hợp lệ! (<= 120 ký tự)',
                    'mota.string'=>'Mô tả vừa nhập chứa kí tự không hợp lệ',

                ]);
            }
            DB::beginTransaction();
            try {
                    $matpold = DB::table('donvi')->select('donvi.Matruongphong') ->where('donvi.MaDV',$re->madv) ->first();
                    // dd($matpold);
                    DB::table('nhanvien')->where('nhanvien.MaNV',$matpold->Matruongphong) ->update(['MaQuyen'=>'001']);
                    DB::table('nhanvien')->where('nhanvien.MaNV',$re->truongphong) ->update(['MaQuyen'=>'002']);
                    DB::table('donvi')->where('donvi.MaDV',$re->madv)
                    ->update([
                        // 'MaDV' => $re + ,
                        'TenPhong' => $re-> tendv,
                        'Mota' => $re -> mota,
                        'Matruongphong' => $re->truongphong
                    ]);
                    // dd(1);
                    DB::commit();
                    session()->flash('success','Cập nhật đơn vị thành công. thông tin đã được ghi vào CSDL');
                    return redirect()->route('listdonvi');
            }  catch (Exception $e) {
                DB::rollBack();
                session()->flash('mess','Lỗi hệ thống thử lại sau!');
                return redirect()->route('listcongviecpb');
            }
        }
    }

    public function chitietdonvi($id) {
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
        }  else if ($user_info->MaQuyen!='000') {
            session()->flash('mess','Bạn Không Có Quyền Thực Hiện Chức Năng Này');
            return redirect()->route('IndexUser');
        } else {
            $user= session('dangnhap.user_info');
            $user_info = DB::table('nhanvien')
                ->join('donvi', 'nhanvien.MaDV', '=', 'donvi.MaDV')
                ->join('phanquyen', 'nhanvien.MaQuyen', '=', 'phanquyen.MaQuyen')
                ->where('nhanvien.MaNV',$user->MaNV )
                ->first();
            $data = DB::table('donvi')
            ->where('donvi.MaDV',$id )
            ->first();
            $soluong = 0;
            $soluong= DB::table('nhanvien')->where('nhanvien.MaDV',$id) -> count();
            $data -> soluong = $soluong;
            $nhanvien = [];
            $nhanvien = DB::table('nhanvien')
                ->where('nhanvien.MaDV',$id )
                ->whereNull('nhanvien.is_deleted')
                ->where('trangthai' , 1)
                ->get();
            $data->nhanvien=$nhanvien->all();
            // dd($data);
            return view('donvi.chitietdonvi',['user_info'=>$user_info ,'data'=>$data]);
        }
    }
    public function Searchdonvi(Request $re)
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
        }  else if ($user_info->MaQuyen!='000') {
            session()->flash('mess','Bạn Không Có Quyền Thực Hiện Chức Năng Này');
            return redirect()->route('IndexUser');
        } else {
            $user= session('dangnhap.user_info');
            $user_info = DB::table('nhanvien')
            ->join('donvi', 'nhanvien.MaDV', '=', 'donvi.MaDV')
            ->join('phanquyen', 'nhanvien.MaQuyen', '=', 'phanquyen.MaQuyen')
            ->where('nhanvien.MaNV',$user->MaNV )
            ->first();
            // $data1=donvi::all();
            $data =[];
            $data = DB::table('donvi')
            ->select('donvi.*', DB::raw('COUNT(nhanvien.MaDV) as soluong'))
            ->leftJoin('nhanvien', 'nhanvien.MaDV', '=', 'donvi.MaDV')
            ->groupBy('donvi.MaDV')
            ->where('donvi.TenPhong','LIKE',"%$re->keywords%")->orWhere('nhanvien.TenNV','LIKE',"%$re->keywords%")->paginate(8);
            if (empty($data-> all())) {
                session()->flash('mess','không có nội dung tìm kiếm phù hợp');
                return redirect()->route('listdonvi');
            } else {
                $truongphong =DB::table('donvi')
                ->join('nhanvien', 'nhanvien.MaNV', '=', 'donvi.Matruongphong') ->get();
                // ->paginate(8);
                foreach ($data as $item) { 
                    $item->tentp ="Chưa có trưởng phòng";
                    foreach ($truongphong as $a) { 

                        if ($item->MaDV===$a->MaDV) {
                            $item->tentp = $a->TenNV;
                        }
                    }
                }
                return  view ('donvi.listdonvi',['user_info'=>$user_info,'list_dv'=>$data]);
            }
        }
        
    }
    public function XoaDonVi($id)
    {
        $user = DB::table('donvi')->where('donvi.MaDV',$id)->first();
       if($user!=null)
         DB::table('donvi')->where('donvi.MaDV',$id)->delete();
        return redirect()->route("listdonvi");
    }
    
}
