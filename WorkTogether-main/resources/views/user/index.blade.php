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
            <div class="container-fluid pt-4 px-4">
                <div class="row g-4">
                    <div class="col-sm-12 col-md-4 col-xl-4">
                        <div class="h-100 bg-light rounded p-4">
                            <div class="d-flex align-items-center justify-content-between mb-4">
                                <h6 class="mb-0">Lịch</h6>
                            </div>
                            <div id="calender"></div>
                        </div>
                    </div>
                    @if(!empty($user_info->congvieccanlam)) 
                        <div class="col-sm-12 col-md-4 col-xl-8">
                            <div class="h-100 bg-light rounded p-4">
                                <div class="d-flex align-items-center justify-content-between mb-4">
                                    <h6 class="mb-0">Các Công Việc Cần Làm</h6>
                                    <a href="{{route('dscongviec')}}">Xem Tất Cả</a>
                                </div>
                                @foreach ($user_info->congvieccanlam as $item)
                                <div class="d-flex align-items-center border-bottom py-2">
                                    <div class="w-100 ms-3">
                                        <div class="d-flex w-100 align-items-center justify-content-between">
                                           <span> <a href="{{route('chitietcongviecnhanvien',['id'=>$item->MaCV])}}">{{$item->Tieude}} - Hạn:{{$item->HanDK}}</a>
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        </div>
                    @endif
                </div>
            </div>
            <!-- Widgets End -->
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