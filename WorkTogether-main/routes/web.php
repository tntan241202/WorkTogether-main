<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use Illuminate\Support\Facades\Redirect;
use App\nguoidung;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/','LoginController@index')->name('login');
Route::post('checklogin','LoginController@check')->name('checklogin');
Route::get('/home','HomeController@index')->name('IndexUser');
Route::get('/logout',function(){
    session()->forget('dangnhap');
    return redirect('/');
})->name('logout');
// quản lý công việc 
Route::get('/congviec/taocongviec','CongViecController@taocongviec')->name('taocongviec');
Route::get('/congviec/dscongviecphongban','CongViecController@dscongviecpb')->name('listcongviecpb');
Route::get('/congviec/dscongviec','CongViecController@dscongviec')->name('dscongviec');
Route::get('congviec/chitietcongviec/{id}','CongViecController@chitietcongviec')->name('chitietcongviec');
Route::get('congviec/chitietcongviecnhanvien/{id}','CongViecController@chitietcongviecnhanvien')->name('chitietcongviecnhanvien');
Route::post('luucongviec','CongViecController@luucongviec')->name('luucongviec');
Route::post('updatecv','CongViecController@updatecv')->name('updatecv');
Route::post('luutrangthai','CongViecController@luutrangthai')->name('luutrangthai');
Route::get('/congviec/themqa/{id}','CongViecController@themqa')->name('themqa');
Route::post('luuqa','CongViecController@luuqa')->name('luuqa');
Route::get('/congviec/dscongviecnhanxet','CongViecController@dscongviecnhanxet')->name('dscongviecnhanxet');
Route::get('congviec/nhanxetcv/{id}','CongViecController@nhanxetcv')->name('nhanxetcv');
Route::post('luutrangthaicv','CongViecController@luutrangthaicv')->name('luutrangthaicv');
Route::get('/congviec/xemketqua','CongViecController@xemketqua')->name('xemketqua');
//nhân viên
Route::get('/list_nhanvien','UserController@list_nhanvien')->name('list_nhanvien');
Route::get('/chitietnhanvien/{id}','UserController@chitietnhanvien')->name('chitietnhanvien');
Route::post('SuaNhanVien','UserController@SuaNhanVien')->name('SuaNhanVien');
Route::get('/nhanvien/themnhanvien','UserController@themnhanvien')->name('themnhanvien');
Route::get('/nhanvien','UserController@index')->name('tatcanhanvien');
Route::post('luunhanvien','UserController@luu')->name('luunhanvien');
Route::get('/nhanvien/doimatkhau','UserController@doipass')->name('doimatkhau');
Route::get('/quenmatkhau','UserController@quenmatkhau')->name('quenmatkhau');
Route::get('/nhanvien/thongtincanhan','UserController@thongtincanhan')->name('thongtincanhan');
Route::post('Luudoimatkhau','UserController@Luudoimatkhau')->name('Luudoimatkhau');
Route::post('resetpass','UserController@resetpass')->name('resetpass');
Route::get('/XoaNhanVien/{id}','UserController@XoaNhanVien')->name('XoaNhanVien');
//quản lý đơn vị
Route::get('donvi/listdonvi','DonViController@listdonvi')->name('listdonvi');
Route::get('donvi/themdonvi','DonViController@themdonvi')->name('themdonvi');
Route::post('luudonvi','DonViController@luudonvi')->name('luudonvi');
Route::get('donvi/chitietdonvi/{id}','DonViController@chitietdonvi')->name('chitietdonvi');
Route::post('updatedonvi','DonViController@updatedonvi')->name('updatedonvi');
Route::get('/XoaDonVi/{id}','DonViController@XoaDonVi')->name('XoaDonVi');
//Tìm kiếm
Route::get('/Searchnhanvien','UserController@Searchnhanvien')->name('Searchnhanvien');
//Route::get('/Searchnhanvienbyid','UserController@Searchnhanvienbyid')->name('Searchnhanvien');
Route::get('/Searchdonvi','DonViController@Searchdonvi')->name('Searchdonvi');
//Nhật ký
Route::get('/nhatky/themnhatky','NhatKyController@themnhatky')->name('themnhatky');
Route::get('/nhatky/themnhatky/{id}','NhatKyController@themnhatkychitietcv');
Route::get('/nhatky/xemnhatky','NhatKyController@xemnhatky')->name('xemnhatky');
Route::get('/nhatky/xemnhatkyphongban','NhatKyController@xemnhatkyphongban')->name('xemnhatkyphongban');
Route::post('luunhatky','NhatKyController@luunhatky')->name('luunhatky');
Route::post('SortPB','NhatKyController@SortPB')->name('SortPB');
Route::post('SortNV','NhatKyController@SortNV')->name('SortNV');
//Lock
Route::get('/chuyentrangthai/{id}/{trangthai}','UserController@chuyentrangthai');

//thống kê
Route::get('thongke','ThongKeController@thongke')->name('thongke');

Route::post('xemthongke','ThongKeController@xemthongke')->name('xemthongke');

Route::get('/download/{file}', 'CongViecController@download')->name('download');
