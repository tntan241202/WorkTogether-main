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
            @if(session()->has('mess'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <i class="fa fa-exclamation-circle me-2"></i>{{ session('mess') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
			@endif
            @if(session()->has('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
			@endif
            <!-- Navbar End -->
            <!-- Widgets Start -->
            <form action="{{ route('xemthongke') }}" method="post" enctype="multipart/form-data">@csrf
            <div class="container-fluid pt-4 px-4">
                <div class="row g-4">
                    <div class="col-sm-12 col-xl-12">
                        <div class="h-100 bg-light rounded p-4">
                            <select name = "month" >
                                <option selected value="">Chọn tháng</option>      
                                 @for ($month = 1; $month <= 12 ; $month++)                  
                                 <option value = "{{ $month }}">{{ $month }}</option>                  
                                 @endfor
                            </select>
                            <input type="text" name="year" min="1900" max="2099" step="1" value="2022" placeholder="Năm" />
                            <select name ="mscv">
                                <option value="" selected>Chọn công việc</option>
                                @foreach($data->dscv as $item)
                                    <option value="{{$item->MaCV}}" >{{$item->Tieude}}</option>
                                @endforeach
                            </select>
                            <select name="msnv">
                                <option value="" selected>Chọn nhân viên</option>
                                @foreach($data->dsnv as $item)
                                    <option value="{{$item->MaNV}}" >{{$item->TenNV}}</option>
                                @endforeach
                            </select>
                            <button type="submit" class="btn btn-primary">Xem</button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
            <!-- Widgets End -->
            <!-- Footer Start -->
            <div class="container-fluid pt-4 px-4">
                <div class="row g-4">
                @if (!empty($data))
                <div class="container-fluid pt-4 px-4">
                    <div class="bg-light text-center rounded p-4">
                        <div class="table-responsive">
                            <table class="table text-start align-middle table-bordered table-hover mb-0">
                                <thead>
                                    <tr class="text-dark">
                                        <th scope="col">Từ </th>
                                        <th scope="col">Đến</th>
                                        <th scope="col">tên nhân viên </th>
                                        <th scope="col">Tên Công việc</th>
                                        <th scope="col">Số giờ</th>
                                        <th scope="col">Số Nhật ký</th>
                                        <th scope="col">Số điểm</th>
                                    </tr>
                                </thead>
                                <tbody>
                                @foreach($data as $item)
                                    <tr>
                                        <td>{{$item->NgayGiao}}</td>
                                        <td>{{$item->HanTT}}</td>
                                        <td>{{$item->TenNV}}</td>
                                        <td>{{$item->Tieude}}</td>
                                        <td>{{$item->sogio}}</td>
                                        <td>{{$item->sonk}}</td>
                                        <td>{{$item->diem}}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                    @endif
                </div>
            </div>
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