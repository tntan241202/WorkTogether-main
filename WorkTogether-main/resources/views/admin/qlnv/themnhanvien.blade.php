
<!DOCTYPE html>
<html lang="en">
@extends('layout.head')
@section('Title')
    Trang Chủ
@endsection
<body>
    <div class="container-xxl position-relative bg-white d-flex p-0">
        <!-- Sidebar Start -->
        @extends('layout.sidebar')
        <!-- Sidebar End -->
        <!-- Content Start -->
        <div class="content">
            <!-- Navbar Start -->
            <nav class="navbar navbar-expand bg-light navbar-light sticky-top px-4 py-0">
                @include('layout.navbar')
            </nav>
            @include('layout.message')
            <!-- Navbar End -->
            <div class="container-fluid pt-4 px-4">
                <div class="row g-4">
                    <div class="col-sm-12 col-xl-12">
                        <div class="bg-light rounded h-100 p-4">
                        <form action="{{ route('luunhanvien') }}" method="post" enctype="multipart/form-data">@csrf
                            <h6 class="mb-4">Thêm nhân viên     </h6>
                            <div class="row mb-3">
                                <label for="inputEmail3" class="col-sm-2 col-form-label">Tên nhân viên </label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" name="tennv" value="{{ old('tennv') }}">
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label for="inputEmail3" class="col-sm-2 col-form-label">Giới Tính </label>
                                <div class="col-sm-10">
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="gioitinh"
                                            id="gridRadios1" value="0" {{ (old('gioitinh') == '0') ? 'checked' : ''}} >
                                        <label class="form-check-label" for="gridRadios1">
                                            Nam
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="gioitinh"
                                            id="gridRadios1" value="1"  {{ (old('gioitinh') == '1') ? 'checked' : ''}}>
                                        <label class="form-check-label" for="gridRadios1">
                                            Nữ
                                        </label>
                                    </div>
                                </div>
                                
                            </div>
                            <div class="row mb-3">
                                <label for="" class="col-sm-2 col-form-label">Ngày sinh</label>
                                <div class="col-sm-10">
                                    <input type="Date" class="form-control" name="ngaysinh" value="{{ old('ngaysinh') }}">
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label for="inputEmail3" class="col-sm-2 col-form-label">Email</label>
                                <div class="col-sm-10">
                                    <input type="email" class="form-control" name="email" value="{{ old('email') }}">
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label for="" class="col-sm-2 col-form-label">Số điện thoại</label>
                                <div class="col-sm-10">
                                    <input type="tel    " class="form-control" name="sdt" value="{{ old('sdt') }}">
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label for="" class="col-sm-2 col-form-label">Địa chỉ</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" name="diachi" value="{{ old('diachi') }}">
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label for="" class="col-sm-2 col-form-label">Tên đăng nhập</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" name="tendn" value="{{ old('tendn') }}">
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label for="" class="col-sm-2 col-form-label">Mật khẩu</label>
                                <div class="col-sm-10">
                                  <input type="password" name="pws" class="form-control"  value="{{ old('pws') }}" autocomplete="new-password">
                                </div>
                            </div>
                            
                            <div class="row mb-3">
                                <label for="" class="col-sm-2 col-form-label">Đơn Vị</label>
                                <div class="col-sm-10">
                                    <select class="form-select mb-3" aria-label="Default select example" name="donvi" >
                                        @foreach ($donvi as $item)
                                        <option value = {{ $item->MaDV }}>{{ $item->TenPhong}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <button type="submit" class="btn btn-primary">Lưu</button>
                            <button type="reset" class="btn btn-primary">Hủy</button>
                        </form>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Footer Start -->
            @include('layout.footer')
            <!-- Footer End -->
        </div>
        <!-- Content End -->


        <!-- Back to Top -->
        <a href="#" class="btn btn-lg btn-primary btn-lg-square back-to-top"><i class="bi bi-arrow-up"></i></a>
    </div>

    <!-- JavaScript Libraries -->
    @include('layout.script')
    <!-- Template Javascript -->
    <script src="{{url('accessweb/js/main.js')}}"></script>
</body>

</html>