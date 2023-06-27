
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
                        <form action="{{ route('SuaNhanVien') }}" method="post" enctype="multipart/form-data">@csrf
                            <h5 class="mb-4">Chi tiết nhân viên  </h5>
                                <input type="hidden" value="{{$data->MaNV}}" name="manv">

                                <div class="mb-3">
                                    <label for="" class="form-label"> <b>Tên nhân viên</b> </label>
                                    {{-- <p> {{$user_info->TenNV}} </p>   --}}
                                    <input value="{{$data->TenNV}}" type="text"class="form-control" id=""  name="tennv">
                                </div>
                                <div class="mb-3">
                                    <label for="" class="form-label"> <b>Giới tính</b></label>
                                    {{-- <input type="" class="form-control" id="" value="{{$data->Gt}}"> --}}
                                    <select id=""  class="form-control" name="gioitinh">
                                        <option value="0" @if ($data->Gt)
                                            {{"selected"}}
                                        @endif>Nam</option>
                                        <option value="1" @if (!$data->Gt)
                                            {{"selected"}}
                                        @endif>Nữ</option>
                                    </select>
                                </div>

                                <div class="mb-3">
                                    <label for="" class="form-label"><b>Ngày sinh</b></label>
                                    <input type="date" class="form-control" id="" value="{{$data->NgaySinh}}" name="ngaysinh">
                                </div>
                                <div class="mb-3">
                                    <label for="exampleInputEmail1" class="form-label"><b>Email</b></label>
                                    <input type="email" class="form-control" id="exampleInputEmail1"
                                        aria-describedby="emailHelp"  value="{{$data->Email}}" name="email">
                                    <div id="emailHelp" class="form-text">
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label for="" class="form-label"><b>Số điện thoại</b></label>
                                    <input type="" class="form-control" id="" value="{{$data->SDT}}"  name="sdt">
                                </div>
                                <div class="mb-3">
                                    <label for="" class="form-label"><b>Địa chỉ</b></label>
                                    <input type="" class="form-control" id=""  value="{{$data->DiaChi}}" name="diachi">
                                </div>
                                
                                <button type="submit" class="btn btn-primary"> Sửa </button>
                                {{-- <a href="{{url("XoaNhanVien/{$data->MaNV}")}}"  class="btn btn-primary">Xóa </a>  --}}
                              
                            
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