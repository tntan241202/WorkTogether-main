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
                            <h6 class="mb-4">Danh sách đơn vị </h6>
                            <a href="{{ route('themdonvi') }}"> <button type="button" class="btn btn-square btn-primary m-2"><i class="fa fa-plus"></i></button></a>
                            <div class="table-responsive">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th scope="col">#</th>
                                            <th scope="col">Tên phòng</th>
                                            <th scope="col">Trưởng phòng</th>
                                            <th scope="col">Số lượng nhân viên</th>
                                            <th scope="col"> Thao tác </th>
                                            
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php $i = 1 @endphp  
                                        @foreach ($list_dv as $item)
                                        <tr>
                                            <td>{{$i}}</td>
                                            <td>{{$item->TenPhong}}</td>
                                            <td> {{$item->tentp}}</td>
                                            <td> {{$item->soluong}}</td>
                                            <td>
                                                <a href="{{ url('donvi/chitietdonvi/')}}/{{ $item->MaDV }}"><button type="button" class="btn btn-sm btn-sm-square btn-outline-primary m-2"><i class="fa fa-info"></i></button></a>
                                            </td>
                                            @php $i++ @endphp 
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
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