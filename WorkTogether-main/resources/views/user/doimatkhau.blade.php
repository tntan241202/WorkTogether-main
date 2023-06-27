

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
                @if ($errors->any())
                <div class="alert alert-danger alert-dismissible fade show" role="alert">@foreach ($errors->all() as $error)
                    <i class="fa fa-exclamation-circle me-2"></i>{{ $error }} <br>
                    @endforeach
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
                 @endif
            <!-- Navbar End -->
             <!-- Table Start -->
            <div class="container-fluid pt-4 px-4">
                <div class="row g-4">
                    <div class="col-sm-12 col-xl-12">
                        <div class="bg-light rounded h-100 p-4">
                            <h6 class="page-header">Cập nhật mật khẩu</h6>
                            <form action="{{ route('Luudoimatkhau') }}" method="POST">
                                @csrf
                                <div class="form-group" style="position: relative">
                                    <label for="email">Mật khẩu cũ:</label>                
                                    <input type="password" class="form-control" placeholder="" name="password_old" value=""> 
                                    <a style="position: absolute;top: 54%; right: 10px; color: #333" href="javascript:void(0)"><i class=""></i></a>
                                </div>
                                <div class="form-group" style="position: relative">
                                    <label for="email">Mật khẩu mới:</label>
                                    <input type="password" class="form-control" placeholder="" name="password" value=""> 
                                    <a style="position: absolute;top: 54%; right: 10px; color: #333" href="javascript:void(0)"><i class=""></i></a>
                                </div>
                                <div class="form-group" style="position: relative">
                                    <label for="email">Nhập lại mật khẩu mới:</label>
                                    <input type="password" class="form-control" placeholder="" name="password_confirmation" value="">
                                    <a style="position: absolute;top: 54%; right: 10px; color: rgb(16, 15, 15)" href="javascript:void(0)"><i class=""></i></a>
                                </div>
                                <button type="submit" class="btn btn-primary">Cập nhật</button>
                            </form>
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