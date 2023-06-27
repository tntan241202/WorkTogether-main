
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
                <form action="{{route('SortPB')}}" method="POST">
                    @csrf
                    <h6 class="mb-2">Lọc</h6>
                    <select class="" name="sortname">
                        <option  value="" selected >Tất cả nhân viên </option>
                        @foreach($data->nhanvien as $nv)
                        <option  value="{{$nv->MaNV}}"> {{$nv->TenNV}}</option>
                        @endforeach
                    </select >
                    <select name="sortCV">
                        <option  value="" selected >Tất cả Công việc </option>
                            @foreach($data->congviec as $cv)
                            <option value="{{$cv->MaCV}}"> {{$cv->Tieude}}</option>
                            @endforeach
                    </select>
                    <select name = "month" >
                        <option selected value="">Chọn tháng</option>      
                        @for ($month = 1; $month <= 12 ; $month++)                  
                        <option value = "{{ $month }}">{{ $month }}</option>                  
                        @endfor
                    </select>
                    <input type="text" name="year" min="1900" max="2099" step="1" value="2022" placeholder="Năm" />
                    <button type="submit" class="btn btn-primary">Xem</button>
                </form>
                
                <div class="row g-4">
                    @if (!empty($data))
                    @foreach($data as $item)
                    <div class="col-sm-12 col-xl-12">
                        <div class="bg-light rounded h-100 p-4">
                            <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link active" id="pills-home-tab" data-bs-toggle="pill"
                                    data-bs-target="#pills-home" type="button" role="tab" aria-controls="pills-home"
                                    aria-selected="true">Công việc: {{$item->Tieude}}</button>
                                </li>
                            </ul>
                            <h6 class="mb-4">
                                @if($item->loaink==0) 
                                    <i>Nhật ký hằng ngày</i>
                                @elseif($item->loaink==1) 
                            <i>Nhật ký cập nhật</i>
                                @endif
                                - {{$item->TenNV}}</h6>
                            <div class="tab-content" id="pills-tabContent">
                                <div class="tab-pane fade show active" id="pills-home" role="tabpanel" aria-labelledby="pills-home-tab">
                                - Ngày ghi nhật ký: {{date('d-m-Y', strtotime($item->NgayTao))}}<br> 
                                @if (!empty($item->sogio)) 
                                    - Số giờ thực hiện: {{$item->sogio}} tiếng <br> 
                                 @endif
                                - Nội dung thực hiện: {{$item->NoiDung}} <br>
                                - Tên Công việc: {{$item->Tieude}} <br>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    @endforeach
                    @endif
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