
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
                            <h6 class="mb-4">Thêm Công Việc</h6>
                            <form action="{{ route('luucongviec') }}" method="post" enctype="multipart/form-data">@csrf
                                <div class="form-floating mb-3">
                                    <input type="text" class="form-control" name="tencv" value="{{ old('tencv') }}">
                                    <label for="floatingInput">Tên Công Việc</label>
                                </div>
                                <div class="form-floating mb-3">
                                    <input type="Date" class="form-control" name="ngaykt" value="{{ old('ngaykt') }}">
                                    <label for="floatingInput">Hạn nộp</label>
                                </div>
                                <div class="form-floating mb-3">
                                    <textarea class="form-control" placeholder=""
                                    name="Mota" style="height: 150px;">{{ old('Mota') }}</textarea>
                                    <label for="floatingTextarea">Mô tả công việc<span class="wpforms-required-label">*</span>
                                    </label>
                                </div>
                                <div class="form-floating mb-3">
                                    <select class="form-select" name="mucdocv"
                                        aria-label="Floating label select example">
                                        <option value="" selected>Vui lòng chọn mức độ ưu tiên</option>
                                            <option value ="0">Thấp</option>
                                            <option value ="1">Vừa</option>
                                            <option value ="2">Cao</option>
                                            <option value ="3">Gấp</option>
                                    </select>
                                    <label for="floatingSelect">Chọn mức độ ưu tiên</label>
                                </div>
                                <div class="mb-3">
                                    <label for="formFileMultiple" class="form-label">Chọn tệp hồ sơ</label>
                                    <input class="form-control" type="file" name="formFileMultiple[]" multiple>
                                </div>
                                <div class="form-floating mb-3">
                                    <div class="bg-light rounded h-100 p-4">
                                        <label>Chọn nhân viên</label>
                                        <select class="form-select" name="nhanvien[]" multiple aria-label="multiple select example">
                                            @foreach ($data as $item)
                                            <option value = {{ $item->MaNV }} {{ old('nhanvien')==$item->MaNV ? 'selected' : ''}} >{{ $item->TenNV}}</option>
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