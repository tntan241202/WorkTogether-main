
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
                <div class="container-fluid pt-4 px-4">
                    <div class="row g-4">
                        <div class="col-sm-12 col-xl-12">
                            <div class="bg-light rounded h-100 p-4">
                            <form action="{{route('updatedonvi') }}" method="post" enctype="multipart/form-data">@csrf
                                <h6 class="mb-4">Chi tiết đơn vị</h6>
                                <div class="row mb-3">
                                    <label for="inputEmail3" class="col-sm-2 col-form-label">Mã đơn vị</label>
                                    <div class="col-sm-10">
                                        {{-- <p>{{$data->MaDV}}</p> --}}
                                        <input type="text" class="form-control" name="madv"  value="{{$data->MaDV}}" readonly>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <label for="inputEmail3" class="col-sm-2 col-form-label">Tên đơn vị </label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" name="tendv" value="{{old('tendv', $data->TenPhong)}}">
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <label for="inputEmail3" class="col-sm-2 col-form-label">Số nhân viên</label>
                                    <div class="col-sm-10">
                                        {{-- <p>{{$data->soluong}}</p> --}}
                                        <input type="text" class="form-control"  value="{{$data->soluong}}" readonly>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <label for="" class="col-sm-2 col-form-label">Trưởng phòng</label>
                                    <div class="col-sm-10">
                                        <select class="form-select mb-3" aria-label="Default select example" name="truongphong" >
                                            @if(empty($data->nhanvien)) {
                                                <option >Chưa có nhân viên</option>
                                            }
                                            @elseif (empty($data->Matruongphong)) { 
                                                <option value="" >Chưa có trưởng phòng</option>
                                            }
                                            @endif
                                                @foreach ($data->nhanvien as $item)
                                                    <option value = {{ $item->MaNV }} @if($item->MaNV === $data->Matruongphong ){ selected } @endif >{{ $item->TenNV}}</option>
                                                @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <label for="" class="col-sm-2 col-form-label">Mô tả</label>
                                    <div class="col-sm-10">
                                        <textarea class="form-control" placeholder=""
                                         style="height: 150px;" name="mota">{{old('mota', $data->Mota)}}</textarea>
                                    </div>
                                </div>
                                 <button type="submit" class="btn btn-primary">Lưu Thay Đổi</button>
                                <button type="reset" class="btn btn-primary">Hủy</button>
                                
                            </form>
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