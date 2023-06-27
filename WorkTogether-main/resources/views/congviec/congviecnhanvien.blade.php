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
             <!-- Table Start -->
             <div class="container-fluid pt-4 px-4">
                <div class="row g-4">
                    <div class="col-12">
                        <div class="bg-light rounded h-100 p-4">
                            <h6 class="mb-4">Danh Sách Công Việc</h6>
                            <div class="table-responsive">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th scope="col">Tên Công Việc</th>
                                            <th scope="col">Ngày Tạo</th></th>
                                            <th scope="col">Hạn Hoàn Thành</th>
                                            <th scope="col">Mức Độ Ưu Tiên</th>
                                            <th scope="col">Trạng Thái</th>
                                            <th scope="col">Thao Tác</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($data as $item)
                                        <tr>
                                            <td>{{ $item->Tieude }}</td>
                                            <td>{{ date('d-m-Y', strtotime($item->Ngaytao)) }}</td>
                                            <td>{{ date('d-m-Y', strtotime($item->HanDK)) }}</td>
                                            @switch($item->mucdocv)
                                                @case(0)
                                                    <td style="color:#ecf022;">Thấp</td>
                                                    @break
                                                @case(1)
                                                    <td style="color:#ffad33;">Vừa</td>
                                                    @break
                                                @case(2)
                                                <td style="color:#e66909;">Cao</td>
                                                @break
                                                @case(3)
                                                <td style="color:#ff4133;">Gấp</td>
                                                @break
                                            @endswitch
                                            @switch($item->Trangthai)
                                                @case(0)
                                                    <td style="color:#33FF83;">Đã Giao</td>
                                                    @break
                                                @case(1)
                                                    <td style="color:#33FF83;">Đang Thực Hiện</td>
                                                    @break
                                                @case(2)
                                                <td style="color:#33FF83;">Đã Hoàn Thành</td>
                                                @break
                                                @case(3)
                                                <td style="color:#33FF83;">Hoàn Thành</td>
                                                @break
                                            @endswitch
                                            <td>
                                                <a href="{{ url('congviec/chitietcongviecnhanvien/')}}/{{ $item->MaCV }}"><button type="button" class="btn btn-sm btn-sm-square btn-outline-primary m-2"><i class="fa fa-info"></i></button>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                                <div>
                                    {{ $data->links() }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Table End -->
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