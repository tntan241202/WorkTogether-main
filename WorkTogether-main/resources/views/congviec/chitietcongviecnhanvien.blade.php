
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
                        <form action="{{route('luutrangthai') }}" method="post" enctype="multipart/form-data">@csrf
                        <h6 class="mb-4">Chi tiết công việc</h6>
                            <div class="form-floating mb-3">
                                <input type="text" class="form-control" name="magiao" value="{{ $data->magiao  }} " readonly>
                                <label for="floatingInput">Mã Giao Việc</label>
                            </div>
                            <div class="form-floating mb-3">
                                <input type="text" class="form-control" name="MaCV" value="{{ $data->MaCV  }} " readonly>
                                <label for="floatingInput">Mã Công Việc</label>
                            </div>
                            <div class="form-floating mb-3">
                                <input type="text" class="form-control"  value="{{ old('tencv',$data->Tieude)  }}" readonly>
                                <label for="floatingInput">Tên Công Việc</label>
                            </div>
                            <div class="form-floating mb-3">
                                <input type="Date" class="form-control"  value="{{ $data->NgayGiao}}" readonly>
                                <label for="floatingInput">Ngày giao công việc</label>
                            </div>
                            <div class="form-floating mb-3">
                                <input type="Date" class="form-control"  value="{{ old('ngaykt', $data->HanDK)}}" readonly>
                                <label for="floatingInput">Hạn nộp</label>
                            </div>
                            
                            <div class="form-floating mb-3">
                                <textarea class="form-control" placeholder=""
                                 style="height: 150px;" readonly>{{ old('Mota',$data->Noidung )}}</textarea>
                                <label for="floatingTextarea">Mô tả công việc</label>
                            </div>
                            <div class="form-floating mb-3">
                                <input type="number" class="form-control"  value="{{ old('diem',$data->diem)  }}" readonly>
                                <label for="floatingInput">Điểm</label>
                            </div>
                            <div class="form-floating mb-3">
                                <textarea class="form-control" placeholder=""
                                style="height: 150px;" readonly>{{ old('noidungnhanxet',$data->Nhanxet )}}</textarea>
                                <label for="floatingTextarea">Nhận xét</label>
                            </div>
                            <div class="mb-3">
                                <label for="formFileMultiple" class="form-label">Chọn tệp hồ sơ</label>
                                <input class="form-control" type="file" name="formFileMultiple[]" multiple>
                            </div>
                            <div class="form-floating mb-3">
                                <select class="form-select" name="trangthai"
                                    aria-label="Floating label select example">
                                        <option @if($data ->Trangthai == 0 ) { selected } @endif value = "0" >Đã giao</option>
                                        <option @if($data ->Trangthai == 1 ) { selected } @endif value = "1" >Đang thực hiện</option>
                                        <option @if($data ->Trangthai == 2 ) { selected } @endif value = "2" >Đã hoàn thành</option>
                                </select>
                                <label for="floatingSelect">Trạng thái</label>
                            </div>
                            <div class="form-floating mb-3">
                                <h6 class="mb-4">Tài liệu công việc</h6>
                                @if (!empty($data->hscv))
                                        @foreach($data->hscv as $hs)
                                            <a href="{{url("download/$hs->duongdan")}}">"{{$hs->duongdan}}"</a>
                                        @endforeach
                                        @endif
                                </div>
                            <button type="submit" class="btn btn-primary">Lưu</button>
                            <a href="{{url('/congviec/themqa/')}}/{{$data->MaCV}}"><button type="button" class="btn btn-primary">Thêm câu hỏi</i></button></a>
                            <a href="{{url('/nhatky/themnhatky/')}}/{{$data->MaCV}}"><button type="button" class="btn btn-primary">Ghi nhật ký</i></button></a>
                        </form>
                        </div>
                    </div>
                    <div class="col-sm-12 col-xl-12">
                        <div class="bg-light rounded h-100 p-4">
                            <h6 class="mb-4">Hồ sơ công việc</h6>
                            <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link active" id="pills-home-tab" data-bs-toggle="pill"
                                        data-bs-target="#pills-home" type="button" role="tab" aria-controls="pills-home"
                                        aria-selected="true">Q/A</button>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link" id="pills-profile-tab" data-bs-toggle="pill"
                                        data-bs-target="#pills-profile" type="button" role="tab"
                                        aria-controls="pills-profile" aria-selected="false">Nhật ký</button>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link" id="pills-contact-tab" data-bs-toggle="pill"
                                        data-bs-target="#pills-contact" type="button" role="tab"
                                        aria-controls="pills-contact" aria-selected="false">Lịch sử</button>
                                </li>
                            </ul>
                            <div class="tab-content" id="pills-tabContent">
                                <div class="tab-pane fade show active" id="pills-home" role="tabpanel" aria-labelledby="pills-home-tab">
                                    @if (!empty($data->qa))
                                    @foreach($data->qa as $item)
                                    <div class="col-sm-12 col-xl-12">
                                        <div class="bg-light rounded h-100 p-4">
                                            <h6 class="mb-4">{{$item->TenNV}} <i> - {{date('d-m-Y', strtotime($item->ngayghiqa))}}</i></h6>
                                            <div class="tab-content" id="pills-tabContent">
                                                <div class="tab-pane fade show active" id="pills-home" role="tabpanel" aria-labelledby="pills-home-tab">
                                                    - Nội dung: {{$item->Noidungqa}} 
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    @endforeach
                                    @endif
                                </div>
                                <div class="tab-pane fade" id="pills-profile" role="tabpanel" aria-labelledby="pills-profile-tab">
                                    <div class="tab-pane fade show active" id="pills-home" role="tabpanel" aria-labelledby="pills-home-tab">
                                        @if (!empty($data->nkhn))
                                        @foreach($data->nkhn as $item)
                                        <div class="col-sm-12 col-xl-12">
                                            <div class="bg-light rounded h-100 p-4">
                                                <h6 class="mb-4">{{$item->TenNV}} <i> - {{date('d-m-Y', strtotime($item->NgayTao))}}</i></h6>
                                                <div class="tab-content" id="pills-tabContent">
                                                    <div class="tab-pane fade show active" id="pills-home" role="tabpanel" aria-labelledby="pills-home-tab">
                                                        - Nội dung: {{$item->NoiDung}} 
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        @endforeach
                                        @endif
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="pills-contact" role="tabpanel" aria-labelledby="pills-contact-tab">
                                    <div class="tab-pane fade show active" id="pills-home" role="tabpanel" aria-labelledby="pills-home-tab">
                                        @if (!empty($data->nkcn))
                                        @foreach($data->nkcn as $item)
                                        <div class="col-sm-12 col-xl-12">
                                            <div class="bg-light rounded h-100 p-4">
                                                <h6 class="mb-4">{{$item->TenNV}} <i> - {{date('d-m-Y', strtotime($item->NgayTao))}}</i></h6>
                                                <div class="tab-content" id="pills-tabContent">
                                                    <div class="tab-pane fade show active" id="pills-home" role="tabpanel" aria-labelledby="pills-home-tab">
                                                        - Nội dung: {{$item->NoiDung}} 
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        @endforeach
                                        @endif
                                    </div>
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
                                
                                
                                  
                     