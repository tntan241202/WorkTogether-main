
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
                <div class="container-fluid pt-4 px-4">
                    <div class="row g-4">
                        <div class="col-sm-12 col-xl-12">
                            <div class="bg-light rounded h-100 p-4">
                                <h6 class="mb-4">Thông Tin Nhân Viên:</h6>
                                <div class="testimonial-item text-center">
                                    <img class="img-fluid rounded-circle mx-auto mb-4" src="{{url('accessweb/img/'.$user_info ->Avt)}}" style="width: 100px; height: 100px;">
                                    <h5 class="mb-1">Tên Nhân Viên: {{$user_info->TenNV}}</h5>
                                    <p>Chức vụ {{$user_info->TenQuyen}}</p>
                                    <p>Tên Đơn Vị: {{$user_info->TenPhong}}</p>
                                    <p>Giới Tính: @if ($user_info->Gt)
                                        {{"Nữ"}}
                                    @else
                                        {{"Nam"}}
                                    @endif </p>
                                    <p>Ngày Sinh: {{$user_info->NgaySinh}}</p>
                                    <p>Email: {{$user_info->Email}}</p>
                                    <p>Số Điện Thoại: {{$user_info->SDT}}</p>
                                    <p>Địa Chỉ: {{$user_info->DiaChi}}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div> 
            <!-- Navbar End -->
            
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