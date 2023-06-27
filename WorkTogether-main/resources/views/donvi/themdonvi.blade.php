
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
                            <form action="{{ route('luudonvi') }}" method="post" enctype="multipart/form-data">@csrf
                                <h6 class="mb-4">Thêm đơn vị    </h6>
                                <div class="row mb-3">
                                    <label for="inputEmail3" class="col-sm-2 col-form-label">Tên đơn vị </label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" name="tendv">
                                    </div>
                                </div>
                               
                                <div class="row mb-3">
                                    <label for="" class="col-sm-2 col-form-label">Mô tả</label>
                                    <div class="col-sm-10">
                                        <textarea class="form-control" placeholder=""
                                        id="floatingTextarea" style="height: 150px;" name="mota"></textarea>
                                    </div>
                                </div>
                                 <button type="submit" class="btn btn-primary">Lưu</button>
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