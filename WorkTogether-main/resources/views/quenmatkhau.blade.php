<!DOCTYPE html>
<html lang="en">
@extends('layout.head')
@section('Title')
    Quên mật khẩu!
@endsection
<body>
    <div class="container-xxl position-relative bg-white d-flex p-0">
        <!-- Spinner Start -->
        <!-- Spinner End -->

        <div id="spinner" class="show bg-white position-fixed translate-middle w-100 vh-100 top-50 start-50 d-flex align-items-center justify-content-center">
            <div class="spinner-border text-primary" style="width: 3rem; height: 3rem;" role="status">
                <span class="sr-only">Loading...</span>
            </div>
        </div>
        <!-- Sign Up Start -->
        <div class="container-fluid">
            @include('layout.message')
                <div class="row h-100 align-items-center justify-content-center" style="min-height: 100vh;">
                    <div class="col-12 col-sm-8 col-md-6 col-lg-5 col-xl-4">
                        <div class="bg-light rounded p-4 p-sm-5 my-4 mx-3">
                            <form action="{{ route('resetpass') }}" method="post" enctype="multipart/form-data">
                                @csrf
                                <div class="d-flex align-items-center justify-content-between mb-3">
                                    <h3>Quên mật khẩu</h3>
                                </div>
                                <div class="form-floating mb-3">
                                    <input type="email" name="email" class="form-control" id="floatingInput" placeholder="ten@gmail.com">
                                    <label for="floatingInput">Địa chỉ email</label>
                                </div>
                                <button type="submit" class="btn btn-primary py-3 w-100 mb-4">Gửi xác nhận</button>
                                <p class="text-center mb-0">Trở lại trang đăng nhập? <a href="{{ route('login') }}">Đăng nhập</a></p>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        <!-- Sign Up End -->
    </div>

    <!-- JavaScript Libraries -->
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="lib/chart/chart.min.js"></script>
    <script src="lib/easing/easing.min.js"></script>
    <script src="lib/waypoints/waypoints.min.js"></script>
    <script src="lib/owlcarousel/owl.carousel.min.js"></script>
    <script src="lib/tempusdominus/js/moment.min.js"></script>
    <script src="lib/tempusdominus/js/moment-timezone.min.js"></script>
    <script src="lib/tempusdominus/js/tempusdominus-bootstrap-4.min.js"></script>

    <!-- Template Javascript -->
    <script src="js/main.js"></script>
</body>
<!-- JavaScript Libraries -->
@include('layout.script')
<!-- Template Javascript -->
<script src="{{url('accessweb/js/main.js')}}"></script>

</html>