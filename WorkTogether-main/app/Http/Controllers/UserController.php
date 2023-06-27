<?php

namespace App\Http\Controllers;

use App\nhanvien;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Illuminate\Auth\Events\Validated;
use Illuminate\Support\Facades\Mail;
use Carbon\Carbon;



class UserController extends Controller
{
   
    public function themnhanvien()
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
            $donvi = DB::table('donvi')->get();
            return  view ('admin.qlnv.themnhanvien',['user_info'=>$user_info,'donvi'=>$donvi]);
        }
    }

    public function thongtincanhan() {
        if (!$this->checksessionlogin()) {
            return redirect()->route('login');
        } else {
            $user= session('dangnhap.user_info');
            $user_info = DB::table('nhanvien')
            ->join('donvi', 'nhanvien.MaDV', '=', 'donvi.MaDV')
            ->join('phanquyen', 'nhanvien.MaQuyen', '=', 'phanquyen.MaQuyen')
            ->where('nhanvien.MaNV',$user->MaNV )
            ->first();
            if ($user_info->trangthai =='0' || !empty($user_info->Is_deleted)) {
                return redirect()->route('login'); 
            } else {
                // dd($user_info);
                return  view ('user.thongtincanhan',['user_info'=>$user_info]);
            }

        }
    }

    public function luu(Request $re) {
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
            $u =  DB::table('nhanvien')->select('TenDN')->get();
            $dt = new Carbon();
            $before = $dt->subYears(18)->format('Y-m-d');
            $re->validate([
                'tennv'=>'required|string|min:6',
                'tendn'=>'required|min:6|alpha_num|unique:nhanvien,TenDN',
                'diachi'=>'required|string|string',
                'gioitinh'=>'required|in:0,1',
                'ngaysinh'=>'date|before:'.$before,
                'sdt'=>'required|digits:10|numeric',
                'email'=>'required|email|unique:nhanvien,Email',
                'pws'=>'required|regex:/^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[#?!@$%^&*-]).{6,}$/',
                'donvi'=>'required',
            ],[
                'tennv.required' => 'Vui lòng không để trống tên!',
                'tennv.min' => 'Tên vừa nhập có độ dài không hợp lệ! (<=6 ký tự)',
                'tennv.string' => 'Tên vừa nhập có ký tự không hợp lệ',
                'tendn.required'=>'Vui lòng điền tên đăng nhập',
                'tendn.min' => 'Tên đăng nhập có độ dài không hợp lệ! (<=6 ký tự)',
                'tendn.alpha_num' => 'Vui lòng nhập tên đăng nhập là chữ!',
                'tendn.unique' => 'Tên đăng nhập đã tồng tại!',
                'diachi.required'=>'Vui lòng nhập địa chỉ',
                'diachi.string'=>'Vui lòng nhập địa chỉ chính xác',
                'ngaysinh.required'=>'Vui lòng Chọn ngày sinh',
                'ngaysinh.date'=>'Vui lòng nhập đúng định dạng ngày sinh',
                'ngaysinh.before'=>'Không được thêm nhân viên dưới 18 tuổi',
                'email.required'=>'Vui lòng nhập Email',
                'email.email'=>'Vui lòng nhập đúng định dạng email xxx@gmail.com',
                'email.unique'=>'Email này đã được sử dụng vui lòng thử lại bằng 1 Email khác',
                'sdt.required'=>'Vui lòng nhập số điện thoại',
                'sdt.digits'=>'Nhập số điện thoại có 10 ký tự số',
                'sdt.numeric'=>'Số điện thoại không được chứ ký tự A-z, ký tự đặc biệt',
                'pws.required'=>'Vui lòng nhập mật khẩu',
                'pws.regex'=>'Mật khẩu có nhất nhất 8 kí tự bao gồm chữ, số, ký tự đặc biệt',
                'donvi.required'=>'Vui lòng Chọn đơn vị',
                'gioitinh.required'=>'Vui lòng điền giới tính',
            ]);
            $d =  DB::table('donvi')->where('MaDV',$re->donvi )->first();
            if (!$d) {
                session()->flash('mess','Xin lỗi, đơn vị bạn chọn không tồn tại vui lòng thử lại hoặc liên hệ QTV!');
                return redirect()->route('IndexUser');
            }
            $mk = bcrypt($re->pws);
            $ma = "NV".DB::table('nhanvien')->count();
            $avt = 'female.jpg';
            if ($re->gioitinh) {
                $avt = 'male.jpg';
            }
            DB::table('nhanvien')->insert([
                'DiaChi' =>$re->diachi,
                'Email' =>$re->email,
                'Gt' =>$re->gioitinh,
                'MaDV' =>$re->donvi,
                'MaQuyen' =>'001',
                'MatKhau' =>$mk,
                'NgaySinh' =>$re->ngaysinh,
                'SDT' =>$re->sdt,
                'TenDN' =>$re->tendn,
                'MaNV' =>  $ma  ,
                'TenNV' => $re->tennv,
                'trangthai' => 1,
                'Avt' => $avt
            ]);
            session()->flash('success','Thêm nhân viên thành công. thông tin đã được ghi vào CSDL');
            return redirect()->route('list_nhanvien');
        }
    }

    public function checksessionlogin() {
        return session()->has('dangnhap');
    }

    public function doipass()
    {
        if (!$this->checksessionlogin()) {
            return redirect()->route('login');
        } else {
            $user= session('dangnhap.user_info');
            $user_info = DB::table('nhanvien')
            ->join('donvi', 'nhanvien.MaDV', '=', 'donvi.MaDV')
            ->join('phanquyen', 'nhanvien.MaQuyen', '=', 'phanquyen.MaQuyen')
            ->where('nhanvien.MaNV',$user->MaNV )
            ->first();
            return  view ('user.doimatkhau',['user_info'=>$user_info]);
        }
    }

    public function Luudoimatkhau(Request $re)
    {
        if (!$this->checksessionlogin()) {
            session()->flash('mess','Vui lòng đăng nhập');
            return redirect()->route('login');
        } 
        else 
        {
            $user= session('dangnhap.user_info');
            $user_info = DB::table('nhanvien')
            ->join('donvi', 'nhanvien.MaDV', '=', 'donvi.MaDV')
            ->join('phanquyen', 'nhanvien.MaQuyen', '=', 'phanquyen.MaQuyen')
            ->where('nhanvien.MaNV',$user->MaNV )
            ->first();
            if ($user_info->trangthai!=1) {
                session()->flash('mess','Tài khoản bị khóa vui lòng liên hệ QTV!');
                return redirect()->route('login');
            }
            $re->validate([
                'password'=>'required|confirmed|regex:/^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[#?!@$%^&*-]).{6,}$/',
                'password_confirmation' => 'required|min:8',
            ],[
                'password.required'=>'Vui lòng nhập mật khẩu',
                'password.confirmed'=>'Mật khẩu và Xác nhận mật khẩu không khớp',
                'password.regex'=>'Mật khẩu có nhất nhất 8 kí tự bao gồm chữ, số, ký tự đặc biệt',
                'password_confirmation.required'=>'Vui lòng nhập xác nhận mật khẩu',
                'password_confirmation.min'=>'Xác nhận mật khẩu không hợp lệ (<8 ký tự)',
            ]);
            if (!Hash::check($re->password_old,$user_info->MatKhau)) {
                session()->flash('mess','Mật khẩu không đúng!');
                return  view ('user.doimatkhau',['user_info'=>$user_info]);
            } 
            if (Hash::check($re->password,$user_info->MatKhau)) {
                return redirect()->route('IndexUser');
            } else {
                
                DB::table('nhanvien')
                ->where('MaNV', $user->MaNV)
                ->update(['MatKhau' => bcrypt($re->password_confirmation)]);
                session()->flash('success','Thay đổi mật khẩu thành công');
                return redirect()->route('IndexUser');

            }
        }   
        
    }
    
    public function quenmatkhau() {
        return view('quenmatkhau');
    }

    public function resetpass(Request $re) {
        // dd($matkhau);
        $re->validate([
            'email'=>'required|email',
        ],[
            'email.required'=>'Vui lòng nhập Email',
            'email.email'=>'Vui lòng nhập đúng định dạng email xxx@gmail.com',
        ]);
        $info = DB::table('nhanvien')
        ->where('Email', $re->email) -> first();
        if (empty($info)) {
            session()->flash('mess','Xin lỗi, Email không tồn tại!');
            return redirect()->route('quenmatkhau');
        } else if ($info->trangthai==0) {
            session()->flash('mess','Xin lỗi, Tài khoản này hiện đang bị khóa!');
            return redirect()->route('quenmatkhau');
        } else {
            $matkhau = Str::random(10);
            // $matkhau =  bcrypt($matkhau);
            DB::table('nhanvien')->where('Email', $re->email) 
            ->update ( ['MatKhau' => bcrypt($matkhau)]);
            $address = $re->email;
            Mail::send('email.sendpass', ['matkhau' => $matkhau], function ($message) use($address,$matkhau) {
                $message->subject('[Worktogether - Mật khẩu của bạn đã được cập nhật]');
                $message->to($address);
            });
            session()->flash('success','Mật khẩu đã được cập nhật vui lòng kiểm tra Email');
            return redirect()->route('quenmatkhau');
        }
    }

    public function SuaNhanVien(Request $re) {
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
            $u =  DB::table('nhanvien')->select('TenDN')->get();
            $dt = new Carbon();
            $before = $dt->subYears(18)->format('Y-m-d');
            // dd($u);    
            $re->validate([
                'tennv'=>'required|string|min:6',
                'diachi'=>'required|string|string',
                'ngaysinh'=>'date|before:'.$before,
                'sdt'=>'required|digits:10|numeric'
            ],[
                'tennv.required' => 'Vui lòng không để trống tên!',
                'tennv.min' => 'Tên vừa nhập có độ dài không hợp lệ! (<=6 ký tự)',
                'tennv.string' => 'Tên vừa nhập có ký tự không hợp lệ',
                'diachi.required'=>'Vui lòng nhập địa chỉ',
                'diachi.string'=>'Vui lòng nhập địa chỉ chính xác',
                'ngaysinh.required'=>'Vui lòng Chọn ngày sinh',
                'ngaysinh.date'=>'Vui lòng nhập đúng định dạng ngày sinh',
                'ngaysinh.before'=>'Không được thêm nhân viên dưới 18 tuổi',
                'email.required'=>'Vui lòng nhập Email',
                'email.email'=>'Vui lòng nhập đúng định dạng email xxx@gmail.com',
                'email.unique'=>'Email này đã được sử dụng vui lòng thử lại bằng 1 Email khác',
                'sdt.required'=>'Vui lòng nhập số điện thoại',
                'sdt.digits'=>'Nhập số điện thoại có 10 ký tự số',
                'sdt.numeric'=>'Số điện thoại không được chứ ký tự A-z, ký tự đặc biệt'
            ]);
            
            $mk = bcrypt($re->pws);
            // $ma = DB::table('nhanvien')->count();
            $avt = 'female.jpg';
            if ($re->gioitinh) {
                $avt = 'male.jpg';
            }
           
            DB::table('nhanvien')->where('nhanvien.MaNV',$re->manv)
            ->update([
                'DiaChi' =>$re->diachi,
                'Email' =>$re->email,
                'Gt' =>$re->gioitinh,
                'NgaySinh' =>$re->ngaysinh,
                'SDT' =>$re->sdt,
                'TenNV' => $re->tennv
            ]);
            session()->flash('success','Cập nhật nhân viên thành công. thông tin đã được ghi vào CSDL');
            return redirect()->route('list_nhanvien');
        }
    }
    
    public function list_nhanvien()
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
            // cái cục này lấy ra thông tin du sơ bao gồm phòng ban , quyền này kia...
            $user= session('dangnhap.user_info');
            // data cho sildebar vs navbar
            $data = DB::table('nhanvien')
            ->join('donvi', 'nhanvien.MaDV', '=', 'donvi.MaDV')
            ->join('phanquyen', 'nhanvien.MaQuyen', '=', 'phanquyen.MaQuyen')
            ->where('nhanvien.MaNV',$user->MaNV)
            ->first();
            // cái này lấy đổ dữ liệu lên table list nhân viên
            $data1 = DB::table('nhanvien')
            ->join('donvi', 'nhanvien.MaDV', '=', 'donvi.MaDV')
            ->join('phanquyen', 'nhanvien.MaQuyen', '=', 'phanquyen.MaQuyen')
            ->where('nhanvien.MaQuyen','<>','000')
            ->paginate(5);
            return  view ('user.list_nhanvien',['user_info'=>$data,'list_user'=>$data1]);
        }
        
    }
    public function chitietnhanvien($id) {
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
            $data = DB::table('nhanvien')
            ->join('donvi', 'nhanvien.MaDV', '=', 'donvi.MaDV')
            ->join('phanquyen', 'nhanvien.MaQuyen', '=', 'phanquyen.MaQuyen')
            ->where('nhanvien.MaNV','LIKE',$id )
            ->first();
            return view('admin.qlnv.chitietnhanvien',['user_info'=>$user_info,'data' => $data]);
        }
    }
    public function Searchnhanvien(Request $re)
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
            // cái này lấy đổ dữ liệu lên table list nhân viên
            $data1 = [];
            $data1 = DB::table('nhanvien')
            ->join('donvi', 'nhanvien.MaDV', '=', 'donvi.MaDV')
            ->join('phanquyen', 'nhanvien.MaQuyen', '=', 'phanquyen.MaQuyen')
            // ->where('nhanvien.MaNV','LIKE',"%$re->keywords%")
             ->where('nhanvien.MaNV','LIKE',"%$re->keywords%" )
            ->orwhere('nhanvien.TenNV','LIKE',"%$re->keywords%")
            ->orwhere('donvi.TenPhong','LIKE',"%$re->keywords%")
            ->paginate(5);
            if (empty($data1->all())) {
                session()->flash('mess','không có nội dung tìm kiếm phù hợp');
                return redirect()->route('list_nhanvien');
            } else {
                return  view ('user.list_nhanvien',['user_info'=>$user_info,'list_user'=>$data1]);
            }
            
        }
        
    }
    public function ChuyenTrangThai($id, $trangthai)
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
            $u =  DB::table('nhanvien')->select('TenDN')->get();
            $dt = new Carbon();
            DB::table('nhanvien')->where('nhanvien.MaNV',$id)
            ->update([
                'trangthai' =>!$trangthai,
            ]);
            session()->flash('success','Cập nhật nhân viên thành công. thông tin đã được ghi vào CSDL');
            return redirect()->route('list_nhanvien');
        }
    }
    public function XoaNhanVien($id)
    {
       $user = DB::table('nhanvien')->where('nhanvien.MaNV',$id)->first();
       if($user!=null)
         DB::table('nhanvien')->where('nhanvien.MaNV',$id)->delete();
        return redirect()->route("list_nhanvien");
    }
    
}
