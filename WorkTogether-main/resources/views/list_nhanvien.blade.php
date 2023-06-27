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
                            <h6 class="mb-4">Danh sách nhân viên</h6>
                           
                        </div>
                    </div>
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    {{-- <th scope="col">Mã nhân viên</th> --}}
                                    <th scope="col">Tên nhân viên</th>
                                    <th scope="col">Giới tính</th>
                                    <th scope="col">Ngày sinh</th>
                                    <th scope="col">Email</th>
                                    <th scope="col">Số điện thoại</th>
                                    <th scope="col">Địa chỉ</th>
                                    <th scope="col">Thao tác</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($list_user as $item)
                                <tr>
                                    {{-- <td>{{$item->MaNV}}</td> --}}
                                    <td>{{$item->TenNV}}</td>
                                    <td>@if ($item->Gt)
                                        {{"Nữ"}}
                                    @else
                                        {{"Nam"}}
                                    @endif</td>
                                    <td>{{$item->NgaySinh}}</td>
                                    <td>{{$item->Email}}</td>
                                    <td>{{$item->SDT}}</td>
                                    <td>{{$item->DiaChi}}</td>

                                    <td> 
                                        <a href=""> Xóa </a>
                                        <a href=""> Sửa </a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
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