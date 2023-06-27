<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;
use app\congviec;

class CongViecController extends Controller
{
    //
    public function dscongviecpb() {
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
            $data = DB::table('congviec')
            ->join('congviec_nhanvien', 'congviec.MaCV', '=', 'congviec_nhanvien.MaCV')
            ->join('nhanvien', 'congviec_nhanvien.MaNV', '=', 'nhanvien.MaNV')
            ->where('congviec.MaDV',$donvi->MaDV )
            ->orderBy('congviec_nhanvien.Trangthai', 'ASC')
            ->orderBy('congviec_nhanvien.HanDK', 'ASC')
            ->orderBy('congviec.mucdocv', 'DESC')
            ->paginate(5);
            // ->get();
            // dd($data->all());
            return  view ('congviec.caccongviec',['data'=>$data,'user_info'=>$user_info]);
        }
    }

    public function dscongviec() {
        $user= session('dangnhap.user_info');
        $user_info = DB::table('nhanvien')
        ->join('donvi', 'nhanvien.MaDV', '=', 'donvi.MaDV')
        ->join('phanquyen', 'nhanvien.MaQuyen', '=', 'phanquyen.MaQuyen')
        ->where('nhanvien.MaNV',$user->MaNV )
        ->where('nhanvien.trangthai',1)
        ->first();
        $donvi = DB::table('donvi') ->where('donvi.MaDV',$user->MaDV)->first();
        if (!$this->checksessionlogin() || empty($user_info)) {
            session()->flash('mess','Vui lòng đăng nhập');
            return redirect()->route('login');
        } else {
            $data = DB::table('congviec')
            ->join('congviec_nhanvien', 'congviec.MaCV', '=', 'congviec_nhanvien.MaCV')
            ->join('nhanvien', 'congviec_nhanvien.MaNV', '=', 'nhanvien.MaNV')
            ->where('congviec_nhanvien.MaNV',$user->MaNV )
            ->where('congviec_nhanvien.Trangthai','<>',3 )
            ->where('congviec_nhanvien.Trangthai','<>',2 )
            ->orderBy('congviec.mucdocv', 'DESC')
            ->paginate(8);
            //->get();
            // dd($data);
            return  view ('congviec.congviecnhanvien',['data'=>$data,'user_info'=>$user_info]);
        }
    }

    public function chitietcongviec($id) {
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
        }  else {
            $data = [];
            $data = DB::table('congviec')
                ->join('congviec_nhanvien', 'congviec.MaCV', '=', 'congviec_nhanvien.MaCV')
                ->join('nhanvien', 'congviec_nhanvien.MaNV', '=', 'nhanvien.MaNV')
                ->where('congviec_nhanvien.magiao',$id )
                ->first();
            if (empty($data)) {
                session()->flash('mess','Lỗi hệ thống vui lòng thử lại sau!');
                return redirect()->route('IndexUser');
            }
           $nhanvien = DB::table('nhanvien')
            ->where('nhanvien.MaDV',$user->MaDV )
            ->where('nhanvien.MaNV','<>',$donvi->Matruongphong)
            ->get();
            
            $qa = DB::table('qa') 
            ->join('nhanvien','nhanvien.MaNV','=','qa.MaNV')
            ->where('qa.MaCV',$data->MaCV) 
            ->get();
            $data->qa = $qa->all();

            $hscv = [];
            $hscv = DB::table('hosocongviec') 
            ->join('congviec','hosocongviec.MaCV','=','congviec.MaCV')
            ->where('hosocongviec.MaCV',$data->MaCV) 
            ->get();
            $data-> hscv=$hscv->all();

           $data->nhanvien= $nhanvien->all(); 

           $nkcn = [];
           $nkcn = DB::table('nhatkycv') 
           ->join('nhanvien','nhanvien.MaNV','=','nhatkycv.MaNV')
           ->where('nhatkycv.MaCV',$data->MaCV)
           ->where('nhatkycv.loaink',1)
           ->get();
           $data-> nkcn=$nkcn->all();
           
           $nkhn = [];
           $nkhn = DB::table('nhatkycv') 
           ->join('nhanvien','nhanvien.MaNV','=','nhatkycv.MaNV')
           ->where('nhatkycv.MaCV',$data->MaCV)
           ->where('nhatkycv.loaink',0)
           ->get();
           $data-> nkhn=$nkhn->all();
           return view('congviec.chitietcongviec',['user_info'=>$user_info,'data' => $data]);
        }
    }

    public function chitietcongviecnhanvien($id) {
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
        } else {
            $data = [];
            $data = DB::table('congviec')
                ->join('congviec_nhanvien', 'congviec.MaCV', '=', 'congviec_nhanvien.MaCV')
                ->join('nhanvien', 'congviec_nhanvien.MaNV', '=', 'nhanvien.MaNV')
                ->where('congviec.MaCV',$id )
                ->first();
            // dd($data);
            if (empty($data)) {
                session()->flash('mess','Lỗi hệ thống vui lòng thử lại sau!');
                return redirect()->route('IndexUser');
            }
            if ($data->MaQuyen==='000' && $data->MaNV != $user->MaNV) {
                session()->flash('mess','Bạn không có quyền xem công việc này');
                return redirect()->route('dscongviec');
            }
            if ($data -> Trangthai == 2 ) {
                session()->flash('success','Công việc này đã hoàn thành hãy chờ kết quả ở mục xem kết quả!');
                return redirect()->route('dscongviec');
            }
            $qa = DB::table('qa') 
            ->join('nhanvien','nhanvien.MaNV','=','qa.MaNV')
            ->where('qa.MaCV',$id) 
            ->get();
           $data->qa = $qa->all();
           $hscv = DB::table('hosocongviec') 
            ->join('congviec','hosocongviec.MaCV','=','congviec.MaCV')
            ->where('hosocongviec.MaCV',$data->MaCV) 
            ->get();
            $data-> hscv=$hscv->all();
            $nkcn = [];
           $nkcn = DB::table('nhatkycv') 
           ->join('nhanvien','nhanvien.MaNV','=','nhatkycv.MaNV')
           ->where('nhatkycv.MaCV',$data->MaCV)
           ->where('nhatkycv.loaink',1)
           ->get();
           $data-> nkcn=$nkcn->all();
           $nkhn = [];
           $nkhn = DB::table('nhatkycv') 
           ->join('nhanvien','nhanvien.MaNV','=','nhatkycv.MaNV')
           ->where('nhatkycv.MaCV',$data->MaCV)
           ->where('nhatkycv.loaink',0)
           ->get();
           $data-> nkhn=$nkhn->all();
        //    dd($data);
             return view('congviec.chitietcongviecnhanvien',['user_info'=>$user_info,'data' => $data]);
        }
    }

    public function taocongviec()
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
            $data = DB::table('nhanvien')
            ->where('nhanvien.MaDV',$donvi->MaDV )
            ->where('nhanvien.trangthai',1)
            ->where('nhanvien.MaNV','<>',$donvi->Matruongphong)
            ->wherenull('nhanvien.Is_deleted')
            ->get();
            return  view ('congviec.taocongviec',['data'=>$data,'user_info'=>$user_info]);
        }
    }

    public function luucongviec(Request $re) {

        
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
            $re->validate([
                'tencv'=>'required|string|max:150|unique:congviec,Tieude',
                'ngaykt'=>'required|date|after_or_equal:today',
                'Mota'=>'required|string',
                'nhanvien' => 'required',
                'mucdocv' => 'required|numeric|between:0,3'
            ],[
                'tencv.required' => 'Vui lòng không để trống tên công việc!',
                'tencv.string' => 'Vui Nhập tên công việc !',
                'tencv.max' => 'Tên công việc quá dài, cân nhắc thay đổi tên !',
                'tencv.unique' => 'Tên công việc bị trùng!',
                'ngaykt.required' => 'Vui lòng không để trống ngày kết thúc!',
                'ngaykt.date' => 'Vui lòng nhập đúng định dạng ngày !',
                'ngaykt.after_or_equal' => 'Vui lòng chọn ngày là ngày hôm nay hoặc sau ngày hôm nay!',
                'Mota.required' => 'Vui lòng không để trống mô tả công việc!',
                'Mota.string' => 'Vui lòng nhập mô tả !',
                'nhanvien.required' => 'Vui lòng chọn nhân viên',
                'mucdocv.required' => 'Vui lòng chọn độ ưu tiên',
                'mucdocv.numeric' => 'Độ ưu tiên không hợp lệ',
                'mucdocv.between' => 'Độ ưu tiên không hợp lệ',
            ]);
            $stt = DB::table('congviec')->count()+1;
            $ma = "CV".$stt;
            $currentTime = Carbon::now()->toDateString();
            DB::beginTransaction();
            try {
                DB::table('congviec')->insert([
                    'MaCV' =>$ma,
                    'tieude' => $re->tencv,
                    'Noidung' => $re->Mota,
                    'Ngaytao' => $currentTime,
                    'MaDV' => $donvi->MaDV,
                    'mucdocv' => $re->mucdocv
                ]);
                $file = $re -> file('formFileMultiple');
                if (!empty($file)) {
                    foreach ($file as $item){
                        $name_file = $item ->getClientOriginalName('formFileMultiple');
                        $extension = $item ->getClientOriginalExtension('formFileMultiple');
                        if (strcasecmp($extension,'jpg') === 0 || strcasecmp($extension,'png') === 0 || strcasecmp($extension,'pdf') === 0 || strcasecmp($extension,'doc') === 0 
                        || strcasecmp($extension,'docx') === 0|| strcasecmp($extension,'xlsx') === 0|| strcasecmp($extension,'pptx') === 0|| strcasecmp($extension,'ppsx') === 0
                        || strcasecmp($extension,'mp4') === 0 || strcasecmp($extension,'txt') === 0) {
                            $name = $ma.'_'.$name_file;
                            $item ->move('docs',$name);
                            DB::table('hosocongviec')->insert([
                                'MaCV' =>$ma,
                                'duongdan' =>$name
                            ]);
                        } else {
                            return redirect()->route('taocongviec')->withErrors('định dạng của file "'.$name_file.'" không được hổ trợ!');
                        }
                    }
                }
                if (!empty($re->nhanvien)){
                    foreach($re->nhanvien as $nv) {
                        $u = DB::table('nhanvien') ->where('nhanvien.MaNV',$nv)->first();
                        if (!empty($u)) {
                            DB::table('congviec_nhanvien')->insert([
                                'MaCV' =>$ma,
                                'MaNV' => $u->MaNV,
                                'NgayGiao' => $currentTime,
                                'Trangthai' => 0,
                                'HanDK' => $re->ngaykt,
                            ]);
                            $magiao = DB::table('congviec_nhanvien')->max('congviec_nhanvien.magiao');
                            $data['macv'] = $magiao;
                            $data['name'] = $u->TenNV;
                            $address = $u->Email;
                            $data['han'] = $re->ngaykt;
                            $data['phongban'] =$donvi->TenPhong;
                            $data['tencongviec'] = $re->tencv;
                            Mail::send('email.mail', ['data' => $data], function ($message) use($address,$data) {
                                $message->subject('[Worktogether - bạn nhận được 1 công việc mới]');
                                $message->to($address);
                            });
                        }
                    }
                        
                }
                $maghi = "NK".DB::table('nhatkycv')->count();
                DB::table('nhatkycv')->insert([
                    'Maghi' =>$maghi,
                    'MaCV' => $ma,
                    'NoiDung' =>"Giao công việc ".$re->tencv." cho ".$u->TenNV,
                    'MaNV' => $user_info->MaNV,
                    'NgayTao' => $currentTime,
                    'loaink' => 1
                ]);
                DB::commit();
                session()->flash('success','Thêm công việc thành công. thông tin đã được ghi vào CSDL');
                return redirect()->route('listcongviecpb');
            }  catch (Exception $e) {
                DB::rollBack();
                session()->flash('mess','Lỗi hệ thống thử lại sau!');
                return redirect()->route('listcongviecpb');
            }
        }
    }
    
    public function updatecv(Request $re) {
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
        }  else 
        if ($user_info->MaQuyen!='002' || $user_info->MaNV != $donvi->Matruongphong) {
            session()->flash('mess','Bạn Không Có Quyền Thực Hiện Chức Năng Này');
            return redirect()->route('IndexUser');
        } else {
            $cv = DB::table('congviec')
            ->join('congviec_nhanvien', 'congviec.MaCV', '=', 'congviec_nhanvien.MaCV')
            ->join('nhanvien', 'congviec_nhanvien.MaNV', '=', 'nhanvien.MaNV')
            ->where('congviec_nhanvien.magiao',$re->magiao)
            ->first();
            if (empty( $cv)) {
                session()->flash('mess','Lỗi hệ thống');
                return redirect()->route('IndexUser');
            }

            if ($cv->Tieude ===$re-> tencv && $cv->Noidung===$re -> Mota && $cv->MaNV ===$re->nhanvien && $cv->HanDK ===$re->ngaykt) {
                return redirect()->route('listcongviecpb');
            }
            if ($cv->Tieude !==$re-> tencv) {
                $re->validate([
                    'tencv'=>'required|string|max:150'],[
                        'tencv.required' => 'Vui lòng không để trống tên công việc!',
                        'tencv.string' => 'Vui Nhập tên công việc !',
                        'tencv.max' => 'Tên công việc quá dài, cân nhắc thay đổi tên !',
                    ]);
            }

            if ($cv->Noidung!==$re -> Mota) {
                $re->validate([
                    'Mota'=>'required|string'
                ],[
                    'Mota.required' => 'Vui lòng không để trống mô tả công việc!',
                    'Mota.string' => 'Vui lòng nhập mô tả !'
                ]);
            }
            
            if($cv->HanDK !==$re->ngaykt) {
                $re->validate([
                    'ngaykt'=>'required|date'
                ],[
                    'ngaykt.required' => 'Vui lòng không để trống ngày kết thúc!',
                    'ngaykt.date' => 'Vui lòng nhập đúng định dạng ngày !'
                ]);
            }
            if ($cv->MaNV !==$re->nhanvien) {

                $re->validate([
                    'nhanvien'=>'required'
                ],[
                    'nhanvien.required' => 'Vui lòng chọn nhân viên!',
                ]);
            }
            $currentTime = Carbon::now()->toDateString();
            $u =  DB::table('nhanvien')->where('nhanvien.MaNV', $re->nhanvien)->first();
            if (empty($u)) {
                session()->flash('mess','Nhân viên bạn chọn không tồn tại vui lòng thử lại');
                return redirect()->route('IndexUser');
            }
            $ma = $re->MaCV;
            $noidung = "Cập nhật: Tên công việc: ".$re->tencv.", Noidung: ".$re->Mota.", ";
            DB::table('congviec')->where('congviec.MaCV',$ma)
            ->update([
                'tieude' => $re->tencv,
                'Noidung' => $re->Mota,
            ]);
            if ($cv->MaNV !==$re->nhanvien ) {
                $nhanviencv = DB::table('congviec_nhanvien') 
                ->where('congviec_nhanvien.MaNV',$re->nhanvien) 
                ->where('congviec_nhanvien.MaCV',$re->MaCV)
                ->first();
                if (!empty($nhanviencv)) {
                    session()->flash('mess','Nhân viên bạn chọn củng đang thực hiện công việc này');
                    return redirect()->route('chitietcongviec',['id'=>$re->magiao]);
                }
                $noidung = $noidung."Nhân viên thực hiện: ".$re->nhanvien;
                DB::table('congviec_nhanvien')->where('congviec_nhanvien.magiao',$re->magiao)
                ->update([
                    'MaNV' => $re->nhanvien,
                    'NgayGiao' =>$currentTime,
                    'HanDK' => $re->ngaykt
                ]);

                $data['name'] = $u->TenNV;
                $address = $u->Email;
                $data['han'] = $re->ngaykt;
                $data['phongban'] =$donvi->TenPhong;
                $data['tencongviec'] = $re->tencv;
                $data['macv'] = $re->MaCV;
                Mail::send('email.mail', ['data' => $data], function ($message) use($address,$data) {
                    $message->subject('[Worktogether - bạn nhận được 1 công việc mới]');
                    $message->to($address);
                });
            } else {
                $noidung = $noidung.", Thời hạn:".$re->ngaykt;
                DB::table('congviec_nhanvien')->where('congviec_nhanvien.magiao',$re->magiao)
                ->update([
                    'HanDK' => $re->ngaykt
                ]);
            }
            $maghi = "NK".DB::table('nhatkycv')->count();
                DB::table('nhatkycv')->insert([
                    'Maghi' =>$maghi,
                    'MaCV' => $ma,
                    'NoiDung' =>$noidung,
                    'MaNV' => $user_info->MaNV,
                    'NgayTao' => $currentTime,
                    'loaink' => 1
                ]);
            session()->flash('success','Cập nhật công việc thành công. thông tin đã được ghi vào CSDL');
            return redirect()->route('listcongviecpb');
        }
    }

    public function luutrangthai(Request $re) {
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
        }  else {
            $data = [];
            $data = DB::table('congviec')
                ->join('congviec_nhanvien', 'congviec.MaCV', '=', 'congviec_nhanvien.MaCV')
                ->join('nhanvien', 'congviec_nhanvien.MaNV', '=', 'nhanvien.MaNV')
                ->where('congviec.MaCV',$re->MaCV )
                ->first();
            if (empty($data)) {
                session()->flash('mess','Lỗi hệ thống vui lòng thử lại sau!');
                return redirect()->route('IndexUser');
            }
            if ($data->MaQuyen==='000' && $data->MaNV != $user_info->MaNV) {
                session()->flash('mess','Bạn không có quyền thay đổi công việc này');
                return redirect()->route('dscongviec');
            }
            $re->validate(['trangthai'=> 'required|numeric|between:1,2'],[
                'trangthai.required' => 'Vui lòng chọn trạng thái!',
                'trangthai.numeric' => 'Trạng thái không hợp lệ!',
                'trangthai.between' => 'Trạng thái không hợp lệ!',
            ]);
            $currentTime = Carbon::now()->toDateString();
            DB::beginTransaction();
            try {
                $noidung = "Chuyển trạng thái -> ";
                if ($re->trangthai == 2) {
                    DB::table('congviec_nhanvien') ->where('congviec_nhanvien.magiao',$re->magiao )
                    ->update (['HanTT'=>$currentTime,'congviec_nhanvien.Trangthai'=>$re->trangthai]);
                    $noidung = $noidung."Đã Hoàn thành (".$currentTime.")";
                }
                else {

                    DB::table('congviec_nhanvien') ->where('congviec_nhanvien.magiao',$re->magiao )
                    ->update (['congviec_nhanvien.Trangthai'=>$re->trangthai]);
                    $noidung = $noidung."Đang thực hiện";
                }
                $maghi = "NK".DB::table('nhatkycv')->count();
                DB::table('nhatkycv')->insert([
                    'Maghi' =>$maghi,
                    'MaCV' => $re->MaCV,
                    'NoiDung' =>$noidung,
                    'MaNV' => $user_info->MaNV,
                    'NgayTao' => $currentTime,
                    'loaink' => 1
                ]);
                $file = $re -> file('formFileMultiple');
                if (!empty($file)) {
                    foreach ($file as $item){
                        $name_file = $item ->getClientOriginalName('formFileMultiple');
                        $extension = $item ->getClientOriginalExtension('formFileMultiple');
                        if (strcasecmp($extension,'jpg') === 0 || strcasecmp($extension,'png') === 0 || strcasecmp($extension,'pdf') === 0 || strcasecmp($extension,'doc') === 0 
                        || strcasecmp($extension,'docx') === 0|| strcasecmp($extension,'xlsx') === 0|| strcasecmp($extension,'pptx') === 0|| strcasecmp($extension,'ppsx') === 0
                        || strcasecmp($extension,'mp4') === 0 || strcasecmp($extension,'txt') === 0) {
                            $name = $re->MaCV.'_'.$name_file;
                            $item ->move('docs',$name);
                            DB::table('hosocongviec')->insert([
                                'MaCV' =>$re->MaCV,
                                'duongdan' =>$name
                            ]);
                        } else {
                            return redirect()->route('taocongviec')->withErrors('định dạng của file "'.$name_file.'" không được hổ trợ!');
                        }
                    }
                }
                DB::commit();
                session()->flash('success','Cập nhật công việc thành công. thông tin đã được ghi vào CSDL');
                return redirect()->route('chitietcongviecnhanvien',['id'=>$re->MaCV]);
            } catch (Exception $e) {
                DB::rollBack();
                session()->flash('mess','Lỗi hệ thống thử lại sau!');
                return redirect()->route('chitietcongviecnhanvien',['id'=>$re->MaCV]);
            }
        }
    }

    public function themqa($id) {
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
        }
       else  if ($user_info ->MaQuyen != '001') {
            session()->flash('mess','Bạn Không Có Quyền Thực Hiện Chức Năng Này');
            return redirect()->route('IndexUser');
        } else {
            $data = DB::table('congviec')
            ->select('congviec.*','congviec_nhanvien.*')
            ->join('congviec_nhanvien', 'congviec_nhanvien.MaCV', '=', 'congviec.MaCV')
            ->join('nhanvien', 'nhanvien.MaNV', '=', 'congviec_nhanvien.MaNV')
            ->where('congviec_nhanvien.MaNV',$user->MaNV)
            ->where('congviec.MaCV',$id)
            ->first();
            if (empty($data)) {
                session()->flash('mess','Công việc không tồn tại hoặc bạn không có quyền đối với công việc này!');
                return redirect()->route('IndexUser');
            } else {
                return  view('congviec.themqa',['user_info'=>$user_info,'data'=>$data]);
            }
        }
    }

    public function luuqa(Request $re){
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
        }
       else  if ($user_info ->MaQuyen != '001') {
            session()->flash('mess','Bạn Không Có Quyền Thực Hiện Chức Năng Này');
            return redirect()->route('IndexUser');
        } else {
            $data = DB::table('congviec')
            ->select('congviec.*','congviec_nhanvien.*')
            ->join('congviec_nhanvien', 'congviec_nhanvien.MaCV', '=', 'congviec.MaCV')
            ->join('nhanvien', 'nhanvien.MaNV', '=', 'congviec_nhanvien.MaNV')
            ->where('congviec_nhanvien.MaNV',$user->MaNV)
            ->where('congviec.MaCV',$re->MaCV)
            ->first();
            if (empty($data)) {
                session()->flash('mess','Công việc không tồn tại hoặc bạn không có quyền đối với công việc này!');
                return redirect()->route('IndexUser');
            } else {
                $re->validate([
                    'MaCV' => 'required|exists:congviec,MaCV',
                    'noidung'=>'required|string|min:20'
                ],[
                    'MaCV.required' => 'Vui lòng chọn công việc',
                    'MaCV.exists' => 'Công việc không tồn tại!!',
                    'noidung.required' => 'Vui lòng không để trống tên công việc!',
                    'noidung.string' => 'Vui Nhập nội dung là chữ !',
                    'noidung.min' => 'Nội dung chưa đảm bảo vui lòng nhập chi tiết!'
                ]);
                DB::beginTransaction();
                try {
                    $stt = DB::table('qa')->count()+1;
                    $ma = "QA".$stt;
                    $currentTime = Carbon::now()->toDateString();
                    DB::table('qa')
                    ->insert([
                        'MaQA' => $ma,
                        'MaCV' => $re -> MaCV,
                        'Noidungqa' => $re->noidung,
                        'MaNV' => $user_info->MaNV,
                        'ngayghiqa' => $currentTime
                    ]);
                    DB::commit();
                    session()->flash('success','Thêm câu hỏi thành công!!');
                    return redirect()->route('chitietcongviecnhanvien',['id'=>$re->MaCV]);
                }  catch (Exception $e) {
                    DB::rollBack();
                    session()->flash('mess','Lỗi hệ thống thử lại sau!');
                    return redirect()->route('dscongviec');
                }
            }
        }
    }
    public function dscongviecnhanxet() {
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
            $data = DB::table('congviec')
            ->join('congviec_nhanvien', 'congviec.MaCV', '=', 'congviec_nhanvien.MaCV')
            ->join('nhanvien', 'congviec_nhanvien.MaNV', '=', 'nhanvien.MaNV')
            ->where('congviec.MaDV',$donvi->MaDV )
            ->where('congviec_nhanvien.Trangthai',2 )
            ->orderBy('congviec_nhanvien.Trangthai', 'ASC')
            ->orderBy('congviec_nhanvien.HanDK', 'DESC')
            ->paginate(8);
            return  view ('congviec.congviecnhanxet',['data'=>$data,'user_info'=>$user_info]);
        }
    }

    public function nhanxetcv($id) {
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
        }  else {
            $data = [];
            $data = DB::table('congviec')
                ->join('congviec_nhanvien', 'congviec.MaCV', '=', 'congviec_nhanvien.MaCV')
                ->join('nhanvien', 'congviec_nhanvien.MaNV', '=', 'nhanvien.MaNV')
                ->where('congviec.MaCV',$id )
                ->first();
            if (empty($data)) {
                session()->flash('mess','Lỗi hệ thống vui lòng thử lại sau!');
                return redirect()->route('IndexUser');
            }
           $nhanvien = DB::table('nhanvien')
            ->where('nhanvien.MaDV',$user->MaDV )
            ->where('nhanvien.MaNV','<>',$donvi->Matruongphong)
            ->get();
            // dd($nhanvien);
            $nhatky = DB::table('nhatkycv')
            ->select( DB::raw('SUM(nhatkycv.sogio) as tongcong'))
            ->where('nhatkycv.MaCV',$id)
            ->groupBy('nhatkycv.MaCV')
            ->get();
           $data->nhanvien= $nhanvien->all();  
           $hscv = [];
           $hscv = DB::table('hosocongviec') 
           ->join('congviec','hosocongviec.MaCV','=','congviec.MaCV')
           ->where('hosocongviec.MaCV',$data->MaCV) 
           ->get();
           $data-> hscv=$hscv->all();
           return view('congviec.nhanxetcv',['user_info'=>$user_info,'data' => $data]);
           //    dd($data);
        }
    }
    
    public function luutrangthaicv(Request $re) {
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
            $cv = DB::table('congviec')
            ->join('congviec_nhanvien', 'congviec.MaCV', '=', 'congviec_nhanvien.MaCV')
            ->join('nhanvien', 'congviec_nhanvien.MaNV', '=', 'nhanvien.MaNV')
            ->where('congviec.MaCV',$re->MaCV)
            ->first();
            if (empty( $cv)) {
                session()->flash('mess','Lỗi hệ thống');
                return redirect()->route('IndexUser');
            }
            $re->validate([
                'diem'=>'numeric|between:0,10',
                'noidungnhanxet'=>'string',
            ],[
                'diem.numeric' => 'Vui lòng nhập điểm là số',
                'diem.between' => 'Vui lòng nhập điểm từ 0 đến 10!',
                'noidungnhanxet.string' => 'Vui Nhập tên công việc !',
            ]);
            DB::beginTransaction();
            try {
                $currentTime = Carbon::now()->toDateString();
                $param = [
                    'Nhanxet' => $re->noidungnhanxet,
                    'diem' => $re->diem
                ];
                if ($cv->Trangthai !== $re->trangthai ) {
                    $param['HanTT'] = null;
                    $param['Trangthai'] = $re->trangthai;
                }
                DB::table('congviec_nhanvien')->where('congviec_nhanvien.magiao',$re->magiao)
                    ->update($param);

                $maghi = "NK".DB::table('nhatkycv')->count();
                DB::table('nhatkycv')->insert([
                    'Maghi' =>$maghi,
                    'MaCV' => $re->MaCV,
                    'NoiDung' =>"Nhận xét công việc ".$cv->Tieude." \n Điểm: ".$re->diem,
                    'MaNV' => $user_info->MaNV,
                    'NgayTao' => $currentTime,
                    'loaink' => 1
                ]);
                DB::commit();
                session()->flash('success','Thêm nhận xét thành công. thông tin đã được ghi vào CSDL');
                return redirect()->route('nhanxetcv',['id'=>$re->MaCV]);
            }  catch (Exception $e) {
                DB::rollBack();
                session()->flash('mess','Lỗi hệ thống thử lại sau!');
                return redirect()->route('dscongviecnhanxet');
            }
        }
    }

    public function xemketqua() {
        $user= session('dangnhap.user_info');
        $user_info = DB::table('nhanvien')
        ->join('donvi', 'nhanvien.MaDV', '=', 'donvi.MaDV')
        ->join('phanquyen', 'nhanvien.MaQuyen', '=', 'phanquyen.MaQuyen')
        ->where('nhanvien.MaNV',$user->MaNV )
        ->where('nhanvien.trangthai',1)
        ->first();
        $donvi = DB::table('donvi') ->where('donvi.MaDV',$user->MaDV)->first();
        if (!$this->checksessionlogin() || empty($user_info)) {
            session()->flash('mess','Vui lòng đăng nhập');
            return redirect()->route('login');
        } else {
            $data = DB::table('congviec')
            ->join('congviec_nhanvien', 'congviec.MaCV', '=', 'congviec_nhanvien.MaCV')
            ->join('nhanvien', 'congviec_nhanvien.MaNV', '=', 'nhanvien.MaNV')
            ->where('congviec_nhanvien.MaNV',$user->MaNV )
            ->where('congviec_nhanvien.Trangthai',3 )
            ->orwhere('congviec_nhanvien.Trangthai',2 )
            ->get();
            $nhatky = [];
            $nhatky = DB::table('nhatkycv')
            ->select('nhatkycv.MaCV', DB::raw('SUM(nhatkycv.sogio) as tongcong'))
            ->groupBy('nhatkycv.MaCV')
            ->get();
            if (!empty($data) && !empty($nhatky)) {
                foreach($data as $item) {
                    $item -> tonggio = 0;
                    foreach($nhatky as $nk) {
                        if ($nk->MaCV==$item->MaCV) {
                            $item -> tonggio = $nk->tongcong;
                        }
                    }
                }
            }
            // dd($data);
            return  view ('congviec.ketquacongviec',['data'=>$data,'user_info'=>$user_info]);
        }
    }
    public function checksessionlogin() {
        return session()->has('dangnhap');
    }

    public function download(Request $re,$file) {
            $file_path = public_path('docs/'.$file);
            return response()->download($file_path);
          }
      
}
