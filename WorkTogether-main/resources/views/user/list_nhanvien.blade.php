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
            <div class="container-fluid pt-4 px-4">
               <div class="row g-4">
                  <div class="col-sm-12 col-xl-12">
                     <div class="bg-light rounded h-100 p-4">
                        <h6 class="mb-4">Danh sách nhân viên</h6>
                        <form class="d-none d-md-flex ms-4" action="{{route('Searchnhanvien')}}" method="get">
                           <input class="form-control border-0" type="search" placeholder="Tìm kiếm" name="keywords">
                        </form>
                     </div>
                  </div>
                  <div class="col-sm-12 col-xl-12">
                     <div class="bg-light rounded h-100 p-4">
                        <div class="table-responsive">
                           <table class="table">
                              <thead>
                                 <tr>
                                    <th scope="col">Mã nhân viên</th>
                                    <th scope="col"><b>Tên nhân viên</b></th>
                                    <th scope="col"><b>Đơn vị</b></th>
                                    <th scope="col"><b>Chức vụ</b></th>
                                    <th scope="col"><b>Trạng thái</b></th>
                                    <th scope="col"><b>Thao tác</b></th>
                                 </tr>
                              </thead>
                              <tbody>
                                 <div>
                                    @foreach ($list_user as $item)
                                    <tr>
                                       <td>{{$item->MaNV}}</td>
                                       <td>{{$item->TenNV}}</td>
                                       <td> {{$item->TenPhong}}</td>
                                       <td>  {{$item->TenQuyen}}</td>
                                       @if ($item->trangthai =='1')
                                            <td> Đang hoạt động </td>
                                       @else
                                            <td>{{ $item->trangthai =='0' }} Không hoạt động</td>
                                       @endif
                                      
                                       <td>
                                          <a href="{{url('chuyentrangthai/')}}/{{$item->MaNV}}/{{$item->trangthai}}"><button type="button" class="btn btn-sm btn-sm-square btn-outline-primary m-2"><i class="fa fa-lock"></i></button>
                                          <a href="{{ url('chitietnhanvien/')}}/{{ $item->MaNV }}">
                                             <button type="button" class="btn btn-sm btn-sm-square btn-outline-primary m-2"><i class="fa fa-info"></i></button>
                                       </td>
                                    </tr>
                                    @endforeach
                                 </div>
                              </tbody>
                           </table>
                           <div>
                           {{ $list_user->links() }}
                           </div>
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